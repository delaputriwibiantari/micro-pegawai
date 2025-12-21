<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.absensi.absensi.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_absensi_id').text(response.data.absensi_id);
                    $('#detail_tanggal').text(response.data.tanggal);
                    $('#detail_sdm_id').text(response.data.sdm_id);
                    $('#detail_nama_lengkap').text(response.data.nama_lengkap);
                    $('#detail_jenis_absen_id').text(response.data.jenis_absen_id);
                    $('#detail_waktu_mulai').text(response.data.waktu_mulai);
                    $('#detail_waktu_selesai').text(response.data.waktu_selesai);
                    $('#detail_total_terlambat').text(response.data.total_terlambat);
                    $('#detail_nama_absen').text(response.data.nama_absen);
                    $('#null_data').hide();
                    $('#show_data').show();
                } else {
                    $('#null_data').show();
                    $('#show_data').hide();
                    Swal.fire('Peringatan', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>
