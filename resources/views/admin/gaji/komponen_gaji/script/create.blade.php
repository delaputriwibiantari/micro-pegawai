<script defer>
    $('#form_create').on('show.bs.modal', function (e) {
        fetchDataDropdown('{{ route('api.gaji.gajiumum') }}', '#umum_id', 'id', 'nominal');
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
                    const rawUmum = $('#umum_id').val();
                    const umum_id = (rawUmum && rawUmum !== 'undefined' && rawUmum !== '') ? rawUmum : null;
                    const input = {
                        komponen_id: $('#komponen_id').val(),
                        nama_komponen: $('#nama_komponen').val(),
                        jenis: $('#jenis').val(),
                        deskripsi: $('#deskripsi').val(),
                        is_umum: $('#is_umum').is(':checked') ? 1 : 0,
                        umum_id

                    };
                    console.log('Data yang akan dikirim:', input);
                    const action = '{{ route('admin.gaji.komponen_gaji.store') }}';
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
