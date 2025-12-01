<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Komponen Gaji</h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Komponen Id</span>
                                </label>
                                <input type="text" id="edit_Komponen_id"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Nama Komponen</span>
                                </label>
                                <input type="text" id="edit_nama_komponen"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1 required">Jenis</label>
                                <select id="edit_jenis" class="form-select form-select-sm" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="PENGHASIL">PENGHASIL</option>
                                    <option value="POTONGAN">POTONGAN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Deskripsi</span>
                                </label>
                                <input type="text" id="edit_deskripsi"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Is Umum</span>
                                </label>
                                <input type="text" id="edit_is_umum"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Umum Id</span>
                                </label>
                                <input type="text" id="edit_umum_id"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal"
                            aria-label="Close">Close
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
