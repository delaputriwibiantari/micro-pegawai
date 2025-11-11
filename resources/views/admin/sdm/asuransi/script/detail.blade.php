<script defer>
    $("#form_detail").on("show.bs.modal", function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.sdm.asuransi.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_nama_lengkap').text(response.data.nama_lengkap);
                    $('#detail_nik').text(response.data.nik);
                    $('#detail_id_jenis_asuransi').text(response.data.nama_asuransi ?? '-'); // ✅ ubah ini
                    $('#detail_nama_anggota').text(response.data.nama_lengkap ?? '-');
                    $('#detail_nomer_peserta').text(response.data.nomer_peserta);
                    $('#detail_kartu_anggota').text(response.data.kartu_anggota);
                    $('#detail_status').text(response.data.status);
                    $('#detail_tanggal_mulai').text(formatter.formatDate(response.data.tanggal_mulai));
                    $('#detail_tanggal_berakhir').text(formatter.formatDate(response.data.tanggal_berakhir));
                    $('#detail_keterangan').text(response.data.keterangan);
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>
