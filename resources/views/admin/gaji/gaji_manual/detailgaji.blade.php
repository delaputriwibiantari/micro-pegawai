@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Crypt;
    $pendapatan = $detail->where('jenis', 'PENGHASIL');
    $potongan = $detail->where('jenis', 'POTONGAN');
@endphp
@extends('admin.layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}">
@endsection

@section('list')
    <li class="breadcrumb-item text-muted">Penggajian</li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Manual</li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">Detail Gaji</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Header Info -->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!-- Header Info (Personal Data) -->
                <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative rounded">
                            <img src="{{ $person->foto !== null ? route('admin.view-file', ['person', $person->foto]) : asset('assets/media/logos/preview.png') }}"
                                 alt="Profile Image"
                                 class="w-125px h-125px object-fit-cover rounded">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
                            <div class="d-flex flex-column flex-grow-1">
                                <div class="d-flex align-items-center mb-3">
                                    <h2 class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                        {{ $person->nama_lengkap ?? 'Nama tidak tersedia' }}
                                    </h2>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center text-gray-600">
                                            <span class="fs-7">NIK: {{ $person->nik ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center text-gray-600">
                                            <span class="fs-7">No. KK: {{ $person->kk ?? '-' }}</span>
                                        </div>
                                    </div>
                                    @if ($person->npwp)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center text-gray-600">
                                                <span class="fs-7">NPWP: {{ $person->npwp }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($person->nomor_hp)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center text-gray-600">
                                                <span class="fs-7">HP: {{ $person->no_hp }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($person->tempat_lahir || $person->tanggal_lahir)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center text-gray-600">
                                                <span class="fs-7">
                                                    {{ $person->tempat_lahir ?? '' }}{{ $person->tempat_lahir && $person->tanggal_lahir ? ', ' : '' }}{{ $person->tanggal_lahir ? Carbon::parse($person->tanggal_lahir)->format('d M Y') : '' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $fullAddress = collect([
                                            $person->alamat,
                                            $person->desa,
                                            $person->kecamatan ? 'Kec. ' . $person->kecamatan : null,
                                            $person->kabupaten,
                                            $person->provinsi,
                                        ])
                                            ->filter()
                                            ->implode(', ');
                                    @endphp
                                    @if ($fullAddress)
                                        <div class="col-12">
                                            <div class="d-flex align-items-start text-gray-600">
                                                <span class="fs-7">{{ $fullAddress }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Tabs -->
                <div class="nav-wrapper mb-6">
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-6 fw-semibold flex-nowrap overflow-auto">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-8 py-5 active text-nowrap"
                               href="#">Rincian Gaji</a>
                        </li>
                    </ul>
                </div>

                <!-- Salary Content (Wrapped inside the same card body) -->
                <div class="table-responsive mb-8 shadow p-6 mx-0 border-hover-dark border-primary border-1 border-dashed rounded-2">
                    <!-- Period Info -->
                    <div class="row g-3 mb-8">
                        <div class="col-md-4">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4">
                                <div class="fs-7 text-gray-400 fw-bold">Periode Gaji</div>
                                <div class="fs-6 text-gray-800 fw-bolder">
                                    {{ Carbon::parse($trx->tanggal_mulai)->translatedFormat('F Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4">
                                <div class="fs-7 text-gray-400 fw-bold">Status</div>
                                <div class="fs-6 text-gray-800 fw-bolder">
                                    <span class="badge badge-light-primary">{{ $trx->status ?? 'DRAFT' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4">
                                <div class="fs-7 text-gray-400 fw-bold">ID Sdm</div>
                                <div class="fs-6 text-gray-800 fw-bolder">{{ $trx->sdm_id }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-10">
                        <!-- Pendapatan -->
                        <div class="col-xl-6">
                            <div class="mb-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">PENGHASIL</span>
                                    <span class="text-gray-400 mt-1 fw-bold fs-7 d-block">Rincian pendapatan bulan ini</span>
                                </h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-4">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-150px">Komponen</th>
                                            <th class="min-w-100px text-end pe-3">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-800 fw-bolder fs-6">
                                        @forelse ($pendapatan as $p)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-gray-900 fw-bold mb-1">{{ $p->nama_komponen }}</span>
                                                        <span class="text-muted fw-semibold fs-7">{{ $p->keterangan }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <span>Rp {{ number_format($p->nominal, 0, ',', '.') }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted py-10">Tidak ada data pendapatan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light-success rounded">
                                            <td class="ps-3 fw-bolder text-success">Total Pendapatan</td>
                                            <td class="pe-3 text-end fw-bolder text-success">
                                                Rp {{ number_format($trx->total_penghasil, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Potongan -->
                        <div class="col-xl-6">
                            <div class="mb-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">POTONGAN</span>
                                    <span class="text-gray-400 mt-1 fw-bold fs-7 d-block">Rincian potongan bulan ini</span>
                                </h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-row-bordered table-row-solid gs-0 gy-4">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-150px">Komponen</th>
                                            <th class="min-w-100px text-end pe-3">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-800 fw-bolder fs-6">
                                        @forelse ($potongan as $pt)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-gray-900 fw-bold mb-1">{{ $pt->nama_komponen }}</span>
                                                        <span class="text-muted fw-semibold fs-7">{{ $pt->keterangan }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <span>Rp {{ number_format($pt->nominal, 0, ',', '.') }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted py-10">Tidak ada data potongan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light-danger rounded">
                                            <td class="ps-3 fw-bolder text-danger">Total Potongan</td>
                                            <td class="pe-3 text-end fw-bolder text-danger">
                                                Rp {{ number_format($trx->total_potongan, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Summary (THP) -->
                    <div class="mt-8">
                        <div class="card bg-primary shadow-sm border-0">
                            <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between p-6">
                                <div class="text-white mb-2 mb-md-0">
                                    <h4 class="text-white fw-bolder mb-0">Take Home Pay</h4>
                                    <p class="text-white opacity-75 fw-bold mb-0 fs-7">Total gaji bersih yang diterima pegawai</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="text-white fs-4 fw-bolder me-2">Rp</span>
                                    <span class="text-white fs-2hx fw-bolder">
                                        {{ number_format($trx->total_dibayar, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="d-flex justify-content-end mb-10 pb-5">
                    <a href="{{ route('admin.gaji.gaji_manual.index', ['admin' => Crypt::encryptString(auth('admin')->id())]) }}" class="btn btn-sm btn-light-primary me-3">
                        <i class="bi bi-arrow-left me-2"></i> Kembali
                    </a>
                    <button class="btn btn-sm btn-primary" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i> Cetak Slip
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <!-- No additional scripts needed for basic display -->
@endsection
