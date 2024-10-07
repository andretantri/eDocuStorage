<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\Document;
use App\Models\Folder;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{
    public function tabel($id, $idf)
    {
        $kriteria = Criteria::find($id);
        $statusKriteria = ($idf == '0') ? 0 : 1;

        $breadcrumbs = [];
        $folder = [];

        $parent = null;
        if ($statusKriteria == 1) {
            $folderLoc = Folder::find($idf);
            while ($folderLoc) {
                $breadcrumbs[] = [
                    'id' => $folderLoc->id,
                    'name' => $folderLoc->name,
                ];
                $folderLoc = $folderLoc->parent; // Ambil parent folder jika ada
            }
            // Urutkan array dari root ke current folder
            $breadcrumbs = array_reverse($breadcrumbs);
            $parent = $idf;
            $folder = Folder::find($idf);
        }
        $sub = Folder::find($idf);
        $allFolders = Folder::where('criteria_id', $id)->where('parent_id', $sub ? $sub->parent : null)->get();
        $data = Folder::where('criteria_id', $id)->where('parent_id', $parent)->get();
        $file = Document::where('folder_id', $idf)->get();

        return view('admin.folder.tabel', compact('data', 'statusKriteria', 'breadcrumbs', 'idf', 'kriteria', 'folder', 'allFolders', 'file'));
    }

    public function store($id, Request $request)
    {
        $path = "";
        $parent = $request->parent_id == 0 ? null : $request->parent_id;
        $kriteria = Criteria::find($id);
        if ($parent == null) {
            $path = $kriteria->name . '/' . $request->name;
        } else {
            $folderLoc = Folder::find($parent);
            while ($folderLoc) {
                $breadcrumbs[] = [
                    'id' => $folderLoc->id,
                    'name' => $folderLoc->name,
                ];
                $folderLoc = $folderLoc->parent; // Ambil parent folder jika ada
            }
            // Urutkan array dari root ke current folder
            $breadcrumbs = array_reverse($breadcrumbs);
            $xpath = "";
            foreach ($breadcrumbs as $newPath) {
                $xpath .= $newPath['name'] . '/';
            }
            $path = $kriteria->name . '/' . $xpath . $request->name;
        }
        $folder = Folder::create([
            'criteria_id' => $id, // Pastikan criteria_id ada di input
            'name' => $request->name,
            'folder_path' => $path,
            'tag_folder' => $request->tag_folder,
            'parent_id' => $parent, // Set null jika parent_id = 0
        ]);

        Storage::disk('google')->makeDirectory($path);

        // Dapatkan ID dari folder yang baru saja dibuat
        $folderId = $folder->id;

        return redirect()->route('admin.folder.tabel', ['id' => $id, 'folder' => $folderId])->with('success', 'Folder berhasil Dibuat!');
    }

    public function upload($id, Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tag' => 'nullable|string',
        ]);

        // Ambil file dari input form
        $file = $request->file('file');

        // Temukan folder berdasarkan ID yang diterima dari request
        $folder = Folder::findOrFail($id); // Mengambil folder berdasarkan ID yang diberikan

        // Tentukan nama file dari input 'name' yang diberikan
        $filename = $request->input('name') . '.' . $file->getClientOriginalExtension();

        // Tentukan path folder dari data yang diambil
        $folderPath = $folder->folder_path; // Misal: 'ParentFolder/SubFolder'

        // Upload ke Google Drive berdasarkan path folder yang telah ditentukan
        $path = Storage::disk('google')->putFileAs($folderPath, $file, $filename);

        // Mendapatkan ID file dari path yang dikembalikan
        $fileId = basename($path);

        // Simpan informasi file ke database (jika perlu)
        $document = Document::create([
            'name' => $filename,
            'description' => $request->input('description'),
            'tag' => $request->input('tag'),
            'google_drive_id' => $path, // ID Google Drive
            'folder_id' => $folder->id, // Asosiasikan dengan folder yang dipilih
        ]);

        return redirect()->route('admin.folder.tabel', ['id' => $folder->criteria->id, 'folder' => $folder->id])->with('success', 'File berhasil Diupload!');
    }

    public function streamFile($id)
    {
        // Mencari dokumen berdasarkan ID
        $file = Document::find($id);

        // Pastikan dokumen ditemukan
        if (!$file) {
            return response()->json(['message' => 'Document not found!'], 404);
        }

        // Mengambil path dari folder
        $path = $file->folder->folder_path . '/' . $file->name ? $file->folder->folder_path . '/' . $file->name : null; // Pastikan folder ada

        // Cek apakah path tidak null
        if (!$path) {
            return response()->json(['message' => 'File path not found!'], 404);
        }

        // Menggunakan Storage disk Google Drive untuk membaca stream file
        $readStream = Storage::disk('google')->readStream($path);

        // Cek apakah stream berhasil
        if (!$readStream) {
            return response()->json(['message' => 'File tidak ditemukan di Google Drive!'], 404);
        }

        // Mengambil informasi file extension dan content type dari Google Drive
        $mimeType = Storage::disk('google')->mimeType($path);
        $filename = basename($path);

        // Menggunakan response()->stream() untuk menampilkan file di browser
        return response()->stream(function () use ($readStream) {
            fpassthru($readStream);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-disposition' => 'inline; filename="' . $filename . '"', // Mengatur agar file ditampilkan di browser
        ]);
    }

    public function destroy($id)
    {
        // Temukan folder berdasarkan ID
        $folder = Folder::find($id);

        // Jika folder tidak ditemukan, kembalikan respon error
        if (!$folder) {
            return response()->json(['message' => 'Folder tidak ditemukan!'], 404);
        }

        Storage::disk('google')->deleteDirectory($folder->folder_path);
        // Hapus folder
        $folder->delete();

        return response()->json(['message' => 'Folder berhasil dihapus!']);
    }

    public function destroyFile($id)
    {
        // Temukan folder berdasarkan ID
        $file = Document::find($id);

        Storage::disk('google')->delete($file->folder->folder_path . '/' . $file->name);
        // Hapus folder
        $file->delete();

        return response()->json(['message' => 'File berhasil dihapus!']);
    }

    public function view($id, $idf)
    {
        $kriteria = Criteria::find($id);
        $statusKriteria = ($idf == '0') ? 0 : 1;

        $breadcrumbs = [];
        $folder = [];

        $parent = null;
        if ($statusKriteria == 1) {
            $folderLoc = Folder::find($idf);
            while ($folderLoc) {
                $breadcrumbs[] = [
                    'id' => $folderLoc->id,
                    'name' => $folderLoc->name,
                ];
                $folderLoc = $folderLoc->parent; // Ambil parent folder jika ada
            }
            // Urutkan array dari root ke current folder
            $breadcrumbs = array_reverse($breadcrumbs);
            $parent = $idf;
            $folder = Folder::find($idf);
        }
        $sub = Folder::find($idf);
        $allFolders = Folder::where('criteria_id', $id)->where('parent_id', $sub ? $sub->parent : null)->get();
        $data = Folder::where('criteria_id', $id)->where('parent_id', $parent)->get();
        $file = Document::where('folder_id', $idf)->get();

        return view('admin.pencarian.view', compact('data', 'statusKriteria', 'breadcrumbs', 'idf', 'kriteria', 'folder', 'allFolders', 'file'));
    }
}
