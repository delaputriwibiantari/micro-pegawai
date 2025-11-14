<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit" enctype="multipart/form-data">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Edit Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1 required">Jenjang Pendidikan</label>
                                <select id="edit_id_jenjang_pendidikan" name="id_jenjang_pendidikan"
                                        data-control="select2"
                                        class="form-select form-select-sm"
                                        data-placeholder="Pilih Jenjang Pendidikan" required>
                                </select>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Institusi</label>
                                <input type="text" id="edit_institusi" class="form-control form-control-sm" maxlength="30" />
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Jurusan</label>
                                <input type="text" id="edit_jurusan" class="form-control form-control-sm" required />
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label class="fw-bolder mb-1 required">Tahun Masuk</label>
                                    <input type="text" id="edit_tahun_masuk" class="form-control form-control-sm" required />
                                </div>
                                <div class="col-6">
                                    <label class="fw-bolder mb-1 required">Tahun Lulus</label>
                                    <input type="text" id="edit_tahun_lulus" class="form-control form-control-sm" required />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1 required">Jenis Nilai</label>
                                <select id="edit_jenis_nilai" class="form-select form-select-sm" required>
                                    <option value="">Pilih Jenis Nilai</option>
                                    <option value="SKS">SKS</option>
                                    <option value="NILAI">NILAI</option>
                                </select>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Jumlah SKS</label>
                                <input type="text" id="edit_sks" class="form-control form-control-sm"/>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1 required">Sumber Biaya</label>
                                <select id="edit_sumber_biaya" class="form-select form-select-sm" required>
                                    <option value="">Pilih Sumber Biaya</option>
                                    <option value="BEASISWA">BEASISWA</option>
                                    <option value="MANDIRI">MANDIRI</option>
                                </select>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">File Ijazah</label>
                                <input type="file" id="edit_file_ijazah" name="file_ijazah" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">File Transkip</label>
                                <input type="file" id="edit_file_transkip" name="file_transkip" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
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
