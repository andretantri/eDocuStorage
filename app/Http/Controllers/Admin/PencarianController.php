<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\Request;

class PencarianController extends Controller
{
    public function search(Request $request)
    {
        $searchValue = $request->input('search');

        // Pencarian berdasarkan folder
        $folders = Folder::where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('tag_folder', 'like', '%' . $searchValue . '%')
            ->get();

        // Pencarian berdasarkan file
        $files = Document::where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('tag', 'like', '%' . $searchValue . '%')
            ->get();

        return response()->json([
            'folders' => $folders,
            'files' => $files,
        ]);
    }

    public function index()
    {
        return view('admin.pencarian.index');
    }
}
