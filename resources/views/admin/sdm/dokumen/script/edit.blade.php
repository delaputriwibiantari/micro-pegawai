<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.dokumen.show', ':id') }}";


    DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                    $('#edit_id_jenis_dokumen').val(data.id_jenis_dokumen).trigger('change');
                    $('#edit_nama_dokumen').val(response.data.nama_dokumen);

                if (data.file_dokumen) {
                    $('#current_file_dokumen_name').text(data.file_dokumen);
                    const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                        .replace(':folder', 'dokumen')
                        .replace(':filename', data.file_dokumen);
                    $('#current_file_dokumen_link').attr('href', fileUrl);
                    $('#current_file_dokumen_info').show();
                } else {
                    $('#current_file_dokumen_info').hide();
                }


                fetchDataDropdown("{{ route('api.ref.jenis-dokumen') }}", "#edit_id_jenis_dokumen", "jenis_dokumen", "jenis_dokumen", function () {
                    $("#edit_id_jenis_dokumen").val(data.id_jenis_dokumen).trigger("change");
                });
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });


        $("#bt_submit_edit").on("submit", function (e) {
            e.preventDefault();
            const fileDokumenInput = document.getElementById('edit_file_dokumen');

            const fileDokumen = fileDokumenInput.files[0];

            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

            if (fileDokumen) {
                if (fileDokumen.size > 5 * 1024 * 1024) {
                    Swal.fire("Warning", "Ukuran file Dokumen tidak boleh lebih dari 10MB", "warning");
                    return;
                }
                if (!allowedTypes.includes(fileDokumen.type)) {
                    Swal.fire("Warning", "Format file Dokumen harus PDF, JPG, JPEG, atau PNG", "warning");
                    return;
                }

            }
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Apakah datanya benar dan apa yang anda inginkan?',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false, allowEscapeKey: false,
                showCancelButton: true,
                cancelButtonColor: '#dd3333',
                confirmButtonText: 'Ya, Simpan', cancelButtonText: 'Batal', focusCancel: true,
            }).then((result) => {
                if (result.value) {
                    DataManager.openLoading();
                    const formData = new FormData();
                    formData.append('id_jenis_dokumen', $('#edit_id_jenis_dokumen').val());
                    formData.append('nama_dokumen', $('#edit_nama_dokumen').val());

                   if (fileDokumen) {
                        formData.append('file_dokumen', fileDokumen);
                    }
                    const updateUrl = "{{ route('admin.sdm.dokumen.update', ':id') }}";
                    DataManager.formData(updateUrl.replace(":id", id), formData).then(response => {

                        if (response.success) {
                            Swal.fire("Success", response.message, "success");
                            setTimeout(() => location.reload(), 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire("Warning", "Validasi bermasalah", "warning");
                        }
                        if (!response.success && !response.errors) {
                            Swal.fire('Peringatan', response.message, 'warning');
                        }
                    }).catch(error => {
                        ErrorHandler.handleError(error);
                    });
                }
            });
        });
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });
</script>
