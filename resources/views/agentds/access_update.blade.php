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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>

    <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script>
</head>
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
        </div>
        <div class="seceditmemberds updateagent">
            <span class="titlebankmaster">leader-access</span>
            <div class="groupseceditmemberds">
                <div class="groupplayerinfo">
                    <div class="listgroupplayerinfo left">
                        <div class="listplayerinfo">
                            <label for="agentname">access type name</label>
                            <div class="groupeditinput">
                                <input type="text" id="agentname" name="agentname" value="leader-access" readonly placeholder="masukkan nama access type">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <spann class="titleeditmemberds">transaction</spann>
                <div class="groupplayerinfo">
                    <div class="listgroupplayerinfo">
                        <div class="grouplistaccess">
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="deposit" name="deposit" value="1">
                                </div>
                                <label for="deposit">view deposit</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="withdraw" name="withdraw" value="1">
                                </div>
                                <label for="withdraw">view withdraw</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="manualtransaction" name="manualtransaction" value="1">
                                </div>
                                <label for="manualtransaction">view manual transaction</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="manualtransaction" name="manualtransaction" value="1">
                                </div>
                                <label for="transaction history">view transaction history</label>
                            </div>
                        </div>
                    </div>
                </div>
                <spann class="titleeditmemberds">data</spann>
                <div class="groupplayerinfo">
                    <div class="listgroupplayerinfo">
                        <div class="grouplistaccess">
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="memberlist" name="memberlist" value="1">
                                </div>
                                <label for="memberlist">view member list</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="referral" name="referral" value="1">
                                </div>
                                <label for="referral">view referral</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="historygame" name="historygame" value="1">
                                </div>
                                <label for="historygame">view history game</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="memberoutstanding" name="memberoutstanding" value="1">
                                </div>
                                <label for="memberoutstanding">view member outstanding</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="report" name="report" value="1">
                                </div>
                                <label for="report">view report</label>
                            </div>
                        </div>
                    </div>
                </div>
                <spann class="titleeditmemberds">general config</spann>
                <div class="groupplayerinfo">
                    <div class="listgroupplayerinfo">
                        <div class="grouplistaccess">
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="bank" name="bank" value="1">
                                </div>
                                <label for="bank">view bank</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="memo" name="memo" value="1">
                                </div>
                                <label for="memo">view memo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <spann class="titleeditmemberds">config admin</spann>
                <div class="groupplayerinfo">
                    <div class="listgroupplayerinfo">
                        <div class="grouplistaccess">
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="agent" name="agent" value="1">
                                </div>
                                <label for="agent">view agent</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="events" name="events" value="1">
                                </div>
                                <label for="events">view events</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="apksettings" name="apksettings" value="1">
                                </div>
                                <label for="apksettings">view apk settings</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="allowedip" name="allowedip" value="1">
                                </div>
                                <label for="allowedip">view allowed IP</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="memouser" name="memouser" value="1">
                                </div>
                                <label for="memouser">memo to other user</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="listgroupplayerinfo right">
                    <button class="tombol primary">
                        <span class="texttombol">SAVE DATA</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.groupeditinput svg').click(function() {
                $(this).closest('.groupeditinput').toggleClass('edit');
                $(this).siblings('input').prop('readonly', function(_, val) {
                    return !val;
                });
            });
        });

        //checked checkbox
        $(document).ready(function(){
            if ($('.check_box input').val() === '1') {
                $('.check_box input').prop('checked', true);
            }
        });
    </script>