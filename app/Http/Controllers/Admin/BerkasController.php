<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
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
        $allFolders = Folder::where('criteria_id', $id)->where('parent_id', $idf)->get();
        $data = Folder::where('criteria_id', $id)->where('parent_id', $idf)->get();
        $file = Document::where('folder_id', $idf)->get();

        $locFolder = "";

        if ($sub != []) {
            $locFolder = $sub->folder_path;
        } else {
            $locFolder = $kriteria->name;
        }


        $listAllDoc = [];
        foreach ($file as $doc) {
            $listAllDoc[] = $doc->google_drive_id;
        }

        $listAllFold = [];
        foreach ($allFolders as $fld) {
            $listAllFold[] = $fld->folder_path;
        }

        $pathFl = $locFolder;

        $listFold = Folder::where('criteria_id', $kriteria->id)->where('folder_path', $pathFl)->get();

        $folderGd = Storage::disk('google')->allDirectories($pathFl);
        $fileGd = Storage::disk('google')->files($pathFl);

        $belumAdaFolder = $this->checkAndUnset($folderGd, $listAllFold);
        $belumAdaFile = $this->checkAndUnset($fileGd, $listAllDoc);

        return view('admin.berkas.tabel', compact('data', 'statusKriteria', 'breadcrumbs', 'idf', 'kriteria', 'folder', 'allFolders', 'file', 'belumAdaFolder', 'belumAdaFile', 'pathFl'));
    }

    public function simpan($id, Request $request)
    {
        if ($request->type == 'folder') {
            $parent = ($request->folderid) ? $request->folderid : null;
            foreach ($request->name as $key => $name) {
                Folder::create([
                    'criteria_id' => $id,
                    'name' => $name,
                    'parent_id' => $parent,
                    'folder_path' => $request->path[$key],
                    'tag_folder' => $request->tag_folder[$key],
                ]);
            }
            return redirect()->route('admin.berkas.view', ['id' => $id, 'folder' => $request->folderid])->with('success', 'Folder berhasil Dihubungkan Dengan Google Drive!');
        } else if ($request->type == 'file') {
            $parent = ($request->folderid) ? $request->folderid : null;
            foreach ($request->name as $key => $name) {
                Document::create([
                    'criteria_id' => $id,
                    'folder_id' => $request->folderid,
                    'name' => $name,
                    'google_drive_id' => $request->path[$key],
                    'tag' => $request->tag[$key],
                ]);
            }
            return redirect()->route('admin.berkas.view', ['id' => $id, 'folder' => $request->folderid])->with('success', 'File berhasil Dihubungkan Dengan Google Drive!');
        } else {
            return abort(404);
        }
    }

    public function checkAndUnset($a, $b)
    {
        foreach ($a as $key => $value) {
            if (in_array($value, $b)) {
                unset($a[$key]);
            }
        }

        return $a;
    }

    public function deleteFile($id)
    {
        // Temukan file berdasarkan ID
        $file = Document::find($id);
        // Hapus file
        $file->delete();

        return response()->json(['message' => 'File berhasil dihapus!']);
    }

    public function deleteFolder($id)
    {
        // Temukan folder berdasarkan ID
        $folder = Folder::find($id);
        // Hapus folder
        $folder->delete();

        return response()->json(['message' => 'Folder berhasil dihapus!']);
    }
}
