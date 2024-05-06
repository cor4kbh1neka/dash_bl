@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
            <span class="countpendingdata">{{ $totalBankcounts }}</span>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secdepositds">
            <div class="groupdatamaster">
                <div class="groupdeposittopbar">
                    <a href="/manualds" class="tombol proses">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M20.7 7c-.3.4-.7.7-.7 1s.3.6.6 1c.5.5 1 .9.9 1.4c0 .5-.5 1-1 1.5L16.4 16L15 14.7l4.2-4.2l-1-1l-1.4 1.4L13 7.1l4-3.8c.4-.4 1-.4 1.4 0l2.3 2.3c.4.4.4 1.1 0 1.4M3 17.2l9.6-9.6l3.7 3.8L6.8 21H3zM7 2v3h3v2H7v3H5V7H2V5h3V2z" />
                        </svg>
                        <span class="texttombol">TRANSAKSI MANUAL</span>
                    </a>
                    <div class="groupbankproses">
                        <div class="listbankproses">
                            <input type="checkbox" id="bcaCheckbox" name="bcaCheckbox">
                            <label for="bcaCheckbox" data-pending="{{ $bca }}">bca ({{ $bca }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="bca1Checkbox" name="bca1Checkbox">
                            <label for="bca1Checkbox" data-pending="{{ $bca1 }}">bca1 ({{ $bca1 }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="bniCheckbox" name="bniCheckbox">
                            <label for="bniCheckbox" data-pending="{{ $bni }}">bni ({{ $bni }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="briCheckbox" name="briCheckbox">
                            <label for="briCheckbox" data-pending="{{ $bri }}">bri ({{ $bri }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="mandiriCheckbox" name="mandiriCheckbox">
                            <label for="mandiriCheckbox" data-pending="{{ $mandiri }}">mandiri
                                ({{ $mandiri }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="cimbCheckbox" name="cimbCheckbox">
                            <label for="cimbCheckbox" data-pending="{{ $cimb }}">CIMB
                                ({{ $cimb }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="danamonCheckbox" name="danamonCheckbox">
                            <label for="danamonCheckbox" data-pending="{{ $danamon }}">danamon
                                ({{ $danamon }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="permataCheckbox" name="permataCheckbox">
                            <label for="permataCheckbox" data-pending="{{ $permata }}">permata
                                ({{ $permata }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="paninCheckbox" name="paninCheckbox">
                            <label for="paninCheckbox" data-pending="{{ $panin }}">panin
                                ({{ $panin }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="bsiCheckbox" name="bsiCheckbox">
                            <label for="bsiCheckbox" data-pending="{{ $bsi }}">bsi ({{ $bsi }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="danaCheckbox" name="danaCheckbox">
                            <label for="danaCheckbox" data-pending="{{ $dana }}">dana
                                ({{ $dana }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="gopayCheckbox" name="gopayCheckbox">
                            <label for="gopayCheckbox" data-pending="{{ $gopay }}">gopay
                                ({{ $gopay }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="ovoCheckbox" name="ovoCheckbox">
                            <label for="ovoCheckbox" data-pending="{{ $ovo }}">ovo ({{ $ovo }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="pulsaCheckbox" name="pulsaCheckbox">
                            <label for="pulsaCheckbox" data-pending="{{ $pulsa }}">pulsa
                                ({{ $pulsa }})</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="linkajaCheckbox" name="linkajaCheckbox">
                            <label for="linkajaCheckbox" data-pending="{{ $linkaja }}">linkaja
                                ({{ $linkaja }})</label>
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
                                <th class="bagtanggal">tanggal</th>
                                <th class="bagnominal">jumlah Withdraw</th>
                                <th class="bagnominal">Sisa Saldo</th>
                                <th>Transfer ke</th>
                            </tr>

                            {{-- @foreach ($data as $i => $d)
                                <tr data-bank="{{ $d->bank }}">
                                    <td>
                                        <div class="statusmember" data-status="{{ $d->statususer }}">{{ $i + 1 }}
                                        </div>
                                    </td>
                                    <td class="check_box">
                                        <input type="checkbox" id="myCheckbox-{{ $i }}"
                                            name="myCheckbox-{{ $i }}" data-id=" {{ $d->id }}">
                                    </td>
                                    <td>
                                        <div class="splitcollum" title="{{ $d->ketmember }}">
                                            <span class="userpending">{{ $d->username }}</span>
                                            <span class="datadetailuser showmodal" data-modal="1"
                                                data-username="{{ $d->username }}" data-jenis="WD">Withdraw</span>
                                        </div>
                                    </td>
                                    <td class="splitcollum">
                                        <div class="splitcollum">
                                            <span class="tanggal">{{ $d->date }} </span>
                                            <span class="waktu">{{ $d->time }}</span>
                                        </div>
                                    </td>
                                    <td class="valuenominal">{{ $d->amount }}</td>
                                    <td class="valuenominal">{{ $d->balance }}</td>
                                    <td>{{ $d->mbank }}, {{ $d->mnamarek }}, {{ $d->mnorek }}</td>
                                </tr>
                            @endforeach --}}

                            @foreach ($data as $i => $d)
                                <tr data-bank="{{ $d->bank }}">
                                    <td>
                                        <div class="statusmember" data-status="{{ $d->statususer }}">{{ $i + 1 }}
                                        </div>
                                    </td>
                                    <td class="check_box" onclick="toggleCheckbox('myCheckbox-{{ $i }}')">
                                        <input type="checkbox" id="myCheckbox-{{ $i }}"
                                            name="myCheckbox-{{ $i }}" data-id="{{ $d->id }}">
                                    </td>
                                    <td>
                                        <div class="splitcollum" title="{{ $d->ketmember }}">
                                            <span class="userpending">
                                                {{ $d->username }}
                                                <a href="/memberlistds/edit/{{ $d->username }}"
                                                    class="iconprofile openviewport" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                    </svg>
                                                </a>
                                            </span>
                                            <span class="datadetailuser showmodal" data-modal="1"
                                                data-username="{{ $d->username }}" data-jenis="WD">Withdraw</span>
                                        </div>
                                    </td>
                                    <td class="splitcollum">
                                        <div class="splitcollum">
                                            <span class="tanggal">{{ $d->date }} </span>
                                            <span class="waktu">{{ $d->time }}</span>
                                        </div>
                                    </td>
                                    <td class="valuenominal">{{ $d->amount }}</td>
                                    <td class="valuenominal">{{ $d->balance }}</td>
                                    <td class="valuebank">{{ $d->mbank }}, {{ $d->mnamarek }}, {{ $d->mnorek }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="groupbuttonproses">
                        <button class="tombol proses" id="approve">
                            <span class="texttombol">PROSES</span>
                        </button>
                        <button class="tombol cancel" id="reject">
                            <span class="texttombol">REJECT</span>
                        </button>
                    </div>
                </div>
                <div class="modalhistory" data-target="1">
                    <div class="secmodalhistory">
                        <span class="closetrigger">x</span>
                        <span class="titlemodalhistory">RIWAYAT WITHDRAW USER : thanos989898</span>
                        <table id="dataTableHistory">
                            <tbody>
                                <tr class="hdtable">
                                    <th class="baguser">user</th>
                                    <th class="bagtanggal">tanggal</th>
                                    <th class="transfer">transfer dari</th>
                                    <th class="bagnominal">jumlah</th>
                                    <th>status</th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="informasihistorycoin">
                            <span>*data yang di tampilkan saat ini, selengkapnya di menu <a
                                    href="/historyds">history</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="groupdataside">
                <span class="toggleshowsidedata">
                    H
                    I
                    S
                    T
                    O
                    R
                    Y

                    C
                    O
                    I
                    N
                </span>
                <div class="tabelhistory">
                    <table>
                        <tbody>
                            <tr class="hdtabtle">
                                <th class="hsusername">username</th>
                                <th>waktu</th>
                                <th>Nominal</th>
                                <th>Agent</th>
                                <th>Jenis Transaksi</th>
                            </tr>
                            @foreach ($dataTransaksi as $dataTrans)
                                <tr>
                                    <td>{{ $dataTrans->username }}</td>
                                    <td>
                                        <div class="splitcollum">
                                            <span class="tanggal">{{ $dataTrans->date }} </span>
                                            <span class="waktu">{{ $dataTrans->time }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $dataTrans->amount }}</td>
                                    <td>{{ $dataTrans->approved_by }}</td>
                                    <td class="hsjenistrans" data-proses="{{ $dataTrans->status }}">
                                        {{ ucfirst($dataTrans->status) }} Deposit</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="informasihistorycoin">
                        <<<<<<< HEAD <span>*data yang di tampilkan saat ini, selengkapnya di menu <a
                                href="/historycoinds">history</a></span>
                            =======
                            <span>*data yang di tampilkan saat ini, selengkapnya di menu <a
                                    href="/historyds">history</a></span>
                            >>>>>>> staging
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

            $('#myCheckbox, [id^="myCheckbox-"]').change(function() {
                var isChecked = $('#myCheckbox:checked, [id^="myCheckbox-"]:checked').length > 0;
                if (isChecked) {
                    $('.all_act_butt').css('display', 'flex');
                } else {
                    $('.all_act_butt').hide();
                }
            });

            $(document).on('click', '#approve', function(event) {
                event.preventDefault();

                var approveButton = $(this);
                if (approveButton.prop('disabled')) {
                    return;
                }

                approveButton.prop('disabled', true);

                var checkedValues = [];
                $('input[id^="myCheckbox-"]:checked').each(function() {
                    var value = $(this).data('id');
                    checkedValues.push(value);
                });

                if (checkedValues.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Silahkan centang list diatas terlebih dahulu!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    approveButton.prop('disabled', false);
                    return;
                }

                var parameterString = $.param({
                    'values[]': checkedValues
                }, true);
                var url = "/approve";

                Swal.fire({
                    title: 'ACCEPT',
                    text: "Apakah Anda yakin ingin meng-accept data ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Accept!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: checkedValues
                            },
                            success: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil di-accept!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    window.location.href = "/depositds/WD";
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat meng-accept data.'
                                });
                            },
                            complete: function() {
                                approveButton.prop('disabled', false);
                            }
                        });
                    } else {
                        approveButton.prop('disabled', false);
                    }
                });
            });

            $(document).on('click', '#reject', function(event) {
                event.preventDefault();

                var approveButton = $(this);
                approveButton.prop('disabled', true);

                var checkedValues = [];
                $('input[id^="myCheckbox-"]:checked').each(function() {
                    var value = $(this).data('id');
                    checkedValues.push(value);
                });

                if (checkedValues.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Silahkan centang list diatas terlebih dahulu!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    approveButton.prop('disabled', false);
                    return;
                }

                var parameterString = $.param({
                    'values[]': checkedValues
                }, true);
                var url =
                    "/reject";

                Swal.fire({
                    title: 'REJECT',
                    text: "Apakah Anda yakin ingin me-reject data ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Reject!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: checkedValues
                            },
                            success: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil di-reject!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    window.location.href = "/depositds/WD";
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat meng-accept data.'
                                });
                            },
                            complete: function() {
                                approveButton.prop('disabled', false);
                            }
                        });
                    } else {
                        approveButton.prop('disabled', false);
                    }
                });
            });
        });
        //open jendela detail
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.6;
                var windowLeft = ($(window).width() - windowWidth) / 2.1;
                var windowTop = ($(window).height() - windowHeight) / 1.5;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" +
                    windowLeft + ", top=" + windowTop);
            });
        });
    </script>
@endsection
