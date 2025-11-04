@extends('admin.layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/responsive.bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}"/>
@endsection

@section('content')
<div class="container-fluid">
    <div class="content flex-column-fluid">
        <div class="card mb-8 border-2 shadow-sm rounded-3">

            <!-- === HEADER PROFIL PEGAWAI === -->
            <div id="detail_person" class="card-body border-bottom py-5">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-100px me-4">
                        <img id="foto_person"  alt="Foto Pegawai" class="rounded">
                    </div>
                    <div>
                        <h4 id="nama_lengkap" class="fw-bold mb-1 text-dark">-</h4>
                        <div class="text-muted fs-7" id="nik_person">NIK: -</div>
                        <div class="text-muted fs-7" id="nip_person">NIP: -</div>
                        <div class="text-muted fs-7" id="alamat_person">Alamat: -</div>
                    </div>
                </div>
            </div>

            <!-- === NAVIGASI TAB === -->
            <div class="card-body pt-0">
                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active text-primary fw-bold" data-bs-toggle="tab" href="#tab-beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-bold" data-bs-toggle="tab" href="#tab-keluarga">Keluarga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-bold" data-bs-toggle="tab" href="#tab-pendidikan">Pendidikan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-bold" data-bs-toggle="tab" href="#tab-asuransi_karyawan">Asuransi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-bold" data-bs-toggle="tab" href="#tab-kepegawaian">Kepegawaian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-bold" data-bs-toggle="tab" href="#tab-dokumen">Dokumen</a>
                    </li>
                </ul>

                <!-- === TAB KONTEN === -->
                <div class="tab-content">

                    <!-- === TAB BERANDA === -->
                    <div class="tab-pane fade show active" id="tab-beranda" role="tabpanel">
                        <div class="p-5 text-center">
                            <h4 class="fw-bold text-dark mb-3">Selamat datang di Profil Pegawai 👋</h4>
                            <p class="text-muted">
                                Di halaman ini kamu bisa melihat data lengkap pegawai seperti <b>Keluarga</b>, <b>Pendidikan</b>, <b>Asuransi</b>, <b>Kepegawaian</b>, dan <b>Dokumen</b>.
                                Klik tab di atas untuk melihat detail masing-masing data.
                            </p>
                        </div>
                    </div>

                                        <!-- === TAB KELUARGA === -->
                    <div class="tab-pane fade" id="tab-keluarga" role="tabpanel">
                        <div class="container-fluid">
                            <div class="content flex-column-fluid">
                                <div class="card mb-xl-8 mb-5 border-2 shadow">
                                    <div class="card-header">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bolder mb-1 ">Data Person</span>
                                        </h3>
                                        <div class="card-toolbar">
                                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                                <a type="button" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6" data-bs-toggle="modal"
                                                data-bs-target="#form_create" title="Tambah Person">Tambah Person</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-5">
                                        <div class="notice d-flex border-primary mb-4 rounded border border-dashed p-4 shadow bg-hover-light-dark">
                                            <div class="d-flex flex-stack fs-sm-8 fs-lg-6">
                                                <div class="row">
                                                    <span class="text-gray-700">Berikut ini adalah data Person.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive mb-8 shadow p-4 mx-0 border-hover-dark border-primary border-1 border-dashed fs-sm-8 fs-lg-6 rounded-2">
                                            <div class="table-responsive">
                                                <table id="example"
                                                    class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                                                    <thead>
                                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 fs-sm-8 fs-lg-6">
                                                        <th class="min-w-75px ps-5">Aksi</th>
                                                        <th class="min-w-150px">ID SDM</th>
                                                        <th class="min-w-60px">ID Person</th>
                                                        <th class="min-w-120px">Status</th>
                                                        <th class="min-w-100px">Status Tanggungan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="text-gray-800 fw-bolder fs-sm-8 fs-lg-6">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            <!-- === TAB PENDIDIKAN === -->
                    <div class="tab-pane fade" id="tab-pendidikan" role="tabpanel">
                        <div class="container-fluid">
                            <div class="content flex-column-fluid">
                                <div class="card mb-xl-8 mb-5 border-2 shadow">
                                    <div class="card-header">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bolder mb-1 ">Data Person</span>
                                        </h3>
                                        <div class="card-toolbar">
                                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                                <input type="hidden" id="id_sdm" name="id_sdm">
                                                <a type="button" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6" data-bs-toggle="modal"
                                                data-bs-target="#form_create_pendidikan" title="Tambah Person">Tambah Pendidikan</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-5">
                                        <div class="notice d-flex border-primary mb-4 rounded border border-dashed p-4 shadow bg-hover-light-dark">
                                            <div class="d-flex flex-stack fs-sm-8 fs-lg-6">
                                                <div class="row">
                                                    <span class="text-gray-700">Berikut ini adalah data Person.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive mb-8 shadow p-4 mx-0 border-hover-dark border-primary border-1 border-dashed fs-sm-8 fs-lg-6 rounded-2">
                                            <div class="table-responsive">
                                                <table id="example"
                                                    class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                                                    <thead>
                                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 fs-sm-8 fs-lg-6">
                                                        <th class="min-w-75px ps-5">Aksi</th>
                                                        <th class="min-w-150px">ID Sdm</th>
                                                        <th class="min-w-60px">Institusi</th>
                                                        <th class="min-w-120px">Jurusan</th>
                                                        <th class="min-w-100px">Tahun Masuk</th>
                                                        <th class="min-w-120px">Tahun Lulus</th>
                                                        <th class="min-w-120px">Jenis Nilai</th>
                                                        <th class="min-w-120px">SKS</th>
                                                        <th class="min-w-120px">Sumber Biaya</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="text-gray-800 fw-bolder fs-sm-8 fs-lg-6">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                            <!-- === TAB ASURANSI === -->
                            <div class="tab-pane fade" id="tab-asuransi_karyawan" role="tabpanel">
                                <div class="table-responsive mb-8 shadow p-4 border-hover-dark border-primary border-1 border-dashed rounded-2">
                                    <table id="asuransiTable" class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                                                <th class="min-w-75px ps-5">Aksi</th>
                                                <th class="min-w-150px">ID Sdm</th>
                                                <th class="min-w-60px">Jenis Asuransi</th>
                                                <th class="min-w-120px">Nomor Peserta</th>
                                                <th class="min-w-100px">Tanggal Aktif</th>
                                                <th class="min-w-100px">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-800 fw-bolder"></tbody>
                                    </table>
                                </div>
                            </div>

                    <!-- === TAB KEPEGAWAIAN === -->
                    <div class="tab-pane fade" id="tab-kepegawaian" role="tabpanel">
                        <div class="table-responsive mb-8 shadow p-4 border-hover-dark border-primary border-1 border-dashed rounded-2">
                            <table id="kepegawaianTable" class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                                        <th class="min-w-75px ps-5">Aksi</th>
                                        <th class="min-w-150px">ID Sdm</th>
                                        <th class="min-w-60px">Jabatan</th>
                                        <th class="min-w-120px">Unit</th>
                                        <th class="min-w-100px">Tanggal Mulai</th>
                                        <th class="min-w-100px">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 fw-bolder"></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- === TAB DOKUMEN === -->
                    <div class="tab-pane fade" id="tab-dokumen" role="tabpanel">
                        <div class="table-responsive mb-8 shadow p-4 border-hover-dark border-primary border-1 border-dashed rounded-2">
                            <table id="dokumenTable" class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                                        <th class="min-w-75px ps-5">Aksi</th>
                                        <th class="min-w-150px">ID Sdm</th>
                                        <th class="min-w-60px">Jenis Dokumen</th>
                                        <th class="min-w-120px">Nomor Dokumen</th>
                                        <th class="min-w-100px">Tanggal Terbit</th>
                                        <th class="min-w-100px">Tanggal Berlaku</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 fw-bolder"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div>
</div>
@include('admin.pendidikan.view.create')
@endsection

@section('javascript')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/lodash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/print.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap.min.js') }}"></script>
    <script>
        function fetchDataDropdown(url, id, placeholder, name, callback) {
            DataManager.executeOperations(url, 'admin_' + url, 120).then(response => {
                $(id).empty().append('<option></option>');
                if (response.success) {
                    response.data.forEach(item => {
                        $(id).append(`<option value="${item['id_' + placeholder]}">${item[name]}</option>`);
                    });
                    $(id).select2();
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

    @include('admin.pendidikan.script.list')
    @include('admin.pendidikan.script.create')
    @include('admin.pendidikan.script.edit')
    @include('admin.pendidikan.script.detail')

@endsection
