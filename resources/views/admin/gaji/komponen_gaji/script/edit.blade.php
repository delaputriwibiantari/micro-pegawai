<script defer>
    // Event ketika modal edit ditampilkan
    $('#form_edit').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.gaji.komponen_gaji.show', [':id']) }}';

        // Simpan ID di data attribute modal
        $(this).data('id', id);

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    const data = response.data;

                    // Isi form dengan data
                    $('#edit_komponen_id').val(data.komponen_id);
                    $('#edit_nama_komponen').val(data.nama_komponen);
                    $('#edit_jenis').val(data.jenis).trigger('change');
                    $('#edit_deskripsi').val(data.deskripsi);

                    // Handle checkbox is_umum
                    if (data.is_umum == 1 || data.is_umum === true) {
                        $('#edit_is_umum').prop('checked', true);
                    } else {
                        $('#edit_is_umum').prop('checked', false);
                    }

                    // TAMBAH: Isi aturan_nominal
                    if (data.aturan_nominal) {
                        $('#edit_aturan_nominal').val(data.aturan_nominal).trigger('change');
                    } else {
                        // Fallback: jika tidak ada aturan_nominal, tentukan dari is_umum
                        const aturan = (data.is_umum == 1 || data.is_umum === true) ? 'gaji_umum' : 'manual';
                        $('#edit_aturan_nominal').val(aturan).trigger('change');
                    }

                    // TAMBAH: Isi referensi_id berdasarkan aturan_nominal
                    if (data.aturan_nominal === 'gaji_umum' && data.referensi_id) {
                        // Load data gaji umum lalu set nilai
                        fetchDataDropdown(
                            '{{ route('api.gaji.gajiumum') }}',
                            '#edit_referensi_id',
                            'umum_id',
                            'nominal',
                            function() {
                                if (data.referensi_id) {
                                    $('#edit_referensi_id').val(data.referensi_id).trigger('change');
                                }
                            }
                        );
                    } else if (data.aturan_nominal === 'tarif_potongan' && data.referensi_id) {
                        // Load data tarif potongan lalu set nilai
                        fetchDataDropdown(
                            '{{ route('api.gaji.tarifpotongan') }}',
                            '#edit_referensi_id',
                            'potongan_id',
                            'nama_potongan',
                            function() {
                                if (data.referensi_id) {
                                    $('#edit_referensi_id').val(data.referensi_id).trigger('change');
                                }
                            }
                        );
                    } else {
                        // Untuk manual atau belum ada referensi
                        $('#edit_referensi_id').empty().trigger('change');
                    }

                    // OPSIONAL: Untuk backward compatibility, handle umum_id jika masih ada
                    if (data.umum_id) {
                        // Jika data lama masih pakai umum_id, set sebagai referensi_id untuk gaji_umum
                        if (!data.referensi_id && (data.is_umum || data.aturan_nominal === 'gaji_umum')) {
                            fetchDataDropdown(
                                '{{ route('api.gaji.gajiumum') }}',
                                '#edit_referensi_id',
                                'umum_id',
                                'nominal',
                                function() {
                                    $('#edit_referensi_id').val(data.umum_id).trigger('change');
                                }
                            );
                        }
                    }

                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
                ErrorHandler.handleError(error);
            });
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
        // Reset checkbox
        $('#edit_is_umum').prop('checked', false);
        // Reset select2 untuk field baru
        $('#edit_aturan_nominal').val(null).trigger('change');
        $('#edit_referensi_id').val(null).trigger('change').prop('disabled', true);
        // Hapus data ID
        $(this).removeData('id');
    });

    // TAMBAH: Event handler untuk aturan_nominal di form edit
    $('#edit_aturan_nominal').on('change', function() {
        const aturan = $(this).val();
        const $referensiField = $('#edit_referensi_id');

        // Reset dan enable/disable referensi field
        $referensiField.val(null).trigger('change');
        $referensiField.prop('disabled', !aturan);

        if (aturan === 'gaji_umum') {
            // Load data gaji umum
            fetchDataDropdown('{{ route('api.gaji.gajiumum') }}', '#edit_referensi_id', 'umum_id', 'nominal');
            $referensiField.prop('disabled', false);
            // Otomatis centang is_umum
            $('#edit_is_umum').prop('checked', true);
        } else if (aturan === 'tarif_potongan') {
            // Load data tarif potongan
            fetchDataDropdown('{{ route('api.gaji.tarifpotongan') }}', '#edit_referensi_id', 'potongan_id', 'nama_potongan');
            $referensiField.prop('disabled', false);
            // Otomatis uncheck is_umum
            $('#edit_is_umum').prop('checked', false);
        } else if (aturan === 'manual' || aturan === '') {
            // Kosongkan referensi_id
            $referensiField.empty().prop('disabled', true);
            $('#edit_is_umum').prop('checked', false);
        }

        // Re-initialize Select2 untuk update tampilan
        $referensiField.select2();
    });

    // TAMBAH: Event handler untuk is_umum checkbox di form edit
    $('#edit_is_umum').on('change', function() {
        if ($(this).is(':checked')) {
            // Jika dicentang, set aturan nominal ke gaji_umum
            $('#edit_aturan_nominal').val('gaji_umum').trigger('change');
        } else {
            // Jika tidak dicentang, set ke manual (jika belum dipilih)
            if (!$('#edit_aturan_nominal').val()) {
                $('#edit_aturan_nominal').val('manual').trigger('change');
            }
        }
    });

    // Event submit untuk form edit
    $('#bt_submit_edit').on('submit', function (e) {
        e.preventDefault();

        // Ambil ID dari modal
        const id = $('#form_edit').data('id');
        if (!id) {
            Swal.fire('Error', 'Data ID tidak ditemukan', 'error');
            return;
        }

        // TAMBAH: Ambil nilai aturan_nominal dan referensi_id
        const rawAturan = $('#edit_aturan_nominal').val();
        const aturan_nominal = (rawAturan && rawAturan !== 'undefined' && rawAturan !== '') ? rawAturan : null;

        const rawReferensi = $('#edit_referensi_id').val();
        const referensi_id = (rawReferensi && rawReferensi !== 'undefined' && rawReferensi !== '') ? rawReferensi : null;

        const input = {
            komponen_id: $('#edit_komponen_id').val(),
            nama_komponen: $('#edit_nama_komponen').val(),
            jenis: $('#edit_jenis').val(),
            deskripsi: $('#edit_deskripsi').val(),
            is_umum: $('#edit_is_umum').is(':checked') ? 1 : 0,
            // HAPUS: umum_id dari input
            // umum_id: umum_id,
            // TAMBAH: 2 field baru
            aturan_nominal: aturan_nominal,
            referensi_id: referensi_id
        };

        console.log('Data yang akan diupdate:', input);

        Swal.fire({
            title: 'Kamu yakin?',
            text: 'Apakah datanya benar dan apa yang anda inginkan?',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            cancelButtonColor: '#dd3333',
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal',
            focusCancel: true
        }).then((result) => {
            if (result.value) {
                DataManager.openLoading();
                const update = '{{ route('admin.gaji.komponen_gaji.update', [':id']) }}';
                DataManager.putData(update.replace(':id', id), input).then(response => {
                    if (response.success) {
                        Swal.fire('Success', response.message, 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    if (!response.success && response.errors) {
                        const validationErrorFilter = new ValidationErrorFilter('edit_');
                        validationErrorFilter.filterValidationErrors(response);
                        Swal.fire('Peringatan', 'Isian Anda belum lengkap atau tidak valid.', 'warning');
                    }
                    if (!response.success && !response.errors) {
                        Swal.fire('Warning', response.message, 'warning');
                    }
                }).catch(error => {
                    ErrorHandler.handleError(error);
                });
            }
        });
    });

    // TAMBAH: Helper function untuk load dropdown dengan callback
    function fetchDataDropdown(url, targetElement, valueField, textField, callback) {
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

                    // Panggil callback setelah select2 diinisialisasi
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            },
            error: function(error) {
                console.error('Error fetching dropdown data:', error);
                $(targetElement).empty().append('<option value="">Error loading data</option>').select2();
                if (typeof callback === 'function') {
                    callback();
                }
            }
        });
    }
</script>
