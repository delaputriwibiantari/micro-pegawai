<script defer>
    $("#form_create").on("show.bs.modal", function () {

        // === LOAD PERIODE GAJI ===
        loadPeriodeGaji();

        // === LOAD PEGAWAI AKTIF ===
        loadPegawaiAktif();


        // === SUBMIT FORM ===
        $("#bt_submit_create").on("submit", function (e) {
            e.preventDefault();

            console.log('🔍 Debug form:');
            console.log({
                periode_id: $('#periode_id').val(),
                sdm_id: $('#sdm_id').val(),
            });

            if (!$('#periode_id').val()) {
                Swal.fire("Warning", "Pilih Periode Gaji terlebih dahulu!", "warning");
                return;
            }

            if (!$('#sdm_id').val()) {
                Swal.fire("Warning", "Pilih Pegawai Aktif terlebih dahulu!", "warning");
                return;
            }

            Swal.fire({
                title: "Kamu yakin?",
                text: "Data penggajian manual akan diproses!",
                icon: "warning",
                confirmButtonColor: "#3085d6",
                showCancelButton: true,
                cancelButtonColor: "#dd3333",
                confirmButtonText: "Ya, Proses",
                cancelButtonText: "Batal",
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((result) => {
                if (result.value) {

                    DataManager.openLoading();

                    const input = {
                        periode_id: $("#periode_id").val(),
                        sdm_id: $("#sdm_id").val(),
                    };

                    const url = "{{ route('admin.gajimanual.store') }}";

                    DataManager.postData(url, input)
                        .then((response) => {
                            if (response.success) {
                                Swal.fire("Success", response.message, "success");
                                setTimeout(() => location.reload(), 800);
                            } else if (response.errors) {
                                const err = new ValidationErrorFilter();
                                err.filterValidationErrors(response);
                                Swal.fire("Warning", "Validasi bermasalah", "warning");
                            } else {
                                Swal.fire("Warning", response.message, "warning");
                            }
                        })
                        .catch((error) => ErrorHandler.handleError(error));
                }
            });
        });


    }).on("hidden.bs.modal", function () {

        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select').val('').trigger('change');
        $m.find('.is-invalid').removeClass('is-invalid');
        $m.find('.invalid-feedback').text('');

    });


    // =======================================================
    //               FUNCTION LOAD PERIODE GAJI
    // =======================================================
    function loadPeriodeGaji() {
        $('#periode_id').html('').trigger("change");

        DataManager.fetchData("{{ route('api.periode.gaji') }}")
            .then((res) => {
                let select = $("#periode_id");
                select.append(`<option value="">Pilih Periode</option>`);

                res.data.forEach((item) => {
                    select.append(`
                        <option value="${item.id}">
                            ${item.nama_periode} (${item.tanggal_mulai} - ${item.tanggal_selesai})
                        </option>
                    `);
                });

                select.trigger("change");
            })
            .catch((err) => ErrorHandler.handleError(err));
    }


    // =======================================================
    //               FUNCTION LOAD PEGAWAI AKTIF
    // =======================================================
    function loadPegawaiAktif() {
        $('#sdm_id').html('').trigger("change");

        DataManager.fetchData("{{ route('api.ref.sdm') }}")
            .then((res) => {
                let select = $("#sdm_id");
                select.append(`<option value="">Pilih Pegawai</option>`);

                res.data.forEach((item) => {
                    select.append(`
                        <option value="${item.id}">
                            ${item.nama_lengkap} (${item.nip ?? '-'})
                        </option>
                    `);
                });

                select.trigger("change");
            })
            .catch((err) => ErrorHandler.handleError(err));
    }

</script>
