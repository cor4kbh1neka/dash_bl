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
        <div class="seccontentds">
            <div class="groupseccontentds">
                <div class="headseccontentds">
                    <a href="/contentds" class="tombol grey">
                        <span class="texttombol">GENERAL</span>
                    </a>
                    <a href="/contentds/promo" class="tombol grey">
                        <span class="texttombol">PROMO</span>
                    </a>
                    <a href="/contentds/slider" class="tombol grey active">
                        <span class="texttombol">SLIDER</span>
                    </a>
                    <a href="/contentds/link" class="tombol grey">
                        <span class="texttombol">LINK</span>
                    </a>
                    <a href="/contentds/socialmedia" class="tombol grey">
                        <span class="texttombol">SOCIAL MEDIA</span>
                    </a>
                </div>
                <div class="listheadsecagentds bottom">
                    <button class="tombol primary setrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M472 168H40a24 24 0 0 1 0-48h432a24 24 0 0 1 0 48m-80 112H120a24 24 0 0 1 0-48h272a24 24 0 0 1 0 48m-96 112h-80a24 24 0 0 1 0-48h80a24 24 0 0 1 0 48" />
                        </svg>
                        <span class="texttombol tmblurutan">URUTAN SLIDER</span>
                    </button>
                </div>
                <div class="groupdatasecagentds">
                    <div class="tabelproses slider">
                        <table id="sortable-table">
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagno">#</th>
                                    <th class="bagmenu"></th>
                                    <th class="bagimage">image</th>
                                    <th class="bagtitle">title</th>
                                    <th class="bagurltarget">url target</th>
                                    <th class="bagstatus">status</th>
                                    <th class="action">tools</th>
                                </tr>
                                <tr class="dinamicrow" data-row="1" data-statusactive="1">
                                    <td>
                                        <div class="statuspromorow slider">1</div>
                                    </td>
                                    <td class="dragmenu">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M3 18v-2h18v2zm0-5v-2h18v2zm0-5V6h18v2z" />
                                        </svg>
                                    </td>
                                    <td>
                                        <img src="https://via.placeholder.com/184x184" alt="image">
                                    </td>
                                    <td class="datamini">BONUS DEPOSIT HARIAN ALL GAME UP TO 10%</td>
                                    <td class="datamini">https://www.loremipsum.com</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/slider/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow" data-row="2" data-statusactive="1">
                                    <td>
                                        <div class="statuspromorow slider">2</div>
                                    </td>
                                    <td class="dragmenu">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M3 18v-2h18v2zm0-5v-2h18v2zm0-5V6h18v2z" />
                                        </svg>
                                    </td>
                                    <td>
                                        <img src="https://via.placeholder.com/184x184" alt="image">
                                    </td>
                                    <td class="datamini">BONUS DEPOSIT HARIAN ALL GAME UP TO 10%</td>
                                    <td class="datamini">https://www.loremipsum.com</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/slider/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow" data-row="3" data-statusactive="2">
                                    <td>
                                        <div class="statuspromorow slider">3</div>
                                    </td>
                                    <td class="dragmenu">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M3 18v-2h18v2zm0-5v-2h18v2zm0-5V6h18v2z" />
                                        </svg>
                                    </td>
                                    <td>
                                        <img src="https://via.placeholder.com/184x184" alt="image">
                                    </td>
                                    <td class="datamini">BONUS DEPOSIT HARIAN ALL GAME UP TO 10%</td>
                                    <td class="datamini">https://www.loremipsum.com</td>
                                    <td class="statuspromo" data-status="2"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/slider/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
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
            $('.statuspromo').each(function(){
                var statusValue = $(this).attr('data-status');
                switch(statusValue) {
                    case '1':
                        $(this).text('Active');
                        break;
                    case '2':
                        $(this).text('in-active');
                        break;
                    default:
                        break;
                }
            });
        });

        $(document).ready(function() {
            $("#sortable-table").sortable({
                items: "tr.dinamicrow.show",
                axis: "y",
                update: function(event, ui) {
                    $("tr.dinamicrow.show").each(function(index) {
                        var rowNumber = index + 1;
                        $(this).find("td:first").text(rowNumber);
                        $(this).attr("data-row", rowNumber);
                    });

                    var newIndex = ui.item.index() + 1;
                    var newRowData = ui.item.data('row');
                    console.log("New index: " + newIndex);
                    console.log("Row data: " + newRowData);
                }
            });
        });

        // button set urutan
        $(document).ready(function(){
            var clickedOnce = false;
            $('.setrow').click(function(){
                $('.bagmenu').toggleClass('show');
                
                if (!clickedOnce) {
                    $('.dinamicrow[data-statusactive="1"]').addClass('show');
                } else {
                    $('.dinamicrow[data-statusactive="1"]').removeClass('show');
                }
                
                var buttonText = $(this).find('.texttombol');
                if (buttonText.text() === 'SAVE URUTAN') {
                    buttonText.text('URUTAN SLIDER');
                } else {
                    buttonText.text('SAVE URUTAN');
                }
                
                var svgIcon = $(this).find('svg');
                if (svgIcon.length > 0) {
                    svgIcon.remove();
                } else {
                    $(this).prepend('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M472 168H40a24 24 0 0 1 0-48h432a24 24 0 0 1 0 48m-80 112H120a24 24 0 0 1 0-48h272a24 24 0 0 1 0 48m-96 112h-80a24 24 0 0 1 0-48h80a24 24 0 0 1 0 48"/></svg>');
                }
                
                clickedOnce = !clickedOnce;
            });
        });
    </script>
@endsection
