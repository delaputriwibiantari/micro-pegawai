<div class="modal fade" id="form_create_asuransi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_create">
            @csrf
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary" id="exampleModalLabel">Tambah SDM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="col-md-13">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                        <span>NIK</span>
                                    </label>
                                    <input type="text" id="search_nik" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                        maxlength="16"
                                        placeholder="Masukkan NIK untuk mencari person" required>
                                    <div class="invalid-feedback"></div>

                                <!-- Bagian hasil NIK (otomatis muncul nanti kalau valid) -->
                                <div id="result_nik" class="p-2 bg-light border rounded d-none">
                                    <p class="mb-1 fw-bold text-success" id="nama_person"></p>
                                    <p class="mb-0 text-muted small" id="alamat_person"></p>
                                </div>

                                <!-- Tombol di bawah input -->
                                <div class="d-flex justify-content-start mt-3">
                                    <button type="button" id="btn_search_person" class="btn btn-primary btn-sm me-2">
                                        Cari Person
                                    </button>
                                    <button type="button" id="btn_clear_person" class="btn btn-dark btn-sm" data-bs-dismiss="modal">
                                        Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hasil pencarian person -->
                    <div id="person_info" style="display:none;"
                             class="mb-4 p-4 bg-light-success border border-success border-dashed rounded">
                            <h6 class="text-success mb-3 fw-bold">
                                Data Person Ditemukan:
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Nama:</strong> <span id="person_nama_lengkap"></span></p>
                                    <p class="mb-1"><strong>NIK:</strong> <span id="person_nik"></span></p>
                                    <p class="mb-1"><strong>Tempat Lahir:</strong> <span
                                                id="person_tempat_lahir"></span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Tanggal Lahir:</strong> <span
                                                id="person_tanggal_lahir"></span></p>
                                    <p class="mb-1"><strong>Alamat:</strong> <span id="person_alamat"></span></p>
                                </div>
                            </div>
                            <input type="hidden" id="id_person" name="id_person">
                        </div>

                    <!-- Form lanjutan SDM -->
                    <div class="row" id="asuransi_form" style="display:none;">
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Jenis Asuransi</span>
                                </label>
                                <select data-control="select2" id="id_jenis_asuransi"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Jenis Asuransi" required>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Nomor Peserta</span>
                                </label>
                                <input type="text" id="nomor_peserta"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" maxlength="16">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Kartu Anggota</span>
                                </label>
                                <input type="text" id="kartu_anggota"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" maxlength="16">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Status </span>
                                </label>
                                <select data-control="select2" id="status_aktif"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Status">
                                    <option value="AKTIF" selected>Aktif</option>
                                    <option value="TIDAK AKTIF">Tidak Aktif</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Tanggal Mulai</span>
                                </label>
                                <input type="date" id="tanggal_mulai"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Tanggal Berakhir</span>
                                </label>
                                <input type="date" id="tanggal_berakhir"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Keterangan</span>
                                </label>
                                <textarea id="keterangan" rows="3"
                                          class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                          placeholder="Masukkan keterangan"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal">
                             Tutup
                        </button>
                    <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6" id="btn_save"
                          style="display:none;">
                         Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
