<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit" enctype="multipart/form-data">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Edit Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1 required">Jenis Dokumen</label>
                                <select id="edit_id_jenis_dokumen" name="id_jenis_dokumen"
                                        data-control="select2"
                                        class="form-select form-select-sm"
                                        data-placeholder="Pilih Jenis Dokumen" required>
                                </select>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Nomor Dokumen</label>
                                <input type="text" id="edit_nomor_dokumen" class="form-control form-control-sm" maxlength="30" />
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1 required">Tanggal Terbit</label>
                                <input type="text" id="edit_tgl_terbit" class="form-control form-control-sm" required />
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label class="fw-bolder mb-1 required">Tanggal Berlaku</label>
                                    <input type="text" id="edit_tgl_berlaku" class="form-control form-control-sm" required />
                                </div>
                            </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>
