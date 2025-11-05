<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_create" enctype="multipart/form-data">
            @csrf
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Tambah SDM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-13">
                            <div class="mb-8">
                                <label class="form-label fw-bold">NIK</label>
                                <input type="text" id="nik" name="nik" class="form-control form-control-sm" maxlength="50" required/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <!-- Bagian hasil NIK (otomatis muncul nanti kalau valid) -->
                            <div id="result_nik" class="p-2 bg-light border rounded d-none">
                                <p class="mb-1 fw-bold text-success" id="nama_person"></p>
                                <p class="mb-0 text-muted small" id="alamat_person"></p>
                            </div>

                            <!-- Tombol di bawah input -->
                            <div class="d-flex justify-content-start mt-3">
                                <button type="button" id="btn-Cari" data-url="{{ route('admin.sdm.cari') }}" class="btn btn-primary btn-sm me-2">
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
                    <div id="form_lanjutan" class="d-none mt-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nip</label>
                            <input type="text" id="nip" name="nip" class="form-control form-control-sm" required>
                        </div>
                        <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Status Pegawai</span>
                                </label>
                                <select data-control="select2" id="status_pegawai" name="status_pegawai"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Jenis Kelamin" required>
                                    <option value="">Pilih Jenis Pegawai</option>
                                    <option value="TETAP">Tetap</option>
                                    <option value="KONTRAK">Kontrak</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                        <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Tipe Pegawai</span>
                                </label>
                                <select data-control="select2" id="tipe_pegawai" name="tipe_pegawai"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Jenis Kelamin" required>
                                    <option value="">Pilih Jenis Tipe Pegawai</option>
                                    <option value="FULL TIME">Full Time</option>
                                    <option value="PART TIME">Part Time</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Masuk</label>
                            <input type="date" id="tanggal_masuk" name="tanggal_masuk" class="form-control form-control-sm" required>
                        </div>

                        <input type="hidden" id="id_person" name="id_person">


                        <div class="mt-3">
                            <button type="submit" class="btn btn-success btn-sm">Simpan SDM</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
