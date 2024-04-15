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
        <div class="secmanualds">
            <div class="groupsecmanualds">
                <form class="groupformmanual">
                    <div class="groupform head">
                        <label for="username">username</label>
                        <label for="saldo">saldo sekarang</label>
                        <label for="keterangan">keterangan</label>
                        <label for="jenis">jenis transaksi</label>
                        <label for="nominal">nominal</label>
                        <label for="button"></label>
                    </div>
                    <div class="groupform input">
                        <input type="text" name="username" id="username" placeholder="masukan username">
                        <input type="number" name="saldo" id="saldo" placeholder="-" disabled>
                        <input type="text" name="keterangan" id="keterangan" placeholder="masukan keterangan">
                        <select name="jenis" id="jenis">
                            <option value="" selected="" place="" style="color: #838383; font-style: italic;" disabled>Pilih Transaksi</option>
                            <option value="deposit">Deposit Manual</option>
                            <option value="witdraw">Withdraw Manual</option>
                        </select>
                        <input type="number" name="nominal" id="nominal" placeholder="masukan nominal">
                        <button class="tombol proses">
                            <span class="texttombol">PROSES</span>
                        </button>
                    </div>
                </form>
                <div class="groupnoted">
                    <div class="listcatatan">
                        <input type="checkbox" id="readCheckbox" name="readCheckbox">
                        <label for="readCheckbox">Pastikan data yang di masukan sudah VALID DAN SESUAI</label>
                    </div>
                    <div class="generatenominal">
                        <span class="textgenerate">Nominal yang akan di proses adalah</span>
                        <span class="nominalproses">Rp 0</span>
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

        $(document).ready(function(){
            $('input[name="nominal"]').on('input', function() {
                var nominal = $(this).val();
                if (nominal === '') {
                    $('.nominalproses').text('Rp 0');
                    return;
                }
                
                var nominalFloat = parseFloat(nominal.replace(/[^\d.-]/g, ''));
                if (!isNaN(nominalFloat)) {
                    var hasil = nominalFloat * 1000;
                    var hasilFormatted = 'Rp ' + hasil.toLocaleString('id-ID');
                    $('.nominalproses').text(hasilFormatted);
                } else {
                    $('.nominalproses').text('');
                }
            });
        });

    </script>
@endsection
