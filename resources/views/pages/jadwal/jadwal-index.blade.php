@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
    <div class="container-fluid">
        <div class="card-breadcrumb">
            <x-breadcrumb title="{{ $pageTitle }}" :links="[
                'Dashboard' => route('dashboard'),
                $pageTitle => '#',
            ]" />
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title fw-semibold mb-0">Data {{ $pageTitle }}</h5>
                <button type="button" class="btn btn-sm btn-primary modal-cre d-flex align-items-center"
                    id="jadwal-perkuliahan" parent="0" judul="Tambah {{ $pageTitle }}">
                    <iconify-icon icon="solar:add-square-bold" class="me-1" width="20" height="20"></iconify-icon>
                    Tambah</button>
            </div>
            <div class="card-body">

                {{-- <p class="mb-0">This is a sample page </p> --}}
                <table class="table table-striped" id="DTable">
                    <thead>
                        <tr>
                            <th width="20">No</th>
                            <th>Mata Kuliah</th>
                            <th>Program Studi</th>
                            <th>Tahun Akademik</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>SKS</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@pushOnce('scripts')
    <script>
        let DTable = new DataTable('#DTable', {
            ajax: "{{ route('datatable', ['table' => 'jadwal']) }}",
            processing: true,
            columnDefs: [{
                className: "align-middle text-center",
                targets: ['_all'],
            }, {
                targets: 0,
                searchable: false,
                orderable: false,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).html(row + 1 + '. '); // Updates the first column with index
                }
            }],
            order: [
                [0, 'asc']
            ],
            columns: [{
                data: null,
            }, {
                data: 'mata_kuliah',
            }, {
                data: 'program_studi',
            }, {
                data: 'tahun_akademik',
            }, {
                data: 'hari',
            }, {
                data: 'jam',
            }, {
                data: 'sks',
            }, {
                data: 'action',
            }, ],
        });
    </script>
@endPushOnce
