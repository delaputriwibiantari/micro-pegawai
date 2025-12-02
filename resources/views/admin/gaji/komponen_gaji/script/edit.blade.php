<script defer>
    // Event ketika modal edit ditampilkan
    $('#form_edit').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.gaji.komponen_gaji.show', [':id']) }}';

        // Simpan ID di data attribute modal
        $(this).data('id', id);

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    const data = response.data;

                    // Isi form dengan data
                    $('#edit_komponen_id').val(data.komponen_id);
                    $('#edit_nama_komponen').val(data.nama_komponen);
                    $('#edit_jenis').val(data.jenis).trigger('change');
                    $('#edit_deskripsi').val(data.deskripsi);

                    // Handle checkbox is_umum
                    if (data.is_umum == 1 || data.is_umum === true) {
                        $('#edit_is_umum').prop('checked', true);
                    } else {
                        $('#edit_is_umum').prop('checked', false);
                    }

                    // Load dropdown dan set nilai
                    fetchDataDropdown('{{ route('api.gaji.gajiumum') }}', '#edit_umum_id_select', 'id', 'nominal', () => {
                        if (data.umum_id) {
                            $('#edit_umum_id_select').val(data.umum_id).trigger('change');
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
        // Reset checkbox
        $('#edit_is_umum').prop('checked', false);
        // Reset select2
        $('#edit_umum_id_select').val(null).trigger('change');
        // Hapus data ID
        $(this).removeData('id');
    });

    // Event submit untuk form edit (di luar show.bs.modal)
    $('#bt_submit_edit').on('submit', function (e) {
        e.preventDefault();

        // Ambil ID dari modal
        const id = $('#form_edit').data('id');
        if (!id) {
            Swal.fire('Error', 'Data ID tidak ditemukan', 'error');
            return;
        }

        // Ambil nilai umum_id dari select2
        const rawUmum = $('#edit_umum_id_select').val();
        const umum_id = (rawUmum && rawUmum !== 'undefined' && rawUmum !== '') ? rawUmum : null;

        const input = {
            komponen_id: $('#edit_komponen_id').val(),
            nama_komponen: $('#edit_nama_komponen').val(),
            jenis: $('#edit_jenis').val(),
            deskripsi: $('#edit_deskripsi').val(),
            is_umum: $('#edit_is_umum').is(':checked') ? 1 : 0,
            umum_id: umum_id
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
                const update = '{{ route('admin.gaji.komponen_gaji.update', [':id']) }}';
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
