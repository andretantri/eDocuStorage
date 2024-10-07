@extends('layouts.full')

@section('title', 'Pencarian Folder atau File')

@section('content-bc', 'Pencarian Folder atau File')

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
    <script>
        $(document).ready(function() {

            $('#tabelData').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                ajax: {
                    url: '{{ route('admin.get.kriteria') }}',
                    type: 'GET',
                },
                dataSrc: function(json) {
                    if (json.recordsTotal === undefined || json.recordsFiltered === undefined) {
                        json.recordsTotal = 0;
                        json.recordsFiltered = 0;
                    }
                    return json.data;
                },
                language: {
                    emptyTable: "Belum Ada Data Tersedia"
                },
                columns: [{
                        data: null,
                        name: 'number',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        render: function(data, type, row) {
                            let questionUrl =
                                '{{ route('admin.folder.tabel', [':id', ':folder']) }}'.replace(
                                    ':id', data.id).replace(
                                    ':folder', '0');
                            var userRole =
                                "{{ Auth::user()->role }}";
                            return `
                                ${userRole === 'admin' ? `
                                                                        <a href="{{ route('admin.kriteria.edit', ['id' => ':id']) }}" class="btn btn-sm btn-primary">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data.id}">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    ` : ''}
                                <a href="${questionUrl}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            `.replace(':id', data.id);
                        }
                    }
                ]
            });

        });
    </script>

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
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Pencarian Folder atau File</h2>
            <form action="{{ route('admin.pencarian') }}" method="GET" id="searchForm">
                <div class="mb-4">
                    <label class="form-label">Cari Folder atau File<code>*</code></label>
                    <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci" required>
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
            <div id="searchResults"></div>
        </div>
        <div class="block block-rounded">

            <div class="block-content block-content-full">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Data Kriteria</h3>
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
                                <th>Nama Kriteria</th>
                                <th>Keterangan</th>
                                <th width='20%'>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const searchValue = this.search.value;

            fetch(`{{ route('admin.pencarian') }}?search=${searchValue}`)
                .then(response => response.json())
                .then(data => {
                    let resultsHtml = '';

                    // Tampilkan hasil folder
                    if (data.folders.length) {
                        resultsHtml += '<h3>Folders</h3><ul class="list-group">';
                        data.folders.forEach(folder => {
                            resultsHtml += `
                            <li class="list-group-item">
                                <a href="{{ route('admin.folder.view', ['id' => 'CRITERIA_ID', 'folder' => 'FOLDER_ID']) }}"
                                   onclick="this.href=this.href.replace('CRITERIA_ID', ${folder.criteria_id}).replace('FOLDER_ID', ${folder.id});">
                                   ${folder.name} (Tag: ${folder.tag_folder})
                                </a>
                            </li>`;
                        });
                        resultsHtml += '</ul>';
                    }

                    // Tampilkan hasil file
                    if (data.files.length) {
                        resultsHtml += '<h3>Files</h3><ul class="list-group">';
                        data.files.forEach(file => {
                            resultsHtml += `
                            <li class="list-group-item">
                                <a href="{{ route('admin.file.stream', ['id' => 'FILE_ID']) }}"
                                   onclick="this.href=this.href.replace('FILE_ID', ${file.id});">
                                   ${file.name} (Tag: ${file.tag})
                                </a>
                            </li>`;
                        });
                        resultsHtml += '</ul>';
                    }

                    if (!data.folders.length && !data.files.length) {
                        resultsHtml = '<p>Tidak ada hasil ditemukan.</p>';
                    }

                    document.getElementById('searchResults').innerHTML = resultsHtml;
                });
        });
    </script>
@endsection
