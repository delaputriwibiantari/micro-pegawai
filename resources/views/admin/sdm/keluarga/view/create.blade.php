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

                        <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Status</span>
                                </label>
                                <select data-control="select2" id="status" name="status"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="KEPALA KELUARGA">Kepala Keluarga</option>
                                    <option value="ISTRI">Istri</option>
                                    <option value="ANAK">Anak</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                        <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Status Tanggungan</span>
                                </label>
                                <select data-control="select2" id="status_tanggungan" name="status_tanggungan"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Status Tanggungan" required>
                                    <option value="">Pilih Status Tanggungan</option>
                                    <option value="YA">Ya</option>
                                    <option value="TIDAK">Tidak</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <input type="hidden" id="id_person" name="id_person">
                            <input type="hidden" id="id_sdm" name="id_sdm">


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
