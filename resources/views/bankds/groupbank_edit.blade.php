@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }}</h2>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor" d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
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
                    <a href="/bankds/addgroupbank" class="tombol grey active">
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
                    <a href="/bankds/listbank" class="tombol grey">
                        <span class="texttombol">LIST BANK</span>
                    </a>
                </div>
                <div class="secgroupdatabankds">
                    <div class="groupsetbankmaster">
                        <span class="titlebankmaster">Edit group Bank</span>
                        <div class="groupplayerinfo">
                            <div class="listgroupplayerinfo left">
                                <div class="listplayerinfo">
                                    <label for="groupbank">group</label>
                                    <div class="groupeditinput">
                                        <select id="groupbank" name="groupbank" value="groupdepo1">
                                            <option value="groupdepo1">groupdepo1</option>
                                            <option value="groupdepo2">groupdepo2</option>
                                            <option value="groupdepo3">groupdepo3</option>
                                            <option value="groupdepo4">groupdepo4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <span class="labelbetpl">GROUP TYPE</span>
                                    <div class="groupradiooption" data-chekced="1">
                                        <div class="listgrpstatusbank">
                                            <input class="status_primary" type="radio" id="deposit" name="group_type" value="1">
                                            <label for="deposit">deposit</label>
                                        </div>
                                        <div class="listgrpstatusbank">
                                            <input class="status_primary" type="radio" id="withdraw" name="group_type" value="2">
                                            <label for="withdraw">withdraw</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="groupbank">minimal deposit</label>
                                    <div class="groupeditinput">
                                        <input type="text" readonly id="mindepo" name="mindepo" value="10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="groupbank">maksimal deposit</label>
                                    <div class="groupeditinput">
                                        <input type="text" readonly id="maxdepo" name="maxdepo" value="100000">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="groupbank">minimal withdraw</label>
                                    <div class="groupeditinput">
                                        <input type="text" readonly id="minwd" name="minwd" value="30">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="listplayerinfo">
                                    <label for="groupbank">maksimal withdraw</label>
                                    <div class="groupeditinput">
                                        <input type="text" readonly id="maxwd" name="maxwd" value="100000">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83l3.75 3.75z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="listgroupplayerinfo right">
                                <a href="/bankds/addgroupbank" class="tombol proses">
                                    <span class="texttombol">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                            <defs>
                                                <mask id="ipSAdd0">
                                                    <g fill="none" stroke-linejoin="round" stroke-width="4">
                                                        <rect width="36" height="36" x="6" y="6" fill="#fff" stroke="#fff" rx="3" />
                                                        <path stroke="#000" stroke-linecap="round" d="M24 16v16m-8-8h16" />
                                                    </g>
                                                </mask>
                                            </defs>
                                            <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSAdd0)" />
                                        </svg>
                                        GROUP BANK
                                    </span>
                                </a>
                                <button class="tombol primary">
                                    <span class="texttombol">SAVE DATA</span>
                                </button>
                            </div>
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

        // clear readonly
        $(document).ready(function() {
            $('.groupeditinput svg').click(function() {
                $(this).closest('.groupeditinput').toggleClass('edit');
                $(this).siblings('input').prop('readonly', function(_, val) {
                    return !val;
                });
            });
        });

        // checked radio button berdasarkan value dari status bank 1, 2, 3
        $(document).ready(function(){
            $('.groupradiooption[data-chekced]').each(function(){
                var checkedBankValue = $(this).attr('data-chekced');
                $(this).find('.listgrpstatusbank input[type="radio"][value="' + checkedBankValue + '"]').prop('checked', true);
            });
        });

        // dropdown selected
        $(document).ready(function(){
        var selectedValue = $('#groupbank').val();
        $('#groupbank option[value="' + selectedValue + '"]').attr('selected', 'selected');
    });
    </script>
@endsection
