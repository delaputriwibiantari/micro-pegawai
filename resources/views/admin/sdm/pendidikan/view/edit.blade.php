<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit" enctype="multipart/form-data">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Edit Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Institusi</span>
                                </label>
                                <input type="text" id="edit_institusi" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="30"/>
                                <div class="invalid-feedback"></div>
                            </div>

                             <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Jurusan</span>
                                </label>
                                <input type="text" id="edit_jurusan"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                <div class="invalid-feedback"></div>
                             </div>

                             <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Tahun Masuk</span>
                                </label>
                                <input type="text" id="edit_tahun_masuk"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                <div class="invalid-feedback"></div>
                             </div>

                             <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Tahun Lulus</span>
                                </label>
                                <input type="text" id="edit_tahun_lulus"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                <div class="invalid-feedback"></div>
                             </div>

                                <div class="col-6">
                                    <div class="d-flex flex-column mb-2">
                                        <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                            <span>Nilai</span>
                                        </label>
                                        <select data-control="select2" id="edit_nilai"
                                                class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                                data-placeholder="Pilih Jenis Kelamin" required>
                                            <option value="">Pilih Jenis Tipe Nilai</option>
                                            <option value="SKS">SKS</option>
                                            <option value="NILAI">NILAI</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column mb-2">
                                    <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                        <span>SKS</span>
                                    </label>
                                    <input type="text" id="edit_sks"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="col-6">
                                    <div class="d-flex flex-column mb-2">
                                        <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                            <span>SUmber Biaya</span>
                                        </label>
                                        <select data-control="select2" id="edit_sumber_biaya"
                                                class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                                data-placeholder="Pilih Jenis Sumber Biaya" required>
                                            <option value="">Pilih Jenis Sumber Biaya</option>
                                            <option value="BEASISWA">BEASISWA</option>
                                            <option value="MANDIRI">MANDIRI</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File Ijazah</label>
                                <input type="file" id="edit_file_ijazah" name="file_ijazah"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-sm-9 fs-lg-7 text-muted">
                                    Format file: PDF, JPG, JPEG, PNG. Maksimal 5MB
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File Transkip</label>
                                <input type="file" id="edit_file_transkip" name="file_transkip"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text fs-sm-9 fs-lg-7 text-muted">
                                    Format file: PDF, JPG, JPEG, PNG. Maksimal 5MB
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal"
                                    aria-label="Close">Close
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">Simpan</button>
                          </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
