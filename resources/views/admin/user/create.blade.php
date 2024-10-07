@extends('layouts.full')

@section('title', 'Tambah Pengguna ')

@section('content-bc', 'Tambah Pengguna')

@section('js')
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Tambah Pengguna</h2>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="row push">
                    <div class="col-lg-12 col-xl-12 overflow-hidden">
                        <p class="text-muted">
                            (<code>*</code>) Wajib Diisi<br>
                        </p>
                        <div class="mb-4">
                            <label class="form-label">Nama<code>*</code></label>
                            <input type="text" name="name" placeholder="Masukkan Nama" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Email<code>*</code></label>
                            <input type="email" name="email" placeholder="Masukkan Email" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password<code>*</code></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Izin (Role)<code>*</code></label>
                            <select name="role" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="operator">Operator</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
