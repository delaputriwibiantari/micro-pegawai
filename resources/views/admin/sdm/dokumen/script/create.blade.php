<script defer>
    $('#form_create_dokumen').on('show.bs.modal', function (e) {
        $('#tgl_terbit').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            altInput: true,
            allowInput: false,
        });

        $('#tgl_berlaku').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            altInput: true,
            allowInput: false,
        });

      $('#bt_submit_create').off('submit').on('submit', function (e) {

            e.preventDefault();
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
                    formData.append('jenis_dokumen', $('#jenis_dokumen').val());
                    formData.append('nomor_dokumen', $('#nomor_dokumen').val());
                    formData.append('tgl_terbit', $('#tgl_terbit').val());
                    formData.append('tgl_berlaku', $('#tgl_berlaku').val());

                    const action = "{{ route('admin.asuransi.store') }}";
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




