<script defer>
    $('#form_create').on('show.bs.modal', function (e) {
        loadPegawaiAktif();
        $('#tanggal_mulai').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
            onChange: hitungTotalHari
        });

        $('#tanggal_selesai').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
            onChange: hitungTotalHari
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

                    formData.append('jenis_cuti', $('#jenis_cuti').val());
                    formData.append('total_hari', $('#total_hari').val());
                    formData.append('sdm_id', $('#sdm_id').val());
                    formData.append('keterangan', $('#keterangan').val());
                    formData.append('tanggal_mulai', $('#tanggal_mulai').val());
                    formData.append('tanggal_selesai', $('#tanggal_selesai').val());
                    formData.append('status', $('#status').val());

                    const action = "{{ route('admin.absensi.cuti.store') }}";
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

    function hitungTotalHari() {
        const mulai = $('#tanggal_mulai').val();
        const selesai = $('#tanggal_selesai').val();

        if (!mulai || !selesai) {
            $('#total_hari').val('');
            return;
        }

        const start = new Date(mulai);
        const end = new Date(selesai);

        if (end < start) {
            $('#total_hari').val('');
            Swal.fire('Peringatan', 'Tanggal selesai tidak boleh sebelum tanggal mulai', 'warning');
            return;
        }

        const diffTime = end.getTime() - start.getTime();
        const totalHari = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

        $('#total_hari').val(totalHari);
    }
</script>
