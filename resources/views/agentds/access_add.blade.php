@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
            <div class="kembali">
                <a href="/agentds/access">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                        <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4" d="M44 40.836c-4.893-5.973-9.238-9.362-13.036-10.168c-3.797-.805-7.412-.927-10.846-.365V41L4 23.545L20.118 7v10.167c6.349.05 11.746 2.328 16.192 6.833c4.445 4.505 7.009 10.117 7.69 16.836Z" clip-rule="evenodd" />
                    </svg>
                    <span class="textkembali">Kembali</span>
                </a>
            </div>
        </div>
        <div class="seceditmemberds updateagent addagent">
            <div class="groupseceditmemberds">
            <div class="groupplayerinfo">
                    <div class="listgroupplayerinfo left small">
                        <div class="listplayerinfo">
                            <label for="agentname">access type name</label>
                            <div class="groupeditinput">
                                <input type="text" id="agentname" name="agentname" value="" placeholder="masukkan nama access type">
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
                                    <input type="checkbox" id="deposit" name="deposit" value="">
                                </div>
                                <label for="deposit">view deposit</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="withdraw" name="withdraw" value="">
                                </div>
                                <label for="withdraw">view withdraw</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="manualtransaction" name="manualtransaction" value="">
                                </div>
                                <label for="manualtransaction">view manual transaction</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="manualtransaction" name="manualtransaction" value="">
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
                                    <input type="checkbox" id="memberlist" name="memberlist" value="">
                                </div>
                                <label for="memberlist">view member list</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="referral" name="referral" value="">
                                </div>
                                <label for="referral">view referral</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="historygame" name="historygame" value="">
                                </div>
                                <label for="historygame">view history game</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="memberoutstanding" name="memberoutstanding" value="">
                                </div>
                                <label for="memberoutstanding">view member outstanding</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="report" name="report" value="">
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
                                    <input type="checkbox" id="bank" name="bank" value="">
                                </div>
                                <label for="bank">view bank</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="memo" name="memo" value="">
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
                                    <input type="checkbox" id="agent" name="agent" value="">
                                </div>
                                <label for="agent">view agent</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="events" name="events" value="">
                                </div>
                                <label for="events">view events</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="apksettings" name="apksettings" value="">
                                </div>
                                <label for="apksettings">view apk settings</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="allowedip" name="allowedip" value="">
                                </div>
                                <label for="allowedip">view allowed IP</label>
                            </div>
                            <div class="listaccess">
                                <div class="check_box">
                                    <input type="checkbox" id="memouser" name="memouser" value="">
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

@endsection