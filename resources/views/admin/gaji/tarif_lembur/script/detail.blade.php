<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.gaji.tarif_lembur.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_tarif_id').text(response.data.tarif_id);
                    $('#detail_jenis_lembur').text(response.data.jenis_lembur === 'BIASA' ? 'BIASA' : (response.data.jenis_lembur === 'LIBUR' ? 'LIBUR' : response.data.jenis_lembur));
                    $('#detail_tarif_per_jam').text(response.data.tarif_per_jam);
                    $('#detail_berlaku_mulai').text(response.data.berlaku_mulai);
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
