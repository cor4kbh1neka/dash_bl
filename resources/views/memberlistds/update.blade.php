@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
            <a href="/memberlistds" class="kembali">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"
                        d="M44 40.836c-4.893-5.973-9.238-9.362-13.036-10.168c-3.797-.805-7.412-.927-10.846-.365V41L4 23.545L20.118 7v10.167c6.349.05 11.746 2.328 16.192 6.833c4.445 4.505 7.009 10.117 7.69 16.836Z"
                        clip-rule="evenodd" />
                </svg>
                <span class="textkembali">Kembali</span>
            </a>
        </div>
        <div class="seceditmemberds">
            <div class="groupseceditmemberds">
                <spann class="titleeditmemberds">player information</spann>
                <form class="groupplayerinfo" data-statusakun="9">
                    <div class="listgroupplayerinfo left">
                        <div class="listplayerinfo">
                            <label for="xyusernamexxy">username</label>
                            <input class="nosabel" readonly type="text" id="xyusernamexxy" name="xyusernamexxy"
                                value="{{ $datauser['xyusernamexxy'] }}">
                        </div>
                        <div class="listplayerinfo">
                            <label for="xybanknamexyy">nama bank</label>
                            <div class="groupeditinput">
                                <input type="text" readonly id="xybanknamexyy" name="xybanknamexyy"
                                    value="{{ $datauser['xybanknamexyy'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="namarek">nama rekening</label>
                            <div class="groupeditinput">
                                <input type="text" readonly id="namarek" name="namarek"
                                    value="{{ $datauser['xybankuserxy'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="nomorrek">nomor rekening</label>
                            <div class="groupeditinput">
                                <input type="text" readonly id="nomorrek" name="nomorrek"
                                    value="{{ $datauser['xxybanknumberxy'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                        <div class="listplayerinfo">
                            <label for="email">email</label>
                            <input class="nosabel" readonly type="text" id="email" name="email"
                                value="{{ substr_replace($datauser['xyx11xuser_mailxxyy'], str_repeat('*', 5), 0, 5) }}">
                        </div>
                        <div class="listplayerinfo">
                            <label for="nomorhp">nomor hp</label>
                            <input class="nosabel" readonly type="text" id="nomorhp" name="nomorhp"
                                value="{{ substr_replace($datauser['xynumbphonexyyy'], str_repeat('*', 5), 0, 5) }}">
                        </div>
                        <div class="listplayerinfogrp">
                            <div class="datalistplayerinfogrp">
                                <label for="groupdp">group bank deposit</label>
                                <select name="groupdp" id="groupdp" value="groupbank1">
                                    <option value="" place="" style="color: #838383; font-style: italic;"
                                        disabled="">pilih group</option>
                                    <option value="groupbank1" {{ $datauser['group'] == 'groupbank1' ? 'selected' : '' }}>
                                        groupbank1</option>
                                    <option value="groupbank2" {{ $datauser['group'] == 'groupbank2' ? 'selected' : '' }}>
                                        groupbank2</option>
                                    <option value="groupbank3" {{ $datauser['group'] == 'groupbank3' ? 'selected' : '' }}>
                                        groupbank3</option>
                                    <option value="groupbank4" {{ $datauser['group'] == 'groupbank4' ? 'selected' : '' }}>
                                        groupbank4</option>
                                </select>
                            </div>
                            <div class="datalistplayerinfogrp">
                                <label for="groupwd">group bank withdraw</label>
                                <select name="groupwd" id="groupwd" value="groupbank1">
                                    <option value="" place="" style="color: #838383; font-style: italic;"
                                        disabled="">pilih group</option>
                                    <option value="groupbank1"
                                        {{ $datauser['groupwd'] == 'groupbank1' ? 'selected' : '' }}>
                                        groupbank1</option>
                                    <option value="groupbank2"
                                        {{ $datauser['groupwd'] == 'groupbank2' ? 'selected' : '' }}>groupbank2
                                    </option>
                                    <option value="groupbank3"
                                        {{ $datauser['groupwd'] == 'groupbank3' ? 'selected' : '' }}>groupbank3
                                    </option>
                                    <option value="groupbank4"
                                        {{ $datauser['groupwd'] == 'groupbank4' ? 'selected' : '' }}>groupbank4
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="listgroupplayerinfo right">
                        <button class="tombol cancel">
                            <span class="texttombol">SUSPEND PLAYER</span>
                        </button>
                        <button class="tombol primary">
                            <span class="texttombol">SAVE DATA</span>
                        </button>
                    </div>
                </form>
                <spann class="titleeditmemberds change">cange data player</spann>
                <div class="groupchangedataplayer">
                    <div class="listchangedataplayer">
                        <div class="groupinputchangedataplayer">
                            <label for="changepassword">CHANGE PASSWORD</label>
                            <input type="password" id="changepassword" name="changepassword"
                                placeholder="masukkan password baru">
                            <input type="password" id="repassword" name="repassword"
                                placeholder="konsfirmasi password baru">
                        </div>
                        <div class="groupbuttonplayer">
                            <button class="tombol primary">
                                <span class="texttombol">SAVE DATA</span>
                            </button>
                        </div>
                    </div>
                    <div class="centerborder"></div>
                    <div class="listchangedataplayer">
                        <label for="changepassword">CHANGE INFORMATION</label>
                        <input type="text" id="informasiplayer" name="informasiplayer"
                            placeholder="masukkan informasi player">
                        <div class="groupstatuspl">
                            <label for="statuspl">STATUS</label>
                            <select name="status" id="status" value="9">
                                <option value="" place="" style="color: #838383; font-style: italic;"
                                    disabled="">PILIH STATUS</option>
                                <option value="9">new member</option>
                                <option value="1">default</option>
                                <option value="2">VVIP</option>
                                <option value="3">bandar</option>
                                <option value="4">warning</option>
                                <option value="5">suspend</option>
                            </select>
                        </div>
                        <div class="groupdatbetpl">
                            <span class="labelbetpl">BET</span>
                            <div class="groupdatabet">
                                <label for="minbet">minimal</label>
                                <input type="text" id="minbet" name="minbet" value="10">
                            </div>
                            <div class="groupdatabet">
                                <label for="maxbet">minimal</label>
                                <input type="text" id="maxbet" name="maxbet" value="50000">
                            </div>
                        </div>
                        <div class="groupbuttonplayer">
                            <button class="tombol primary">
                                <span class="texttombol">SAVE DATA</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.groupeditinput svg').click(function() {
                $(this).closest('.groupeditinput').toggleClass('edit');
                $(this).siblings('input').prop('readonly', function(_, val) {
                    return !val;
                });
            });
        });
    </script>
@endsection
