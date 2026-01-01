<script>
$(document).ready(function () {

    // =====================================================
    // MODAL OPEN
    // =====================================================
    $('#form_create').on('shown.bs.modal', function () {
        loadPeriodeGaji();
        loadPegawaiAktif();
    });

    // =====================================================
    // SUBMIT FORM
    // =====================================================
    $('#bt_submit_create').on('submit', function (e) {
        e.preventDefault();

        const periode_id = $('#periode_id').val();
        const sdm_id     = $('#sdm_id').val();

        // Reset error
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');

        // Validasi frontend
        if (!periode_id) {
            $('#periode_id')
                .addClass('is-invalid')
                .next('.invalid-feedback')
                .text('Periode gaji wajib dipilih');
            return;
        }

        if (!sdm_id) {
            $('#sdm_id')
                .addClass('is-invalid')
                .next('.invalid-feedback')
                .text('Pegawai wajib dipilih');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Penggajian manual akan diproses',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Proses',
            cancelButtonText: 'Batal',
            allowOutsideClick: false
        }).then((result) => {
            if (!result.isConfirmed) return;

            const btnSubmit = $('#bt_submit_create button[type="submit"]');
            btnSubmit
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm"></span> Processing...');

            $.ajax({
                url: "{{ route('admin.payroll.store') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    periode_id: periode_id,
                    sdm_id: sdm_id
                },
                success: function (res) {
                    if (res.success) {
                        Swal.fire('Success', res.message, 'success');
                        $('#form_create').modal('hide');
                        setTimeout(() => location.reload(), 1200);
                    } else {
                        Swal.fire('Warning', res.message || 'Proses gagal', 'warning');
                    }
                },
                error: function (xhr) {
                    let message = 'Terjadi kesalahan server';

                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            $('#' + field)
                                .addClass('is-invalid')
                                .next('.invalid-feedback')
                                .text(errors[field][0]);
                        }
                        message = 'Validasi gagal';
                    } else if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire('Error', message, 'error');
                },
                complete: function () {
                    btnSubmit.prop('disabled', false).html('Proses');
                }
            });
        });
    });

    // =====================================================
    // MODAL CLOSE RESET
    // =====================================================
    $('#form_create').on('hidden.bs.modal', function () {
        const modal = $(this);

        modal.find('form')[0].reset();
        modal.find('select').val(null).trigger('change');
        modal.find('.is-invalid').removeClass('is-invalid');
        modal.find('.invalid-feedback').text('');
    });

    // =====================================================
    // LOAD PERIODE GAJI
    // =====================================================
    function loadPeriodeGaji() {
        $.ajax({
            url: "{{ route('api.gaji.gajiperiode') }}",
            method: 'GET',
            dataType: 'json',
            success: function (res) {
                const select = $('#periode_id');

                select.empty().append('<option></option>');

                if (res.data) {
                    res.data.forEach(item => {
                        select.append(`
                            <option value="${item.id}">
                                ${item.tanggal_mulai} - ${item.tanggal_selesai}
                            </option>
                        `);
                    });
                }

                select.select2({
                    dropdownParent: $('#form_create'),
                    placeholder: 'Pilih Periode Gaji',
                    allowClear: true
                });
            }
        });
    }

    // =====================================================
    // LOAD PEGAWAI AKTIF
    // =====================================================
    function loadPegawaiAktif() {
        $.ajax({
            url: "{{ route('api.ref.sdm') }}",
            method: 'GET',
            dataType: 'json',
            success: function (res) {
                const select = $('#sdm_id');

                select.empty().append('<option></option>');

                if (res.data) {
                    res.data.forEach(item => {
                        select.append(`
                            <option value="${item.id}">
                                ${item.nama_lengkap}
                            </option>
                        `);
                    });
                }

                select.select2({
                    dropdownParent: $('#form_create'),
                    placeholder: 'Pilih Pegawai Aktif',
                    allowClear: true
                });
            }
        });
    }

});
</script>
