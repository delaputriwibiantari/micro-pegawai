<script defer>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.dokumen.show', ':id') }}";

        DataManager.fetchData(detail.replace(':id', id)).then(response => {
                if (response.success) {
                    const data = response.data;
                    $("#detail_id_jenis_dokumen").text(data.jenis_dokumen);
                    $("#detail_nama_dokumen").text(data.nama_dokumen);
                   if (data.file_dokumen) {
                        $('#detail_file_dokumen_name').text(data.file_dokumen);
                        const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                            .replace(':folder', 'dokumen')
                            .replace(':filename', data.file_dokumen);
                        $('#detail_file_dokumen_link').attr('href', fileUrl);
                        $('#detail_file_dokumen_section').show();
                        $('#no_file_dokumen_section').hide();
                    } else {
                        $('#detail_file_dokumen_section').hide();
                        $('#no_file_dokumen_section').show();
                    }
                } else {
                    Swal.fire("Warning", response.message, "warning");
                }
            })
            .catch(error => {
                ErrorHandler.handleError(error);
            });
    })
</script>
