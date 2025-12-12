<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.absensi.jenis_absensi.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_jenis_absen_id').text(response.data.jenis_absen_id);
                    $('#detail_nama_absen').text(response.data.nama_absen);
                    $('#detail_kategori').text(response.data.kategori);
                    $('#detail_potong_gaji').text(response.data.potong_gaji);
                    $('#detail_warna').text(response.data.warna);
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
