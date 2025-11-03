<div class="modal fade" id="form_create_pendidikan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_create" enctype="multipart/form-data">
            @csrf
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Tambah Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-13">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Institusi</label>
                            <input type="text" id="nip" name="nip" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jurusan</label>
                            <input type="text" id="jurusan" name="jurusan" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tahun Masuk</label>
                            <input type="text" id="tahun_masuk" name="nip" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tahun Lulus</label>
                            <input type="text" id="tahun_lulus" name="tahun_lulus" class="form-control form-control-sm" required>
                        </div>
                        <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Jenis Nilai</span>
                                </label>
                                <select data-control="select2" id="jenis_nilai" name="jenis_nilai"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Jenis Nilai" required>
                                    <option value="">Pilih Jenis Nilai</option>
                                    <option value="IPK">IPK</option>
                                    <option value="NILAI">NILAI</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">SKS</label>
                            <input type="text" id="sks" name="sks" class="form-control form-control-sm" required>
                        </div>
                        <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Sumber Biaya</span>
                                </label>
                                <select data-control="select2" id="sumber_biaya" name="sumber_biaya"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Sumber Biaya" required>
                                    <option value="">Pilih Sumber Biaya</option>
                                    <option value="BEASISWA">BEASISWA</option>
                                    <option value="MANDIRI">MANDIRI</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                        <input type="hidden" id="id_person" name="id_person">


                        <div class="mt-3">
                            <button type="submit" class="btn btn-success btn-sm">Simpan Pendidikan</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
