<div class="modal fade" id="form_approval" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" id="bt_submit_approval">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approval Izin</h5>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <!-- Pegawai -->
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Pegawai</label>
                                <input type="text" id="approval_nama_lengkap"
                                       class="form-control form-control-sm"
                                       readonly>
                            </div>

                            <!-- Jenis Izin -->
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Jenis Izin</label>
                                <input type="text" id="approval_jenis_izin"
                                       class="form-control form-control-sm"
                                       readonly>
                            </div>

                            <!-- Keterangan -->
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Keterangan</label>
                                <textarea id="approval_keterangan"
                                          class="form-control form-control-sm"
                                          rows="2"
                                          readonly></textarea>
                            </div>

                            <!-- Tanggal -->
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Tanggal</label>
                                <input type="date" id="approval_tanggal"
                                       class="form-control form-control-sm"
                                       readonly>
                            </div>

                            <!-- Jam Mulai -->
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Jam Mulai</label>
                                <input type="time" id="approval_jam_mulai"
                                       class="form-control form-control-sm"
                                       readonly>
                            </div>

                            <!-- Jam Selesai -->
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Jam Selesai</label>
                                <input type="time" id="approval_jam_selesai"
                                       class="form-control form-control-sm"
                                       readonly>
                            </div>

                            <!-- Status -->
                            <div class="d-flex flex-column mb-2">
                                <label class="fw-bolder mb-1">Status</label>
                                <select class="form-select form-select-sm"
                                        id="approval_status"
                                        name="status"
                                        data-control="select2"
                                        data-placeholder="Pilih Status">
                                    <option value=""></option>
                                    <option value="DISETUJUI">DISETUJUI</option>
                                    <option value="DITOLAK">DITOLAK</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-sm btn-dark"
                            data-bs-dismiss="modal">Close</button>

                    <button type="submit"
                            class="btn btn-sm btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
