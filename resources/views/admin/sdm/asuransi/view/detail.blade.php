<div class="modal fade" id="form_detail_asuransi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Asuransi</h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kolom 2: Data Dasar -->
                    <div class="col-md-4">
                        <h6 class="text-primary fw-bold mb-3 border-bottom border-primary pb-2">Data Dasar</h6>
                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Jenis Asuransi</span>
                            </label>
                            <p id="detail_id_Jenis_asuransi" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Nomor Peserta</span>
                            </label>
                            <p id="detail_nomor_peserta" class="fw-light fs-sm-8 fs-lg-6"></p>
                        </div>
                    <!-- Kolom 3: Alamat -->
                    <div class="col-md-5">
                        <h6 class="text-primary fw-bold mb-3 border-bottom border-primary pb-2">Alamat</h6>

                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Tanggal Aktif</span>
                            </label>
                            <p id="detail_tanggal_aktif" class="fw-light fs-sm-8 fs-lg-6" style="min-height: 60px;"></p>
                        </div>
                        <div class="d-flex flex-column mb-3">
                            <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                <span>Status</span>
                            </label>
                            <p id="detail_status" class="fw-light fs-sm-8 fs-lg-6" style="min-height: 60px;"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal"
                        aria-label="Close">Tutup
                </button>
            </div>
        </div>
    </div>
</div>
