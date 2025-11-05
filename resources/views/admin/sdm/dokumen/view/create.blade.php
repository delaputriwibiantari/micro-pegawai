<div class="modal fade" id="form_create_asuransi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_create" enctype="multipart/form-data">
            @csrf
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Tambah Asuransi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-13">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Dokumen</label>
                            <input type="text" id="jenis_dokumen" name="jenis_dokumen" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Dokumen</label>
                            <input type="text" id="nomor_dokumen" name="nomor_dokumen" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Terbit</label>
                            <input type="text" id="tgl_terbit" name="tgl_terbit" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Berlaku</label>
                            <input type="text" id="tgl_berlaku" name="tgl_berlaku" class="form-control form-control-sm" required>
                        </div>

                        <div class="mt-3">
                             <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal"
                            aria-label="Close">Close
                              </button>
                            <button type="submit" id="bt_submit_create" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">Simpan</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
