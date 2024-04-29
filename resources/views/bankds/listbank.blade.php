@extends('layouts.index')

@section('container')
    <!-- CSS SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- JavaScript SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
        <div class="secbankds">
            <div class="groupsecbankds">
                <div class="headsecbankds">
                    <a href="/bankds" class="tombol grey">
                        <span class="texttombol">ACTIVE BANK</span>
                    </a>
                    <a href="/bankds/addbankmaster" class="tombol grey">
                        <span class="texttombol">ADD & SET MASTER</span>
                    </a>
                    <a href="/bankds/addgroupbank" class="tombol grey">
                        <span class="texttombol">ADD & SET GROUP</span>
                    </a>
                    <a href="/bankds/addbank" class="tombol grey">
                        <span class="texttombol">ADD & SET BANK</span>
                    </a>
                    <a href="/bankds/listmaster" class="tombol grey">
                        <span class="texttombol">LIST MASTER</span>
                    </a>
                    <a href="/bankds/listgroup" class="tombol grey">
                        <span class="texttombol">LIST GROUP</span>
                    </a>
                    <a href="/bankds/listbank/0/0" class="tombol grey active">
                        <span class="texttombol">LIST BANK</span>
                    </a>
                    <a href="/bankds/xdata" class="tombol grey">
                        <span class="texttombol">X DATA</span>
                    </a>
                </div>
                <div class="secgroupdatabankds">
                    <span class="titlebankmaster">LIST REKENING BANK</span>
                    <div class="groupactivebank">
                        <div class="listgroupbank">
                            <div class="grouptablebank frinput">
                                <table>
                                    <tbody>
                                        <tr class="titlelistgroupbank">
                                            <th colspan="6" class="texttitle">DEPOSIT</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">
                                                <div class="listinputmember">
                                                    <select class="inputnew" name="groupbank" id="groupbank">
                                                        <option value="" selected="" place=""
                                                            style="color: #838383; font-style: italic;" disabled="">pilih
                                                            group</option>
                                                        @foreach ($listgroupdp as $bank => $d)
                                                            <option value="{{ $bank }}"
                                                                {{ $bank == $group ? 'selected' : '' }}>
                                                                {{ $bank }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </th>
                                            <th colspan="1">
                                                <button id="tambahKolom" class="tombol primary">
                                                    <span class="texttombol">+ tambah</span>
                                                </button>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table id="listbankTable">
                                    <tbody>
                                        <tr class="thead listbanksd">
                                            <th class="bknomor">#</th>
                                            <th class="bkmaster">master</th>
                                            <th class="bknamabank">nama bank</th>
                                            <th class="bknomorrek">nomor rekening</th>
                                            <th class="bknamarek">ganti bank</th>
                                            <th class="bkbarcode">barcode</th>
                                            <th class="check_box">
                                                <input type="checkbox" id="myCheckboxDeposit" name="myCheckboxDeposit">
                                            </th>
                                            <th class="bkactionss">actions</th>
                                        </tr>
                                        @foreach ($listbankdp as $group => $d)
                                            @foreach ($d as $bank => $dt)
                                                @foreach ($dt['data_bank'] as $dbank)
                                                    <tr id="listbankTable">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ strtoupper($bank) }}</td>
                                                        {{-- <td>
                                                            <div class="listinputmember">
                                                                <select class="inputnew smallfont" name="bankmaster"
                                                                    id="bankmaster_{{ $loop->iteration }}" data-jenis="1">
                                                                    @foreach ($listmasterbank as $d)
                                                                        <option value="{{ $d['bnkmstrxyxyx'] }}"
                                                                            {{ $d['bnkmstrxyxyx'] == $bank ? 'selected' : '' }}>
                                                                            {{ $d['bnkmstrxyxyx'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td> --}}
                                                        <td>
                                                            <div class="listinputmember">
                                                                <select class="inputnew smallfont">
                                                                    <option value="{{ $dbank['namebankxxyy'] }}">
                                                                        {{ $dbank['namebankxxyy'] }} -
                                                                        {{ $dbank['xynamarekx'] }} -
                                                                        {{ $dbank['norekxyxy'] }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="ceonorek">{{ $dbank['norekxyxy'] }}</td>

                                                        {{-- <td> {{ $dbank['bnkmstrxyxyx'] }} - {{ $dbank['namebankxxyy'] }}
                                                        </td> --}}
                                                        <td>
                                                            <div class="listinputmember">
                                                                <select class="inputnew smallfont" name="bankbaru"
                                                                    id="bankmaster_{{ $loop->iteration }}" data-jenis="1">
                                                                    @php $firstLoop = true; @endphp
                                                                    @foreach ($listbankex as $listbank)
                                                                        <option value="{{ $listbank }}"
                                                                            {{ $firstLoop ? 'selected' : '' }}>
                                                                            {{ $firstLoop ? 'pilih Bank' : $listbank }}
                                                                        </option>
                                                                        @php $firstLoop = false; @endphp
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>

                                                        {{-- <td>{{ $dbank['xynamarekx'] }}</td> --}}
                                                        <td class="check_box xurlbarcode">
                                                            <input type="checkbox" id="urlbarcode" name="urlbarcode"
                                                                data-barcode="{{ $dbank['zwzwshowbarcode'] ? '1' : '' }}"
                                                                disabled>
                                                        </td>
                                                        <td class="check_box"
                                                            onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                            <input type="checkbox" id="myCheckboxDeposit-0"
                                                                name="myCheckboxDeposit-0" data-id="">
                                                        </td>
                                                        <td>
                                                            <div class="kolom_action">
                                                                <div class="dot_action">
                                                                    <span>•</span>
                                                                    <span>•</span>
                                                                    <span>•</span>
                                                                </div>
                                                                <div class="action_crud">
                                                                    <a href="/bankds/setbank">
                                                                        <div class="list_action">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1em" height="1em"
                                                                                viewBox="0 0 24 24">
                                                                                <g fill="none" stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2">
                                                                                    <path
                                                                                        d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                                    <path
                                                                                        d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                                </g>
                                                                            </svg>
                                                                            <span>Edit</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="#">
                                                                        <div class="list_action">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1em" height="1em"
                                                                                viewBox="0 0 24 24">
                                                                                <path fill="currentColor"
                                                                                    d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                            </svg>
                                                                            <span>delete</span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <button class="tombol primary">
                                <span class="texttombol">UPDATE</span>
                            </button>
                        </div>

                        <div class="listgroupbank">
                            <div class="grouptablebank frinput">
                                <table>
                                    <tbody>
                                        <tr class="titlelistgroupbank">
                                            <th colspan="6" class="texttitle">WITHDRAW</th>
                                        </tr>
                                        <tr>
                                            <th colspan="6">
                                                <div class="listinputmember">
                                                    <select class="inputnew" name="groupbank" id="groupbankwd">
                                                        <option value="" selected="" place=""
                                                            style="color: #838383; font-style: italic;" disabled="">
                                                            pilih group
                                                        </option>
                                                        @foreach ($listgroupwd as $bank => $d)
                                                            <option value="{{ $bank }}"
                                                                {{ $bank == $groupwd ? 'selected' : '' }}>
                                                                {{ $bank }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <tbody>
                                        <tr class="thead listbanksd">
                                            <th class="bknomor">#</th>
                                            <th class="bkmaster">master</th>
                                            <th class="bknamabank">nama bank</th>
                                            <th class="bknamarek">nama rekening</th>
                                            <th class="bknomorrek">nomor rekening</th>
                                            <th class="bkbarcode">barcode</th>
                                            <th class="check_box">
                                                <input type="checkbox" id="myCheckboxWithdraw" name="myCheckboxWithdraw">
                                            </th>
                                            <th class="bkactionss">actions</th>
                                        </tr>
                                        @foreach ($listbankwd as $group => $d)
                                            @foreach ($d as $bank => $dt)
                                                @foreach ($dt['data_bank'] as $dbank)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <div class="listinputmember">
                                                                <select class="inputnew smallfont" name="bankmaster"
                                                                    id="bankmaster_{{ $loop->iteration }}"
                                                                    data-jenis="1">
                                                                    @foreach ($listmasterbank as $d)
                                                                        <option value="{{ $d['bnkmstrxyxyx'] }}"
                                                                            {{ $d['bnkmstrxyxyx'] == $bank ? 'selected' : '' }}>
                                                                            {{ $d['bnkmstrxyxyx'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </td>

                                                        <td>
                                                            <div class="listinputmember">
                                                                <select class="inputnew smallfont" name="namabank"
                                                                    id="namabank">
                                                                    {{-- @foreach ($dbank as $dtb)
                                                                        @dd($dtb) --}}
                                                                    <option id="pertama"
                                                                        value="{{ $dbank['namebankxxyy'] }}">
                                                                        {{ $dbank['namebankxxyy'] }}</option>
                                                                    {{-- @endforeach --}}
                                                                </select>
                                                            </div>

                                                        </td>
                                                        <td>florensia sitanggang</td>
                                                        <td class="ceonorek">03559178112</td>
                                                        <td class="check_box xurlbarcode">
                                                            <input type="checkbox" id="urlbarcode" name="urlbarcode"
                                                                data-barcode="" disabled>
                                                        </td>
                                                        <td class="check_box"
                                                            onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                            <input type="checkbox" id="myCheckboxDeposit-0"
                                                                name="myCheckboxDeposit-0" data-id="">
                                                        </td>
                                                        <td>
                                                            <div class="kolom_action">
                                                                <div class="dot_action">
                                                                    <span>•</span>
                                                                    <span>•</span>
                                                                    <span>•</span>
                                                                </div>
                                                                <div class="action_crud">
                                                                    <a href="/bankds/setbank">
                                                                        <div class="list_action">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1em" height="1em"
                                                                                viewBox="0 0 24 24">
                                                                                <g fill="none" stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2">
                                                                                    <path
                                                                                        d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                                    <path
                                                                                        d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                                </g>
                                                                            </svg>
                                                                            <span>Edit</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="#">
                                                                        <div class="list_action">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="1em" height="1em"
                                                                                viewBox="0 0 24 24">
                                                                                <path fill="currentColor"
                                                                                    d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                            </svg>
                                                                            <span>delete</span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button class="tombol primary">
                                <span class="texttombol">UPDATE</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#myCheckboxDeposit').change(function() {
                var isChecked = $(this).is(':checked');

                $('tbody tr:not([style="display: none;"]) [id^="myCheckboxDeposit-"]').prop('checked',
                    isChecked);
            });
        });
        $(document).ready(function() {
            $('#myCheckboxDeposit, [id^="myCheckboxDeposit-"]').change(function() {
                var isChecked = $('#myCheckboxDeposit:checked, [id^="myCheckboxDeposit-"]:checked').length >
                    0;
                if (isChecked) {
                    $('.all_act_butt').css('display', 'flex');
                } else {
                    $('.all_act_butt').hide();
                }
            });

        });

        $(document).ready(function() {
            $('#myCheckboxWithdraw').change(function() {
                var isChecked = $(this).is(':checked');

                $('tbody tr:not([style="display: none;"]) [id^="myCheckboxWithdraw-"]').prop('checked',
                    isChecked);
            });
        });
        $(document).ready(function() {
            $('#myCheckboxWithdraw, [id^="myCheckboxWithdraw-"]').change(function() {
                var isChecked = $('#myCheckboxWithdraw:checked, [id^="myCheckboxWithdraw-"]:checked')
                    .length > 0;
                if (isChecked) {
                    $('.all_act_butt').css('display', 'flex');
                } else {
                    $('.all_act_butt').hide();
                }
            });

        });

        // checked radio button berdasarkan value dari status bank 1, 2, 3
        $(document).ready(function() {
            $('tr[data-chekcedbank]').each(function() {
                var checkedBankValue = $(this).attr('data-chekcedbank');
                $(this).find('.listgrpstatusbank input[type="radio"][value="' + checkedBankValue + '"]')
                    .prop('checked', true);
            });
        });

        // url barcode ada maka checked
        $(document).ready(function() {
            $('input[type="checkbox"][data-barcode]').each(function() {
                var barcodeURL = $(this).data('barcode');
                if (barcodeURL) {
                    $(this).prop('checked', true);
                }
            });
        });

        // notifikasi show barcode
        $(document).ready(function() {
            $('.xurlbarcode').click(function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Mengubah data ini harus di kolom edit',
                    showConfirmButton: false,
                });
            });
        });

        //format value norek
        $(document).ready(function() {
            $('.ceonorek').each(function() {
                var nomorRekElement = $(this);
                var nomorRekValue = nomorRekElement.text();

                var formattedNomorRek = nomorRekValue.replace(/^(\d{3})(\d{4})(\d{4})$/, '$1-$2-$3');
                formattedNomorRek = formattedNomorRek.replace(/^(\d{3})(\d{4})(\d{4})(\d{4})$/,
                    '$1-$2-$3-$4');

                nomorRekElement.text(formattedNomorRek);
            });
        });

        $(document).ready(function() {
            $('#groupbank, #groupbankwd').change(function() {
                var selectedGroup = $('#groupbank').val();
                var selectBankWd = $('#groupbankwd').val();

                selectedGroup = selectedGroup == null || selectedGroup == '' ? '0' : selectedGroup;
                selectBankWd = selectBankWd == null || selectBankWd == '' ? '0' : selectBankWd;

                var redirectUrl = '/bankds/listbank/' + selectedGroup + '/' + selectBankWd;
                window.location.href = redirectUrl;
            });
        });

        $(document).ready(function() {
            $('select[name="bankmaster"]').change(function() {
                var selectedValue = $(this).val();
                var jenis = $(this).data('jenis');

                $.ajax({
                    url: '/getGroupBank/' + selectedValue + '/' + jenis,
                    type: 'GET',
                    success: function(response) {

                        var selectElement = $('#namabank');

                        $.each(response, function(index, item) {
                            selectElement.append($('<option>', {
                                value: item,
                                text: item
                            }));
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan saat melakukan permintaan GET.');
                    }
                });
            });
        });
    </script>


    <script>
        document.getElementById('tambahKolom').addEventListener('click', function() {
            var table = document.getElementById('listbankTable').getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();

            // Tambahkan kolom baru ke baris
            newRow.innerHTML = `
            <td>-</td>
            <td>Empty</td>
            <td>Empty</td>
            <td>Empty</td>
            <td>
                <div class="listinputmember">
                    <select class="inputnew smallfont" name="bankbaru"
                        id="bankbaru2" data-jenis="1">
                        @php $firstLoop = true; @endphp
                        @foreach ($listbankex as $listbank)
                            <option value="{{ $listbank }}"
                                {{ $firstLoop ? 'selected' : '' }}>
                                {{ $firstLoop ? 'pilih Bank' : $listbank }}
                            </option>
                            @php $firstLoop = false; @endphp
                        @endforeach
                    </select>
                </div>
            </td>
            <td class="check_box xurlbarcode">
                <input type="checkbox" id="urlbarcode" name="urlbarcode"
                    data-barcode="{{ $dbank['zwzwshowbarcode'] ? '1' : '' }}"
                    disabled>
            </td>
            <td class="check_box"
                onclick="toggleCheckbox('myCheckboxDeposit-0')">
                <input type="checkbox" id="myCheckboxDeposit-0"
                    name="myCheckboxDeposit-0" data-id="">
            </td>
            <td>
                <div class="kolom_action">
                    <div class="dot_action">
                        <span>•</span>
                        <span>•</span>
                        <span>•</span>
                    </div>
                    <div class="action_crud">
                        <a href="/bankds/setbank">
                            <div class="list_action">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2">
                                        <path
                                            d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                        <path
                                            d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                    </g>
                                </svg>
                                <span>Edit</span>
                            </div>
                        </a>
                        <a href="#">
                            <div class="list_action">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="1em" height="1em"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                </svg>
                                <span>delete</span>
                            </div>
                        </a>
                    </div>
                </div>
            </td>
        `;
        });
    </script>
@endsection
