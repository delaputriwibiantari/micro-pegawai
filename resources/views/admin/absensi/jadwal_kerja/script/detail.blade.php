<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.absensi.jadwal_kerja.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_jadwal_id').text(response.data.jadwal_id);
                    $('#detail_nama_jadwal').text(response.data.nama_jadwal);
                    $('#detail_jam_masuk').text(response.data.jam_masuk);
                    $('#detail_jam_pulang').text(response.data.jam_pulang);
                    $('#detail_toleransi_terlambat').text(response.data.toleransi_terlambat);
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
