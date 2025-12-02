<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.gaji.gaji_periode.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_periode_id').text(response.data.periode_id);
                    $('#detail_tahun').text(response.data.tahun);
                    $('#detail_tanggal_mulai').text(response.data.tanggal_mulai);
                    $('#detail_tanggal_selesai').text(response.data.tanggal_selesai);
                    $('#detail_status').text(response.data.status === 'DRAFT' ? 'DRAFT' : (response.data.status === 'FINAL' ? 'FINAL' : (response.data.status === 'CLOSED' ? 'CLOSED' : response.data.status));
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
