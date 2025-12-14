<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {

        $('#edit_tanggal_mulai').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
            onChange: hitungTotalHariEdit
        });

        $('#edit_tanggal_selesai').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
            onChange: hitungTotalHariEdit
        });



        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.absensi.cuti.show', [':id']) }}';

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#edit_cuti_id').val(response.data.cuti_id);
                    $('#edit_jenis_cuti').val(response.data.jenis_cuti).trigger('change');
                    $('#edit_sdm_id').val(response.data.sdm_id);
                    $('#edit_nama_lengkap').val(response.data.nama_lengkap);
                    $('#edit_keterangan').val(response.data.keterangan);document
                        .getElementById('edit_tanggal_mulai')
                        ._flatpickr
                        .setDate(response.data.tanggal_mulai, true);

                        document
                        .getElementById('edit_tanggal_selesai')
                        ._flatpickr
                        .setDate(response.data.tanggal_selesai, true);
                    $('#edit_total_hari').val(response.data.total_hari);
                    $('#edit_status').val(response.data.status).trigger('change');
                    
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
                        cuti_id: $('#edit_cuti_id').val(),
                        sdm_id: $('#edit_sdm_id').val(),
                        jenis_cuti: $('#edit_jenis_cuti').val(),
                        keterangan: $('#edit_keterangan').val(),
                        tanggal_mulai: $('#edit_tanggal_mulai').val(),
                        tanggal_selesai: $('#edit_tanggal_selesai').val(),
                        total_hari: $('#edit_total_hari').val(),
                        status: $('#edit_status').val(),

                    };
                    const update = '{{ route('admin.absensi.cuti.update', [':id']) }}';
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
    });

    function hitungTotalHariEdit() {
        const mulai = $('#edit_tanggal_mulai').val();
        const selesai = $('#edit_tanggal_selesai').val();

        if (!mulai || !selesai) {
            $('#edit_total_hari').val('');
            return;
        }

        const start = new Date(mulai);
        const end = new Date(selesai);

        if (end < start) {
            $('#edit_total_hari').val('');
            Swal.fire('Peringatan', 'Tanggal selesai tidak boleh sebelum tanggal mulai', 'warning');
            return;
        }

        const diffTime = end.getTime() - start.getTime();
        const totalHari = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

        $('#edit_total_hari').val(totalHari);
    }

</script>
