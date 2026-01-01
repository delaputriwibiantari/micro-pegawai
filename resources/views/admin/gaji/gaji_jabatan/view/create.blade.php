<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_create">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Gaji Jabatan</h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Komponen Id</span>
                                </label>
                                <select data-control="select2" class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                    name="komponen_id" id="komponen_id" data-allow-clear="true" data-placeholder="Komponen Id"
                                    >
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Jabatan</span>
                                </label>
                                <select data-control="select2" class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                    name="id_jabatan" id="id_jabatan" data-allow-clear="true" data-placeholder="Id Jabatan"
                                    >
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                             <!-- TAMBAH: Checkbox Use Override -->
                            <div class="d-flex flex-column mb-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                           name="use_override" id="use_override"
                                           value="1" checked>
                                    <label class="form-check-label fs-sm-8 fs-lg-6 fw-bolder"
                                           for="use_override">
                                        Gunakan Nominal Kustom
                                    </label>
                                    <small class="text-muted d-block mt-1">
                                        Jika dicentang, gunakan nominal custom. Jika tidak, gunakan nominal default dari komponen.
                                    </small>
                                </div>
                            </div>

                            <!-- TAMBAH: Input Override Nominal -->
                            <div class="d-flex flex-column mb-2" id="override_nominal_container">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Nominal Kustom (Override)</span>
                                </label>
                                <input type="text" name="override_nominal" id="override_nominal"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       placeholder="Masukkan nominal custom">
                                <small class="text-muted mt-1">
                                    Hanya diisi jika ingin menggunakan nominal berbeda dari komponen.
                                </small>
                                <div class="invalid-feedback"></div>
                            </div>

                            <!-- KOLOM NOMINAL LAMA (dihidden, untuk backward compatibility) -->
                            <input type="hidden" name="nominal" id="nominal_hidden">
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
