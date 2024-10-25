@extends('layouts.full')

@section('title', 'Folder ')

@section('content-bc', 'Folder ')

@section('css')
    <link rel="stylesheet" href="{{ asset('template/assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('js')
    <script src="{{ asset('template/assets/js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('template/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('template/assets/js/pages/be_tables_datatables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#tabelData').on('click', '.delete-folder-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus data ini?',
                    text: "Anda tidak akan dapat mengembalikannya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Lanjutkan Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let deleteUrl = '{{ route('admin.berkas-folder.delete', ':id') }}';
                        deleteUrl = deleteUrl.replace(':id', id);
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                window.location.reload();
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );

                            },
                            error: function(response) {
                                Swal.fire(
                                    'Failed!',
                                    'Gagal Hapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $('#tabelDataFile').on('click', '.delete-file-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus data ini?',
                    text: "Anda tidak akan dapat mengembalikannya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Lanjutkan Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let deleteUrl = '{{ route('admin.berkas-file.delete', ':id') }}';
                        deleteUrl = deleteUrl.replace(':id', id);
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                window.location.reload();
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );

                            },
                            error: function(response) {
                                Swal.fire(
                                    'Failed!',
                                    'Gagal Hapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        document.getElementById('copyTag').addEventListener('click', function() {
            // Ambil nilai dari inputTag
            let tagValue = document.getElementById('inputTag').value;

            // Ambil semua input dengan class "tag-file"
            let tagInputs = document.querySelectorAll('.tag-file');

            // Loop melalui setiap input dan set nilai tagValue ke dalamnya
            tagInputs.forEach(function(input) {
                input.value = tagValue;
            });
        });
    </script>
@endsection

@section('content-isi')
    <div class="row items-push">
        <div class="col-xl-12">
            <!-- Breadcrumb Section -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <!-- Iterasi Breadcrumbs jika ada data folder parent -->
                    @if ($breadcrumbs != '[]')
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item" aria-current="page">
                                <a
                                    href="{{ route('admin.berkas.view', ['id' => $kriteria->id, 'folder' => $breadcrumb['id']]) }}">
                                    {{ $breadcrumb['name'] }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ol>
            </nav>
        </div>
    </div>
    <div class="row items-push">
        <div class="col-xl-12">
            <!-- Pie Chart -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Sub Folder</h3>
                </div>
                <div class="block-content block-content-full">

                    <div class="progress push" style="height: 10px; display: none;" role="progressbar" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 0%;"></div>
                    </div>
                    <table id="tabelData" class="display table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sub Folder</th>
                                <th>Tag</th>
                                <th>Jumlah</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->count() != 0)
                                @foreach ($data as $index => $content)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a
                                                href="{{ route('admin.berkas.view', ['id' => $kriteria->id, 'folder' => $content->id]) }}">
                                                {{ $content->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($content->tag_folder)
                                                @foreach (explode(',', $content->tag_folder) as $tag)
                                                    <span class="badge bg-primary">{{ $tag }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge bg-secondary">No Tags</span>
                                            @endif
                                        </td>
                                        <td>
                                            Sub Folder : {{ $content->subfolders->count() }}<br>
                                            File Dalam Folder : {{ $content->documents->count() }}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger delete-folder-btn"
                                                data-id="{{ $content->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" align="center">Belum Ada Data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="row items-push">
        <div class="col-xl-12">
            <!-- Pie Chart -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">File</h3>
                </div>
                <div class="block-content block-content-full">

                    <div class="progress push" style="height: 10px; display: none;" role="progressbar" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 0%;"></div>
                    </div>
                    <table id="tabelDataFile" class="display table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>File</th>
                                <th>Tag</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($file->count() != 0)
                                @foreach ($file as $index => $dFile)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('admin.file.stream', ['id' => $dFile->id]) }}">
                                                {{ $dFile->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($dFile->tag)
                                                @foreach (explode(',', $dFile->tag) as $tag)
                                                    <span class="badge bg-primary">{{ $tag }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge bg-secondary">No Tags</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger delete-file-btn"
                                                data-id="{{ $dFile->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" align="center">Belum Ada Data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    @if (count($belumAdaFolder) > 0)
        <div class="row items-push">
            <div class="col-xl-12">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <h2 class="content-heading pt-0">Hubungkan Folder (Diambil Dari Google Drive)</h2>
                        <form action="{{ route('admin.berkas.upload', ['id' => $kriteria->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="folder">
                            <input type="hidden" name="folderid" value="{{ $idf }}">
                            <div class="row push">
                                <div class="col-lg-12 col-xl-12 overflow-hidden">
                                    <div class="alert alert-info" role="alert">
                                        Tag untuk mempermudah pencarian folder. Gunakan koma (,) untuk memisahkan beberapa
                                        tag.
                                    </div>
                                    @foreach ($belumAdaFolder as $k => $folder)
                                        @php
                                            $folder_fl = str_replace($pathFl . '/', '', $folder);
                                            $tags_fl = strtolower(preg_replace('/^[^)]+\)\s*/', '', $folder_fl));
                                        @endphp
                                        <div class="row align-items-center">
                                            <div class="col-md-1 mb-4 text-center">
                                                <label class="form-label" style="font-weight: bold; font-size: 18px;">
                                                    {{ $k + 1 }}
                                                </label>
                                            </div>
                                            <div class="col-md-5 mb-4">
                                                <label class="form-label">Nama Folder<code>*</code></label>
                                                <input type="text" name="name[]" placeholder="Masukkan Nama Folder"
                                                    class="form-control" value="{{ $folder_fl }}" readonly>
                                            </div>
                                            <input type="hidden" name="path[]" class="form-control"
                                                value="{{ $folder }}">
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label">Tambah Tag Folder<code>*</code></label>
                                                <input type="text" name="tag_folder[]" placeholder="Masukkan Tag Folder"
                                                    class="form-control" value="{{ $tags_fl }}" required>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-md-12 mb-4 text-end">
                                            <button class="btn btn-primary" type="submit">Hubungkan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (count($belumAdaFile) > 0)
        <div class="col-xl-12">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <h2 class="content-heading pt-0">Hubungkan File (Diambil Dari Google Drive)</h2>
                    <form action="{{ route('admin.berkas.upload', ['id' => $kriteria->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="file">
                        <input type="hidden" name="folderid" value="{{ $idf }}">

                        <div class="row push">
                            <div class="col-lg-12 col-xl-12 overflow-hidden">
                                <p class="text-muted">
                                    (<code>*</code>) Wajib Diisi<br>
                                </p>

                                <div class="alert alert-info" role="alert">
                                    Apabila tag yang digunakan sama, masukkan pada tag dibawah lalu klik copy ke semua tag
                                </div>

                                <!-- Input baru untuk memasukkan tag -->
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <input type="text" id="inputTag" placeholder="Masukkan Tag untuk disalin"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="copyTag" class="btn btn-success">Copy ke semua
                                            Tag</button>
                                    </div>
                                </div>

                                <div class="alert alert-info" role="alert">
                                    Tag untuk mempermudah pencarian folder. Gunakan koma (,) untuk memisahkan beberapa tag.
                                </div>

                                @foreach ($belumAdaFile as $k => $file)
                                    @php
                                        $file_fi = str_replace($pathFl . '/', '', $file);
                                        $tags_fi = strtolower(preg_replace('/[.)].*/', '', $file_fi));

                                    @endphp
                                    <div class="row align-items-center">
                                        <div class="col-md-1 mb-4 text-center">
                                            <label class="form-label" style="font-weight: bold; font-size: 18px;">
                                                {{ $k + 1 }}
                                            </label>
                                        </div>

                                        <div class="col-md-5 mb-4">
                                            <label class="form-label">Nama File<code>*</code></label>
                                            <input type="text" name="name[]" placeholder="Masukkan Nama File"
                                                class="form-control" value="{{ $file_fi }}" readonly>
                                        </div>
                                        <textarea name="path[]" id="path" cols="30" rows="10" hidden>{{ $file }}</textarea>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Tag<code>*</code></label>
                                            <input type="text" name="tag[]" placeholder="Masukkan Tag File"
                                                class="form-control tag-file" value="{{ $tags_fi }}" required>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-md-12 mb-4 text-end">
                                        <button class="btn btn-primary" type="submit">Hubungkan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
