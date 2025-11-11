<div class="modal fade" id="form_detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Detail Asuransi
                </h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kolom 1 -->
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Jenjang Pendidikan</label>
                            <p id="detail_id_jenjang_pendidikan" class="fw-light"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Institusi</label>
                            <p id="detail_institusi" class="fw-light"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Jurusan</label>
                            <p id="detail_jurusan" class="fw-light"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Tahun Masuk</label>
                            <p id="detail_tahun_masuk" class="fw-light"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Tahun Lulus</label>
                            <p id="detail_tahun_lulus" class="fw-light"></p>
                        </div>

                    </div>

                    <!-- Kolom 2 -->
                    <div class="col-md-6">
                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Jumlah SKS</label>
                            <p id="detail_sks" class="fw-light"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Jenis Nilai</label>
                            <p id="detail_jenis_nilai" class="fw-light"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Sumber Biaya</label>
                            <p id="detail_sumber_biaya" class="fw-light"></p>
                        </div>
                            <div class="d-flex flex-column mb-3">
                                    <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File Ijazah</label>
                                    <div id="detail_file_ijazah_section">
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="#" id="detail_file_ijazah_link" target="_blank" class="btn btn-sm btn-light-primary">
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
                            <div class="d-flex flex-column mb-3">
                                    <label class="fs-sm-8 fs-lg-6 fw-bolder mb-1">File Transkip</label>
                                    <div id="detail_file_transkip_section">
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="#" id="detail_file_transkip_link" target="_blank" class="btn btn-sm btn-light-primary">
                                                Lihat File
                                            </a>
                                            <span id="detail_file_transkip_name" class="ms-3 text-muted"></span>
                                        </div>
                                    </div>
                                    <div id="no_file_transkip_section" style="display: none;">
                                        <div class="alert alert-warning">
                                            Tidak ada file Transkip yang diupload.
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
