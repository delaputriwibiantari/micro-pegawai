<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.gaji.gaji_jabatan.show', [':id']) }}';

        $(this).data('id', id);

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    const data = response.data;

                    $('#edit_gaji_master_id').val(data.gaji_master_id);
                    $('#edit_nominal').val(data.nominal);

                    fetchDataDropdown('{{ route('api.gaji.komponengaji') }}', '#edit_komponen_id_select', 'id', 'nama_komponen', () => {
                        if (data.komponen_id) {
                            $('#edit_komponen_id_select').val(data.komponen_id).trigger('change');
                        }
                    });
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
                ErrorHandler.handleError(error);
            });
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();

        $('#edit_komponen_id_select').val(null).trigger('change');
        // Hapus data ID
        $(this).removeData('id');
    });

    $('#bt_submit_edit').on('submit', function (e) {
        e.preventDefault();

        // Ambil ID dari modal
        const id = $('#form_edit').data('id');
        if (!id) {
            Swal.fire('Error', 'Data ID tidak ditemukan', 'error');
            return;
        }

        // Ambil nilai umum_id dari select2
        const rawKomponen = $('#edit_komponen_id_select').val();
        const komponen_id = (rawKomponen && rawKomponen !== 'undefined' && rawKomponen !== '') ? rawKomponen : null;

        const input = {
            gaji_master_id: $('#edit_gaji_master_id').val(),
            nominal: $('#edit_nominal').val(),
            komponen_id: komponen_id
        };

        console.log('Data yang akan diupdate:', input);

        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Apakah datanya benar dan apa yang anda inginkan?',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            cancelButtonColor: '#dd3333',
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal',
            focusCancel: true
        }).then((result) => {
            if (result.value) {
                DataManager.openLoading();
                const update = '{{ route('admin.gaji.gaji_jabatan.update', [':id']) }}';
                DataManager.putData(update.replace(':id', id), input).then(response => {
                    if (response.success) {
                        Swal.fire('Success', response.message, 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    if (!response.success && response.errors) {
                        const validationErrorFilter = new ValidationErrorFilter('edit_');
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
        });
    });
</script>
