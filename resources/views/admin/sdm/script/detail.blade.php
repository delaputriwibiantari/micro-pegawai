<script defer>
document.addEventListener('DOMContentLoaded', function() {
    // ===============================
    // SAAT KLIK TOMBOL DETAIL
    // ===============================
    document.addEventListener('click', function(e) {
        const button = e.target.closest('.detail-button');
        if (button) {
            const id = button.getAttribute('data-id');

            // Simpan id ke localStorage agar bisa diambil di halaman detail
            localStorage.setItem('selected_sdm_id', id);

            // Redirect ke halaman show dengan ID
            window.location.href = `/admin/sdm/show/${id}`;
        }
    });

    // ===============================
    // SAAT HALAMAN DETAIL DILOAD
    // ===============================
    const savedId = localStorage.getItem('selected_sdm_id');
    if (savedId) {
        const idInput = document.getElementById('id_sdm');
        if (idInput) {
            idInput.value = savedId;
            console.log('ID SDM di-set:', savedId);
        }
    }

    // ===============================
    // SAAT TOMBOL TAMBAH PENDIDIKAN DIKLIK
    // ===============================
    const modalTrigger = document.querySelector('[data-bs-target="#form_create_pendidikan"]');
    if (modalTrigger) {
        modalTrigger.addEventListener('click', function() {
            const currentId = localStorage.getItem('selected_sdm_id');
            const idInput = document.getElementById('id_sdm');
            if (idInput && currentId) {
                idInput.value = currentId;
                console.log('ID SDM dikirim ke form pendidikan:', currentId);
            }
        });
    }
});
</script>
