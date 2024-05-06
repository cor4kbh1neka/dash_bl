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
        <div class="secanalyticds">
            <div class="groupsecanalyticds">
                <div class="headsecanalyticds">
                    <a href="/analyticsds" class="tombol grey">
                        <span class="texttombol">META TAG</span>
                    </a>
                    <a href="/analyticsds/sitemap" class="tombol grey active">
                        <span class="texttombol">SITE MAP</span>
                    </a>
                </div>
                <div class="groupdataanalyticds">
                    <div class="groupsetbankmaster">
                        <div class="groupplayerinfo">
                            <div class="listdatasitemap">
                                <div class="listgroupplayerinfo left sitemap">
                                    <div class="listplayerinfo url">
                                        <label for="urlpage">url page</label>
                                        <div class="groupeditinput">
                                            <span class="textslice">/</span>
                                            <input type="text" id="urlpage" name="urlpage" value="home" placeholder="input halaman" />
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="lastmod">last modified</label>
                                        <div class="groupeditinput">
                                            <input type="date" id="lastmod" name="lastmod" value="2024-04-30" />
                                        </div>
                                    </div>
                                    <div class="groupdeleterow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                            <defs>
                                                <mask id="ipSDeleteTwo0">
                                                    <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4">
                                                        <path fill="#fff" stroke="#fff" d="M14 11L4 24l10 13h30V11z" />
                                                        <path stroke="#000" d="m21 19l10 10m0-10L21 29" />
                                                    </g>
                                                </mask>
                                            </defs>
                                            <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSDeleteTwo0)" />
                                        </svg>
                                        <span class="textdelete">delete</span>
                                    </div>
                                </div>
                                <div class="listgroupplayerinfo left sitemap">
                                    <div class="listplayerinfo url">
                                        <label for="urlpage">url page</label>
                                        <div class="groupeditinput">
                                            <span class="textslice">/</span>
                                            <input type="text" id="urlpage" name="urlpage" value="login" placeholder="input halaman" />
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="lastmod">last modified</label>
                                        <div class="groupeditinput">
                                            <input type="date" id="lastmod" name="lastmod" value="2024-04-30" />
                                        </div>
                                    </div>
                                    <div class="groupdeleterow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                            <defs>
                                                <mask id="ipSDeleteTwo0">
                                                    <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4">
                                                        <path fill="#fff" stroke="#fff" d="M14 11L4 24l10 13h30V11z" />
                                                        <path stroke="#000" d="m21 19l10 10m0-10L21 29" />
                                                    </g>
                                                </mask>
                                            </defs>
                                            <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSDeleteTwo0)" />
                                        </svg>
                                        <span class="textdelete">delete</span>
                                    </div>
                                </div>
                                <div class="listgroupplayerinfo left sitemap">
                                    <div class="listplayerinfo url">
                                        <label for="urlpage">url page</label>
                                        <div class="groupeditinput">
                                            <span class="textslice">/</span>
                                            <input type="text" id="urlpage" name="urlpage" value="register" placeholder="input halaman" />
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="lastmod">last modified</label>
                                        <div class="groupeditinput">
                                            <input type="date" id="lastmod" name="lastmod" value="2024-04-30" />
                                        </div>
                                    </div>
                                    <div class="groupdeleterow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                            <defs>
                                                <mask id="ipSDeleteTwo0">
                                                    <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4">
                                                        <path fill="#fff" stroke="#fff" d="M14 11L4 24l10 13h30V11z" />
                                                        <path stroke="#000" d="m21 19l10 10m0-10L21 29" />
                                                    </g>
                                                </mask>
                                            </defs>
                                            <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSDeleteTwo0)" />
                                        </svg>
                                        <span class="textdelete">delete</span>
                                    </div>
                                </div>
                                <div class="listgroupplayerinfo left sitemap">
                                    <div class="listplayerinfo url">
                                        <label for="urlpage">url page</label>
                                        <div class="groupeditinput">
                                            <span class="textslice">/</span>
                                            <input type="text" id="urlpage" name="urlpage" value="promosihome" placeholder="input halaman" />
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="lastmod">last modified</label>
                                        <div class="groupeditinput">
                                            <input type="date" id="lastmod" name="lastmod" value="2024-04-30" />
                                        </div>
                                    </div>
                                    <div class="groupdeleterow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                            <defs>
                                                <mask id="ipSDeleteTwo0">
                                                    <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4">
                                                        <path fill="#fff" stroke="#fff" d="M14 11L4 24l10 13h30V11z" />
                                                        <path stroke="#000" d="m21 19l10 10m0-10L21 29" />
                                                    </g>
                                                </mask>
                                            </defs>
                                            <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSDeleteTwo0)" />
                                        </svg>
                                        <span class="textdelete">delete</span>
                                    </div>
                                </div>
                                <div class="listgroupplayerinfo left sitemap">
                                    <div class="listplayerinfo url">
                                        <label for="urlpage">url page</label>
                                        <div class="groupeditinput">
                                            <span class="textslice">/</span>
                                            <input type="text" id="urlpage" name="urlpage" value="klasemenhome" placeholder="input halaman" />
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="lastmod">last modified</label>
                                        <div class="groupeditinput">
                                            <input type="date" id="lastmod" name="lastmod" value="2024-04-30" />
                                        </div>
                                    </div>
                                    <div class="groupdeleterow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                            <defs>
                                                <mask id="ipSDeleteTwo0">
                                                    <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4">
                                                        <path fill="#fff" stroke="#fff" d="M14 11L4 24l10 13h30V11z" />
                                                        <path stroke="#000" d="m21 19l10 10m0-10L21 29" />
                                                    </g>
                                                </mask>
                                            </defs>
                                            <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSDeleteTwo0)" />
                                        </svg>
                                        <span class="textdelete">delete</span>
                                    </div>
                                </div>
                                <div class="listgroupplayerinfo left sitemap">
                                    <div class="listplayerinfo url">
                                        <label for="urlpage">url page</label>
                                        <div class="groupeditinput">
                                            <span class="textslice">/</span>
                                            <input type="text" id="urlpage" name="urlpage" value="livescorehome" placeholder="input halaman" />
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="lastmod">last modified</label>
                                        <div class="groupeditinput">
                                            <input type="date" id="lastmod" name="lastmod" value="2024-04-30" />
                                        </div>
                                    </div>
                                    <div class="groupdeleterow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                            <defs>
                                                <mask id="ipSDeleteTwo0">
                                                    <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4">
                                                        <path fill="#fff" stroke="#fff" d="M14 11L4 24l10 13h30V11z" />
                                                        <path stroke="#000" d="m21 19l10 10m0-10L21 29" />
                                                    </g>
                                                </mask>
                                            </defs>
                                            <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSDeleteTwo0)" />
                                        </svg>
                                        <span class="textdelete">delete</span>
                                    </div>
                                </div>
                                <div class="listgroupplayerinfo left sitemap">
                                    <div class="listplayerinfo url">
                                        <label for="urlpage">url page</label>
                                        <div class="groupeditinput">
                                            <span class="textslice">/</span>
                                            <input type="text" id="urlpage" name="urlpage" value="peraturanhome" placeholder="input halaman" />
                                        </div>
                                    </div>
                                    <div class="listplayerinfo">
                                        <label for="lastmod">last modified</label>
                                        <div class="groupeditinput">
                                            <input type="date" id="lastmod" name="lastmod" value="2024-04-30" />
                                        </div>
                                    </div>
                                    <div class="groupdeleterow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                            <defs>
                                                <mask id="ipSDeleteTwo0">
                                                    <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4">
                                                        <path fill="#fff" stroke="#fff" d="M14 11L4 24l10 13h30V11z" />
                                                        <path stroke="#000" d="m21 19l10 10m0-10L21 29" />
                                                    </g>
                                                </mask>
                                            </defs>
                                            <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSDeleteTwo0)" />
                                        </svg>
                                        <span class="textdelete">delete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="listgroupplayerinfo right">
                                <button class="tombol proses">
                                    <span class="texttombol">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                            <defs>
                                                <mask id="ipSAdd0">
                                                    <g fill="none" stroke-linejoin="round" stroke-width="4">
                                                        <rect width="36" height="36" x="6" y="6" fill="#fff" stroke="#fff" rx="3" />
                                                        <path stroke="#000" stroke-linecap="round" d="M24 16v16m-8-8h16" />
                                                    </g>
                                                </mask>
                                            </defs>
                                            <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSAdd0)" />
                                        </svg>
                                        ADD PAGE
                                    </span>
                                </button>
                                <button class="tombol primary">
                                    <span class="texttombol">SAVE DATA</span>
                                </button>
                            </div>
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
    </script>
@endsection
