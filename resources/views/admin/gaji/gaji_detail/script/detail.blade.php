<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.gaji.gaji_detail.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_detail_id').text(response.data.detail_id);
                    $('#detail_komponen_id').text(response.data.komponen_id);
                    $('#detail_nominal').text(response.data.nominal);
                    $('#detail_keterangan').text(response.data.keterangan);
                    $('#detail_transaksi_id').text(response.data.transaksi_id);
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
