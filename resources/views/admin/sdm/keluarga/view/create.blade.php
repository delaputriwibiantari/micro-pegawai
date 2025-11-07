<div class="modal fade" id="form_create_keluarga" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_create" enctype="multipart/form-data">
            @csrf
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Tambah Keluarga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-13">
                            <div class="mb-8">
                                <label class="form-label fw-bold">NIK</label>
                               <input type="text" id="nik" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                   maxlength="16" placeholder="Masukkan NIK untuk mencari person anggota keluarga"
                                   required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <!-- Bagian hasil NIK (otomatis muncul nanti kalau valid) -->
                            <div id="result_nik" class="p-2 bg-light border rounded d-none">
                               <h6 class="text-success mb-2">Data Ditemukan:</h6>
                           <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nama:</strong> <span id="person_nama"></span></p>
                                <p class="mb-1"><strong>NIK:</strong> <span id="person_nik"></span></p>
                                <p class="mb-1"><strong>Tempat Lahir:</strong> <span id="person_tempat_lahir"></span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tanggal Lahir:</strong> <span
                                            id="person_tanggal_lahir"></span></p>
                                <p class="mb-1"><strong>Alamat:</strong> <span id="person_alamat"></span></p>
                            </div>
                        </div>
                        <input type="hidden" id="id_person" name="id_person">
                        <input type="hidden" id="id_sdm" name="id_sdm">
                            </div>

                            <!-- Tombol di bawah input -->
                            <div class="d-flex justify-content-start mt-3">
                                <button type="button" id="btn-Cari" class="btn btn-primary btn-sm me-2">
                                    Cari Person
                                </button>
                                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Hasil pencarian person -->
                    <div id="info_person" class="mt-3"></div>
                    <h6 class="fw-bold text-primary mt-4" id="nama_person_heading"></h6>

                    <!-- Form lanjutan SDM -->

                         <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1 required">Hubungan</label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="id_hubungan_keluarga"
                                        name="id_hubungan_keluarga"
                                        data-placeholder="Pilih Hubungan Keluarga"
                                        data-allow-clear="true" required>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Status Tanggungan</span>
                                </label>
                                <select data-control="select2" id="status_tanggungan" name="status_tanggungan"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Status Tanggungan" required>
                                    <option value="">Pilih Status Tanggungan</option>
                                    <option value="YA">YA</option>
                                    <option value="TIDAK">TIDAK</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Pekerjaan</label>
                                <input type="text" name="pekerjaan"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="pekerjaan" placeholder="Masukkan Pekerjaan" maxlength="100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Pendidikan Terakhir</label>
                                <input type="text" name="pendidikan_terakhir"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="pendidikan_terakhir" placeholder="Masukkan Pendidikan Terakhir" maxlength="100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Penghasilan</label>
                                <input type="text" name="penghasilan"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       id="penghasilan" placeholder="Masukkan Penghasilan" maxlength="100">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="mt-3">
                             <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal"
                            aria-label="Close">Close
                              </button>
                            <button type="submit" id="bt_submit_create" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">Simpan</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
