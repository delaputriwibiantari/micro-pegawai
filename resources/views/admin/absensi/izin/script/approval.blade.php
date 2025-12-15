<script defer>
    $('#form_approval').on('show.bs.modal', function (e) {

        const button = $(e.relatedTarget);
        const id = button.data('id');

        const detail = '{{ route('admin.absensi.izin.show', [':id']) }}';

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {

                    $('#approval_nama_lengkap').val(response.data.nama_lengkap);
                    $('#approval_jenis_izin').val(response.data.jenis_izin).trigger('change');
                    $('#approval_keterangan').val(response.data.keterangan);
                    $('#approval_tanggal').val(response.data.tanggal);
                    $('#approval_jam_mulai').val(response.data.jam_mulai);
                    $('#approval_jam_selesai').val(response.data.jam_selesai);
                    $('#approval_status').val(response.data.status).trigger('change');

                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            })
            .catch(function (error) {
                ErrorHandler.handleError(error);
            });

        $('#bt_submit_approval').off('submit').on('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Apakah izin ini ingin diproses?',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dd3333',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.value) {

                    DataManager.openLoading();

                    const input = {
                        status: $('#approval_status').val(),
                    };

                    const approval = '{{ route('admin.absensi.izin.approval', [':id']) }}';

                    DataManager.putData(approval.replace(':id', id), input)
                        .then(response => {
                            if (response.success) {
                                Swal.fire('Success', response.message, 'success');
                                setTimeout(() => location.reload(), 1000);
                            }

                            if (!response.success && response.errors) {
                                const validationErrorFilter =
                                    new ValidationErrorFilter('approval_');
                                validationErrorFilter.filterValidationErrors(response);
                                Swal.fire(
                                    'Peringatan',
                                    'Status belum dipilih atau tidak valid.',
                                    'warning'
                                );
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
