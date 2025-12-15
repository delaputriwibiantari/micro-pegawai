<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {

        // tanggal izin
        $('#edit_tanggal').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
        });

        // jam mulai
        $('#edit_jam_mulai').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            allowInput: false,
        });

        // jam selesai
        $('#edit_jam_selesai').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            allowInput: false,
        });

        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.absensi.izin.show', [':id']) }}';

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {

                    const status = response.data.status;

                    $('#edit_izin_id').val(response.data.izin_id);
                    $('#edit_jenis_izin').val(response.data.jenis_izin).trigger('change');
                    $('#edit_sdm_id').val(response.data.sdm_id);
                    $('#edit_nama_lengkap').val(response.data.nama_lengkap);
                    $('#edit_keterangan').val(response.data.keterangan);

                    document
                        .getElementById('edit_tanggal')
                        ._flatpickr
                        .setDate(response.data.tanggal, true);

                    document
                        .getElementById('edit_jam_mulai')
                        ._flatpickr
                        .setDate(response.data.jam_mulai, true);

                    document
                        .getElementById('edit_jam_selesai')
                        ._flatpickr
                        .setDate(response.data.jam_selesai, true);

                    $('#edit_status').val(response.data.status).trigger('change');


                    if (status !== 'PENGAJUAN') {
                        $('#form_edit input, #form_edit select, #form_edit textarea')
                            .prop('disabled', true);

                        $('#bt_submit_edit').prop('disabled', true);

                        Swal.fire(
                            'Informasi',
                            'Data Izin yang sudah ' + status + ' tidak dapat diubah.',
                            'info'
                        );
                    } else {
                        $('#form_edit input, #form_edit select, #form_edit textarea')
                            .prop('disabled', false);

                        $('#bt_submit_edit').prop('disabled', false);
                    }

                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
                ErrorHandler.handleError(error);
            });

        $('#bt_submit_edit').on('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Apakah datanya benar dan sesuai?',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                cancelButtonColor: '#dd3333',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                focusCancel: true
            }).then((result) => {
                if (result.value) {
                    DataManager.openLoading();

                    const input = {
                        izin_id: $('#edit_izin_id').val(),
                        sdm_id: $('#edit_sdm_id').val(),
                        jenis_izin: $('#edit_jenis_izin').val(),
                        keterangan: $('#edit_keterangan').val(),
                        tanggal: $('#edit_tanggal').val(),
                        jam_mulai: $('#edit_jam_mulai').val(),
                        jam_selesai: $('#edit_jam_selesai').val(),
                        status: $('#edit_status').val(),
                    };

                    const update = '{{ route('admin.absensi.izin.update', [':id']) }}';

                    DataManager.putData(update.replace(':id', id), input)
                        .then(response => {
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
                        })
                        .catch(error => {
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
