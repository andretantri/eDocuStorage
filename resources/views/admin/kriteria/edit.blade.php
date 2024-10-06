@extends('layouts.full')

@section('title', 'Update Kriteria ')

@section('content-bc', 'Update Kriteria')

@section('js')
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Update Kriteria</h2>
            <form action="{{ route('admin.kriteria.update', $data->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row push">
                    <div class="col-lg-12 col-xl-12 overflow-hidden">
                        <p class="text-muted">
                            (<code>*</code>) Wajib Diisi<br>
                        </p>
                        <div class="mb-4">
                            <label class="form-label">Nama Kriteria<code>*</code></label>
                            <input type="text" name="name" placeholder="Masukkan Nama Kriteria" class="form-control"
                                required value="{{ $data->name }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Deskripsi<code>*</code></label>
                            <input type="text" name="description" placeholder="Masukkan Deskripsi" class="form-control"
                                required value="{{ $data->description }}">
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
