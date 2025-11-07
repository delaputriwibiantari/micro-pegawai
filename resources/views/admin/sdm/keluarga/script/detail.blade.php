<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.sdm.keluarga.show', [':id']) }}';


        DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                    $('#detail_id_hubungan_keluarga').text(response.data.id_hubungan_keluarga);
                    $('#detail_status_tanggungan').text(response.data.status_tanggungan === 'YA' ? 'YA' : (response.data.status_tanggungan === 'TIDAK' ? 'TIDAK' : response.data.status_tanggungan));
                    $('#detail_pekerjaan').text(response.data.pekerjaan);
                    $('#detail_pendidikan_terakhir').text(response.data.pendidikan_terakhir);
                    $('#detail_penghasilan').text(response.data.penghasilan);

                } else {
                    Swal.fire("Warning", response.message, "warning");
                }
            })
            .catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>

