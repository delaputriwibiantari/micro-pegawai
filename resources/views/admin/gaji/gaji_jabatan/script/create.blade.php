<script defer>
    $('#form_create').on('show.bs.modal', function (e) {
        fetchDataDropdown('{{ route('api.gaji.komponengaji') }}', '#komponen_id', 'komponen_id', 'nama_komponen');
        fetchDataDropdown('{{ route('api.master.jabatan') }}', '#id_jabatan', 'id_jabatan', 'jabatan');
        $('#bt_submit_create').on('submit', function (e) {
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
                    const rawKomponen = $('#komponen_id').val();
                    const komponen_id = (rawKomponen && rawKomponen !== 'undefined' && rawKomponen !== '') ? rawKomponen : null;
                    const rawJabatan = $('#id_jabatan').val();
                    const id_jabatan = (rawJabatan&& rawJabatan!== 'undefined' && rawJabatan!== '') ? rawJabatan: null;
                    const input = {
                        gaji_master_id: $('#gaji_master_id').val(),
                        nominal: $('#nominal').val(),
                        komponen_id,
                        id_jabatan

                    };
                    console.log('Data yang akan dikirim:', input);
                    const action = '{{ route('admin.gaji.gaji_jabatan.store') }}';
                    DataManager.postData(action, input).then(response => {
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
