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
                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" onclick="logOutSemua()" class="btn btn-sm btn-warning d-flex align-items-center">
                        <iconify-icon icon="solar:logout-3-bold" class="me-1" width="20"
                            height="20"></iconify-icon>Log out semua</button>
                    <button type="button" class="btn btn-sm btn-primary modal-cre d-flex align-items-center" id="user"
                        parent="0">
                        <iconify-icon icon="solar:add-square-bold" class="me-1" width="20"
                            height="20"></iconify-icon>
                        Tambah</button>
                </div>
            </div>
            <div class="card-body">

                {{-- <p class="mb-0">This is a sample page </p> --}}
                <table class="table table-striped" id="DTable">
                    <thead>
                        <tr>
                            <th width="20">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Address</th>
                            <th>Status</th>
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
        function logOutSemua() {

            Swal.fire({
                title: "Perhatian!",
                text: "Kamu yakin ingin menghapus semua session user yang aktif (Log-out)?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    var base_url = $('meta[name="base-url"]').attr("content");
                    var page = base_url + "/user/logout-all";
                    console.log(page);
                    $('#page-pre-loader').show();
                    axios.get(page)
                        .then(function(response) {
                            $('#page-pre-loader').hide();
                            if (response.param == true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.data.message,
                                });
                            } else {
                                Toast.fire({
                                    icon: 'warning',
                                    title: response.data.message,
                                });
                            }
                            console.log(response);
                        })
                        .catch(function(error) {
                            $('#page-pre-loader').hide();
                            console.log(error);
                        });
                }
            });
        }

        function logOutUser($id) {
            Swal.fire({
                title: "Perhatian!",
                text: "Kamu yakin ingin menghapus session user ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    var base_url = $('meta[name="base-url"]').attr("content");
                    var page = base_url + "/user/logout/" + $id;
                    console.log(page);
                    $('#page-pre-loader').show();
                    axios.get(page)
                        .then(function(response) {
                            console.log(response);

                            $('#page-pre-loader').hide();
                            if (response.param == true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.data.message,
                                });
                            } else {
                                Toast.fire({
                                    icon: 'warning',
                                    title: response.data.message,
                                });
                            }
                        })
                        .catch(function(error) {
                            $('#page-pre-loader').hide();
                            console.log(error);
                        });
                }
            });
        }


        let DTable = new DataTable('#DTable', {
            ajax: "{{ route('datatable', ['table' => 'user']) }}",
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
                data: 'name',
            }, {
                data: 'email',
            }, {
                data: 'roles',
            }, {
                data: 'address',
            }, {
                data: 'status',
            }, {
                data: 'action',
            }, ],
        });
    </script>
@endPushOnce
