<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_create">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan</h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Pegawai Aktif</span>
                                </label>
                                <select data-control="select2" class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                    name="sdm_id" id="sdm_id" data-allow-clear="true" data-placeholder="Pilih Pegawai"
                                    >
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Jenis Cuti</label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="jenis_cuti"
                                        name="jenis_cuti"
                                         data-allow-clear="true"
                                        data-placeholder="Pilih Jenis Cuti">
                                            <option value=""></option>
                                            <option value="TAHUNAN">TAHUNAN</option>
                                            <option value="SAKIT">SAKIT</option>
                                            <option value="MELAHIRKAN">MELAHIRKAN</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Keterangan</span>
                                </label>
                                <input type="text" id="keterangan"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Tanggal Mulai</span>
                                </label>
                                <input type="date" id="tanggal_mulai"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Tanggal Selesai</span>
                                </label>
                                <input type="date" id="tanggal_selesai"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 readonly">
                                    <span>Total Hari</span>
                                </label>
                                <input type="text" id="total_hari"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       readonly>
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
