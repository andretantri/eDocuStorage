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
@endsection

@section('content-isi')
    <div class="row items-push">
        <div class="col-xl-12">
            <!-- Breadcrumb Section -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a
                            href="{{ route('admin.folder.view', ['id' => $kriteria->id, 'folder' => 0]) }}">{{ $kriteria->name }}</a>
                    </li>

                    <!-- Iterasi Breadcrumbs jika ada data folder parent -->
                    @if ($breadcrumbs != '[]')
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item" aria-current="page">
                                <a
                                    href="{{ route('admin.folder.view', ['id' => $kriteria->id, 'folder' => $breadcrumb['id']]) }}">
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
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->count() != 0)
                                @foreach ($data as $index => $content)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a
                                                href="{{ route('admin.folder.view', ['id' => $kriteria->id, 'folder' => $content->id]) }}">
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
@endsection
