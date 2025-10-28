<script defer>
$('#form_edit').on('show.bs.modal', function (e) {
    const button = $(e.relatedTarget);
    const id = button.data("id");
    const detail = '{{ route('admin.admin.person.show', [':id']) }}';

    // ✅ AMAN: inisialisasi flatpickr dan simpan instance
    let edit_tanggal_lahir = $('#edit_tanggal_lahir').flatpickr({
        dateFormat: 'Y-m-d',
        altFormat: 'd/m/Y',
        allowInput: false,
        altInput: true,
    });

    DataManager.fetchData(detail.replace(':id', id))
        .then(function (response) {
            if (response.success) {
                // ✅ AMAN: pakai selector yang benar sesuai modal edit
                $('#edit_nama_lengkap').val(response.data.nama_lengkap);
                $('#edit_nama_panggilan').val(response.data.nama_panggilan);
                $('#edit_tempat_lahir').val(response.data.tempat_lahir);

                // ✅ AMAN: gunakan instance flatpickr untuk setDate
                edit_tanggal_lahir.setDate(response.data.tanggal_lahir);

                $('#edit_agama').val(response.data.agama);
                $('#edit_kewarganegaraan').val(response.data.kewarganegaraan);
                $('#edit_email').val(response.data.email);
                $('#edit_no_hp').val(response.data.no_hp);
                $('#edit_nik').val(response.data.nik);
                $('#edit_kk').val(response.data.kk);
                $('#edit_npwp').val(response.data.npwp);
                $('#edit_alamat').val(response.data.alamat);
                $('#edit_jk').val(response.data.jk).trigger('change');
                $('#edit_golongan_darah').val(response.data.golongan_darah).trigger('change');
                $('#edit_rt').val(response.data.rt);
                $('#edit_rw').val(response.data.rw);

                // ✅ AMAN: foto preview
                if (response.data.foto) {
                    const photoUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                        .replace(':folder', 'person')
                        .replace(':filename', response.data.foto);
                    $('#edit_image_preview').css({
                        'background-image': `url('${photoUrl}')`,
                        'background-size': 'cover',
                        'background-position': 'center'
                    });
                } else {
                    $('#edit_image_preview').css({
                        'background-image': '',
                        'background-size': 'contain',
                        'background-position': 'center'
                    });
                }

                // ✅ AMAN: isi dropdown provinsi/kabupaten/kecamatan/desa
                fetchDataDropdown('{{ route('api.almt.provinsi') }}', '#edit_id_provinsi', 'provinsi', 'provinsi', () => {
                    $('#edit_id_provinsi option').each(function () {
                        if ($(this).text() === response.data.provinsi) {
                            $('#edit_id_provinsi').val($(this).val()).trigger('change');

                            setTimeout(() => {
                                $('#edit_id_kabupaten option').each(function () {
                                    if ($(this).text() === response.data.kabupaten) {
                                        $('#edit_id_kabupaten').val($(this).val()).trigger('change');

                                        setTimeout(() => {
                                            $('#edit_id_kecamatan option').each(function () {
                                                if ($(this).text() === response.data.kecamatan) {
                                                    $('#edit_id_kecamatan').val($(this).val()).trigger('change');

                                                    setTimeout(() => {
                                                        $('#edit_id_desa option').each(function () {
                                                            if ($(this).text() === response.data.desa) {
                                                                $('#edit_id_desa').val($(this).val()).trigger('change');
                                                                return false;
                                                            }
                                                        });
                                                    }, 500);
                                                    return false;
                                                }
                                            });
                                        }, 500);
                                        return false;
                                    }
                                });
                            }, 500);
                            return false;
                        }
                    });
                });

            } else {
                Swal.fire('Warning', response.message, 'warning');
            }
        }).catch(function (error) {
            ErrorHandler.handleError(error);
        });

    // ✅ AMAN: update dependent dropdown
    $('#edit_id_provinsi').off('change.edit').on('change.edit', function () {
        const provinsiId = $(this).val();
        $('#edit_id_kabupaten, #edit_id_kecamatan, #edit_id_desa').empty().append('<option value="">-- Pilih --</option>');
        if (provinsiId) {
            const kabupatenUrl = `{{ route('api.almt.kabupaten', ':id') }}`.replace(':id', provinsiId);
            fetchDataDropdown(kabupatenUrl, '#edit_id_kabupaten', 'kabupaten', 'kabupaten');
        }
    });

    $('#edit_id_kabupaten').off('change.edit').on('change.edit', function () {
        const kabupatenId = $(this).val();
        $('#edit_id_kecamatan, #edit_id_desa').empty().append('<option value="">-- Pilih --</option>');
        if (kabupatenId) {
            const kecamatanUrl = `{{ route('api.almt.kecamatan', ':id') }}`.replace(':id', kabupatenId);
            fetchDataDropdown(kecamatanUrl, '#edit_id_kecamatan', 'kecamatan', 'kecamatan');
        }
    });

    $('#edit_id_kecamatan').off('change.edit').on('change.edit', function () {
        const kecamatanId = $(this).val();
        $('#edit_id_desa').empty().append('<option value="">-- Pilih --</option>');
        if (kecamatanId) {
            const desaUrl = `{{ route('api.almt.desa', ':id') }}`.replace(':id', kecamatanId);
            fetchDataDropdown(desaUrl, '#edit_id_desa', 'desa', 'desa');
        }
    });

    // ✅ AMAN: submit form edit, gunakan selector modal edit
    $('#bt_submit_edit').off('submit').on('submit', function (e) {
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

                // ✅ AMAN: gunakan selector modal edit yang benar
                formData.append('nama_lengkap', $('#edit_nama_lengkap').val());
                formData.append('nama_panggilan', $('#edit_nama_panggilan').val());
                formData.append('tempat_lahir', $('#edit_tempat_lahir').val());
                formData.append('tanggal_lahir', $('#edit_tanggal_lahir').val());
                formData.append('agama', $('#edit_agama').val());
                formData.append('kewarganegaraan', $('#edit_kewarganegaraan').val());
                formData.append('email', $('#edit_email').val());
                formData.append('no_hp', $('#edit_no_hp').val());
                formData.append('nik', $('#edit_nik').val());
                formData.append('kk', $('#edit_kk').val());
                formData.append('npwp', $('#edit_npwp').val());
                formData.append('alamat', $('#edit_alamat').val());
                formData.append('id_desa', $('#edit_id_desa').val());
                formData.append('jk', $('#edit_jk').val());
                formData.append('golongan_darah', $('#edit_golongan_darah').val());
                formData.append('rt', $('#edit_rt').val());
                formData.append('rw', $('#edit_rw').val());

                const fileInput = $('#edit_foto')[0];
                if (fileInput.files[0]) {
                    formData.append('foto', fileInput.files[0]);
                }

                const update = '{{ route('admin.admin.person.update', [':id']) }}';
                DataManager.formData(update.replace(':id', id), formData).then(response => {
                    if (response.success) {
                        Swal.fire('Success', response.message, 'success');
                        setTimeout(() => { location.reload(); }, 1000);
                    } else if (response.errors) {
                        new ValidationErrorFilter('edit_').filterValidationErrors(response);
                        Swal.fire('Peringatan', 'Isian Anda belum lengkap atau tidak valid.', 'warning');
                    } else {
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
</script>
