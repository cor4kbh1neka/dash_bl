@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secmemberlist">
            <div class="grouphistoryds memberlist">
                <div class="groupheadhistoryds">
                    <div class="listmembergroup">
                        <div class="listinputmember">
                            <label for="username">username</label>
                            <input type="text" id="username" name="username" placeholder="username">
                        </div>
                        <div class="listinputmember">
                            <label for="norek">nomor rekening</label>
                            <input type="text" id="norek" name="norek" placeholder="nomor rekening">
                        </div>
                        <div class="listinputmember">
                            <label for="namerek">nama rekening</label>
                            <input type="text" id="namerek" name="namerek" placeholder="nama rekening">
                        </div>
                        <div class="listinputmember">
                            <label for="bank">bank</label>
                            <input type="text" id="bank" name="bank" placeholder="bank">
                        </div>
                        <div class="listinputmember">
                            <label for="nope">nomor handphone</label>
                            <input type="text" id="nope" name="nope" placeholder="nomor handphone">
                        </div>
                    </div>
                    <div class="listmembergroup">
                        <div class="listinputmember">
                            <label for="referral">referral</label>
                            <input type="text" id="referral" name="referral" placeholder="referral">
                        </div>
                        <div class="listinputmember">
                            <label for="gabungdari">tanggal gabung dari</label>
                            <input type="date" id="gabungdari" name="gabungdari" placeholder="tanggal gabung dari">
                        </div>
                        <div class="listinputmember">
                            <label for="gabunghingga">tanggal gabung hingga</label>
                            <input type="date" id="gabunghingga" name="tanggal gabung hingga"
                                placeholder="nama rekening">
                        </div>
                        <div class="listinputmember">
                            <label for="status">bank</label>
                            <select name="status" id="status">
                                <option value="" selected="" place=""
                                    style="color: #838383; font-style: italic;" disabled="">Status</option>
                                <option value="9">new member</option>
                                <option value="1">default</option>
                                <option value="2">VVIP</option>
                                <option value="3">bandar</option>
                                <option value="4">warning</option>
                                <option value="5">suspend</option>
                            </select>
                        </div>
                        <div class="listinputmember">
                            <button class="tombol primary">
                                <span class="texttombol">SUBMIT</span>
                            </button>
                        </div>
                        <div class="exportdata">
                            <span class="textdownload">download</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                <th class="bagno">#</th>
                                <th class="baguser">Username</th>
                                <th class="baguser">referral</th>
                                <th class="bagbank">bank</th>
                                <th class="bagnominal">balance</th>
                                <th class="statusakun">status</th>
                                <th class="bagketerangan">information</th>
                                <th class="bagtanggal">tanggal gabung</th>
                                <th class="bagtanggal">last login</th>
                                <th class="action">tools</th>
                            </tr>
                            @foreach ($data as $i => $d)
                                <tr>
                                    <td>{{ $i + 0 }}</td>
                                    <td>{{ $d->username }}</td>
                                    <td>{{ $d->referral }}</td>
                                    <td>{{ $d->mbank }}, {{ $d->mnamarek }}, {{ $d->mnorek }}</td>
                                    <td class="valuenominal">
                                        <span class="koinasli">{{ $d->balance }}</span>
                                        <span class="cointorp"></span>
                                    </td>
                                    <td class="hsjenisakun" data-statusakun="{{ $d->status }}"></td>
                                    <td>{{ $d->keterangan }}</td>
                                    <td>{{ $d->created_at }}</td>
                                    <td>{{ $d->lastlogin }}</td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/memberlistds/edit/{{ $d->id }}" class="tombol grey">
                                                <span class="texttombol">EDIT</span>
                                            </a>
                                            <button class="tombol grey showmodal" data-modal="1"
                                                data-username="{{ $d->username }}" data-jenis="ALL">
                                                <span class="texttombol">HISTORY BANK</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="modalhistory" data-target="1">
                        <div class="secmodalhistory">
                            <span class="closetrigger">x</span>
                            <span class="titlemodalhistory">HISTORY COIN USER : thanos989898</span>
                            <table id="dataTableHistory">
                                <tbody>
                                    <tr class="hdtable">
                                        <th class="bagno">#</th>
                                        <th class="bagtanggal coin">tanggal</th>
                                        <th class="bagstatustrans">status</th>
                                        <th class="bagagent">agent</th>
                                        <th class="bagnominal">coin</th>
                                        <th class="bagnominal">last coin</th>
                                    </tr>
                                    {{-- <tr>
                                        <td>1</td>
                                        <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                        <td class="hsjenistrans" data-proses="accept">accept deposit</td>
                                        <td>CSDP1</td>
                                        <td>1,000.00</td>
                                        <td>2,860.68</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                        <td class="hsjenistrans" data-proses="accept">accept withdraw</td>
                                        <td>CSDP1</td>
                                        <td>1,000.00</td>
                                        <td>1,860.68</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                        <td class="hsjenistrans" data-proses="accept">accept deposit</td>
                                        <td>CSDP1</td>
                                        <td>1,000.00</td>
                                        <td>1,860.68</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                        <td class="hsjenistrans" data-proses="accept">manual deposit</td>
                                        <td>CSDP1</td>
                                        <td>860.00</td>
                                        <td>860.68</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                        <td class="hsjenistrans" data-proses="cancel">reject deposit</td>
                                        <td>CSDP1</td>
                                        <td>1000.00</td>
                                        <td>0.68</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                        <td class="hsjenistrans" data-proses="accept">accept deposit</td>
                                        <td>CSDP1</td>
                                        <td>1,000.00</td>
                                        <td>1,000.68</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                        <td class="hsjenistrans" data-proses="accept">accept deposit</td>
                                        <td>CSDP1</td>
                                        <td>500.00</td>
                                        <td>500.68</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                        <td class="hsjenistrans" data-proses="accept">accept deposit</td>
                                        <td>CSDP1</td>
                                        <td>500.00</td>
                                        <td>500.68</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                        <td class="hsjenistrans" data-proses="accept">accept deposit</td>
                                        <td>CSDP1</td>
                                        <td>500.00</td>
                                        <td>500.68</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                        <td class="hsjenistrans" data-proses="accept">accept deposit</td>
                                        <td>CSDP1</td>
                                        <td>500.00</td>
                                        <td>500.68</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                            <div class="grouppagination">
                                <div class="grouppaginationcc">
                                    <div class="trigger left">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <g fill="none" fill-rule="evenodd">
                                                <path
                                                    d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                <path fill="currentColor"
                                                    d="M7.94 13.06a1.5 1.5 0 0 1 0-2.12l5.656-5.658a1.5 1.5 0 1 1 2.121 2.122L11.122 12l4.596 4.596a1.5 1.5 0 1 1-2.12 2.122l-5.66-5.658Z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="trigger right">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <g fill="none" fill-rule="evenodd">
                                                <path
                                                    d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                                <path fill="currentColor"
                                                    d="M16.06 10.94a1.5 1.5 0 0 1 0 2.12l-5.656 5.658a1.5 1.5 0 1 1-2.121-2.122L12.879 12L8.283 7.404a1.5 1.5 0 0 1 2.12-2.122l5.658 5.657Z" />
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
                            <div class="informasihistorycoin">
                                <span>*data yang di tampilkan saat ini, selengkapnya di menu <a
                                        href="/historyds">history</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="grouppagination">
                        <div class="grouppaginationcc">
                            <div class="trigger left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <g fill="none" fill-rule="evenodd">
                                        <path
                                            d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                        <path fill="currentColor"
                                            d="M7.94 13.06a1.5 1.5 0 0 1 0-2.12l5.656-5.658a1.5 1.5 0 1 1 2.121 2.122L11.122 12l4.596 4.596a1.5 1.5 0 1 1-2.12 2.122l-5.66-5.658Z" />
                                    </g>
                                </svg>
                            </div>
                            <div class="trigger right">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <g fill="none" fill-rule="evenodd">
                                        <path
                                            d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                        <path fill="currentColor"
                                            d="M16.06 10.94a1.5 1.5 0 0 1 0 2.12l-5.656 5.658a1.5 1.5 0 1 1-2.121-2.122L12.879 12L8.283 7.404a1.5 1.5 0 0 1 2.12-2.122l5.658 5.657Z" />
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

        // convert nominal
        $(document).ready(function() {
            $('.koinasli').each(function() {
                var nilaiAsli = parseFloat($(this).text());
                var nilaiKonversi = nilaiAsli * 1000;
                var nilaiFormat = formatRupiah(nilaiKonversi);
                $(this).next('.cointorp').text(nilaiFormat);
            });

            function formatRupiah(nilai) {
                var bilangan = nilai.toString().replace(/[^,\d]/g, '');
                var bilanganSplit = bilangan.split(',');
                var sisa = bilanganSplit[0].length % 3;
                var rupiah = bilanganSplit[0].substr(0, sisa);
                var ribuan = bilanganSplit[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = bilanganSplit[1] !== undefined ? rupiah + ',' + bilanganSplit[1] : rupiah;
                return 'Rp' + rupiah;
            }
        });

        $(document).ready(function() {
            $('.hsjenisakun').each(function() {
                var status = $(this).data('statusakun');
                var text = '';

                switch (status) {
                    case 1:
                        text = 'default';
                        break;
                    case 2:
                        text = 'vvip';
                        break;
                    case 3:
                        text = 'bandar';
                        break;
                    case 4:
                        text = 'warning';
                        break;
                    case 5:
                        text = 'suspend';
                        break;
                    case 9:
                        text = 'new member';
                        break;
                    default:
                        text = 'unknown';
                        break;
                }

                $(this).text(text);
            });
        });
    </script>
@endsection
