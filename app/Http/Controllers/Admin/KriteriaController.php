<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KriteriaController extends Controller
{
    public function index()
    {
        return view('admin.kriteria.index');
    }

    public function getData(Request $request)
    {
        // Mulai query dengan eager load relasi 'getFolder'
        $data = Criteria::with('folders'); // Eager load folders

        // Hitung total record sebelum filtering
        $recordsTotal = $data->count();

        // Jika ada pencarian
        if ($request->has('search') && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $data->where('name', 'like', '%' . $searchValue . '%');
        }

        // Hitung record setelah filtering
        $recordsFiltered = $data->count();

        // Pagination: skip dan take berdasarkan DataTables request
        $data->skip($request->start ?? 0)
            ->take($request->length ?? $recordsTotal);

        // Ambil data akhir
        $data = $data->get();

        foreach ($data as $c) {
            $specificFolder = $c->getFolder(); // Mengambil folder khusus
            $folderId = $specificFolder ? $specificFolder->id : null; // Ambil ID folder
            // Proses lebih lanjut
        }

        // Kembalikan data dalam format JSON untuk DataTables
        return response()->json([
            'draw' => intval($request->draw ?? 1),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }


    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $criteria = Criteria::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        Folder::create([
            'criteria_id' => $criteria->id,
            'name' => $request->name,
            'tag_folder' => $request->name,
            'folder_path' => $request->name,
            'parent_id' => null,
        ]);

        Storage::disk('google')->makeDirectory($request->name);

        return redirect()->route('admin.kriteria')->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function destroy($id)
    {
        $data = Criteria::find($id);

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }

    public function edit($id)
    {
        $data = Criteria::find($id);
        return view('admin.kriteria.edit', compact('data'));
    }

    public function update($id, Request $request)
    {

        $data = Criteria::find($id);

        // Mendapatkan semua file dari direktori lama
        $files = Storage::disk('google')->files($data->name);

        // Salin setiap file ke direktori baru
        foreach ($files as $file) {
            $newFilePath = str_replace($data->name, $request->name, $file);
            Storage::disk('google')->copy($file, $newFilePath);
        }

        // Jika ingin menghapus direktori lama dan isi setelah menyalin, uncomment baris berikut
        if (count($files) == 0) {
            Storage::disk('google')->makeDirectory($request->name);
        }

        Storage::disk('google')->deleteDirectory($data->name);


        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect()->route('admin.kriteria')->with('success', 'Data Berhasil Diubah!');
    }
}
