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
                    <a href="/bankds/listbank" class="tombol grey active">
                        <span class="texttombol">LIST BANK</span>
                    </a>
                </div>
                <div class="secgroupdatabankds">
                    ini hasil data
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
