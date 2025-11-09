<div class="modal fade" id="form_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit" enctype="multipart/form-data">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold text-primary">Edit Asuransi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                     <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">Nama</label>
                                <p id="edit_nama_lengkap" class="fw-light fs-sm-8 fs-lg-6"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">NIK</label>
                                <p id="edit_nik" class="fw-light fs-sm-8 fs-lg-6"></p>
                            </div>
                        </div>
                    </div>


                   <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Jenis Asuransi</span>
                                </label>
                                <select data-control="select2" id="edit_id_jenis_asuransi"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Jenis Asuransi" required>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Nomer Peserta</span>
                                </label>
                                <input type="text" id="edit_nomer_peserta"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" maxlength="16">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Kartu Anggota</span>
                                </label>
                                <input type="text" id="edit_kartu_anggota"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" maxlength="16">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Status Aktif</span>
                                </label>
                                <select data-control="select2" id="edit_status"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih Status">
                                    <option value="AKTIF">Aktif</option>
                                    <option value="TIDAK AKTIF">Tidak Aktif</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Tanggal Mulai</span>
                                </label>
                                <input type="date" id="edit_tanggal_mulai"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Tanggal Berakhir</span>
                                </label>
                                <input type="date" id="edit_tanggal_berakhir"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2">
                                <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Keterangan</span>
                                </label>
                                <textarea id="edit_keterangan" rows="3"
                                          class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                          placeholder="Masukkan keterangan"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                     </div>
                       </div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                         </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
