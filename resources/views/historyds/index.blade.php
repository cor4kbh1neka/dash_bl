@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor" d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="historyds">
            <div class="grouphistoryds">
                <div class="groupheadhistoryds">
                    <div class="listheadhistoryds top">
                        <button class="tombol grey active">
                            <span class="texttombol">ALL TRANSACTION</span>
                        </button>
                        <button class="tombol grey">
                            <span class="texttombol">HISTORY DEPOSIT</span>
                        </button>
                        <button class="tombol grey">
                            <span class="texttombol">HISTORY WITHDRAW</span>
                        </button>
                        <button class="tombol grey">
                            <span class="texttombol">HISTORY MANUAL</span>
                        </button>
                    </div>
                    <div class="grouplistheadhistoryds">
                        <div class="listheadhistoryds bottom one">
                            <input type="text" id="" name="" placeholder="User ID">
                            <select name="type" id="type">
                                <option value="" selected="" place="" style="color: #838383; font-style: italic;" disabled>Tipe Transaksi</option>
                                <option value="DP">Accept Deposit</option>
                                <option value="DPM">Deposit Manual</option>
                                <option value="WD">Accept Withdraw</option>
                                <option value="WDM">Withdraw Manual</option>
                            </select>
                            <select name="agent" id="agent">
                                <option value="" selected="" place="" style="color: #838383; font-style: italic;" disabled>Pilih Agent</option>
                                <option value="1">CSDP1</option>
                                <option value="2">CSDP2</option>
                                <option value="3">CSWD1</option>
                                <option value="4">CSWD2</option>
                            </select>
                        </div>
                        <div class="listheadhistoryds bottom two">
                            <input type="date" id="tgldari" name="tgldari" >
                            <input type="date" id="tglhingga" name="tglhingga" >
                            <button class="tombol primary">
                                <span class="texttombol">SUBMIT</span>
                            </button>
                        </div>
                        <div class="exportdata">
                            <span class="textdownload">download</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                <th class="bagno">#</th>
                                <th class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox">
                                </th>
                                <th class="baguser">Username</th>
                                <th class="bagnominal">nominal</th>
                                <th class="agentdata">agent</th>
                                <th class="typetrans">type transaksi</th>
                                <th class="statustrans">status</th>
                                <th class="bagketerangan">keterangan</th>
                                <th class="bagtanggal">di terima</th>
                                <th class="bagtanggal">di proses</th>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember">1</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>thanos98</td>
                                <td class="valuenominal">100,000</td>
                                <td>CSAG01</td>
                                <td class="texttype">Deposit Manual</td>
                                <td class="hsjenistrans" data-proses="accept">accepted</td>
                                <td>maksimal 20 karakter</td>
                                <td>2024-04-05 21:09:03</td>
                                <td>2024-04-05 21:09:03</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember">2</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>lontong989898</td>
                                <td class="valuenominal">100,000</td>
                                <td>CSAG01</td>
                                <td class="texttype">Withdraw Manual</td>
                                <td class="hsjenistrans" data-proses="accept">accepted</td>
                                <td>maksimal 20 karakter</td>
                                <td>2024-04-05 21:09:03</td>
                                <td>2024-04-05 21:09:03</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember">2</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>thanos989898</td>
                                <td class="valuenominal">50,000</td>
                                <td>CSAG01</td>
                                <td class="texttype">deposit</td>
                                <td class="hsjenistrans" data-proses="cancel">rejected</td>
                                <td>maksimal 20 karakter</td>
                                <td>2024-04-05 21:09:03</td>
                                <td>2024-04-05 21:09:03</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember">3</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>thanos989898</td>
                                <td class="valuenominal">50,000</td>
                                <td>CSAG01</td>
                                <td class="texttype">withdraw</td>
                                <td class="hsjenistrans" data-proses="accept">accepted</td>
                                <td>maksimal 20 karakter</td>
                                <td>2024-04-05 21:09:03</td>
                                <td>2024-04-05 21:09:03</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember">4</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>thanos989898</td>
                                <td class="valuenominal">50,000</td>
                                <td>CSAG01</td>
                                <td class="texttype">deposit</td>
                                <td class="hsjenistrans" data-proses="accept">accepted</td>
                                <td>maksimal 20 karakter</td>
                                <td>2024-04-05 21:09:03</td>
                                <td>2024-04-05 21:09:03</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember">5</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>thanos989898</td>
                                <td class="valuenominal">50,000</td>
                                <td>CSAG01</td>
                                <td class="texttype">deposit</td>
                                <td class="hsjenistrans" data-proses="accept">accepted</td>
                                <td>maksimal 20 karakter</td>
                                <td>2024-04-05 21:09:03</td>
                                <td>2024-04-05 21:09:03</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember">6</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>thanos989898</td>
                                <td class="valuenominal">50,000</td>
                                <td>CSAG01</td>
                                <td class="texttype">deposit</td>
                                <td class="hsjenistrans" data-proses="accept">accepted</td>
                                <td>maksimal 20 karakter</td>
                                <td>2024-04-05 21:09:03</td>
                                <td>2024-04-05 21:09:03</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember">7</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>thanos989898</td>
                                <td class="valuenominal">50,000</td>
                                <td>CSAG01</td>
                                <td class="texttype">deposit</td>
                                <td class="hsjenistrans" data-proses="accept">accepted</td>
                                <td>maksimal 20 karakter</td>
                                <td>2024-04-05 21:09:03</td>
                                <td>2024-04-05 21:09:03</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember">8</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>thanos989898</td>
                                <td class="valuenominal">50,000</td>
                                <td>CSAG01</td>
                                <td class="texttype">deposit</td>
                                <td class="hsjenistrans" data-proses="accept">accepted</td>
                                <td>maksimal 20 karakter</td>
                                <td>2024-04-05 21:09:03</td>
                                <td>2024-04-05 21:09:03</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember">9</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>thanos989898</td>
                                <td class="valuenominal">50,000</td>
                                <td>CSAG01</td>
                                <td class="texttype">deposit</td>
                                <td class="hsjenistrans" data-proses="accept">accepted</td>
                                <td>maksimal 20 karakter</td>
                                <td>2024-04-05 21:09:03</td>
                                <td>2024-04-05 21:09:03</td>
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
