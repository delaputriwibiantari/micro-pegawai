<script defer>
    $('#form_create_dokumen').on('show.bs.modal', function (e) {
        fetchDataDropdown("{{ route('api.ref.jenis-dokumen') }}", '#id_jenis_dokumen', 'jenis-dokumen', 'jenis-dokumen');


      $('#bt_submit_create').off('submit').on('submit', function (e) {
            e.preventDefault();
            const fileDokumenInput = document.getElementById('file_dokumen');
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
                    formData.append('id_jenis_dokumen', $('#id_jenis_dokumen').val());
                    formData.append('nama_dokumen', $('#nama_dokumen').val());
                   if (fileDokumen) {
                        formData.append('file_dokumen', fileDokumen);
                    }
                    const action = "{{ route('admin.sdm.dokumen.store') }}";
                    DataManager.formData(action, formData).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Warning', 'validasi bermasalah', 'warning');
                        }

                        if (!response.success && !response.errors) {
                            Swal.fire('Peringatan', response.message, 'warning');
                        }

                    }).catch(error => {
                        ErrorHandler.handleError(error);
                    });
                }
            })
        });
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });
</script>




