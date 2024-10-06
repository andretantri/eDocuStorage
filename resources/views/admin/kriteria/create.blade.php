@extends('layouts.full')

@section('title', 'Tambah Kriteria ')

@section('content-bc', 'Tambah Kriteria')

@section('js')
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Setting Kriteria</h2>
            <form action="{{ route('admin.kriteria.store') }}" method="POST">
                @csrf
                <div class="row push">
                    <div class="col-lg-12 col-xl-12 overflow-hidden">
                        <p class="text-muted">
                            (<code>*</code>) Wajib Diisi<br>
                        </p>
                        <div class="mb-4">
                            <label class="form-label">Nama Kriteria<code>*</code></label>
                            <input type="text" name="name" placeholder="Masukkan Nama Kriteria" class="form-control"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Deskripsi<code>*</code></label>
                            <input type="text" name="description" placeholder="Masukkan Deskripsi" class="form-control"
                                required>
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
