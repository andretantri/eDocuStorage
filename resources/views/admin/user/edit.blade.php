@extends('layouts.full')

@section('title', 'Edit Pengguna')

@section('content-bc', 'Edit Pengguna')

@section('js')
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Edit Pengguna</h2>
            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row push">
                    <div class="col-lg-12 col-xl-12 overflow-hidden">
                        <p class="text-muted">
                            (<code>*</code>) Wajib Diisi<br>
                        </p>
                        <div class="mb-4">
                            <label class="form-label">Nama<code>*</code></label>
                            <input type="text" name="name" value="{{ $user->name }}" placeholder="Masukkan Nama"
                                class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Email<code>*</code></label>
                            <input type="email" name="email" value="{{ $user->email }}" placeholder="Masukkan Email"
                                class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Password">
                            <small class="text-muted">Isi password baru jika ingin mengubahnya.</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Izin (Role)<code>*</code></label>
                            <select name="role" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                            <a href="{{ route('admin.user') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
