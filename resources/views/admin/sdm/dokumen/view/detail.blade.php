<div class="modal fade" id="form_detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Dokumen</h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="row">
                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Jenis Dokumen</label>
                            <p id="detail_id_jenis_dokumen" class="fw-light"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Nama Dokumen</label>
                            <p id="detail_nama_dokumen" class="fw-light"></p>
                        </div>


                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-2">
                            <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File Dokumen</label>
                            <div id="detail_file_ijazah_section">
                                <div class="d-flex align-items-center mb-3">
                                    <a href="#" id="detail_file_dokumen_link" target="_blank" class="btn btn-sm btn-light-primary">
                                        Lihat File
                                    </a>
                                    <span id="detail_file_ijazah_name" class="ms-3 text-muted"></span>
                                </div>
                            </div>
                            <div id="no_file_ijazah_section" style="display: none;">
                                <div class="alert alert-warning">
                                    Tidak ada file Ijazah yang diupload.
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark" data-bs-dismiss="modal" aria-label="Close">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
