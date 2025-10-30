<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script defer>
    $(document).ready(function () {
        // Isi dropdown person saat halaman siap (jika diperlukan)
        fetchDataDropdown("{{ route('api.person.list') }}", "#id_person", "id", "nama_lengkap");

        // Event pencarian NIK
        $('#btn-Cari').off('click').on('click', function () {
            alert('Tombol berhasil diklik!');
            let nik = $('#nik').val();
            let url = $('#btn-Cari').data('url');


            if (nik === '') {
                alert('Masukkan NIK terlebih dahulu!');
                return;
            }

            $.ajax({
                url: "{{ route('admin.sdm.cari') }}",
                method: 'GET',
                data: { nik: nik },
                success: function (res) {
                    if (res.success) {
                        $('#info_person').html(`
                            <div class="alert alert-success">
                                <strong>Nama:</strong> ${res.data.nama_lengkap}<br>
                                <strong>NIK:</strong> ${res.data.nik}<br>
                                <strong>Tanggal Lahir:</strong> ${res.data.tanggal_lahir}<br>
                                <strong>Alamat:</strong> ${res.data.alamat}
                            </div>
                        `);
                        $('#form_lanjutan').removeClass('d-none');
                        $('#id_person').val(res.data.id_person);
                        $('#nama_lengkap').val(res.data.nama_lengkap);
                        $('#nama_person_heading').text(res.data.nama_lengkap);
                    } else {
                        $('#info_person').html(`
                            <div class="alert alert-danger">${res.message}</div>
                        `);
                        $('#form_lanjutan').addClass('d-none');
                    }
                },
                error: function () {
                    alert('Terjadi kesalahan saat mencari data.');
                }
            });
        });

        // Submit form SDM
        $('#bt_submit_create').off('submit').on('submit', function (e) {
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
                focusCancel: true,
            }).then((result) => {
                if (result.value) {
                    DataManager.openLoading();
                    const formData = new FormData();
                    formData.append('nip', $('#nip').val());
                    formData.append('status_pegawai', $('#status_pegawai').val());
                    formData.append('tipe_pegawai', $('#tipe_pegawai').val());
                    formData.append('tanggal_masuk', $('#tanggal_masuk').val());
                    formData.append('id_person', $('#id_person').val());

                    const action = "{{ route('admin.sdm.store') }}";
                    DataManager.formData(action, formData).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        } else if (response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Warning', 'validasi bermasalah', 'warning');
                        } else {
                            Swal.fire('Peringatan', response.message, 'warning');
                        }
                    }).catch(error => {
                        ErrorHandler.handleError(error);
                    });
                }
            });
        });

        // Reset form saat modal ditutup
        $('#form_create').on('hidden.bs.modal', function () {
            const $m = $(this);
            $m.find('form').trigger('reset');
            $m.find('select, textarea').val('').trigger('change');
            $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
            $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
            $('#info_person').html('');
            $('#form_lanjutan').addClass('d-none');
            $('#nama_person_heading').text('');
        });
    });
</script>


