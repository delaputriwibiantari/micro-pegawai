<script defer>
    $('#form_edit_pendidikan').on('show.bs.modal', function (e) {
        // Don't reset here - let global cleaner handle it
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.pendidikan.show', [':id']) }}';


        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#edit_institusi').val(response.data.institusi);
                    $('#edit_jurusan').val(response.data.jurusan);
                    $('#edit_tahun_masuk').val(response.data.tahun_masuk);
                    $('#edit_tahun_lulus').val(response.data.tahun_lulus);
                    $('#edit_jenis_nilai').val(response.data.jenis_nilai).trigger('change');
                    $('#edit_sks').val(response.data.sks);
                    $('#edit_sumber_biaya').val(response.data.sumber_biaya)trigger('change');
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
                    formData.append('institusi', $('#edit_institusi').val());
                    formData.append('jurusan', $('#edit_jurusan').val());
                    formData.append('tahun_masuk', $('#edit_tahun_masuk').val());
                    formData.append('tahun_lulus', $('#edit_tahun_lulus').val());
                    formData.append('jenis_nilai', $('#edit_jenis_nilai').val());
                    formData.append('sks', $('#edit_sks').val());
                    formData.append('sumber_biaya', $('#edit_sumber_biaya').val());
                    }

                    const update = '{{ route('admin.pendidikan.update', [':id']) }}';
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
