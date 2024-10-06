<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\Folder;

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
        $allFolders = Folder::where('criteria_id', $id)->get();
        $data = Folder::where('criteria_id', $id)->where('parent_id', $parent)->get();

        return view('admin.folder.tabel', compact('data', 'statusKriteria', 'breadcrumbs', 'idf', 'kriteria', 'folder', 'allFolders'));
    }

    public function pertanyaan($id, $kategori, $sub, $order)
    {

        // return view('admin.folder.set', ['pertanyaan' => $pertanyaan, 'ujian' => $ujian, 'list' => $lq, 'order' => $order]);
    }

    public function store($id, Request $request)
    {
        $folder = Folder::create([
            'criteria_id' => $id, // Pastikan criteria_id ada di input
            'name' => $request->name,
            'tag_folder' => $request->tag_folder,
            'parent_id' => $request->parent_id == 0 ? null : $request->parent_id, // Set null jika parent_id = 0
        ]);

        // Dapatkan ID dari folder yang baru saja dibuat
        $folderId = $folder->id;

        return redirect()->route('admin.folder.tabel', ['id' => $id, 'folder' => $folderId])->with('success', 'Folder berhasil Dibuat!');
    }
}
