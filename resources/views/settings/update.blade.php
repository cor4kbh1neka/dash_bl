<div class="sec_box hgi-100">
    <form action="" method="POST" enctype="multipart/form-data" id="form">
        @csrf
        @foreach ($data['data'] as $index => $item)
            <div class="sec_form">
                <div class="sec_head_form">
                    <h3>{{ $title }}</h3>
                    <span>Update {{ $title }}</span>
                </div>
                <div class="list_form">
                    <span class="sec_label">Version</span>
                    <input type="text" id="version" name="version" required placeholder="Masukkan Version"
                        value="{{ $item['version'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Home</span>
                    <input type="text" id="home" name="home" required placeholder="Masukkan Home"
                        value="{{ $item['home'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Deposit</span>
                    <input type="text" id="deposit" name="deposit" required placeholder="Masukkan Deposit"
                        value="{{ $item['deposit'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Server 1</span>
                    <input type="text" id="server1" name="server1" required placeholder="Masukkan Server 1"
                        value="{{ $item['server1'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Server 2</span>
                    <input type="text" id="server2" name="server2" required placeholder="Masukkan Server 2"
                        value="{{ $item['server2'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Server 3</span>
                    <input type="text" id="server3" name="server3" required placeholder="Masukkan Server 3"
                        value="{{ $item['server3'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Update</span>
                    <input type="text" id="update" name="update" required placeholder="Masukkan Update"
                        value="{{ $item['update'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Peraturan</span>
                    <input type="text" id="peraturan" name="peraturan" required placeholder="Masukkan Peraturan"
                        value="{{ $item['peraturan'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Klasemen</span>
                    <input type="text" id="klasemen" name="klasemen" required placeholder="Masukkan Klasemen"
                        value="{{ $item['klasemen'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Promosi</span>
                    <input type="text" id="promosi" name="promosi" required placeholder="Masukkan Promosi"
                        value="{{ $item['promosi'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">LiveScore</span>
                    <input type="text" id="livescore" name="livescore" required placeholder="Masukkan LiveScore"
                        value="{{ $item['livescore'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">LiveChat</span>
                    <input type="text" id="livescore" name="livescore" required placeholder="Masukkan LiveChat"
                        value="{{ $item['livescore'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Whatsapp 1</span>
                    <input type="text" id="whatsapp1" name="whatsapp1" required placeholder="Masukkan Whatsapp 1"
                        value="{{ $item['whatsapp1'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Whatsapp 2</span>
                    <input type="text" id="whatsapp2" name="whatsapp2" required placeholder="Masukkan Whatsapp 2"
                        value="{{ $item['whatsapp2'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Facebook</span>
                    <input type="text" id="facebook" name="facebook" required placeholder="Masukkan Facebook"
                        value="{{ $item['facebook'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Instagram</span>
                    <input type="text" id="instagram" name="instagram" required placeholder="Masukkan Instagram"
                        value="{{ $item['instagram'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Telegram</span>
                    <input type="text" id="telegram" name="telegram" required placeholder="Masukkan Telegram"
                        value="{{ $item['telegram'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Prediksi</span>
                    <input type="text" id="prediksi" name="prediksi" required placeholder="Masukkan Prediksi"
                        value="{{ $item['prediksi'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Id Event</span>
                    <input type="text" id="idevent" name="idevent" required placeholder="Masukkan Id Event"
                        value="{{ $item['idevent'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Icon Gif</span>
                    <input type="text" id="icongif" name="icongif" required placeholder="Masukkan Icon Gif"
                        value="{{ $item['icongif'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Posisi</span>
                    <input type="number" id="posisi" name="posisi" min=1 required placeholder="Masukkan Posisi"
                        value="{{ $item['posisi'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Switchs</span>
                    <div class="sec_togle">
                        <input type="checkbox" id="switchs" name="switchs"
                            {{ $item['switchs'] == 1 ? 'checked' : '' }}>
                        <label for="switchs" class="sec_switch"></label>
                    </div>
                </div>

                <div class="list_form">
                    <span class="sec_label">Banner URL</span>
                    <input type="text" id="bannerurl" name="bannerurl" required placeholder="Masukkan Banner URL"
                        value="{{ $item['bannerurl'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Link Event</span>
                    <input type="text" id="linkevent" name="linkevent" required placeholder="Masukkan Link Event"
                        value="{{ $item['linkevent'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Title</span>
                    <input type="text" id="title" name="title" required placeholder="Masukkan Title"
                        value="{{ $item['title'] }}">
                </div>
                <div class="list_form">
                    <span class="sec_label">Content</span>
                    <input type="text" id="content" name="content" required placeholder="Masukkan Content"
                        value="{{ $item['content'] }}">
                </div>
            </div>
        @endforeach
        <div class="sec_button_form">
            <button class="sec_botton btn_submit" type="submit" id="Contactsubmit">Submit</button>

        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#warna').on('change', function() {
            var selectedValue = $(this).val();
            changeWarna(selectedValue);
        });

        function changeWarna(warna) {
            $('h3.headtitle').removeClass().addClass(warna + ' headtitle');
        }
    });
    $(document).ready(function() {
        $('#form').submit(function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            $('input[type="checkbox"]', this).each(function() {
                var isChecked = $(this).is(':checked') ? 1 : 0;
                formData.append($(this).attr('name'), isChecked);
            });

            $.ajax({
                url: "/settings/update",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result.errors) {
                        $('.alert-danger').html('');

                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<li>' + value + '</li>');
                        });
                    } else {
                        $('.alert-danger').hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Contactikasi berhasil dikirim!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            $('.aplay_code').load('/settings',
                                function() {
                                    adjustElementSize();
                                    localStorage.setItem('lastPage',
                                        '/settings');
                                });
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengirim contact.'
                    });

                    console.log(xhr.responseText);
                }
            });
        });

        $(document).off('click', '#cancel').on('click', '#cancel', function(event) {
            event.preventDefault();
            var namabo = $(this).data('namabo');
            $('.aplay_code').load('/settings', function() {
                adjustElementSize();
                localStorage.setItem('lastPage', '/settings');
            });
        });
    });
</script>
