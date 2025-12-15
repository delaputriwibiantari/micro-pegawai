<script defer>
    $('#form_create').on('show.bs.modal', function () {

        loadNamaPegawai();

        $('#bt_submit_create').on('submit', function (e) {
            e.preventDefault();

            if (!$('#sdm_id').val()) {
                Swal.fire("Warning", "Pilih Nama Pegawai terlebih dahulu!", "warning");
                return;
            }

            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Apakah datanya benar dan sesuai?',
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

                    const input = {
                        izin_id: $('#izin_id').val(),
                        sdm_id: $('#sdm_id').val(),
                        jenis_izin: $('#jenis_izin').val(),
                        keterangan: $('#keterangan').val(),
                        tanggal: $('#tanggal').val(),
                        jam_mulai: $('#jam_mulai').val(),
                        jam_selesai: $('#jam_selesai').val(),
                    };

                    const action = '{{ route('admin.absensi.izin.store') }}';

                    DataManager.postData(action, input)
                        .then(response => {
                            if (response.success) {
                                Swal.fire('Success', response.message, 'success');
                                setTimeout(() => location.reload(), 1000);
                            }

                            if (!response.success && response.errors) {
                                const validationErrorFilter = new ValidationErrorFilter();
                                validationErrorFilter.filterValidationErrors(response);
                                Swal.fire('Warning', 'Isian belum lengkap atau tidak valid.', 'warning');
                            }

                            if (!response.success && !response.errors) {
                                Swal.fire('Peringatan', response.message, 'warning');
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

    function loadNamaPegawai() {
        $('#sdm_id').html('').trigger("change");

        DataManager.fetchData("{{ route('api.ref.sdm') }}")
            .then((res) => {
                let select = $("#sdm_id");
                select.append(`<option value="">Pilih Pegawai</option>`);

                res.data.forEach((item) => {
                    select.append(`
                        <option value="${item.id}">
                            ${item.nama_lengkap}
                        </option>
                    `);
                });

                select.trigger("change");
            })
            .catch((err) => ErrorHandler.handleError(err));
    }
</script>
