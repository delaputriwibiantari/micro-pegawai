<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_create" enctype="multipart/form-data">
            @csrf
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Tambah SDM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-13">
                            <div class="mb-8">
                                <label class="form-label fw-bold">NIK</label>
                                <input type="text" id="nip" name="nip" class="form-control form-control-sm" maxlength="50" required/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <!-- Bagian hasil NIK (otomatis muncul nanti kalau valid) -->
                            <div id="result_nik" class="p-2 bg-light border rounded d-none">
                                <p class="mb-1 fw-bold text-success" id="nama_person"></p>
                                <p class="mb-0 text-muted small" id="alamat_person"></p>
                            </div>

                            <!-- Tombol di bawah input -->
                            <div class="d-flex justify-content-start mt-3">
                                <button type="submit" id="bt_submit_create" class="btn btn-primary btn-sm me-2">
                                    Cari Person
                                </button>
                                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
