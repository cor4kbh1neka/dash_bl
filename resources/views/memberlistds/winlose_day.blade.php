<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/utama/g21-icon.ico') }}" />
    <title>Dashboard | L21</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/design.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/custom_dash.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script>
</head>
<div class="body_openwindow datawinlose">
    <div class="sec_openwindow">
        <div class="table_detailhistorygameds">
            <span class="titlewinloseuser">W/L - {{ $username }}</span>
            <a href="/memberlistds/winlosemonth/{{ $username }}/{{ $year }}" class="cctkembali">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                    <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"
                        d="M44 40.836c-4.893-5.973-9.238-9.362-13.036-10.168c-3.797-.805-7.412-.927-10.846-.365V41L4 23.545L20.118 7v10.167c6.349.05 11.746 2.328 16.192 6.833c4.445 4.505 7.009 10.117 7.69 16.836Z"
                        clip-rule="evenodd" />
                </svg>
                <span class="cctextkembali">kembali</span>
            </a>
            <table>
                <tbody>
                    <tr>
                        <th class="bagxdate">date</th>
                        <th class="bagdeposit">deposit (IDR)</th>
                        <th class="bagwithdraw">withdraw (IDR)</th>
                        <th class="bagwinlose">W/L (IDR)</th>
                    </tr>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->day }}({{ date('M', mktime(0, 0, 0, $d->month, 1)) }})</td>
                            <td class="deposit nominal" data-value="{{ $d->deposit }}"></td>
                            <td class="withdraw nominal" data-value="{{ $d->withdraw }}"></td>
                            <td class="total nominal" data-value=""></td>
                        </tr>
                    @endforeach
                    <tr class="ccsubtotal">
                        <th class="bagtotal">total</th>
                        <th class="subdeposit nominal" data-value=""></th>
                        <th class="subwithdraw nominal" data-value=""></th>
                        <th class="subtotal nominal" data-value=""></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // print nilai statusdeposit
    $(document).ready(function() {
        var countdownValue = $('.statusdepo').attr('data-countdownline');
        var jenisGames = getUrlParameter('games');
        var statusValue = getUrlParameter('statusdp');
        var tanggalFrom = getUrlParameter('datefrom');
        var tanggalTo = getUrlParameter('dateto');
        var combinedValue = countdownValue;
        $('.jenisgames').text(jenisGames);
        $('.statusdepo').text(combinedValue);
        $('.textdepo').text(statusValue);
        $('.tangfrom').text(tanggalFrom);
        $('.tangto').text(tanggalTo);

        if (statusValue.toLowerCase() === 'all') {
            $('.jumlahdownline').remove();
        }
    });

    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        if (results === null) {
            return '';
        } else {
            var value = decodeURIComponent(results[1].replace(/\+/g, ' '));
            return value.split('?')[0];
        }
    }

    $(document).ready(function() {
        // Format nominal
        $(".nominal").each(function() {
            var nominal = $(this).attr("data-value");
            var formattedNominal = parseFloat(nominal).toLocaleString('en', {
                maximumFractionDigits: 2
            });
            $(this).text(formattedNominal);
        });

        // Hitung winlose untuk setiap baris
        $("tr").each(function() {
            var depositValue = parseFloat($(this).find(".deposit").attr("data-value"));
            var withdrawValue = parseFloat($(this).find(".withdraw").attr("data-value"));
            var totalValue = depositValue - withdrawValue;
            $(this).find(".total").attr("data-value", totalValue);
            $(this).find(".total").text(totalValue.toLocaleString('en', {
                maximumFractionDigits: 2
            }));
        });

        // Jumlahkan semua nilai deposit
        var totalDeposit = 0;
        $(".deposit").each(function() {
            totalDeposit += parseFloat($(this).attr("data-value"));
        });
        $(".subdeposit").attr("data-value", totalDeposit);
        $(".subdeposit").text(totalDeposit.toLocaleString('en', {
            maximumFractionDigits: 2
        }));

        // Jumlahkan semua nilai withdraw
        var totalWithdraw = 0;
        $(".withdraw").each(function() {
            totalWithdraw += parseFloat($(this).attr("data-value"));
        });
        $(".subwithdraw").attr("data-value", totalWithdraw);
        $(".subwithdraw").text(totalWithdraw.toLocaleString('en', {
            maximumFractionDigits: 2
        }));

        // Jumlahkan semua nilai total
        var totalTotal = 0;
        $(".total").each(function() {
            totalTotal += parseFloat($(this).attr("data-value"));
        });
        $(".subtotal").attr("data-value", totalTotal);
        $(".subtotal").text(totalTotal.toLocaleString('en', {
            maximumFractionDigits: 2
        }));
    });
</script>
