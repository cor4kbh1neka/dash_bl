@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secreportds">
            <div class="groupsecreportds">
                <div class="groupdatareportds">
                    <div class="grouphistoryds memberlist">
                        <div class="groupheadhistoryds">
                            <form method="GET" action="/bonusds" class="listmembergroup">
                                <div class="listinputmember">
                                    <label for="bonus">Bonus</label>
                                    <select name="bonus" id="bonus" required>
                                        <option value="" selected="" place=""
                                            style="color: #838383; font-style: italic;" disabled="">Pilih Bonus</option>
                                        <option value="1" {{ $bonus == '1' ? 'selected' : '' }}>Cashback</option>
                                        <option value="2" {{ $bonus == '2' ? 'selected' : '' }}>Rollingan</option>
                                    </select>
                                </div>
                                <div class="listinputmember">
                                    <label for="gabungdari">tanggal dari</label>
                                    <input type="date" id="gabungdari" name="gabungdari"
                                        placeholder="tanggal gabung dari" value="{{ $gabungdari }}" required>
                                </div>
                                <div class="listinputmember">
                                    <label for="gabunghingga">tanggal hingga</label>
                                    <input type="date" id="gabunghingga" name="gabunghingga"
                                        placeholder="tanggal gabung hingga" value="{{ $gabunghingga }}" required>
                                </div>
                                <div class="listinputmember">
                                    <label for="kecuali">Pengecualian</label>
                                    <select name="kecuali" id="kecuali" required>
                                        <option value="" selected="" place=""
                                            style="color: #838383; font-style: italic;" disabled="">Pilih pengecualian
                                        </option>
                                        @foreach ($dataBonusPengecualian as $d)
                                            <option value="{{ $d->nama }}"
                                                {{ $d->nama == $pengecualian ? 'selected' : '' }}>{{ $d->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="listinputmember">
                                    <button class="tombol primary">
                                        <span class="texttombol">SUBMIT</span>
                                    </button>
                                </div>
                                <div class="grouprightbtn">
                                    <div class="listinputmember">
                                        <button type="button" class="tombol primary" disabled>
                                            <span class="texttombol">PROSES BONUS</span>
                                        </button>
                                    </div>
                                    <div class="exportdata">
                                        <span class="textdownload">download</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                        </svg>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="totalbonus">
                            <div class="listtotalbonus">
                                <span class="textbonus">Bonus :</span>
                                <span class="countbonus">Rollingan</span>
                            </div>
                            <div class="listtotalbonus">
                                <span class="textbonus">tanggal :</span>
                                <div class="grouptgllistbonus">
                                    <span class="countbonus from">2024-04-17</span>
                                    <span>s/d</span>
                                    <span class="countbonus to">2024-04-17</span>
                                </div>
                            </div>
                            <div class="listtotalbonus">
                                <span class="textbonus">Pengecualian :</span>
                                <span class="countbonus">Tanpa pengecualian</span>
                            </div>
                            <div class="listtotalbonus">
                                <span class="textbonus">Jumlah User :</span>
                                <span class="countbonus">280</span>
                            </div>
                            <div class="listtotalbonus">
                                <span class="textbonus">total bonus :</span>
                                <span class="nominalbonus" data-bonus="200000000.69"></span>
                            </div>
                        </div>
                        <div class="tabelproses">
                            <table>
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagnot" rowspan="2">#</th>
                                        <th class="check_box boxme" rowspan="2">
                                            <input type="checkbox" id="myCheckbox" name="myCheckbox">
                                        </th>
                                        <th class="bagusercc">username</th>
                                        <th class="bagturnover" rowspan="2">turnover</th>
                                        <th class="bagwinlose" rowspan="2">win/lose</th>
                                        <th class="bagnominalbonus" rowspan="2">nominal bonus (IDR)</th>
                                    </tr>
                                    <tr class="hdtable search">
                                        <th class="tdsearch">
                                            <div class="grubsearchtable">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24"
                                                    stroke-width="1.5" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                                <input type="text" placeholder="Cari data..." id="searchData-username"
                                                    class="searchData-username">
                                            </div>
                                        </th>
                                    </tr>
                                    @foreach ($data as $i => $d)
                                        <tr>
                                            <td>1</td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                                <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0"
                                                    data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td class="username">{{ $d->username }}</td>
                                            <td class="datacc" data-get="{{ $d->totalstake }}"></td>
                                            <td class="datacc" data-get="{{ $d->totalwinloss }}"></td>
                                            <td class="datacc" data-get="{{ $d->totalbonus }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

        // print nilai td
        $(document).ready(function() {
            $('.datacc').each(function() {
                var value = parseFloat($(this).attr('data-get')).toFixed(2);
                var formattedValue = numberWithCommas(value);
                $(this).text(formattedValue);
            });
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // print total bonus
        $(document).ready(function() {
            var value = parseFloat($('.nominalbonus').attr('data-bonus')).toFixed(2);
            var formattedValue = formatCurrency(value);
            $('.nominalbonus').text(formattedValue);
        });

        function formatCurrency(amount) {
            return 'IDR ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace('.00', '.');
        }

        $(document).ready(function() {
            $('#searchData-username').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('tr.hdtable.search').nextAll('tr').each(function() {
                    var username = $(this).find('.username').text().toLowerCase();
                    if (username.includes(value)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
@endsection
