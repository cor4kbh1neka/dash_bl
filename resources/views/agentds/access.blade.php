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
                        <a href="/agentds" class="tombol grey">
                            <span class="texttombol">agent</span>
                        </a>
                        <a href="/agentds/access" class="tombol grey active">
                            <span class="texttombol">access grouping</span>
                        </a>
                    </div>
                    <div class="listheadsecagentds bottom">
                        <a href="/agentds/accessadd" class="tombol proses">
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
                                ADD ACCESS TYPE
                            </span>
                        </a>
                    </div>
                </div>
                <div class="groupdatasecagentds accgroup">
                    <div class="tabelproses">
                        <table>
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagno">#</th>
                                    <th class="bagaccagent">access type</th>
                                    <th class="action">tools</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>leader-access</td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/accessupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">DELETE</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>captain-access</td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/accessupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">DELETE</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>CS-access</td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/accessupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">DELETE</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>admin-access</td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/accessupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">DELETE</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>marketing-access</td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/accessupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">DELETE</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>MT-access</td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/agentds/accessupdate" target="_blank" class="tombol grey openviewport">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol cancel border">
                                                <span class="texttombol">DELETE</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

        //open jendela detail
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.6;
                var windowLeft = ($(window).width() - windowWidth) / 1.5;
                var windowTop = ($(window).height() - windowHeight) / 1.5;

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
