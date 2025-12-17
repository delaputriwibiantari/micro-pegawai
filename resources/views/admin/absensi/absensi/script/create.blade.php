<script defer>
    let jadwalKerja = null;
    $('#form_create').on('show.bs.modal', function (e) {

        loadPegawaiAktif();

        fetchDataDropdown('{{ route('api.ref.jadwalkerja') }}', '#jadwal_id', 'id', 'nama_jadwal');
        $('#tanggal').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
        });


        $('#bt_submit_create').off('submit').on('submit', function (e) {
            e.preventDefault();
            if (!validateWaktuAbsensi()) {
                return; // Berhenti jika validasi gagal
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

                    formData.append('jadwal_id', $('#jadwal_id').val());
                    formData.append('sdm_id', $('#sdm_id').val());
                    formData.append('waktu_mulai', $('#waktu_mulai').val());
                    formData.append('waktu_selesai', $('#waktu_selesai').val());
                    const action = "{{ route('admin.absensi.absensi.store') }}";
                    DataManager.formData(action, formData).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (!response.success && response.errors) {

                            // Ambil pesan error pertama
                            let message = 'Validasi bermasalah';

                            if (response.errors.jadwal_id) {
                                message = response.errors.jadwal_id[0];
                            }

                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: message,
                                allowOutsideClick: false
                            });

                            // optional: tetap tandai field invalid
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
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

    function validateWaktuAbsensi() {
        if (!jadwalKerja) return true;

        const waktuMulai = $('#waktu_mulai').val();
        const waktuSelesai = $('#waktu_selesai').val();

        const mulai = timeToMinutes(waktuMulai);
        const jamMasuk = timeToMinutes(jadwalKerja.jam_masuk);
        const batasMasuk = timeToMinutes(jadwalKerja.jam_batas_masuk);
        const jamPulang = timeToMinutes(jadwalKerja.jam_pulang);
        const batasPulang = timeToMinutes(jadwalKerja.jam_batas_pulang);

        // 1. Belum jam kerja
        if (mulai < jamMasuk) {
            Swal.fire('Peringatan', 'Belum memasuki jam kerja', 'warning');
            return false;
        }

        // 2. Absensi sudah berakhir
        if (mulai > batasPulang) {
            Swal.fire('Peringatan', 'Waktu absensi sudah berakhir', 'warning');
            return false;
        }

        // 3. Validasi jam pulang (jika ada)
        if (waktuSelesai) {
            const selesai = timeToMinutes(waktuSelesai);
            if (selesai < jamPulang) {
                Swal.fire('Peringatan', 'Belum memasuki jam pulang', 'warning');
                return false;
            }
        }

        return true;
    }


</script>
