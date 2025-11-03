<!-- resources/views/admin/sdm/script/detail.blade.php -->
<script>
    function loadPersonDetail(personId) {
        $.ajax({
            url: `/admin/person/${personId}`, // ganti sesuai route-mu
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;

                    // isi elemen di view detail.blade.php
                    $('#nama_person').text(data.nama_lengkap || '-');
                    $('#nik_person').text('NIK: ' + (data.nik || '-'));
                    $('#nip_person').text('NIP: ' + (data.nip || '-'));
                    $('#alamat_person').text(data.alamat || '-');

                    if (data.foto) {
                        $('#foto_person').attr('src', `/storage/${data.foto}`);
                    } else {
                        $('#foto_person').attr('src', `{{ asset('assets/img/default-user.png') }}`);
                    }
                } else {
                    Swal.fire('Gagal', 'Data person tidak ditemukan!', 'warning');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching person data:', error);
                Swal.fire('Error', 'Terjadi kesalahan mengambil data person', 'error');
            }
        });
    }

    // Contoh pemanggilan otomatis (misal ID person dikirim dari halaman SDM)
    $(document).ready(function() {
        const personId = "{{ $person_id ?? '' }}"; // pastikan variabel ini dikirim dari controller
        if (personId) {
            loadPersonDetail(personId);
        }
    });
</script>
