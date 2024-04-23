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
                    <a href="/bankds/listmaster" class="tombol grey active">
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
                    <div class="groupactivebank">
                        <div class="listgroupbank">
                            <div class="grouptablebank">
                                <table>
                                    <tbody>
                                        <tr class="titlelistgroupbank">
                                            <th colspan="5" class="texttitle">DEPOSIT</th>
                                            <th class="bkadlist">
                                                <a href="/bankds/addbankmaster" class="addlist">
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
                                                </a>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <tbody>
                                        <tr class="thead">
                                            <th class="bknomor">#</th>
                                            <th class="bknama">nama bank</th>
                                            <th class="bkonline">online bank</th>
                                            <th class="bkonline">offline bank</th>
                                            <th class="bkonline">trouble bank</th>
                                            <th class="check_box">
                                                <input type="checkbox" id="myCheckboxDeposit" name="myCheckboxDeposit">
                                            </th>
                                        </tr>
                                        <tr data-chekcedbank="2" class="chekcedbank">
                                            <td>1</td>
                                            <td>
                                                <select id="depo_bca" name="depo_bca" value="bca">
                                                    <option value="bca" selected>bca</option>
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
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_online" type="radio" id="depo_online_bca" name="statusdepo_bca" value="1">
                                                    <label for="depo_online_bca">online</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_offline" type="radio" id="depo_offline_bca" name="statusdepo_bca" value="2">
                                                    <label for="depo_offline_bca">offline</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_trouble" type="radio" id="depo_trouble_bca" name="statusdepo_bca" value="3">
                                                    <label for="depo_trouble_bca">trouble</label>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                <input type="checkbox" id="myCheckboxDeposit-0" name="myCheckboxDeposit-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                        </tr>
                                        <tr data-chekcedbank="3" class="chekcedbank">
                                            <td>2</td>
                                            <td>
                                                <select id="depo_bni" name="depo_bni" value="bni">
                                                    <option value="bca">bca</option>
                                                    <option value="bni" selected>bni</option>
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
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_online" type="radio" id="depo_online_bni" name="statusdepo_bni" value="1">
                                                    <label for="depo_online_bni">online</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_offline" type="radio" id="depo_offline_bni" name="statusdepo_bni" value="2">
                                                    <label for="depo_offline_bni">offline</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_trouble" type="radio" id="depo_trouble_bni" name="statusdepo_bni" value="3">
                                                    <label for="depo_trouble_bni">trouble</label>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                <input type="checkbox" id="myCheckboxDeposit-0" name="myCheckboxDeposit-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                        </tr>
                                        <tr data-chekcedbank="1" class="chekcedbank">
                                            <td>3</td>
                                            <td>
                                                <select id="depo_bri" name="depo_bri" value="bri">
                                                    <option value="bca">bca</option>
                                                    <option value="bni">bni</option>
                                                    <option value="bri" selected>bri</option>
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
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_online" type="radio" id="depo_online_bri" name="statusdepo_bri" value="1">
                                                    <label for="depo_online_bri">online</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_offline" type="radio" id="depo_offline_bri" name="statusdepo_bri" value="2">
                                                    <label for="depo_offline_bri">offline</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_trouble" type="radio" id="depo_trouble_bri" name="statusdepo_bri" value="3">
                                                    <label for="depo_trouble_bri">trouble</label>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                <input type="checkbox" id="myCheckboxDeposit-0" name="myCheckboxDeposit-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                        </tr>
                                        <tr data-chekcedbank="1" class="chekcedbank">
                                            <td>4</td>
                                            <td>
                                                <select id="depo_mandiri" name="depo_mandiri" value="mandiri">
                                                    <option value="bca">bca</option>
                                                    <option value="bni">bni</option>
                                                    <option value="bri">bri</option>
                                                    <option value="mandiri" selected>mandiri</option>
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
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_online" type="radio" id="depo_online_mandiri" name="statusdepo_mandiri" value="1">
                                                    <label for="depo_online_mandiri">online</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_offline" type="radio" id="depo_offline_mandiri" name="statusdepo_mandiri" value="2">
                                                    <label for="depo_offline_mandiri">offline</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_trouble" type="radio" id="depo_trouble_mandiri" name="statusdepo_mandiri" value="3">
                                                    <label for="depo_trouble_mandiri">trouble</label>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                <input type="checkbox" id="myCheckboxDeposit-0" name="myCheckboxDeposit-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                        </tr>
                                        <tr data-chekcedbank="1" class="chekcedbank">
                                            <td>5</td>
                                            <td>
                                                <select id="depo_cimb" name="depo_cimb" value="cimb">
                                                    <option value="bca">bca</option>
                                                    <option value="bni">bni</option>
                                                    <option value="bri">bri</option>
                                                    <option value="mandiri">mandiri</option>
                                                    <option value="cimb" selected>cimb</option>
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
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_online" type="radio" id="depo_online_cimb" name="statusdepo_cimb" value="1">
                                                    <label for="depo_online_cimb">online</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_offline" type="radio" id="depo_offline_cimb" name="statusdepo_cimb" value="2">
                                                    <label for="depo_offline_cimb">offline</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_trouble" type="radio" id="depo_trouble_cimb" name="statusdepo_cimb" value="3">
                                                    <label for="depo_trouble_cimb">trouble</label>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                <input type="checkbox" id="myCheckboxDeposit-0" name="myCheckboxDeposit-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="tombol primary">
                                <span class="texttombol">UPDATE</span>
                            </button>
                        </div>

                        <div class="listgroupbank">
                            <div class="grouptablebank">
                                <table>
                                    <tbody>
                                        <tr class="titlelistgroupbank">
                                            <th colspan="5" class="texttitle">WITHDRAW</th>
                                            <th class="bkadlist">
                                                <a href="/bankds/addbankmaster" class="addlist">
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
                                                </a>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <tbody>
                                        <tr class="thead">
                                            <th class="bknomor">#</th>
                                            <th class="bknama">nama bank</th>
                                            <th class="bkonline">online bank</th>
                                            <th class="bkonline">offline bank</th>
                                            <th class="bkonline">trouble bank</th>
                                            <th class="check_box">
                                                <input type="checkbox" id="myCheckboxWithdraw" name="myCheckboxWithdraw">
                                            </th>
                                        </tr>
                                        <tr data-chekcedbank="1" class="chekcedbank">
                                            <td>1</td>
                                            <td>
                                                <select id="wd_bca" name="wd_bca" value="bca">
                                                    <option value="bca" selected>bca</option>
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
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_online" type="radio" id="wd_online_bca" name="statuswd_bca" value="1">
                                                    <label for="wd_online_bca">online</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_offline" type="radio" id="wd_offline_bca" name="statuswd_bca" value="2">
                                                    <label for="wd_offline_bca">offline</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_trouble" type="radio" id="wd_trouble_bca" name="statuswd_bca" value="3">
                                                    <label for="wd_trouble_bca">trouble</label>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxWithdraw-0')">
                                                <input type="checkbox" id="myCheckboxWithdraw-0" name="myCheckboxWithdraw-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                        </tr>
                                        <tr data-chekcedbank="1" class="chekcedbank">
                                            <td>2</td>
                                            <td>
                                                <select id="wd_bni" name="wd_bni" value="bni">
                                                    <option value="bca">bca</option>
                                                    <option value="bni" selected>bni</option>
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
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_online" type="radio" id="wd_online_bni" name="statuswd_bni" value="1">
                                                    <label for="wd_online_bni">online</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_offline" type="radio" id="wd_offline_bni" name="statuswd_bni" value="2">
                                                    <label for="wd_offline_bni">offline</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_trouble" type="radio" id="wd_trouble_bni" name="statuswd_bni" value="3">
                                                    <label for="wd_trouble_bni">trouble</label>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxWithdraw-0')">
                                                <input type="checkbox" id="myCheckboxWithdraw-0" name="myCheckboxWithdraw-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                        </tr>
                                        <tr data-chekcedbank="1" class="chekcedbank">
                                            <td>3</td>
                                            <td>
                                                <select id="wd_bri" name="wd_bri" value="bri">
                                                    <option value="bca">bca</option>
                                                    <option value="bni">bni</option>
                                                    <option value="bri" selected>bri</option>
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
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_online" type="radio" id="wd_online_bri" name="statuswd_bri" value="1">
                                                    <label for="wd_online_bri">online</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_offline" type="radio" id="wd_offline_bri" name="statuswd_bri" value="2">
                                                    <label for="wd_offline_bri">offline</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_trouble" type="radio" id="wd_trouble_bri" name="statuswd_bri" value="3">
                                                    <label for="wd_trouble_bri">trouble</label>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxWithdraw-0')">
                                                <input type="checkbox" id="myCheckboxWithdraw-0" name="myCheckboxWithdraw-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                        </tr>
                                        <tr data-chekcedbank="2" class="chekcedbank">
                                            <td>4</td>
                                            <td>
                                                <select id="wd_mandiri" name="wd_mandiri" value="mandiri">
                                                    <option value="bca">bca</option>
                                                    <option value="bni">bni</option>
                                                    <option value="bri">bri</option>
                                                    <option value="mandiri" selected>mandiri</option>
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
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_online" type="radio" id="wd_online_mandiri" name="statuswd_mandiri" value="1">
                                                    <label for="wd_online_mandiri">online</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_offline" type="radio" id="wd_offline_mandiri" name="statuswd_mandiri" value="2">
                                                    <label for="wd_offline_mandiri">offline</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_trouble" type="radio" id="wd_trouble_mandiri" name="statuswd_mandiri" value="3">
                                                    <label for="wd_trouble_mandiri">trouble</label>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxWithdraw-0')">
                                                <input type="checkbox" id="myCheckboxWithdraw-0" name="myCheckboxWithdraw-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                        </tr>
                                        <tr data-chekcedbank="3" class="chekcedbank">
                                            <td>5</td>
                                            <td>
                                                <select id="wd_cimb" name="wd_cimb" value="cimb">
                                                    <option value="bca">bca</option>
                                                    <option value="bni">bni</option>
                                                    <option value="bri">bri</option>
                                                    <option value="mandiri">mandiri</option>
                                                    <option value="cimb" selected>cimb</option>
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
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_online" type="radio" id="wd_online_cimb" name="statuswd_cimb" value="1">
                                                    <label for="wd_online_cimb">online</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_offline" type="radio" id="wd_offline_cimb" name="statuswd_cimb" value="2">
                                                    <label for="wd_offline_cimb">offline</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="listgrpstatusbank">
                                                    <input class="status_trouble" type="radio" id="wd_trouble_cimb" name="statuswd_cimb" value="3">
                                                    <label for="wd_trouble_cimb">trouble</label>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxWithdraw-0')">
                                                <input type="checkbox" id="myCheckboxWithdraw-0" name="myCheckboxWithdraw-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                        </tr>
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
