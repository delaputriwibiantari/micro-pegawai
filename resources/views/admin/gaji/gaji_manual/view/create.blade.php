<div
    class="modal fade"
    id="form_create"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
>
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_create">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Tambah Penggajian Manual
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <!-- Periode Gaji -->
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Periode Gaji</span>
                                </label>
                                <select
                                    name="periode_id"
                                    id="periode_id"
                                    class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                    data-control="select2"
                                    data-allow-clear="true"
                                    data-placeholder="Pilih Periode"
                                >
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <!-- Pegawai Aktif -->
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Pegawai Aktif</span>
                                </label>
                                <select
                                    name="sdm_id"
                                    id="sdm_id"
                                    class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                    data-control="select2"
                                    data-allow-clear="true"
                                    data-placeholder="Pilih Pegawai"
                                >
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-sm btn-dark fs-sm-8 fs-lg-6"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        type="submit"
                        class="btn btn-sm btn-primary fs-sm-8 fs-lg-6"
                    >
                        Proses
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
