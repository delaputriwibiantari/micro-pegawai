<script defer>
    $("#form_detail").on("show.bs.modal", function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.sdm.sdm.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_nama_lengkap').text(response.data.nama_lengkap);
                    $('#detail_nik').text(response.data.nik);
                    $('#detail_no_hp').text(response.data.no_hp);
                    $('#detail_status_pegawai').text(response.data.status_pegawai);
                    $('#detail_tipe_pegawai').text(response.data.tipe_pegawai);
                    $('#detail_tahun_masuk').text(formatter.formatDate(response.data.tahun_masuk));
                } else {
                    Swal.fire('Peringatan', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>
