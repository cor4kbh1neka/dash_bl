@extends('layouts.index')

@section('container')
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
                    <a href="/bankds/listbank" class="tombol grey">
                        <span class="texttombol">LIST BANK</span>
                    </a>
                    <a href="/bankds/xdata" class="tombol grey active">
                        <span class="texttombol">X DATA</span>
                    </a>
                </div>
                <div class="secgroupdatabankds">
                    <div class="groupsetbankmaster">
                        <div class="grouphistoryds memberlist">
                            <div class="groupheadhistoryds">
                                <div class="listmembergroup">
                                    <div class="listinputmember">
                                        <label for="username">
                                            username
                                            <div class="check_box">
                                                <input type="checkbox" id="checkusername" name="checkusername">
                                            </div>
                                        </label>
                                        <input type="text" id="username" name="username" placeholder="username">
                                    </div>
                                    <div class="listinputmember">
                                        <label for="typexdata">type x data</label>
                                        <select id="typexdata" name="typexdata">
                                            <option value="xdeposit">xdeposit</option>
                                            <option value="xwithdraw">xwithdraw</option>
                                        </select>
                                    </div>
                                    <div class="listinputmember">
                                        <label for="gabungdari">
                                            tanggal dari
                                            <div class="check_box">
                                                <input type="checkbox" id="checktgldari" name="checktgldari">
                                            </div>
                                        </label>
                                        <input type="date" id="gabungdari" name="gabungdari"
                                            placeholder="tanggal gabung dari">
                                    </div>
                                    <div class="listinputmember">
                                        <label for="gabunghingga">
                                            tanggal hingga
                                            <div class="check_box">
                                                <input type="checkbox" id="checktglhingga" name="checktglhingga">
                                            </div>
                                        </label>
                                        <input type="date" id="gabunghingga" name="tanggal gabung hingga"
                                            placeholder="nama rekening">
                                    </div>
                                    <div class="listinputmember">
                                        <label for="xmincount">
                                            x data minimal
                                            <div class="check_box">
                                                <input type="checkbox" id="checkxmincount" name="checkxmincount">
                                            </div>
                                        </label>
                                        <input type="number" id="xmincount" name="xmincount" placeholder="x data minimal">
                                    </div>
                                    <div class="listinputmember">
                                        <label for="xmaxcount">
                                            x data maksimal
                                            <div class="check_box">
                                                <input type="checkbox" id="checkxmaxcount" name="checkxmaxcount">
                                            </div>
                                        </label>
                                        <input type="number" id="xmaxcount" name="xmaxcount" placeholder="x data maksimal">
                                    </div>
                                    <div class="listinputmember">
                                        <label for="status">
                                            bank
                                            <div class="check_box">
                                                <input type="checkbox" id="checkbank" name="checkbank">
                                            </div>
                                        </label>
                                        <select id="bank" name="bank">
                                            <option value="bca">bca</option>
                                            <option value="bni">bni</option>
                                            <option value="bri">bri</option>
                                            <option value="mandiri">mandiri</option>
                                            <option value="cimb">cimb</option>
                                            <option value="danamon">danamon</option>
                                            <option value="panin">panin</option>
                                            <option value="cimb">cimb</option>
                                            <option value="permata">permata</option>
                                            <option value="bsi">bsi</option>
                                            <option value="dana">dana</option>
                                            <option value="gopay">gopay</option>
                                            <option value="ovo">ovo</option>
                                            <option value="pulsa">pulsa</option>
                                            <option value="linkaja">linkaja</option>
                                            <option value="qris">qris</option>
                                        </select>
                                    </div>
                                    <div class="listinputmember">
                                        <button class="tombol primary">
                                            <span class="texttombol">SUBMIT</span>
                                        </button>
                                    </div>
                                    <div class="exportdata">
                                        <span class="textdownload">download</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="totalcountxdata">
                                hasil <span class="countxdata">120</span> users dari total <span
                                    class="totaluser">12000</span> users aktif
                            </div>
                            <div class="tabelproses">
                                <table>
                                    <tbody>
                                        <tr class="hdtable">
                                            <th class="bagno">#</th>
                                            <th class="baguser">Username</th>
                                            <th class="bagbalance">balance (IDR)</th>
                                            <th class="bagtanggal">register date</th>
                                            <th class="bagbankgroup">bank group</th>
                                            <th class="bagxdata">x data</th>
                                            <th class="bagbank">bank</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>thanos98</td>
                                            <td>1,269.35</td>
                                            <td>2024-04-05 21:09:03</td>
                                            <td>groupbankdepo1</td>
                                            <td>10</td>
                                            <td>bca</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>thanos98</td>
                                            <td>1,269.35</td>
                                            <td>2024-04-05 21:09:03</td>
                                            <td>groupbankdepo1</td>
                                            <td>10</td>
                                            <td>bca</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>thanos98</td>
                                            <td>1,269.35</td>
                                            <td>2024-04-05 21:09:03</td>
                                            <td>groupbankdepo1</td>
                                            <td>10</td>
                                            <td>bca</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>thanos98</td>
                                            <td>1,269.35</td>
                                            <td>2024-04-05 21:09:03</td>
                                            <td>groupbankdepo1</td>
                                            <td>10</td>
                                            <td>bca</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>thanos98</td>
                                            <td>1,269.35</td>
                                            <td>2024-04-05 21:09:03</td>
                                            <td>groupbankdepo1</td>
                                            <td>10</td>
                                            <td>bca</td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>thanos98</td>
                                            <td>1,269.35</td>
                                            <td>2024-04-05 21:09:03</td>
                                            <td>groupbankdepo1</td>
                                            <td>10</td>
                                            <td>bca</td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>thanos98</td>
                                            <td>1,269.35</td>
                                            <td>2024-04-05 21:09:03</td>
                                            <td>groupbankdepo1</td>
                                            <td>10</td>
                                            <td>bca</td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>thanos98</td>
                                            <td>1,269.35</td>
                                            <td>2024-04-05 21:09:03</td>
                                            <td>groupbankdepo1</td>
                                            <td>10</td>
                                            <td>bca</td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>thanos98</td>
                                            <td>1,269.35</td>
                                            <td>2024-04-05 21:09:03</td>
                                            <td>groupbankdepo1</td>
                                            <td>10</td>
                                            <td>bca</td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>thanos98</td>
                                            <td>1,269.35</td>
                                            <td>2024-04-05 21:09:03</td>
                                            <td>groupbankdepo1</td>
                                            <td>10</td>
                                            <td>bca</td>
                                        </tr>
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
    </script>
@endsection
