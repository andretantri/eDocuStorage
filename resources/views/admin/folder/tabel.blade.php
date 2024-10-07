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
                        let deleteUrl = '{{ route('admin.folder.delete', ':id') }}';
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
                                    'Data kriteria Berhasil Dihapus.',
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
                        let deleteUrl = '{{ route('admin.file.delete', ':id') }}';
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
                                    'Data kriteria Berhasil Dihapus.',
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
@endsection

@section('content-isi')
    <div class="row items-push">
        <div class="col-xl-12">
            <!-- Breadcrumb Section -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="{{ route('admin.folder.tabel', ['id' => $kriteria->id, 'folder' => 0]) }}">{{ $kriteria->name }}</a>
                    </li>

                    <!-- Iterasi Breadcrumbs jika ada data folder parent -->
                    @if ($breadcrumbs != '[]')
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item" aria-current="page">
                                <a
                                    href="{{ route('admin.folder.tabel', ['id' => $kriteria->id, 'folder' => $breadcrumb['id']]) }}">
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
                                                href="{{ route('admin.folder.tabel', ['id' => $kriteria->id, 'folder' => $content->id]) }}">
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
    @if ($statusKriteria != 0)

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
    @endif

    <div class="row items-push">
        <div class="@if ($idf == 0) col-xl-12 @else col-xl-6 @endif">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <h2 class="content-heading pt-0">Buat Folder</h2>
                    <form action="{{ route('admin.folder.store', ['id' => $kriteria->id]) }}" method="POST">
                        @csrf
                        <div class="row push">
                            <div class="col-lg-12 col-xl-12 overflow-hidden">
                                <p class="text-muted">
                                    (<code>*</code>) Wajib Diisi<br>
                                </p>
                                <div class="mb-4">
                                    <label class="form-label">Nama Folder<code>*</code></label>
                                    <input type="text" name="name" placeholder="Masukkan Nama Folder"
                                        class="form-control" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Tag Folder<code>*</code></label>
                                    <input type="text" name="tag_folder" placeholder="Masukkan Tag Folder"
                                        class="form-control" required>
                                    <small class="text-muted">Tag untuk mempermudah pencarian folder. Gunakan koma (,) untuk
                                        memisahkan beberapa tag.</small>
                                </div>

                                <!-- Dropdown untuk memilih Parent Folder -->
                                <div class="mb-4">
                                    <label class="form-label">Parent Folder (Opsional)</label>
                                    <select name="parent_id" class="form-control">
                                        @if ($statusKriteria == 0)
                                            <option value="0">None (Folder Utama)</option>
                                        @endif
                                        @foreach ($allFolders as $folder)
                                            <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Pilih folder ini sebagai subfolder dari parent tertentu atau
                                        pilih None untuk menjadikannya folder utama.</small>
                                </div>

                                <div class="mb-4">
                                    <button class="btn btn-primary" type="submit">Simpan dan Buka Folder</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if ($idf != 0)
            <div class="col-xl-6">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <h2 class="content-heading pt-0">Upload File</h2>
                        <form action="{{ route('admin.file.upload', ['id' => $idf]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row push">
                                <div class="col-lg-12 col-xl-12 overflow-hidden">
                                    <p class="text-muted">
                                        (<code>*</code>) Wajib Diisi<br>
                                    </p>
                                    <div class="mb-4">
                                        <label class="form-label">Nama File<code>*</code></label>
                                        <input type="text" name="name" placeholder="Masukkan Nama File"
                                            class="form-control" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Tag<code>*</code></label>
                                        <input type="text" name="tag" placeholder="Masukkan Tag File"
                                            class="form-control" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Deskripsi<code>*</code></label>
                                        <textarea name="description" rows="3" placeholder="Masukkan Deskripsi File" class="form-control" required></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Pilih File<code>*</code></label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>
                                    <div class="mb-4">
                                        <button class="btn btn-primary" type="submit">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
