<div class="sec_box hgi-100">
    <form action="" method="POST" enctype="multipart/form-data" id="form">
        @csrf

        <div class="sec_form">
            <div class="sec_head_form">
                <h3>{{ $title }}</h3>
                <span>Tambah {{ $title }}</span>
            </div>
            <div class="list_form">
                <span class="sec_label">IP Address</span>
                <input type="text" id="ip_address" name="ip_address" placeholder="Masukkan IP Address" required>
            </div>
        </div>
        <div class="sec_button_form">
            <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>
            <a href="#" id="cancel"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {

        $('#form').submit(function(event) {
            event.preventDefault();

            // Memeriksa apakah password dan konfirmasi password cocok
            const passwordInput = $('#password').val();
            const cpasswordInput = $('#cpassword').val();

            if (passwordInput !== cpasswordInput) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Password dan konfirmasi password tidak cocok!',
                });
            } else {
                // Jika password cocok, lanjutkan dengan mengirimkan data formulir ke server

                // Menggunakan variabel FormData untuk mengumpulkan data formulir
                var formData = new FormData(this);

                // Mengambil token CSRF dari meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Menambahkan token CSRF dalam data formData
                formData.append('_token', csrfToken);

                $.ajax({
                    url: "/allowedip/store",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(result) {
                        if (result.errors) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: result.errors
                            });
                        } else {
                            $('.alert-danger').hide();

                            // Tampilkan SweetAlert untuk sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Contactikasi berhasil dikirim!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {

                                // Lakukan perubahan halaman atau tindakan lainnya setelah contact berhasil dikirim
                                $('.aplay_code').load('/allowedip', function() {
                                    adjustElementSize();
                                    localStorage.setItem('lastPage',
                                        '/allowedip');
                                });
                            });
                        }
                    },
                    error: function(xhr) {
                        // Tampilkan SweetAlert untuk kesalahan
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat mengirim contact.'
                        });

                        console.log(xhr.responseText);
                    }
                });
            }
        });

        $(document).off('click', '#cancel').on('click', '#cancel', function(event) {
            event.preventDefault();
            var namabo = $(this).data('namabo');
            $('.aplay_code').load('/allowedip', function() {
                adjustElementSize();
                localStorage.setItem('lastPage', '/allowedip');
            });
        });
    });
</script>
