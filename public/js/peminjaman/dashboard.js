$(document).ready(function () {
    Swal.fire({
        icon: 'warning',
        title: 'Mohon Perhatian!',
        text: 'Bon mobil hanya boleh dilakukan satu hari sebelum tanggal pinjam atau pada tanggal tersebut',
        // timer: 4000,
        showCancelButton: false,
        showConfirmButton: true,
        allowOutsideClick: false
    });
});