@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor" d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secmemods">
            <div class="groupsecmemods">
                <div class="headgroupsecmemods">
                    <a href="/memods" class="tombol grey active">
                        <span class="texttombol">create</span>
                    </a>
                    <a href="/memods/delivered" class="tombol grey">
                        <span class="texttombol">delivered</span>
                    </a>
                    <a href="/memods/viewinbox" class="tombol grey">
                        <span class="texttombol">inbox</span>
                        <span class="unreadmessage">2</span>
                    </a>
                    <a href="/memods/archiveinbox" class="tombol grey">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 6h10M7 9h10m-8 8h6" />
                                <path d="M3 12h-.4a.6.6 0 0 0-.6.6v8.8a.6.6 0 0 0 .6.6h18.8a.6.6 0 0 0 .6-.6v-8.8a.6.6 0 0 0-.6-.6H21M3 12V2.6a.6.6 0 0 1 .6-.6h16.8a.6.6 0 0 1 .6.6V12M3 12h18" />
                            </g>
                        </svg>
                        <span class="texttombol">archive</span>
                    </a>
                </div>
                <div class="groupdatamemo">
                    <div class="groupplayerinfo">
                        <div class="listgroupplayerinfo left">
                            <div class="listplayerinfo">
                                <span class="labelbetpl">to user</span>
                                <div class="groupradiooption">
                                    <div class="listgrpstatusbank">
                                        <input class="status_primary" type="radio" id="allplayer" name="memoplayer" value="1">
                                        <label for="allplayer">all player</label>
                                    </div>
                                    <div class="listgrpstatusbank">
                                        <input class="status_primary" type="radio" id="oneplayer" name="memoplayer" value="2">
                                        <label for="oneplayer">to user</label>
                                    </div>
                                </div>
                            </div>
                            <div class="listplayerinfo xusername">
                                <label for="username">username</label>
                                <div class="groupeditinput">
                                    <input type="text" id="username" name="username" value="" placeholder="isi username user">
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="pengirim">pengirim</label>
                                <div class="groupeditinput">
                                    <input type="text" id="pengirim" name="pengirim" value="" placeholder="isi admin pengirim">
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="subject">subject</label>
                                <div class="groupeditinput">
                                    <input type="text" id="subject" name="subject" value="" placeholder="isi subject">
                                </div>
                            </div>
                            <div class="listplayerinfo">
                                <label for="textmemo">memo</label>
                                <div class="groupeditinput">
                                    <textarea name="textmemo" id="textmemo" cols="30" rows="10" placeholder="isi keterangan memo"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="listgroupplayerinfo right solo">
                            <button class="tombol primary">
                                <span class="texttombol">SEND</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#myCheckbox').change(function() {
                var isChecked = $(this).is(':checked');

                $('tbody tr:not([style="display: none;"]) [id^="myCheckbox-"]').prop('checked', isChecked);
            });
        });

        $(document).ready(function() {
            $('#myCheckbox, [id^="myCheckbox-"]').change(function() {
                var isChecked = $('#myCheckbox:checked, [id^="myCheckbox-"]:checked').length > 0;
                if (isChecked) {
                    $('.all_act_butt').css('display', 'flex');
                } else {
                    $('.all_act_butt').hide();
                }
            });

        });

        // clear readonly
        $(document).ready(function() {
            $('.groupeditinput svg').click(function() {
                $(this).closest('.groupeditinput').toggleClass('edit');
                $(this).siblings('input').prop('readonly', function(_, val) {
                    return !val;
                });
            });
        });

        //show username for option to user
        $(document).ready(function(){
            // Menggunakan event change untuk menangani perubahan pada radio button
            $('input[name="memoplayer"]').change(function(){
                // Memeriksa apakah radio button yang dipilih memiliki nilai "2"
                if($(this).val() === "2") {
                    // Jika ya, tambahkan kelas 'show' pada elemen '.listplayerinfo.xusername'
                    $('.listplayerinfo.xusername').addClass('show');
                } else {
                    // Jika tidak, hapus kelas 'show' dari elemen '.listplayerinfo.xusername'
                    $('.listplayerinfo.xusername').removeClass('show');
                }
            });
        });
    </script>
@endsection
