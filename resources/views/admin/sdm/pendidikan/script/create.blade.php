<script defer>
    $('#form_create_pendidikan').on('show.bs.modal', function (e) {
         fetchDataDropdown("{{ route('api.ref.jenjang-pendidikan') }}", '#id_jenjang_pendidikan', 'jenjang_pendidikan', 'jenjang_pendidikan');

      $('#bt_submit_create').off('submit').on('submit', function (e) {
            e.preventDefault();
            const fileIjazahInput = document.getElementById('file_ijazah');
            const fileTranskipInput = document.getElementById('file_transkip');
            const fileIjazah = fileIjazahInput.files[0];
            const fileTranskip = fileTranskipInput.files[0];
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

            if (fileIjazah) {
                if (fileIjazah.size > 5 * 1024 * 1024) {
                    Swal.fire("Warning", "Ukuran file Ijazah tidak boleh lebih dari 10MB", "warning");
                    return;
                }
                if (!allowedTypes.includes(fileIjazah.type)) {
                    Swal.fire("Warning", "Format file Ijazah harus PDF, JPG, JPEG, atau PNG", "warning");
                    return;
                }

            }

            if (fileTranskip) {
                if (fileTranskip.size > 5 * 1024 * 1024) {
                    Swal.fire("Warning", "Ukuran file Transkip tidak boleh lebih dari 10MB", "warning");
                    return;
                }

                if (!allowedTypes.includes(fileTranskip.type)) {
                    Swal.fire("Warning", "Format file Transkip harus PDF, JPG, JPEG, atau PNG", "warning");
                    return;
                }
            }
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
                    formData.append('institusi', $('#institusi').val());
                    formData.append('jurusan', $('#jurusan').val());
                    formData.append('tahun_masuk', $('#tahun_masuk').val());
                    formData.append('tahun_lulus', $('#tahun_lulus').val());
                    formData.append('jenis_nilai', $('#jenis_nilai').val());
                    formData.append('sks', $('#sks').val());
                    formData.append('sumber_biaya', $('#sumber_biaya').val());
                    formData.append('id_sdm', $('#id_sdm').val());

                    const action = "{{ route('admin.sdm.pendidikan.store') }}";
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
