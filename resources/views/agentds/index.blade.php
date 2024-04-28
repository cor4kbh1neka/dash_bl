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
        <div class="secagentds">
            <div class="groupsecagentds">
                <div class="headgroupsecagentds">
                    <div class="listheadsecagentds">
                        <a href="/memods" class="tombol grey active">
                            <span class="texttombol">agent</span>
                        </a>
                        <a href="/agentds/access" class="tombol grey">
                            <span class="texttombol">access grouping</span>
                        </a>
                    </div>
                    <div class="listheadsecagentds bottom">
                        <a href="/agentds/create" class="tombol proses">
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
                                ADD AGENT
                            </span>
                        </a>
                        <div class="groupsearchagentds">
                            <div class="grubsearchnav">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14" />
                                </svg>
                                <input type="text" placeholder="Cari Tabel..." id="searchTabel">
                            </div>
                            <button class="tombol primary">
                                <span class="texttombol">search</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="groupdatasecagentds">
                    <div class="tabelproses">
                        <table>
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagno">#</th>
                                    <th class="baglogininfo">login information</th>
                                    <th class="bagiplogin">IP login</th>
                                    <th class="baguser">user agent</th>
                                    <th class="bagaccagent">agent access</th>
                                    <th class="bagstatus">status</th>
                                    <th class="action">tools</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>2024-04-05 21:09:03</td>
                                    <td>202.178.118.234</td>
                                    <td>
                                        <div class="splitcollum" title="suka ngibul">
                                            <span class="userpending">
                                                adminIT
                                                <a href="/agentds/agentinfo" class="iconprofile openviewportinfo" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </td>
                                    <td>leader-access</td>
                                    <td class="statusagent" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/agentupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">suspend</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>2024-04-05 21:09:03</td>
                                    <td>202.178.118.234</td>
                                    <td>
                                        <div class="splitcollum" title="suka ngibul">
                                            <span class="userpending">
                                                adminIT
                                                <a href="/agentds/agentinfo" class="iconprofile openviewportinfo" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </td>
                                    <td>leader-access</td>
                                    <td class="statusagent" data-status="2"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/agentupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">suspend</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2024-04-05 21:09:03</td>
                                    <td>202.178.118.234</td>
                                    <td>
                                        <div class="splitcollum" title="suka ngibul">
                                            <span class="userpending">
                                                adminIT
                                                <a href="/agentds/agentinfo" class="iconprofile openviewportinfo" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </td>
                                    <td>leader-access</td>
                                    <td class="statusagent" data-status="3"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/agentupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">suspend</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>2024-04-05 21:09:03</td>
                                    <td>202.178.118.234</td>
                                    <td>
                                        <div class="splitcollum" title="suka ngibul">
                                            <span class="userpending">
                                                adminIT
                                                <a href="/agentds/agentinfo" class="iconprofile openviewportinfo" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </td>
                                    <td>leader-access</td>
                                    <td class="statusagent" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/agentupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">suspend</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>2024-04-05 21:09:03</td>
                                    <td>202.178.118.234</td>
                                    <td>
                                        <div class="splitcollum" title="suka ngibul">
                                            <span class="userpending">
                                                adminIT
                                                <a href="/agentds/agentinfo" class="iconprofile openviewportinfo" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </td>
                                    <td>leader-access</td>
                                    <td class="statusagent" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/agentupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">suspend</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="grouppagination">
                            <div class="grouppaginationcc">
                                <div class="trigger left">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <g fill="none" fill-rule="evenodd">
                                            <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                            <path fill="currentColor" d="M7.94 13.06a1.5 1.5 0 0 1 0-2.12l5.656-5.658a1.5 1.5 0 1 1 2.121 2.122L11.122 12l4.596 4.596a1.5 1.5 0 1 1-2.12 2.122l-5.66-5.658Z" />
                                        </g>
                                    </svg>
                                </div>
                                <div class="trigger right">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                        <g fill="none" fill-rule="evenodd">
                                            <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                            <path fill="currentColor" d="M16.06 10.94a1.5 1.5 0 0 1 0 2.12l-5.656 5.658a1.5 1.5 0 1 1-2.121-2.122L12.879 12L8.283 7.404a1.5 1.5 0 0 1 2.12-2.122l5.658 5.657Z" />
                                        </g>
                                    </svg>
                                </div>
                                <span class="numberpage active">1</span>
                                <span class="numberpage">2</span>
                                <span class="numberpage">3</span>
                                <span class="numberpage">4</span>
                                <span class="numberpage">5</span>
                                <span class="numberpage">...</span>
                                <span class="numberpage">12</span>
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

        //open jendela edit agent
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.6;
                var windowLeft = ($(window).width() - windowWidth) / 1.3;
                var windowTop = ($(window).height() - windowHeight) / 1.5;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + windowLeft + ", top=" + windowTop);
            });
        });

        //open jendela info agent
        $(document).ready(function() {
            $(".openviewportinfo").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 300;
                var windowHeight = $(window).height() * 0.20;
                var windowLeft = ($(window).width() - windowWidth) / 1.6;
                var windowTop = ($(window).height() - windowHeight) / 1.8;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + windowLeft + ", top=" + windowTop);
            });
        });

        // print text status
        $(document).ready(function(){
            $('.statusagent').each(function(){
                var statusValue = $(this).attr('data-status');
                switch(statusValue) {
                    case '1':
                        $(this).text('Active');
                        break;
                    case '2':
                        $(this).text('Non-active');
                        break;
                    case '3':
                        $(this).text('Suspend');
                        break;
                    default:
                        break;
                }
            });
        });
    </script>
@endsection
