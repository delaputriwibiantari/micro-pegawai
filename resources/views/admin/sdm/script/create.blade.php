<script defer>
    $('#form_create').on('show.bs.modal', function (e) {


        // Pertama, isi dropdown person dari API (sama kayak fetchDataDropdown-mu)
fetchDataDropdown("{{ route('api.person.list') }}", "#id_person", "id", "nama_lengkap");

// Ketika dropdown person berubah, ambil nama lengkap-nya
$('#id_person').off('change').on('change', function () {
    const personId = $(this).val();
    // Kosongkan input nama_lengkap dulu
    $('#nama_lengkap').val('');

    if (personId) {
        // Panggil endpoint API untuk ambil detail person berdasarkan ID
        const personUrl = `{{ route('api.person.show', ':id') }}`.replace(':id', personId);
        $.get(personUrl, function (data) {

            if (data && data.nama_lengkap) {
                // Isi otomatis nama lengkap di form sdm
                $('#nama_lengkap').val(data.nama_lengkap);
            }
        });
    }
});


        $('#bt_submit_create').off('submit').on('submit', function (e) {
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
                    formData.append('nip', $('#nip').val());
                    formData.append('status_pegawai', $('#status_pegawai').val());
                    formData.append('tipe_pegawai', $('#tempat_lahir').val());
                    formData.append('tanggal_masuk', $('#tanggal_masuk').val());
                    formData.append('id_person', $('#id_person').val());
                    formData.append('nama_lengkap', $('#nama_lengkap').val());

                    }

                    const action = "{{ route('admin.admin.sdm.store') }}";
                    DataManager.formData(action, formData).then(response => {
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
