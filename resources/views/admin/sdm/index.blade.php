@extends('admin.layout.index')

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="content flex-column-fluid">
            <div class="card mb-xl-8 mb-5 border-2 shadow">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder mb-1">Data SDM</span>
                    </h3>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <a type="button" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6" data-bs-toggle="modal"
                               data-bs-target="#form_create" title="Tambah SDM">Tambah SDM</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    <!-- Notice Box seperti di Person -->
                    <div class="notice d-flex border-primary mb-4 rounded border border-dashed p-4 shadow bg-hover-light-dark">
                        <div class="d-flex flex-stack fs-sm-8 fs-lg-6">
                            <div class="row">
                                <span class="text-gray-700">Berikut ini adalah data SDM (Sumber Daya Manusia).</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Container dengan styling yang sama -->
                    <div class="table-responsive mb-8 shadow p-4 mx-0 border-hover-dark border-primary border-1 border-dashed fs-sm-8 fs-lg-6 rounded-2">
                        <div class="table-responsive">
                            <table id="sdmTable" class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 fs-sm-8 fs-lg-6">
                                        <th class="min-w-75px ps-5">Aksi</th>
                                        <th class="min-w-150px">NIP</th>
                                        <th class="min-w-60px">Status Pegawai</th>
                                        <th class="min-w-120px">Tipe Pegawai</th>
                                        <th class="min-w-100px">Tanggal Masuk</th>
                                        <th class="min-w-120px">ID Person</th>
                                        <th class="min-w-120px">Nama Lengkap</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 fw-bolder fs-sm-8 fs-lg-6">
                                    <!-- Data akan diisi oleh DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.sdm.view.create')
    @include('admin.sdm.view.edit')

@endsection

@section('javascript')
    @include('admin.sdm.script.list')
    @include('admin.sdm.script.create')
    @include('admin.sdm.script.edit')
    @include('admin.sdm.script.detail')
<!-- jQuery (WAJIB duluan) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables Core -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Responsive (biar tabel menyesuaikan di HP/laptop) -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- DataTables Buttons (export Excel, CSV, dll) -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- JSZip buat export Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- Lodash (buat debounce search biar gak lag) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>

<script>
        function fetchDataDropdown(url, id, placeholder, name, callback) {
            DataManager.executeOperations(url, 'admin_' + url, 120).then(response => {
                $(id).empty().append('<option></option>');
                if (response.success) {
                    response.data.forEach(item => {
                        $(id).append(`<option value="${item['id_' + placeholder]}">${item[name]}</option>`);
                    });

                    // ✅ Jalankan select2 hanya jika plugin-nya ada
                    if ($.fn.select2) {
                        $(id).select2();
                    }

                    if (callback) {
                        callback();
                    }
                } else if (!response.errors) {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(error => {
                ErrorHandler.handleError(error);
            });
        }

    </script>
@endsection
