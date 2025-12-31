@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

$adminEnc = Auth::guard('admin')->check()
    ? Crypt::encryptString(Auth::guard('admin')->id())
    : null;
@endphp

@if(session('admin_role') === 'developer')
    <li>Manajemen User</li>
@endif

<div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper"
     data-kt-scroll="true"
     data-kt-scroll-activate="{default: false, lg: true}"
     data-kt-scroll-height="auto"
     data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
     data-kt-scroll-wrappers="#kt_aside_menu"
     data-kt-scroll-offset="0">
    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
         id="#kt_aside_menu"
         data-kt-menu="true">
        <div class="menu-item">
            <a class="menu-link" href="{{ route('index', ['admin' => $adminEnc]) }}">
                <span class="menu-title">Dashboard</span>
            </a>

            <a class="menu-link {{ request()->routeIs('admin.admin.person.index') ? 'active' : '' }}"
               href="{{ route('admin.admin.person.index', ['admin' => $adminEnc]) }}">
                <span class="menu-title">Person</span>
            </a>

            <a class="menu-link {{ request()->routeIs('admin.sdm.index') ? 'active' : '' }}"
               href="{{ route('admin.sdm.index', ['admin' => $adminEnc]) }}">
                <span class="menu-title">SDM</span>
            </a>

            @php
                $referensiActive =
                    request()->routeIs('admin.ref.jenjang-pendidikan.*') ||
                    request()->routeIs('admin.ref.hubungan-keluarga.*') ||
                    request()->routeIs('admin.ref.jenis-asuransi.*') ||
                    request()->routeIs('admin.ref.jenis-dokumen.*') ||
                    request()->routeIs('admin.ref.bank.*') ||
                    request()->routeIs('admin.ref.eselon.*');
            @endphp

            <div data-kt-menu-trigger="click"
                 class="menu-item menu-accordion {{ $referensiActive ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-title">Referensi</span>
                    <span class="menu-arrow"></span>
                </span>

                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <a class="menu-link" href="{{ route('admin.ref.jenjang-pendidikan.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Jenjang Pendidikan</span>
                    </a>
                    <a class="menu-link" href="{{ route('admin.ref.hubungan-keluarga.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Hubungan Keluarga</span>
                    </a>
                    <a class="menu-link" href="{{ route('admin.ref.jenis-asuransi.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Jenis Asuransi</span>
                    </a>
                    <a class="menu-link" href="{{ route('admin.ref.eselon.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Eselon</span>
                    </a>
                    <a class="menu-link" href="{{ route('admin.ref.jenis-dokumen.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Jenis Dokumen</span>
                    </a>
                    <a class="menu-link" href="{{ route('admin.ref.bank.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Bank</span>
                    </a>
                </div>
            </div>
            @php
                $masterActive =
                    request()->routeIs('admin.master.periode.*') ||
                    request()->routeIs('admin.master.unit.*') ||
                    request()->routeIs('admin.master.jabatan.*');
            @endphp
            <div data-kt-menu-trigger="click"
                 class="menu-item menu-accordion {{ $masterActive ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-title">Master</span>
                    <span class="menu-arrow"></span>
                </span>

                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <a class="menu-link" href="{{ route('admin.master.periode.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Periode</span>
                    </a>
                    <a class="menu-link" href="{{ route('admin.master.unit.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Unit</span>
                    </a>
                    <a class="menu-link" href="{{ route('admin.master.jabatan.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Jabatan</span>
                    </a>
                     @auth('admin')
                        @if(Auth::guard('admin')->user()->role === 'developer')
                            <a class="menu-link" href="{{ route('admin.master.user.index', ['admin' => $adminEnc]) }}">
                                <span class="menu-title px-4">Manajemen User</span>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
            @php
                $gajiActive = request()->routeIs('admin.gaji.gaji_manual.*')||
                                request()->routeIs('admin.gaji.gaji_periode.*')||
                                request()->routeIs('admin.gaji.komponen_gaji.*')||
                                request()->routeIs('admin.gaji.gaji_umum.*')||
                                request()->routeIs('admin.gaji.gaji_jabatan.*')||
                                request()->routeIs('admin.gaji.tarif_lembur.*')||
                                request()->routeIs('admin.gaji.tarif_potongan.*');
            @endphp

            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ $gajiActive ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-title">Refrensi Gaji</span>
                    <span class="menu-arrow"></span>
                </span>

                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <a class="menu-link {{ request()->routeIs('admin.gaji.gaji_manual.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.gaji_manual.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Penggajian Manual</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.gaji.gaji_periode.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.gaji_periode.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Priode Gaji</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.gaji.komponen_gaji.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.komponen_gaji.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Komponen Gaji</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.gaji.gaji_umum.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.gaji_umum.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Gaji Umum</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.gaji.gaji_jabatan.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.gaji_jabatan.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Gaji Jabatan</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.gaji.tarif_lembur.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.tarif_lembur.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Tarif Lembur</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.gaji.tarif_potongan.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.tarif_potongan.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Tarif Potongan</span>
                    </a>
                </div>
            </div>

           @php
                $absensiActive = request()->routeIs('admin.absensi.jenis_absensi.*')||
                                request()->routeIs('admin.absensi.jadwal_kerja.*')||
                                request()->routeIs('admin.absensi.libur_nasional.*')||
                                request()->routeIs('admin.absensi.libur_perusahaan.*')||
                                request()->routeIs('admin.absensi.cuti.*')||
                                request()->routeIs('admin.absensi.izin.*')||
                                request()->routeIs('admin.absensi.lembur.*')||
                                request()->routeIs('admin.absensi.absensi.*');
            @endphp

            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ $absensiActive ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-title">Refrensi Absensi</span>
                    <span class="menu-arrow"></span>
                </span>

                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <a class="menu-link {{ request()->routeIs('admin.absensi.absensi.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.absensi.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Absensi</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.absensi.jenis_absensi.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.jenis_absensi.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Jenis Absensi</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.absensi.jadwal_kerja.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.jadwal_kerja.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Jadwal Kerja</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.absensi.libur_nasional.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.libur_nasional.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Libur Nasional</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.absensi.libur_perusahaan.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.libur_perusahaan.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Libur Perusahaan</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.absensi.cuti.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.cuti.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Pengajuan Cuti</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.absensi.izin.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.izin.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Pengajuan Izin</span>
                    </a>

                    <a class="menu-link {{ request()->routeIs('admin.absensi.lembur.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.lembur.index', ['admin' => $adminEnc]) }}">
                        <span class="menu-title px-4">Pengajuan Lembur</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
