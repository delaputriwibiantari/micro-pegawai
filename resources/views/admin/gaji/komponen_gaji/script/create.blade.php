<script defer>
    $('#form_create').on('show.bs.modal', function (e) {
        fetchDataDropdown('{{ route('api.gaji.gajiumum') }}', '#umum_id', 'id', 'nominal');

        // TAMBAH: Initialize Select2 untuk aturan_nominal
        $('#aturan_nominal').select2({
            placeholder: "Pilih Aturan Nominal",
            allowClear: true,
            width: '100%'
        });

        // TAMBAH: Initialize Select2 untuk referensi_id
        $('#referensi_id').select2({
            placeholder: "Pilih Referensi",
            allowClear: true,
            width: '100%'
        });

        // TAMBAH: Event handler untuk aturan nominal
        $('#aturan_nominal').on('change', function() {
            const aturan = $(this).val();
            const $referensiField = $('#referensi_id');

            // Reset dan enable/disable referensi field
            $referensiField.val(null).trigger('change');
            $referensiField.prop('disabled', !aturan);

            if (aturan === 'gaji_umum') {
                // Load data gaji umum
                fetchDataDropdown('{{ route('api.gaji.gajiumum') }}', '#referensi_id', 'umum_id', 'nominal');
                $referensiField.prop('disabled', false);
                // Update placeholder
                $referensiField.data('select2').$container.find('.select2-selection__placeholder').text('Pilih Gaji Umum');
                // Otomatis centang is_umum
                $('#is_umum').prop('checked', true);
                // Sinkronkan umum_id dengan referensi_id jika perlu
                $referensiField.on('change', function() {
                    $('#umum_id').val($(this).val());
                });
            } else if (aturan === 'tarif_potongan') {
                // Load data tarif potongan
                fetchDataDropdown('{{ route('api.gaji.tarifpotongan') }}', '#referensi_id', 'potongan_id', 'nama_potongan');
                $referensiField.prop('disabled', false);
                // Update placeholder
                $referensiField.data('select2').$container.find('.select2-selection__placeholder').text('Pilih Tarif Potongan');
                // Otomatis uncheck is_umum
                $('#is_umum').prop('checked', false);
            } else if (aturan === 'tarif_lembur') {
                // Load data tarif lembur
                fetchDataDropdown('{{ route('api.gaji.tariflembur') }}', '#referensi_id', 'tarif_id','tarif_per_jam');
                $referensiField.prop('disabled', false);
                // Update placeholder
                $referensiField.data('select2').$container.find('.select2-selection__placeholder').text('Pilih Tarif Lembur');
                // Otomatis uncheck is_umum
                $('#is_umum').prop('checked', false);
            } else if (aturan === 'manual' || aturan === '') {
                // Kosongkan referensi_id
                $referensiField.empty().prop('disabled', true);
                $referensiField.data('select2').$container.find('.select2-selection__placeholder').text('Pilih Referensi');
            }

            // Re-initialize Select2 untuk update tampilan
            $referensiField.select2();
        });

        // TAMBAH: Event handler untuk is_umum checkbox
        $('#is_umum').on('change', function() {
            if ($(this).is(':checked')) {
                // Jika dicentang, set aturan nominal ke gaji_umum
                $('#aturan_nominal').val('gaji_umum').trigger('change');
            } else {
                // Jika tidak dicentang, set ke manual (jika belum dipilih)
                if (!$('#aturan_nominal').val()) {
                    $('#aturan_nominal').val('manual').trigger('change');
                }
            }
        });

        $('#bt_submit_create').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Apakah datanya benar dan apa yang anda inginkan?',
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
                    const rawUmum = $('#umum_id').val();
                    const umum_id = (rawUmum && rawUmum !== 'undefined' && rawUmum !== '') ? rawUmum : null;

                    // TAMBAH: Ambil nilai aturan_nominal dan referensi_id
                    const rawAturan = $('#aturan_nominal').val();
                    const aturan_nominal = (rawAturan && rawAturan !== 'undefined' && rawAturan !== '') ? rawAturan : null;

                    const rawReferensi = $('#referensi_id').val();
                    const referensi_id = (rawReferensi && rawReferensi !== 'undefined' && rawReferensi !== '') ? rawReferensi : null;

                    const input = {
                        komponen_id: $('#komponen_id').val(),
                        nama_komponen: $('#nama_komponen').val(),
                        jenis: $('#jenis').val(),
                        deskripsi: $('#deskripsi').val(),
                        is_umum: $('#is_umum').is(':checked') ? 1 : 0,
                        umum_id,
                        // TAMBAH: 2 field baru
                        aturan_nominal: aturan_nominal,
                        referensi_id: referensi_id
                    };

                    console.log('Data yang akan dikirim:', input);
                    const action = '{{ route('admin.gaji.komponen_gaji.store') }}';
                    DataManager.postData(action, input).then(response => {
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
            });
        });
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();

        // TAMBAH: Reset Select2 untuk field baru
        $('#aturan_nominal').val(null).trigger('change');
        $('#referensi_id').val(null).prop('disabled', true).trigger('change');
    });

    // TAMBAH: Helper function untuk load dropdown
    function fetchDataDropdown(url, targetElement, valueField, textField) {
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if (response.success && response.data) {
                    const $select = $(targetElement);
                    $select.empty();
                    $select.append('<option value="">Pilih</option>');

                    response.data.forEach(item => {
                        const value = item[valueField] || item.id || item.value;
                        const text = item[textField] || item.label || item.nama || item.nominal;
                        $select.append(`<option value="${value}">${text}</option>`);
                    });

                    $select.select2();
                }
            },
            error: function(error) {
                console.error('Error fetching dropdown data:', error);
                $(targetElement).empty().append('<option value="">Error loading data</option>');
            }
        });
    }
</script>
