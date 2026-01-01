<script defer>
    $('#form_edit')
        .on('show.bs.modal', function (e) {
            const button = $(e.relatedTarget);
            const id = button.data('id');
            const detail = '{{ route('admin.gaji.gaji_jabatan.show', [':id']) }}';

            $(this).data('id', id);

            DataManager.fetchData(detail.replace(':id', id))
                .then(function (response) {
                    if (!response.success) {
                        Swal.fire('Warning', response.message, 'warning');
                        return;
                    }

                    const data = response.data;

                    $('#edit_gaji_master_id').val(data.gaji_master_id);
                    $('#edit_override_nominal').val(data.override_nominal);

                    fetchDataDropdown(
                        '{{ route('api.gaji.komponengaji') }}',
                        '#edit_komponen_id_select',
                        'komponen_id',
                        'nama_komponen',
                        () => {
                            $('#edit_komponen_id_select')
                                .val(data.komponen_id)
                                .trigger('change');
                        }
                    );

                    fetchDataDropdown(
                        '{{ route('api.master.jabatan') }}',
                        '#edit_id_jabatan',
                        'id_jabatan',
                        'jabatan',
                        () => {
                            $('#edit_id_jabatan')
                                .val(data.id_jabatan)
                                .trigger('change');
                        }
                    );


                    // SET CHECKBOX & VISIBILITY
                    $('#edit_use_override').prop('checked', data.use_override == 1);
                    if (data.use_override == 1) {
                        $('#override_nominal_container').show();
                    } else {
                        $('#override_nominal_container').hide();
                        $('#edit_override_nominal').val('');
                    }
                })
                .catch(ErrorHandler.handleError);
        })
        .on('hidden.bs.modal', function () {
            const $m = $(this);
            $m.find('form').trigger('reset');
            $m.find('select, textarea').val('').trigger('change');
            $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
            $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();

            $('#edit_komponen_id_select').val(null).trigger('change');
            $(this).removeData('id');
        });

    // TOGGLE OVERRIDE
    $('#edit_use_override').on('change', function () {
        if (this.checked) {
            $('#override_nominal_container').show();
        } else {
            $('#override_nominal_container').hide();
            $('#edit_override_nominal').val('');
        }
    });

    // SUBMIT EDIT
    $('#bt_submit_edit').on('submit', function (e) {
        e.preventDefault();

        const id = $('#form_edit').data('id');
        if (!id) {
            Swal.fire('Error', 'Data ID tidak ditemukan', 'error');
            return;
        }

        const rawKomponen = $('#edit_komponen_id_select').val();
        const komponen_id =
            rawKomponen && rawKomponen !== 'undefined' && rawKomponen !== ''
                ? rawKomponen
                : null;

        const rawJabatan = $('#edit_id_jabatan').val();
        const id_jabatan =
            rawJabatan && rawJabatan !== 'undefined' && rawJabatan !== ''
                ? rawJabatan
                : null;

        const input = {
            komponen_id: komponen_id,
            id_jabatan: id_jabatan,
            use_override: $('#edit_use_override').is(':checked') ? 1 : 0,
            override_nominal: $('#edit_use_override').is(':checked')
                ? $('#edit_override_nominal').val()
                : null
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
            if (!result.value) return;

            DataManager.openLoading();
            const update = '{{ route('admin.gaji.gaji_jabatan.update', [':id']) }}';

            DataManager.postData(update.replace(':id', id), input)
                .then(response => {
                    if (response.success) {
                        Swal.fire('Success', response.message, 'success');
                        setTimeout(() => location.reload(), 1000);
                        return;
                    }

                    if (response.errors) {
                        const validationErrorFilter = new ValidationErrorFilter('edit_');
                        validationErrorFilter.filterValidationErrors(response);
                        Swal.fire(
                            'Peringatan',
                            'Isian Anda belum lengkap atau tidak valid.',
                            'warning'
                        );
                        return;
                    }

                    Swal.fire('Warning', response.message, 'warning');
                })
                .catch(ErrorHandler.handleError);
        });
    });
</script>
