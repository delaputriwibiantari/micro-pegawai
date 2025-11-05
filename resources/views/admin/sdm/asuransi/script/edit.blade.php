<script defer>
    $('#form_edit_asuransi').on('show.bs.modal', function (e) {
        // Don't reset here - let global cleaner handle it
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.asuransi.show', [':id']) }}';


        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#edit_kode_asuransi').val(response.data.kode_asuransi);
                    $('#edit_nama_asuransi').val(response.data.nama_asuransi);
                    $('#edit_penyelenggara').val(response.data.penyelenggara);
                    $('#edit_tipe_asuransi').val(response.data.tipe_asuransi);
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });


        $('#bt_submit_edit').off('submit').on('submit', function (e) {
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
                    formData.append('kode_asuransi', $('#edit_kode_asuransi').val());
                    formData.append('nama_asuransi', $('#edit_nama_asuransi').val());
                    formData.append('penyelenggara', $('#edit_penyelenggara').val());
                    formData.append('tipe_asuransi', $('#edit_tipe_asuransi').val());
                    }

                    const update = '{{ route('admin.asuransi.update', [':id']) }}';
                    DataManager.formData(update.replace(':id', id), formData).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter(
                                'edit_');
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Peringatan', 'Isian Anda belum lengkap atau tidak valid.', 'warning');
                        }

                        if (!response.success && !response.errors) {
                            Swal.fire('Warning', response.message, 'warning');
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
