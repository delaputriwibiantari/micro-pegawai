@extends('admin.layout.index')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="content flex-column-fluid">
        <div class="card mb-8 border-2 shadow-sm rounded-3">

            <!-- === HEADER PROFIL PEGAWAI === -->
            <div id="detail_person" class="card-body border-bottom py-5">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-100px me-4">
                        <img id="foto_person" src="{{ asset('assets/img/default-user.png') }}" alt="Foto Pegawai" class="rounded">
                    </div>
                    <div>
                        <h4 id="nama_person" class="fw-bold mb-1 text-dark">-</h4>
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
                        <div class="table-responsive mb-8 shadow p-4 border-hover-dark border-primary border-1 border-dashed rounded-2">
                            <table id="keluargaTable" class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                                        <th class="min-w-75px ps-5">Aksi</th>
                                        <th class="min-w-150px">ID Sdm</th>
                                        <th class="min-w-60px">ID Person</th>
                                        <th class="min-w-120px">Status</th>
                                        <th class="min-w-100px">Status Tanggungan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 fw-bolder"></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- === TAB PENDIDIKAN === -->
                    <div class="tab-pane fade" id="tab-pendidikan" role="tabpanel">
                        <div class="table-responsive mb-8 shadow p-4 border-hover-dark border-primary border-1 border-dashed rounded-2">
                            <table id="pendidikanTable" class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-2">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
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
                                <tbody class="text-gray-800 fw-bolder"></tbody>
                            </table>
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
@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    // Inisialisasi semua DataTables
    $('#keluargaTable, #pendidikanTable, #asuransiTable, #kepegawaianTable, #dokumenTable').DataTable({
        responsive: true,
        paging: false,
        searching: false,
        info: false
    });
});
</script>
@endsection
