<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit" enctype="multipart/form-data">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Edit SDM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1 required">Hubungan Keluarga</label>
                                <select id="edit_id_hubungan_keluarga" name="id_hubungan_keluarga"
                                        data-control="select2"
                                        class="form-select form-select-sm"
                                        data-placeholder="Pilih Hubungan Keluarga" required>
                                </select>
                            </div>

                                    <div class="d-flex flex-column mb-2">
                                         <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Status Tanggungan</span>
                                    </label>
                                    <select data-control="select2" id="edit_status_tanggungan"
                                            class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                            data-placeholder="Pilih Status Tanggungan" required>
                                        <option value="">Pilih Status Tanggungan</option>
                                        <option value="YA">YA</option>
                                        <option value="TIDAK">TIDAK</option>
                                    </select>
                                          <div class="invalid-feedback"></div>
                                    </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Pekerjaan</span>
                                </label>
                                <input type="text" id="edit_pekerjaan"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Pendidikan Terakhir</span>
                                </label>
                                <input type="text" id="edit_pendidikan_terakhir" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="30"/>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Penghasilan</span>
                                </label>
                                <input type="text" id="edit_penghasilan" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="30"/>
                                <div class="invalid-feedback"></div>
                            </div>
                         </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal"
                                    aria-label="Close">Close
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">Simpan</button>
                          </div>

                </form>
             </div>
          </div>
      </div>

