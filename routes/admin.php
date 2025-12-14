<?php

use App\Http\Controllers\admin\absensi\CutiController;
use App\Http\Controllers\admin\absensi\JadwalKerjaController;
use App\Http\Controllers\admin\absensi\JenisAbsensiController;
use App\Http\Controllers\admin\absensi\LiburNasionalController;
use App\Http\Controllers\admin\absensi\LiburPerusahaanController;
use App\Http\Controllers\admin\gaji\GajiJabatanController;
use App\Http\Controllers\admin\gaji\GajiManualController;
use App\Http\Controllers\admin\gaji\GajiPeriodeController;
use App\Http\Controllers\admin\gaji\GajiUmumController;
use App\Http\Controllers\admin\gaji\KomponenGajiController;
use App\Http\Controllers\admin\gaji\TarifLemburController;
use App\Http\Controllers\admin\gaji\TarifPotonganController;
use App\Http\Controllers\admin\master\MasterJabatanController;
use App\Http\Controllers\Admin\Master\MasterPeriodeController;
use App\Http\Controllers\admin\master\MasterUnitController;
use App\Http\Controllers\admin\master\MasterUserController;
use App\Http\Controllers\admin\pendidikan\PendidikanController;
use App\Http\Controllers\admin\person\PersonAsuransiController;
use App\Http\Controllers\Content\PortalController;
use App\Http\Controllers\admin\person\PersonController;
use App\Http\Controllers\admin\ref\RefBankController;
use App\Http\Controllers\admin\ref\RefEselonController;
use App\Http\Controllers\admin\ref\RefHubunganKeluargaController;
use App\Http\Controllers\admin\ref\RefJenisAsuransiController;
use App\Http\Controllers\admin\ref\RefJenisDokumenController;
use App\Http\Controllers\admin\sdm\SdmController;
use App\Http\Controllers\admin\ref\RefJenjangPendidikanController;
use App\Http\Controllers\admin\sdm\SdmDokumenController;
use App\Http\Controllers\admin\sdm\SdmKeluargaController;
use App\Http\Controllers\admin\sdm\SdmPendidikanController;
use App\Http\Controllers\Admin\Sdm\SdmRekeningController;
use App\Http\Controllers\admin\sdm\SdmStrukturalController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:admin,developer'])->group(function () {
    Route::get('view-file/{folder}/{filename}', [PortalController::class, 'viewFile'])
        ->where(['folder' => '[A-Za-z0-9_\-]+', 'filename' => '[A-Za-z0-9_\-\.]+'])
        ->name('view-file');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('person')->name('person.')->group(function () {
            Route::get('/', [PersonController::class, 'index'])
                ->name('index'); // Menjadi: admin.person.index
            Route::get('data', [PersonController::class, 'list'])
                ->name('list'); // Menjadi: admin.person.list
            Route::get('show/{id}', [PersonController::class, 'show'])
                ->name('show'); // Menjadi: admin.person.show
            Route::post('/store', [PersonController::class, 'store'])
                ->name('store'); // Menjadi: admin.person.store
            Route::post('update/{id}', [PersonController::class, 'update'])
                ->name('update'); // Menjadi: admin.person.update
            Route::post('destroy/{id}', [PersonController::class, 'destroy'])
                ->name('destroy');
        });
    });

    Route::prefix('sdm')->name('sdm.')->group(function () {
        Route::get('/', [SdmController::class, 'index'])
            ->name('index');
        Route::get('data', [SdmController::class, 'list'])
            ->name('sdm.list');
        Route::get('show/{id}', [SdmController::class, 'show'])
            ->name('sdm.show');
        Route::post('/store', [SdmController::class, 'store'])
            ->name('sdm.store');
        Route::post('update/{id}', [SdmController::class, 'update'])
            ->name('sdm.update');
        Route::get('histori/{id}', [SdmController::class, 'histori'])
            ->name('sdm.histori');
        Route::get('find/by/nik/{id}', [SdmController::class, 'find_by_nik'])
            ->name('sdm.find_by_nik');

        Route::prefix('pendidikan')->name('pendidikan.')->group(function () {
            Route::get('/{id}', [SdmPendidikanController::class, 'index'])
                ->name('index');
            Route::get('data/{id}', [SdmPendidikanController::class, 'list'])
                ->name('list');
            Route::post('store', [SdmPendidikanController::class, 'store'])
                ->name('store');
            Route::post('update/{id}', [SdmPendidikanController::class, 'update'])
                ->name('update');
                Route::get('show/{id}', [SdmPendidikanController::class, 'show'])
                    ->name('show'); // Menjadi: admin.person.show
            Route::post('destroy/{id}', [SdmPendidikanController::class, 'destroy'])
                ->name('destroy');
        });

        Route::prefix('dokumen')->name('dokumen.')->group(function () {
            Route::get('/{id}', [SdmDokumenController::class, 'index'])
                ->name('index');
            Route::get('data/{id}', [SdmDokumenController::class, 'list'])
                ->name('list');
            Route::post('store', [SdmDokumenController::class, 'store'])
                ->name('store');
            Route::post('update/{id}', [SdmDokumenController::class, 'update'])
                ->name('update');
                Route::get('show/{id}', [SdmDokumenController::class, 'show'])
                    ->name('show'); // Menjadi: admin.person.show
            Route::post('destroy/{id}', [SdmDokumenController::class, 'destroy'])
                ->name('destroy');
        });

        Route::prefix('keluarga')->name('keluarga.')->group(function () {
            Route::get('/{id}', [SdmKeluargaController::class, 'index'])
                ->name('index');
            Route::get('data/{id}', [SdmKeluargaController::class, 'list'])
                ->name('list');
            Route::get('show/{id}', [SdmKeluargaController::class, 'show'])
                ->name('show');
            Route::post('/store', [SdmKeluargaController::class, 'store'])
                ->name('store');
            Route::post('update/{id}', [SdmKeluargaController::class, 'update'])
                ->name('update');
            Route::post('destroy/{id}', [SdmKeluargaController::class, 'destroy'])
                ->name('destroy');
            Route::get('find/by/nik/{id}', [SdmKeluargaController::class, 'find_by_nik'])
                ->name('find_by_nik');
        });

        Route::prefix('asuransi')->name('asuransi.')->group(function () {
            Route::get('/{id}', [PersonAsuransiController::class, 'index'])
                ->name('index');
            Route::get('data/{id}', [PersonAsuransiController::class, 'list'])
                ->name('list');
            Route::get('show/{id}', [PersonAsuransiController::class, 'show'])
                ->name('show');
            Route::post('/store', [PersonAsuransiController::class, 'store'])
                ->name('store');
            Route::post('update/{id}', [PersonAsuransiController::class, 'update'])
                ->name('update');
            Route::post('destroy/{id}', [PersonAsuransiController::class, 'destroy'])
                ->name('destroy');
            Route::get('find/by/nik/{id}', [PersonAsuransiController::class, 'find_by_nik'])
                ->name('find_by_nik');
        });

        Route::prefix('rekening')->name('rekening.')->group(function () {
            Route::get('/{id}', [SdmRekeningController::class, 'index'])
                ->name('index');
            Route::get('data/{id}', [SdmRekeningController::class, 'list'])
                ->name('list');
            Route::get('show/{id}', [SdmRekeningController::class, 'show'])
                ->name('show');
            Route::post('/store', [SdmRekeningController::class, 'store'])
                ->name('store');
            Route::post('update/{id}', [SdmRekeningController::class, 'update'])
                ->name('update');
            Route::post('destroy/{id}', [SdmRekeningController::class, 'destroy'])
                ->name('destroy');
        });

        Route::prefix('struktural')->name('struktural.')->group(function () {
            Route::get('/{id}', [SdmStrukturalController::class, 'index'])
                ->name('index');
            Route::get('data/{id}', [SdmStrukturalController::class, 'list'])
                ->name('list');
            Route::get('show/{id}', [SdmStrukturalController::class, 'show'])
                ->name('show');
            Route::post('/store', [SdmStrukturalController::class, 'store'])
                ->name('store');
            Route::post('update/{id}', [SdmStrukturalController::class, 'update'])
                ->name('update');
            Route::post('destroy/{id}', [SdmStrukturalController::class, 'destroy'])
                ->name('destroy');
        });
    });
});

Route::prefix('ref')->group(function () {
    Route::prefix('jenjang-pendidikan')->group(function () {
        Route::get('/', [RefJenjangPendidikanController::class, 'index'])
            ->name('ref.jenjang-pendidikan.index');
        Route::get('data', [RefJenjangPendidikanController::class, 'list'])
            ->name('ref.jenjang-pendidikan.list');
        Route::get('show/{id}', [RefJenjangPendidikanController::class, 'show'])
            ->name('ref.jenjang-pendidikan.show');
        Route::post('/store', [RefJenjangPendidikanController::class, 'store'])
            ->name('ref.jenjang-pendidikan.store');
        Route::post('update/{id}', [RefJenjangPendidikanController::class, 'update'])
            ->name('ref.jenjang-pendidikan.update');
    });

    Route::prefix('jenis-dokumen')->group(function () {
        Route::get('/', [RefJenisDokumenController::class, 'index'])
            ->name('ref.jenis-dokumen.index');
        Route::get('data', [RefJenisDokumenController::class, 'list'])
            ->name('ref.jenis-dokumen.list');
        Route::get('show/{id}', [RefJenisDokumenController::class, 'show'])
            ->name('ref.jenis-dokumen.show');
        Route::post('/store', [RefJenisDokumenController::class, 'store'])
            ->name('ref.jenis-dokumen.store');
        Route::post('update/{id}', [RefJenisDokumenController::class, 'update'])
            ->name('ref.jenis-dokumen.update');
    });

    Route::prefix('hubungan-keluarga')->group(function () {
        Route::get('/', [RefHubunganKeluargaController::class, 'index'])
            ->name('ref.hubungan-keluarga.index');
        Route::get('data', [RefHubunganKeluargaController::class, 'list'])
            ->name('ref.hubungan-keluarga.list');
        Route::get('show/{id}', [RefHubunganKeluargaController::class, 'show'])
            ->name('ref.hubungan-keluarga.show');
        Route::post('/store', [RefHubunganKeluargaController::class, 'store'])
            ->name('ref.hubungan-keluarga.store');
        Route::post('update/{id}', [RefHubunganKeluargaController::class, 'update'])
            ->name('ref.hubungan-keluarga.update');
    });

    Route::prefix('bank')->group(function () {
        Route::get('/', [RefBankController::class, 'index'])
            ->name('ref.bank.index');
        Route::get('data', [RefBankController::class, 'list'])
            ->name('ref.bank.list');
        Route::get('show/{id}', [RefBankController::class, 'show'])
            ->name('ref.bank.show');
        Route::post('/store', [RefBankController::class, 'store'])
            ->name('ref.bank.store');
        Route::post('update/{id}', [RefBankController::class, 'update'])
            ->name('ref.bank.update');
    });

    Route::prefix('eselon')->group(function () {
        Route::get('/', [RefEselonController::class, 'index'])
            ->name('ref.eselon.index');
        Route::get('data', [RefEselonController::class, 'list'])
            ->name('ref.eselon.list');
        Route::get('show/{id}', [RefEselonController::class, 'show'])
            ->name('ref.eselon.show');
        Route::post('/store', [RefEselonController::class, 'store'])
            ->name('ref.eselon.store');
        Route::post('update/{id}', [RefEselonController::class, 'update'])
            ->name('ref.eselon.update');
    });

    Route::prefix('jenis-asuransi')->group(function () {
        Route::get('/', [RefJenisAsuransiController::class, 'index'])
            ->name('ref.jenis-asuransi.index');
        Route::get('data', [RefJenisAsuransiController::class, 'list'])
            ->name('ref.jenis-asuransi.list');
        Route::get('show/{id}', [RefJenisAsuransiController::class, 'show'])
            ->name('ref.jenis-asuransi.show');
        Route::post('/store', [RefJenisAsuransiController::class, 'store'])
            ->name('ref.jenis-asuransi.store');
        Route::post('update/{id}', [RefJenisAsuransiController::class, 'update'])
            ->name('ref.jenis-asuransi.update');
    });
});

Route::prefix('master')->name('master.')->group(function () {

    Route::prefix('periode')->name('periode.')->group(function () {
        Route::get('/', [MasterPeriodeController::class, 'index'])
            ->name('index');
        Route::get('data', [MasterPeriodeController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [MasterPeriodeController::class, 'show'])
            ->name('show');
        Route::post('/store', [MasterPeriodeController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [MasterPeriodeController::class, 'update'])
            ->name('update');
    });

    Route::prefix('unit')->name('unit.')->group(function () {
        Route::get('/', [MasterUnitController::class, 'index'])
            ->name('index');
        Route::get('data', [MasterUnitController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [MasterUnitController::class, 'show'])
            ->name('show');
        Route::post('/store', [MasterUnitController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [MasterUnitController::class, 'update'])
            ->name('update');
    });



    Route::prefix('jabatan')->name('jabatan.')->group(function () {
        Route::get('/', [MasterJabatanController::class, 'index'])
            ->name('index');
        Route::get('data', [MasterJabatanController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [MasterJabatanController::class, 'show'])
            ->name('show');
        Route::post('/store', [MasterJabatanController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [MasterJabatanController::class, 'update'])
            ->name('update');
    });

});

Route::middleware(['role:developer'])->group(function () {
    Route::prefix('master')->name('master.')->group(function () {
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [MasterUserController::class, 'index'])
                ->name('index');
            Route::get('data', [MasterUserController::class, 'list'])
                ->name('list');
            Route::get('show/{id}', [MasterUserController::class, 'show'])
                ->name('show');
            Route::post('/store', [MasterUserController::class, 'store'])
                ->name('store');
            Route::post('update/{id}', [MasterUserController::class, 'update'])
                ->name('update');
        });
    });
});

Route::prefix('gaji')->name('gaji.')->group(function () {

    Route::prefix('gaji_umum')->name('gaji_umum.')->group(function () {
        Route::get('/', [GajiUmumController::class, 'index'])
            ->name('index');
        Route::get('data', [GajiUmumController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [GajiUmumController::class, 'show'])
            ->name('show');
        Route::post('/store', [GajiUmumController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [GajiUmumController::class, 'update'])
            ->name('update');
    });

    Route::prefix('komponen_gaji')->name('komponen_gaji.')->group(function () {
        Route::get('/', [KomponenGajiController::class, 'index'])
            ->name('index');
        Route::get('data', [KomponenGajiController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [KomponenGajiController::class, 'show'])
            ->name('show');
        Route::post('/store', [KomponenGajiController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [KomponenGajiController::class, 'update'])
            ->name('update');
    });

    Route::prefix('gaji_periode')->name('gaji_periode.')->group(function () {
        Route::get('/', [GajiPeriodeController::class, 'index'])
            ->name('index');
        Route::get('data', [GajiPeriodeController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [GajiPeriodeController::class, 'show'])
            ->name('show');
        Route::post('/store', [GajiPeriodeController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [GajiPeriodeController::class, 'update'])
            ->name('update');
    });


    Route::prefix('tarif_lembur')->name('tarif_lembur.')->group(function () {
        Route::get('/', [TarifLemburController::class, 'index'])
            ->name('index');
        Route::get('data', [TarifLemburController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [TarifLemburController::class, 'show'])
            ->name('show');
        Route::post('/store', [TarifLemburController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [TarifLemburController::class, 'update'])
            ->name('update');
    });

    Route::prefix('tarif_potongan')->name('tarif_potongan.')->group(function () {
        Route::get('/', [TarifPotonganController::class, 'index'])
            ->name('index');
        Route::get('data', [TarifPotonganController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [TarifPotonganController::class, 'show'])
            ->name('show');
        Route::post('/store', [TarifPotonganController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [TarifPotonganController::class, 'update'])
            ->name('update');
    });

    Route::prefix('gaji_jabatan')->name('gaji_jabatan.')->group(function () {
        Route::get('/', [GajiJabatanController::class, 'index'])
            ->name('index');
        Route::get('data', [GajiJabatanController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [GajiJabatanController::class, 'show'])
            ->name('show');
        Route::post('/store', [GajiJabatanController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [GajiJabatanController::class, 'update'])
            ->name('update');
    });

    Route::prefix('gaji_manual')->name('gaji_manual.')->group(function () {
        Route::get('/', [GajiManualController::class, 'index'])
            ->name('index');
        Route::get('data', [GajiManualController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [GajiManualController::class, 'show'])
            ->name('show');
        Route::post('/store', [GajiManualController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [GajiManualController::class, 'update'])
            ->name('update');
        Route::get('histori/{id}', [GajiManualController::class, 'detailgaji'])
            ->name('detailgaji');
        Route::get('find/by/nik/{id}', [GajiManualController::class, 'find_by_nik'])
            ->name('find_by_nik');
    });
});

Route::prefix('absensi')->name('absensi.')->group(function () {

    Route::prefix('jenis_absensi')->name('jenis_absensi.')->group(function () {
        Route::get('/', [JenisAbsensiController::class, 'index'])
            ->name('index');
        Route::get('data', [JenisAbsensiController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [JenisAbsensiController::class, 'show'])
            ->name('show');
        Route::post('/store', [JenisAbsensiController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [JenisAbsensiController::class, 'update'])
            ->name('update');
    });

    Route::prefix('jadwal_kerja')->name('jadwal_kerja.')->group(function () {
        Route::get('/', [JadwalKerjaController::class, 'index'])
            ->name('index');
        Route::get('data', [JadwalKerjaController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [JadwalKerjaController::class, 'show'])
            ->name('show');
        Route::post('/store', [JadwalKerjaController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [JadwalKerjaController::class, 'update'])
            ->name('update');
    });

    Route::prefix('libur_nasional')->name('libur_nasional.')->group(function () {
        Route::get('/', [LiburNasionalController::class, 'index'])
            ->name('index');
        Route::get('data', [LiburNasionalController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [LiburNasionalController::class, 'show'])
            ->name('show');
        Route::post('/store', [LiburNasionalController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [LiburNasionalController::class, 'update'])
            ->name('update');
    });

    Route::prefix('libur_perusahaan')->name('libur_perusahaan.')->group(function () {
        Route::get('/', [LiburPerusahaanController::class, 'index'])
            ->name('index');
        Route::get('data', [LiburPerusahaanController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [LiburPerusahaanController::class, 'show'])
            ->name('show');
        Route::post('/store', [LiburPerusahaanController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [LiburPerusahaanController::class, 'update'])
            ->name('update');
    });

    Route::prefix('cuti')->name('cuti.')->group(function () {
        Route::get('/', [CutiController::class, 'index'])
            ->name('index');
        Route::get('data', [CutiController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [CutiController::class, 'show'])
            ->name('show');
        Route::post('/store', [CutiController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [CutiController::class, 'update'])
            ->name('update');
        Route::post('approval/{id}', [CutiController::class, 'approval'])
            ->name('approval');
    });

});
