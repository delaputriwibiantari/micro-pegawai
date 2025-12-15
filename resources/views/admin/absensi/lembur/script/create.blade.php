<script defer>
    $('#form_create').on('show.bs.modal', function (e) {
        loadPegawaiAktif();

        $('#tanggal').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
            onChange: hitungTotalJam
        });

        $('#jam_mulai, #jam_selesai')
        .off('change keyup')
        .on('change keyup', hitungTotalJam);

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
                    formData.append('tanggal', $('#tanggal').val());
                    formData.append('sdm_id', $('#sdm_id').val());
                    formData.append('jam_mulai', $('#jam_mulai').val());
                    formData.append('jam_selesai', $('#jam_selesai').val());
                    formData.append('durasi_jam', $('#durasi_jam').val());
                    formData.append('status', $('#status').val());
                    hitungTotalJam();

                    const action = "{{ route('admin.absensi.lembur.store') }}";
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

    function loadPegawaiAktif() {
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

    function hitungTotalJam() {
        const mulai = $('#jam_mulai').val();
        const selesai = $('#jam_selesai').val();

        if (!mulai || !selesai) {
            $('#durasi_jam').val('');
            return;
        }

        const start = new Date(`1970-01-01T${mulai}:00`);
        const end   = new Date(`1970-01-01T${selesai}:00`);

        if (end < start) {
            $('#durasi_jam').val('');
            Swal.fire('Peringatan', 'Jam selesai tidak boleh sebelum jam mulai', 'warning');
            return;
        }

        const diffMs = end - start;
        const diffJam = (diffMs / (1000 * 60 * 60)).toFixed(2);

        $('#durasi_jam').val(diffJam);
    }

</script>
