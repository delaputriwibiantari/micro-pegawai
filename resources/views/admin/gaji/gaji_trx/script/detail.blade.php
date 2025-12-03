<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.gaji.gaji_umum.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_transaksi_id').text(response.data.transaksi_id);
                    $('#detail_periode_id').text(response.data.periode_id);
                    $('#detail_total_penghasil').text(response.data.total_penghasil);
                    $('#detail_total_potongan').text(response.data.total_potongan);
                    $('#detail_total_bayar').text(response.data.total_bayar);
                    $('#detail_sdm_id').text(response.data.sdm_id);
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
