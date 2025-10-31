<script defer>
$('#form_edit_sdm').on('show.bs.modal', function (e) {
    const button = $(e.relatedTarget);
    const id = button.data("id");
    const detail = '{{ route('admin.sdm.show', [':id']) }}'; // route detail SDM

    // Flatpickr untuk tanggal masuk
    let edit_tanggal_masuk = $('#edit_tanggal_masuk').flatpickr({
        dateFormat: 'Y-m-d',
        altFormat: 'd/m/Y',
        altInput: true,
        allowInput: false,
    });

    // 🔍 Ambil detail data SDM
    DataManager.fetchData(detail.replace(':id', id))
        .then(function (response) {
            if (response.success) {
                $('#edit_nip').val(response.data.nip);
                $('#edit_status_pegawai').val(response.data.status_pegawai);
                $('#edit_tipe_pegawai').val(response.data.tipe_pegawai);
                $('#edit_id_person').val(response.data.id_person);
                $('#edit_nama_lengkap').val(response.data.nama_lengkap);

                edit_tanggal_masuk.setDate(response.data.tanggal_masuk);

            } else {
                Swal.fire('Warning', response.message, 'warning');
            }
        })
        .catch(function (error) {
            ErrorHandler.handleError(error);
        });

    // 📝 Saat form disubmit
    $('#bt_submit_edit_sdm').off('submit').on('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin nih?',
            text: 'Data SDM akan diperbarui!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                DataManager.openLoading();
                const formData = new FormData();

                formData.append('nip', $('#edit_nip').val());
                formData.append('status_pegawai', $('#edit_status_pegawai').val());
                formData.append('tipe_pegawai', $('#edit_tipe_pegawai').val());
                formData.append('tanggal_masuk', $('#edit_tanggal_masuk').val());
                formData.append('id_person', $('#edit_id_person').val());

                const updateUrl = '{{ route('admin.sdm.update', [':id']) }}';

                DataManager.formData(updateUrl.replace(':id', id), formData)
                    .then(response => {
                        if (response.success) {
                            Swal.fire('Berhasil', response.message, 'success');
                            setTimeout(() => { location.reload(); }, 800);
                        } else if (response.errors) {
                            new ValidationErrorFilter('edit_').filterValidationErrors(response);
                            Swal.fire('Peringatan', 'Ada data yang belum lengkap atau salah.', 'warning');
                        } else {
                            Swal.fire('Gagal', response.message, 'error');
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
