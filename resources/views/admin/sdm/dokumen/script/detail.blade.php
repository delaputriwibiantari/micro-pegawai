<script defer>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.struktural.show', ':id') }}";

        DataManager.fetchData(detail.replace(':id', id)).then(response => {
                if (response.success) {
                    const data = response.data;
                    $("#detail_jenis_dokumen").text(data.jenis_dokumen);
                    $("#detail_nomor_dokumen").text(data.nomor_dokumen);
                    $("#detail_tgl_terbit").text(formatter.formatDate(data.tgl_terbit));
                    $("#detail_tgl_berlaku").text(formatter.formatDate(data.tgl_berlaku));

                } else {
                    Swal.fire("Warning", response.message, "warning");
                }
            })
            .catch(error => {
                ErrorHandler.handleError(error);
            });
    })
</script>
