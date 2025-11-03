<div class="modal fade" id="form_detail_pendidikan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pendidikan</h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kolom 1 -->
                    <div class="col-md-6">
                        <h6 class="text-primary fw-bold mb-3 border-bottom border-primary pb-2">Informasi Akademik</h6>

                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Institusi</label>
                            <p id="detail_institusi" class="fw-light"></p>
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label class="fw-bolder mb-1">Jurusan</label>
                            <p id="detail_jurusan" class="fw-light"></p>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="fw-bolder mb-1">Tahun Masuk</label>
                                <p id="detail_tahun_masuk" class="fw-light"></p>
                            </div>
                            <div class="col-6">
                                <label class="fw-bolder mb-1">Tahun Lulus</label>
                                <p id="detail_tahun_lulus" class="fw-light"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom 2 -->
                    <div class="col-md-6">
                        <h6 class="text-primary fw-bold mb-3 border-bottom border-primary pb-2">Keterangan Nilai & Biaya</h6>

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
