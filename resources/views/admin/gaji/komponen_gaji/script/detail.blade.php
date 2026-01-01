<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.gaji.komponen_gaji.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_komponen_id').text(response.data.komponen_id);
                    $('#detail_nama_komponen').text(response.data.nama_komponen);
                    $('#detail_jenis').text(response.data.jenis === 'PENGHASIL' ? 'PENGHASIL' : (response.data.jenis === 'POTONGAN' ? 'POTONGAN' : response.data.jenis));
                    $('#detail_deskripsi').text(response.data.deskripsi);
                    $('#detail_is_umum').text(response.data.is_umum);
                    $('#detail_aturan_nominal').text(response.data.aturan_nominal);
                    $('#detail_referensi_id').text(response.data.referensi_id);
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
