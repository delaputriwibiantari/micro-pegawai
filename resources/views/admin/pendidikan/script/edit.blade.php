<script defer>
$(document).ready(function() {

    console.log('🚀 Script Pendidikan Edit loaded successfully');
    console.log('Flatpickr available:', typeof flatpickr !== 'undefined');

    let edit_tahun_masuk;
    let edit_tahun_lulus;

    // ✅ Saat modal edit pendidikan dibuka
    $(document).on('show.bs.modal', '#form_edit_pendidikan', function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        $(this).data('current-id', id);

        const detailUrl = '{{ route('admin.pendidikan.show', [':id']) }}'.replace(':id', id);
        console.log('🆔 ID Pendidikan:', id);
        console.log('🔗 Detail URL:', detailUrl);

        // Hapus instance flatpickr lama kalau ada
        if (edit_tahun_masuk && edit_tahun_masuk.destroy) edit_tahun_masuk.destroy();
        if (edit_tahun_lulus && edit_tahun_lulus.destroy) edit_tahun_lulus.destroy();

        // Inisialisasi flatpickr untuk tahun masuk & lulus
        try {
            edit_tahun_masuk = flatpickr('#edit_tahun_masuk', {
                dateFormat: 'Y',
                altInput: true,
                altFormat: 'Y',
                allowInput: false
            });
            edit_tahun_lulus = flatpickr('#edit_tahun_lulus', {
                dateFormat: 'Y',
                altInput: true,
                altFormat: 'Y',
                allowInput: false
            });
            console.log('✅ Flatpickr berhasil diinisialisasi');
        } catch (err) {
            console.error('❌ Flatpickr gagal diinisialisasi:', err);
            $('#edit_tahun_masuk, #edit_tahun_lulus').attr('type', 'number');
        }

        // ✅ Ambil detail data pendidikan dari server
        DataManager.fetchData(detailUrl)
            .then(function(response) {
                console.log('✅ Data fetched:', response);

                if (response.success && response.data) {
                    $('#edit_institusi').val(response.data.institusi);
                    $('#edit_jurusan').val(response.data.jurusan);
                    $('#edit_tahun_masuk').val(response.data.tahun_masuk);
                    $('#edit_tahun_lulus').val(response.data.tahun_lulus);
                    $('#edit_jenis_nilai').val(response.data.jenis_nilai).trigger('change');
                    $('#edit_sks').val(response.data.sks);
                    $('#edit_sumber_biaya').val(response.data.sumber_biaya).trigger('change');
                    $('#edit_id_person').val(response.data.id_person);
                    $('#edit_nama_person').val(response.data.nama_person);

                    // Set tanggal ke flatpickr kalau ada
                    if (edit_tahun_masuk && response.data.tahun_masuk)
                        edit_tahun_masuk.setDate(response.data.tahun_masuk, true, 'Y');
                    if (edit_tahun_lulus && response.data.tahun_lulus)
                        edit_tahun_lulus.setDate(response.data.tahun_lulus, true, 'Y');

                    console.log('🎓 Form Pendidikan berhasil diisi!');
                } else {
                    Swal.fire('Warning', response.message || 'Data pendidikan tidak ditemukan', 'warning');
                }
            })
            .catch(function(error) {
                console.error('💥 Fetch error:', error);
                ErrorHandler.handleError(error);
            });
    });

    // ✅ Reset form saat modal ditutup
    $('#form_edit_pendidikan').on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });

    // ✅ Submit handler untuk update data pendidikan
    $(document).on('submit', '#bt_submit_edit_pendidikan', function(e) {
        e.preventDefault();
        console.log('🔄 Submit edit pendidikan diklik');

        const id = $('#form_edit_pendidikan').data('current-id');
        const updateUrl = '{{ route('admin.pendidikan.update', [':id']) }}'.replace(':id', id);

        Swal.fire({
            title: 'Yakin mau update?',
            text: 'Data pendidikan akan diperbarui!',
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
                formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // ✅ CSRF
                formData.append('institusi', $('#edit_institusi').val());
                formData.append('jurusan', $('#edit_jurusan').val());
                formData.append('tahun_masuk', $('#edit_tahun_masuk').val());
                formData.append('tahun_lulus', $('#edit_tahun_lulus').val());
                formData.append('jenis_nilai', $('#edit_jenis_nilai').val());
                formData.append('sks', $('#edit_sks').val());
                formData.append('sumber_biaya', $('#edit_sumber_biaya').val());
                formData.append('id_person', $('#edit_id_person').val());

                DataManager.formData(updateUrl, formData)
                    .then(response => {
                        console.log('✅ Update response:', response);
                        if (response.success) {
                            Swal.fire('Berhasil', response.message, 'success');
                            $('#form_edit_pendidikan').modal('hide');
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
