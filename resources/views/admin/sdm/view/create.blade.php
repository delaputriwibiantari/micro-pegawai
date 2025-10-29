<div class="modal fade" id="form_create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_create" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah SDM</h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom 2: Data Dasar -->
                        <div class="col-md-4">
                            <h6 class="text-primary fw-bold mb-3 border-bottom border-primary pb-2">Data Dasar</h6>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>NIP</span>
                                </label>
                                <input type="text" id="nip" name="nip" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="50" required/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Status Pegawai</span>
                                </label>
                                <input type="text" id="status_pegawai" name="status_pegawai" class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="50" required/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Tipe Pegawai</span>
                                </label>
                                <input type="text" id="tipe_pegawai" name="tipe_pegawai"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"
                                       maxlength="30" required/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>Tanggal Masuk</span>
                                </label>
                                <input type="text" id="tanggal_masuk" name="tanggal_masuk"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>ID Person</span>
                                </label>
                                <input type="text" id="id_peson" name="id_peson"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6" required/>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1 required">
                                    <span>ID Person</span>
                                </label>
                                <select data-control="select2" id="id_person" name="id_person"
                                        class="form-control form-control-sm fs-sm-8 fs-lg-6" data-allow-clear="true"
                                        data-placeholder="Pilih ID Person" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="l">Laki-laki</option>
                                    <option value="p">Perempuan</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex flex-column mb-2">
                                <label class="d-flex align-items-center fs-sm-8 fs-lg-6 fw-bolder mb-1">
                                    <span>Nama Lengkap</span>
                                </label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap"
                                       class="form-control form-control-sm fs-sm-8 fs-lg-6"/>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark fs-sm-8 fs-lg-6" data-bs-dismiss="modal"
                            aria-label="Close">Close
                    </button>
                    <button type="submit" id="bt_submit_create" class="btn btn-sm btn-primary fs-sm-8 fs-lg-6">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
