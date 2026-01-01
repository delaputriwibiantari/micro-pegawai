<script>
    $('#form_edit').on('show.bs.modal', function (e) {

        $('#edit_tanggal').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
        });

        const fpJamMulai = flatpickr('#edit_jam_mulai', {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            onChange: hitungTotalJamEdit
        });

        const fpJamSelesai = flatpickr('#edit_jam_selesai', {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            onChange: hitungTotalJamEdit
        });


        const button = $(e.relatedTarget);
        const id = button.data('id');
        if (!id || id === 'undefined') {
            return;
        }
        const detail = '{{ route('admin.absensi.lembur.show', [':id']) }}';

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {

                    const status = response.data.status;

                    $('#edit_lembur_id').val(response.data.lembur_id);
                    $('#edit_sdm_id').val(response.data.sdm_id);
                    $('#edit_tanggal').val(response.data.tanggal);
                    $('#edit_nama_lengkap').val(response.data.nama_lengkap);
                    $('#edit_keterangan').val(response.data.keterangan);

                    fpJamMulai.setDate(response.data.jam_mulai, true);
                    fpJamSelesai.setDate(response.data.jam_selesai, true);

                    $('#edit_durasi_jam').val(response.data.durasi_jam);
                    $('#edit_status').val(status).trigger('change');

                    // === LOGIKA KUNCI EDIT ===
                    if (status !== 'PENGAJUAN') {
                        $('#form_edit input, #form_edit select, #form_edit textarea')
                            .prop('disabled', true);

                        $('#bt_submit_edit').prop('disabled', true);

                        Swal.fire(
                            'Informasi',
                            'Data lembur yang sudah ' + status + ' tidak dapat diubah.',
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
                text: 'Apakah datanya benar dan apa yang anda inginkan?',
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
                        lembur_id: $('#edit_lembur_id').val(),
                        sdm_id: $('#edit_sdm_id').val(),
                        tanggal: $('#edit_tanggal').val(),
                        jam_mulai: $('#edit_jam_mulai').val(),
                        jam_selesai: $('#edit_jam_selesai').val(),
                        durasi_jam: $('#edit_durasi_jam').val(),
                        status: $('#edit_status').val(),

                    };
                    const update = '{{ route('admin.absensi.lembur.update', [':id']) }}';
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
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
        $m.find('input, select, textarea').prop('disabled', false);
        $('#bt_submit_edit').prop('disabled', false);
    });


    function hitungTotalJamEdit() {
        const mulai = $('#edit_jam_mulai').val();
        const selesai = $('#edit_jam_selesai').val();

        if (!mulai || !selesai) {
            $('#edit_durasi_jam').val('');
            return;
        }

        const start = new Date(`1970-01-01T${mulai}:00`);
        const end   = new Date(`1970-01-01T${selesai}:00`);

        if (end <= start) {
            $('#edit_durasi_jam').val('');
            Swal.fire(
                'Peringatan',
                'Jam selesai harus lebih besar dari jam mulai',
                'warning'
            );
            return;
        }

        const diffMs  = end - start;
        const diffJam = (diffMs / (1000 * 60 * 60)).toFixed(2);

        $('#edit_durasi_jam').val(diffJam);
    }


</script>
