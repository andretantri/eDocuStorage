@extends('layouts.full')

@section('title', 'Dashboard Admin')

@section('content-bc', 'Dashboard Admin')

@section('js')
    <script src="{{ asset('template/assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/chart.js/chart.umd.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>


    <script></script>
@endsection

@section('content-isi')
    <div class="row items-push">
        <div class="col-xl-12">
            <div class="block block-rounded">
                <div class="block-content">
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <strong>Nama Aplikasi:</strong> eDocuStorage
                        </li>
                        <li class="list-group-item">
                            <strong>Versi Aplikasi:</strong> 1.0.0
                        </li>
                        <li class="list-group-item">
                            <strong>PHP Version:</strong> {{ phpversion() }}
                        </li>
                        <li class="list-group-item">
                            <strong>Database Connection:</strong> {{ config('database.default') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Laravel Version:</strong> {{ app()->version() }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
