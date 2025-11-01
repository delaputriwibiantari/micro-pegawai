<script defer>
$(document).ready(function() {

    console.log('🚀 Script loaded successfully');
    console.log('Flatpickr available:', typeof flatpickr !== 'undefined');

    let edit_tanggal_masuk;

    // ✅ Simpan ID saat modal show
    $(document).on('show.bs.modal', '#form_edit', function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        $(this).data('current-id', id);

        const detailUrl = '{{ route('admin.sdm.show', [':id']) }}'.replace(':id', id);
        console.log('🆔 ID:', id);
        console.log('🔗 URL:', detailUrl);

        if (edit_tanggal_masuk && edit_tanggal_masuk.destroy) {
            edit_tanggal_masuk.destroy();
            console.log('♻️ Flatpickr instance lama dihapus');
        }

        // Inisialisasi ulang flatpickr secara aman
        try {
            edit_tanggal_masuk = flatpickr('#edit_tanggal_masuk', {
                dateFormat: 'Y-m-d',
                altFormat: 'd/m/Y',
                altInput: true,
                allowInput: false
            });
            console.log('✅ Flatpickr berhasil diinisialisasi');
        } catch (err) {
            console.error('❌ Flatpickr gagal diinisialisasi:', err);
            $('#edit_tanggal_masuk').attr('type', 'date');
        }

        // ✅ Ambil data detail via DataManager (menghindari CSRF error)
        DataManager.fetchData(detailUrl)
            .then(function(response) {
                console.log('✅ Data fetched:', response);

                if (response.success && response.data) {
                    $('#edit_nip').val(response.data.nip);
                    $('#edit_status_pegawai').val(response.data.status_pegawai).trigger('change');
                    $('#edit_tipe_pegawai').val(response.data.tipe_pegawai).trigger('change');
                    $('#edit_id_person').val(response.data.id_person);
                    $('#edit_nama_lengkap').val(response.data.nama_lengkap);

                    if (response.data.tanggal_masuk) {
                        if (edit_tanggal_masuk && typeof edit_tanggal_masuk.setDate === 'function') {
                            edit_tanggal_masuk.setDate(response.data.tanggal_masuk);
                        } else {
                            $('#edit_tanggal_masuk').val(response.data.tanggal_masuk);
                        }
                    }

                    console.log('🎉 Form berhasil diisi!');
                } else {
                    Swal.fire('Warning', response.message || 'Data tidak ditemukan', 'warning');
                }
            })
            .catch(function(error) {
                console.error('💥 Fetch error:', error);
                ErrorHandler.handleError(error);
            });
    });

    // ✅ Reset modal saat ditutup
    $('#form_edit').on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });

    // ✅ Submit handler
    $(document).on('submit', '#bt_submit_edit', function(e) {
        e.preventDefault();
        console.log('🔄 Submit button clicked');

        const id = $('#form_edit').data('current-id');
        const updateUrl = '{{ route('admin.sdm.update', [':id']) }}'.replace(':id', id);

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
                formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // ✅ Tambah CSRF token
                formData.append('nip', $('#edit_nip').val());
                formData.append('status_pegawai', $('#edit_status_pegawai').val());
                formData.append('tipe_pegawai', $('#edit_tipe_pegawai').val());
                formData.append('tanggal_masuk', $('#edit_tanggal_masuk').val());
                formData.append('id_person', $('#edit_id_person').val());
                formData.append('nama_lengkap', $('#edit_nama_lengkap').val());

                DataManager.formData(updateUrl, formData)
                    .then(response => {
                        console.log('✅ Update response:', response);
                        if (response.success) {
                            Swal.fire('Berhasil', response.message, 'success');
                            $('#form_edit').modal('hide');
                            setTimeout(() => { location.reload(); }, 800);
                        } else if (response.errors) {
                            new ValidationErrorFilter('edit_').filterValidationErrors(response);
                            Swal.fire('Peringatan', 'Ada data yang belum lengkap atau salah.', 'warning');
                        } else {
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('💥 Update error:', error);
                        ErrorHandler.handleError(error);
                    });
            }
        });
    });
});
</script>
