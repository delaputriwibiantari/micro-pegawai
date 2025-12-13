<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_create">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Komponen Gaji</h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Nama Komponen</span>
                                </label>
                                <input type="text" id="nama_komponen"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Jenis</label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="jenis"
                                        name="jenis"
                                         data-allow-clear="true"
                                        data-placeholder="Pilih Jenis">
                                            <option value="PENGHASIL">PENGHASIL</option>
                                            <option value="POTONGAN">POTONGAN</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Deskripsi</span>
                                </label>
                                <input type="text" id="deskripsi"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Terapkan Umum</span>
                                </label>
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" id="is_umum" name="is_umum"/>
                                    <label class="form-check-label" for="is_umum">
                                        Ya
                                    </label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Umum Id</span>
                                </label>
                                <select data-control="select2" class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                    name="umum_id" id="umum_id" data-allow-clear="true" data-placeholder="Umum Id"
                                    >
                                </select>
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
