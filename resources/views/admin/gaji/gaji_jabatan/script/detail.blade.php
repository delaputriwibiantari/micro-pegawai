<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.gaji.gaji_jabatan.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_gaji_master_id').text(response.data.gaji_master_id);
                    $('#detail_komponen_id').text(response.data.komponen_id);
                    $('#detail_nama_komponen').text(response.data.nama_komponen);
                    $('#detail_use_override').text(response.data.use_override);
                    $('#detail_override_nominal').text(response.data.override_nominal);
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
