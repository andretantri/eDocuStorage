<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        return view('admin.kriteria.index');
    }

    public function getData(Request $request)
    {
        $data = Criteria::query();

        $recordsTotal = $data->count();

        if ($request->has('search') && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $data->where('name', 'like', '%' . $searchValue . '%');
        }

        $recordsFiltered = $data->count();

        $data->skip($request->start ?? 0)
            ->take($request->length ?? $recordsTotal);

        $data = $data->get();

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
        Criteria::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

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

        $data->name = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect()->route('admin.kriteria')->with('success', 'Data Berhasil Diubah!');
    }
}
