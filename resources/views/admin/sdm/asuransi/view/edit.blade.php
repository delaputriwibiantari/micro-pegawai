<div class="modal fade" id="form_edit_asuransi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit" enctype="multipart/form-data">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Edit Asuransi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                            <div class="row">
                                    <div class="col-6">
                                    <div class="d-flex flex-column mb-2">
                                         <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Jenis Asuransi</span>
                                    </label>
                                    <select data-control="select2" id="edit_id_jenis_asuransi"
                                            class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                            data-placeholder="Pilih Jenis Asuransi" required>
                                        <option value="">Pilih Jenis Pegawai</option>
                                        <option value="TETAP">Tetap</option>
                                        <option value="KONTRAK">Kontrak</option>
                                    </select>
                                          <div class="invalid-feedback"></div>
                                    </div>
                                    </div>
                                </div>
                             <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Nomor Peserta</span>
                                </label>
                                <input type="text" id="edit_nomor_peserta"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                <div class="invalid-feedback"></div>
                             </div>

                             <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Tanggal Aktif</span>
                                </label>
                                <input type="date" id="edit_tanggal_aktif"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                <div class="invalid-feedback"></div>
                             </div>

                             <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Status</span>
                                </label>
                                <input type="text" id="edit_status"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                <div class="invalid-feedback"></div>
                             </div>

                          <div class="modal-footer">
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
