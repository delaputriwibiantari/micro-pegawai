<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.absensi.lembur.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_lembur_id').text(response.data.lembur_id);
                    $('#detail_tanggal').text(response.data.tanggal);
                    $('#detail_jam_mulai').text(response.data.jam_mulai);
                    $('#detail_sdm_id').text(response.data.sdm_id);
                    $('#detail_nama_lengkap').text(response.data.nama_lengkap);
                    $('#detail_jam_selesai').text(response.data.jam_selesai);
                    $('#detail_status').text(response.data.status);
                    $('#detail_disetujui_oleh').text(response.data.disetujui_oleh);
                    $('#detail_disetujui_oleh_nama').text(response.data.disetujui_oleh_nama);
                    $('#detail_disetujui_pada').text(response.data.disetujui_pada);
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
