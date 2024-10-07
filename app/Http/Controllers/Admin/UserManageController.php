<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManageController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function getData(Request $request)
    {
        $data = User::query(); // Tidak perlu eager load jika role ada di tabel user

        // Total records before filtering
        $recordsTotal = $data->count();

        // Filter by search
        if ($request->has('search') && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $data->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('role', 'like', '%' . $searchValue . '%'); // Filter by role as well
        }

        // Total records after filtering
        $recordsFiltered = $data->count();

        // Apply pagination
        $data->skip($request->start ?? 0)
            ->take($request->length ?? $recordsTotal);

        $data = $data->get(); // Fetch data after filtering and pagination

        // Return JSON response for DataTable
        return response()->json([
            'draw' => intval($request->draw ?? 1),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role, // Include role column
                ];
            }),
        ]);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'], // Konfirmasi password
        ]);

        // Buat pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        return redirect()->route('admin.user')->with('success', 'Data Berhasil Ditambahkan!');
    }

    public function destroy($id)
    {
        $data = User::find($id);

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Exclude current user's email from unique check
            'password' => 'nullable|min:8',
            'role' => 'required|in:admin,user,operator',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->role = $validatedData['role'];
        $user->save();

        return redirect()->route('admin.user')->with('success', 'Data Berhasil Diubah!');
    }
}
