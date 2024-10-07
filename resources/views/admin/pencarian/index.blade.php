@extends('layouts.full')

@section('title', 'Pencarian Folder atau File')

@section('content-bc', 'Pencarian Folder atau File')

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
