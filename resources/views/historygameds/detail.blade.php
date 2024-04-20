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
    <div class="body_openwindow">
        <div class="sec_openwindow">
            <div class="groupdetailhistorygameds">
                <div class="headdetailhistorygameds">
                    <div class="listheaddetail">
                        <span class="label">Nomor Invoice</span>
                        <span class="gap">:</span>
                        <span class="value refNo">4653610</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">Username</span>
                        <span class="gap">:</span>
                        <span class="value username">thanos989898</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">Date/Time Bet</span>
                        <span class="gap">:</span>
                        <span class="value orderTime">2024-04-17T08:55:58.703</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">Game Type</span>
                        <span class="gap">:</span>
                        <span class="value sportsType">Mix Parlay</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">Odds Bet</span>
                        <span class="gap">:</span>
                        <span class="value odds">5.147</span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">Nominal Bet(IDR)</span>
                        <span class="gap">:</span>
                        <span class="valuenominal stake" data-stake="10.000000"></span>
                    </div>
                    <div class="listheaddetail">
                        <span class="label">Win/Lose(IDR)</span>
                        <span class="gap">:</span>
                        <div class="grouphasilpertandingan">
                            <span class="valuenominal winLost" data-winLost="-10.000000"></span>
                            <span class="statusgame status" data-status="lose">lose</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table_detailhistorygameds">
                <table>
                    <tbody>
                        <tr>
                            <td class="bagnomor">1</td>
                            <td>
                                <div class="groupdetailmatch">
                                    <span class="namaliga subBet-league">e-Football F23 International Friendly</span>
                                    <span class="pertandingan subBet-match">e-Spain vs e-France</span>
                                    <div class="allscore">
                                        <div class="listscore">
                                            <span class="labelscore">HT</span>
                                            <span class="valuescore subBet-htScore">0:0</span>
                                        </div>
                                        <div class="listscore">
                                            <span class="labelscore">FT</span>
                                            <span class="valuescore subBet-ftScore">0:1</span>
                                        </div>
                                    </div>
                                    <span class="detailbetting">detail bet : <span class="htft isHalfWonLose" data-isHalfWonLose="false"></span></span>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">type :</span>
                                            <span class="valuebet subBet-marketType_sportType">Handicap (Football)</span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">odds :</span>
                                            <span class="valuebet subBet-odds" data-valueodds="1.46">1.46</span>
                                        </div>
                                    </div>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">pilihan :</span>
                                            <span class="valuebet subBet-betOption">e-Everton <span class="subBet-hdp" data-hdp="0.00">(0.00)</span></span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">status :</span>
                                            <span class="valuebet subBet status" data-statusbet="lose">lose</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="bagnomor">2</td>
                            <td>
                                <div class="groupdetailmatch">
                                    <span class="namaliga subBet-league">e-Football F23 Elite Club Friendly</span>
                                    <span class="pertandingan subBet-match">e-Liverpool vs e-Bayer Leverkusen</span>
                                    <div class="allscore">
                                        <div class="listscore">
                                            <span class="labelscore">HT</span>
                                            <span class="valuescore subBet-htScore">1:0</span>
                                        </div>
                                        <div class="listscore">
                                            <span class="labelscore">FT</span>
                                            <span class="valuescore subBet-ftScore">2:2</span>
                                        </div>
                                    </div>
                                    <span class="detailbetting">detail bet : <span class="htft isHalfWonLose" data-isHalfWonLose="false"></span></span>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">type :</span>
                                            <span class="valuebet subBet-marketType_sportType">Handicap (Football)</span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">odds :</span>
                                            <span class="valuebet subBet-odds" data-valueodds="1.56">1.56</span>
                                        </div>
                                    </div>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">pilihan :</span>
                                            <span class="valuebet subBet-betOption">e-Liverpool <span class="subBet-hdp" data-hdp="0.00">(0.00)</span></span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">status :</span>
                                            <span class="valuebet subBet status" data-statusbet="lose">lose</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="bagnomor">3</td>
                            <td>
                                <div class="groupdetailmatch">
                                    <span class="namaliga subBet-league">e-Football F23 Elite Club Friendly</span>
                                    <span class="pertandingan subBet-match">e-Ajax vs e-Bayer Leverkusen</span>
                                    <div class="allscore">
                                        <div class="listscore">
                                            <span class="labelscore">HT</span>
                                            <span class="valuescore subBet-htScore">1:1</span>
                                        </div>
                                        <div class="listscore">
                                            <span class="labelscore">FT</span>
                                            <span class="valuescore subBet-ftScore">1:4</span>
                                        </div>
                                    </div>
                                    <span class="detailbetting">detail bet : <span class="htft isHalfWonLose" data-isHalfWonLose="true"></span></span>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">type :</span>
                                            <span class="valuebet subBet-marketType_sportType">handicap (Football)</span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">odds :</span>
                                            <span class="valuebet subBet-odds" data-valueodds="2.26">2.26</span>
                                        </div>
                                    </div>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">pilihan :</span>
                                            <span class="valuebet subBet-betOption">e-Bayer Leverkusen <span class="subBet-hdp" data-hdp="-2.50">(-2.50)</span></span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">status :</span>
                                            <span class="valuebet subBet status" data-statusbet="won">won</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="bagnomor">4</td>
                            <td>
                                <div class="groupdetailmatch">
                                    <span class="namaliga subBet-league">e-Football F23 Elite Club Friendly</span>
                                    <span class="pertandingan subBet-match">e-Ajax vs e-Bayer Leverkusen</span>
                                    <div class="allscore">
                                        <div class="listscore">
                                            <span class="labelscore">HT</span>
                                            <span class="valuescore subBet-htScore">1:1</span>
                                        </div>
                                        <div class="listscore">
                                            <span class="labelscore">FT</span>
                                            <span class="valuescore subBet-ftScore">1:4</span>
                                        </div>
                                    </div>
                                    <span class="detailbetting">detail bet : <span class="htft isHalfWonLose" data-isHalfWonLose="true"></span></span>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">type :</span>
                                            <span class="valuebet subBet-marketType_sportType">Over/Under (Football)</span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">odds :</span>
                                            <span class="valuebet subBet-odds" data-valueodds="2.26">2.26</span>
                                        </div>
                                    </div>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">pilihan :</span>
                                            <span class="valuebet subBet-betOption">Over <span class="subBet-hdp" data-hdp="4.50">(4.50)</span></span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">status :</span>
                                            <span class="valuebet subBet status" data-statusbet="won">won</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="bagnomor">5</td>
                            <td>
                                <div class="groupdetailmatch">
                                    <span class="namaliga subBet-league">e-Football F23 Elite Club Friendly</span>
                                    <span class="pertandingan subBet-match">e-Ajax vs e-Bayer Leverkusen</span>
                                    <div class="allscore">
                                        <div class="listscore">
                                            <span class="labelscore">HT</span>
                                            <span class="valuescore subBet-htScore">1:1</span>
                                        </div>
                                        <div class="listscore">
                                            <span class="labelscore">FT</span>
                                            <span class="valuescore subBet-ftScore">1:4</span>
                                        </div>
                                    </div>
                                    <span class="detailbetting">detail bet : <span class="htft isHalfWonLose" data-isHalfWonLose="true"></span></span>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">type :</span>
                                            <span class="valuebet subBet-marketType_sportType">Over/Under (Football)</span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">odds :</span>
                                            <span class="valuebet subBet-odds" data-valueodds="2.26">2.26</span>
                                        </div>
                                    </div>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">pilihan :</span>
                                            <span class="valuebet subBet-betOption">Over <span class="subBet-hdp" data-hdp="4.50">(4.50)</span></span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">status :</span>
                                            <span class="valuebet subBet status" data-statusbet="won">won</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="bagnomor">6</td>
                            <td>
                                <div class="groupdetailmatch">
                                    <span class="namaliga subBet-league">e-Football F23 Elite Club Friendly</span>
                                    <span class="pertandingan subBet-match">e-Ajax vs e-Bayer Leverkusen</span>
                                    <div class="allscore">
                                        <div class="listscore">
                                            <span class="labelscore">HT</span>
                                            <span class="valuescore subBet-htScore">1:1</span>
                                        </div>
                                        <div class="listscore">
                                            <span class="labelscore">FT</span>
                                            <span class="valuescore subBet-ftScore">1:4</span>
                                        </div>
                                    </div>
                                    <span class="detailbetting">detail bet : <span class="htft isHalfWonLose" data-isHalfWonLose="true"></span></span>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">type :</span>
                                            <span class="valuebet subBet-marketType_sportType">Over/Under (Football)</span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">odds :</span>
                                            <span class="valuebet subBet-odds" data-valueodds="2.26">2.26</span>
                                        </div>
                                    </div>
                                    <div class="listdetailbettting">
                                        <div class="dddetailbetting">
                                            <span class="labelbet">pilihan :</span>
                                            <span class="valuebet subBet-betOption">Over <span class="subBet-hdp" data-hdp="4.50">(4.50)</span></span>
                                        </div>
                                        <div class="dddetailbetting">
                                            <span class="labelbet">status :</span>
                                            <span class="valuebet subBet status" data-statusbet="won">won</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        //format nominal odds dan stake
        $(document).ready(function() {
            $('div').each(function() {

                var odds = $(this).find('.valuenominal.odds').attr('data-odds');
                odds = (parseFloat(odds) * 10).toFixed(2);
                $(this).find('.valuenominal.odds').text(odds);

                var stake = $(this).find('.valuenominal.stake').attr('data-stake');
                stake = parseFloat(stake).toFixed(2);
                $(this).find('.valuenominal.stake').text(stake);

                var winLost = $(this).find('.valuenominal.winLost').attr('data-winLost');
                winLost = parseFloat(winLost).toFixed(2);

                if (winLost === "0.00") {
                    $(this).find('.valuenominal.winLost').text("-");
                } else {
                    $(this).find('.valuenominal.winLost').text(winLost);
                }
            });
        });

        //half time dan fulltime
        $(document).ready(function() {
            $(".htft").each(function() {
                var isHalfWonLose = $(this).attr("data-isHalfWonLose");

                if (isHalfWonLose === "true") {
                    $(this).text("Half Time");
                } else {
                    $(this).text("Full Time");
                }
            });
        });
    </script>