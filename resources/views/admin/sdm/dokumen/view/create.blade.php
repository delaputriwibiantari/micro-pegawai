<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_create" enctype="multipart/form-data">
            @csrf
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Tambah Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-13">
                        <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1 required">Jenis Dokumen</label>
                                <select data-control="select2"
                                        class="form-select form-select-sm fs-sm-8 fs-lg-6"
                                        id="id_jenis_dokumen"
                                        name="id_jenis_dokumen"
                                        data-placeholder="Pilih Jenis Dokumen"
                                        data-allow-clear="true" required>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Dokumen</label>
                            <input type="text" id="nama_dokumen" name="nama_dokumen" class="form-control form-control-sm" required>
                        </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Upload File</label>
                                <input type="file" id="file_dokumen" name="file_dokumen"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-sm-9 fs-lg-7 text-muted">
                                    Format file: PDF, JPG, JPEG, PNG. Maksimal 5MB
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>

                        <div class="modal-footer">
                             <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal" aria-label="Close">Close</button>
                            <button type="submit" id="bt_submit_create" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
