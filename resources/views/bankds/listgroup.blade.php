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
                    <a href="/bankds/listgroup" class="tombol grey active">
                        <span class="texttombol">LIST GROUP</span>
                    </a>
                    <a href="/bankds/listbank" class="tombol grey">
                        <span class="texttombol">LIST BANK</span>
                    </a>
                    <a href="/bankds/xdata" class="tombol grey">
                        <span class="texttombol">X DATA</span>
                    </a>
                </div>
                <div class="secgroupdatabankds">
                    <span class="titlebankmaster">LIST GROUP BANK</span>
                    <div class="groupactivebank">
                        <div class="listgroupbank">
                            <div class="grouptablebank frinput">
                                <table>
                                    <tbody>
                                        <tr class="titlelistgroupbank">
                                            <th colspan="6" class="texttitle">DEPOSIT</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <tbody>
                                        <tr class="thead">
                                            <th class="bknomor">#</th>
                                            <th class="bknama">nama bank</th>
                                            <th class="xcount">xdeposit</th>
                                            <th class="check_box">
                                                <input type="checkbox" id="myCheckboxDeposit" name="myCheckboxDeposit">
                                            </th>
                                            <th class="bkactionss">actions</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td class="tdnamabank">groupdepo1</td>
                                            <td>
                                                <div class="inputtablebank">
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="mincount_grp1" value="0">
                                                        <label for="mincount_grp1" class="textparam">Minimal</label>
                                                    </div>
                                                    <div class="gapcount">-</div>
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="maxcount_grp1" value="10">
                                                        <label for="maxcount_grp1" class="textparam">Maksimal</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                <input type="checkbox" id="myCheckboxDeposit-0" name="myCheckboxDeposit-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setgroupbank">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                    </g>
                                                                </svg>
                                                                <span>Edit</span>
                                                            </div>
                                                        </a>
                                                        <a href="#" >
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>delete</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="tdnamabank">groupdepo2</td>
                                            <td>
                                                <div class="inputtablebank">
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="mincount_grp2" value="11">
                                                        <label for="mincount_grp2" class="textparam">Minimal</label>
                                                    </div>
                                                    <div class="gapcount">-</div>
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="maxcount_grp2" value="50">
                                                        <label for="maxcount_grp2" class="textparam">Maksimal</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                <input type="checkbox" id="myCheckboxDeposit-0" name="myCheckboxDeposit-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setgroupbank">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                    </g>
                                                                </svg>
                                                                <span>Edit</span>
                                                            </div>
                                                        </a>
                                                        <a href="#" >
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>delete</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="tdnamabank">groupdepo3</td>
                                            <td>
                                                <div class="inputtablebank">
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="mincount_grp3" value="51">
                                                        <label for="mincount_grp3" class="textparam">Minimal</label>
                                                    </div>
                                                    <div class="gapcount">-</div>
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="maxcount_grp3" value="100">
                                                        <label for="maxcount_grp3" class="textparam">Maksimal</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                <input type="checkbox" id="myCheckboxDeposit-0" name="myCheckboxDeposit-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setgroupbank">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                    </g>
                                                                </svg>
                                                                <span>Edit</span>
                                                            </div>
                                                        </a>
                                                        <a href="#" >
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>delete</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td class="tdnamabank">groupdepo4</td>
                                            <td>
                                                <div class="inputtablebank">
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="mincount_grp4" value="101">
                                                        <label for="mincount_grp4" class="textparam">Minimal</label>
                                                    </div>
                                                    <div class="gapcount">-</div>
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="maxcount_grp4" value="200">
                                                        <label for="maxcount_grp4" class="textparam">Maksimal</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                <input type="checkbox" id="myCheckboxDeposit-0" name="myCheckboxDeposit-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setgroupbank">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                    </g>
                                                                </svg>
                                                                <span>Edit</span>
                                                            </div>
                                                        </a>
                                                        <a href="#" >
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>delete</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td class="tdnamabank">groupdepo5</td>
                                            <td>
                                                <div class="inputtablebank">
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="mincount_grp5" value="201">
                                                        <label for="mincount_grp5" class="textparam">Minimal</label>
                                                    </div>
                                                    <div class="gapcount">-</div>
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="maxcount_grp5" value="500">
                                                        <label for="maxcount_grp5" class="textparam">Maksimal</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxDeposit-0')">
                                                <input type="checkbox" id="myCheckboxDeposit-0" name="myCheckboxDeposit-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setgroupbank">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                    </g>
                                                                </svg>
                                                                <span>Edit</span>
                                                            </div>
                                                        </a>
                                                        <a href="#" >
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>delete</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td class="tdnamabank">top level</td>
                                            <td>
                                                <div class="inputtablebank single">
                                                    <div class="listinputtablebank">
                                                        <input type="text" class="inputnew" id="toplevel" disabled value="∞">
                                                        <label for="toplevel" class="textparam">> dari count maksimal xdeposit</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box"></td>
                                            <td></td>
                                        </tr>
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
                                    </tbody>
                                </table>
                                <table>
                                    <tbody>
                                        <tr class="thead">
                                            <th class="bknomor">#</th>
                                            <th class="bknama">nama bank</th>
                                            <th class="xcount">xwithdraw</th>
                                            <th class="check_box">
                                                <input type="checkbox" id="myCheckboxWithdraw" name="myCheckboxWithdraw">
                                            </th>
                                            <th class="bkactionss">actions</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td class="tdnamabank">groupwd1</td>
                                            <td>
                                                <div class="inputtablebank">
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="mincount_grp1" value="0">
                                                        <label for="mincount_grp1" class="textparam">Minimal</label>
                                                    </div>
                                                    <div class="gapcount">-</div>
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="maxcount_grp1" value="10">
                                                        <label for="maxcount_grp1" class="textparam">Maksimal</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxWithdraw-0')">
                                                <input type="checkbox" id="myCheckboxWithdraw-0" name="myCheckboxWithdraw-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setgroupbank">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                    </g>
                                                                </svg>
                                                                <span>Edit</span>
                                                            </div>
                                                        </a>
                                                        <a href="#" >
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>delete</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="tdnamabank">groupwd2</td>
                                            <td>
                                                <div class="inputtablebank">
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="mincount_grp2" value="11">
                                                        <label for="mincount_grp2" class="textparam">Minimal</label>
                                                    </div>
                                                    <div class="gapcount">-</div>
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="maxcount_grp2" value="50">
                                                        <label for="maxcount_grp2" class="textparam">Maksimal</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxWithdraw-0')">
                                                <input type="checkbox" id="myCheckboxWithdraw-0" name="myCheckboxWithdraw-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setgroupbank">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                    </g>
                                                                </svg>
                                                                <span>Edit</span>
                                                            </div>
                                                        </a>
                                                        <a href="#" >
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>delete</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="tdnamabank">groupwd3</td>
                                            <td>
                                                <div class="inputtablebank">
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="mincount_grp3" value="51">
                                                        <label for="mincount_grp3" class="textparam">Minimal</label>
                                                    </div>
                                                    <div class="gapcount">-</div>
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="maxcount_grp3" value="100">
                                                        <label for="maxcount_grp3" class="textparam">Maksimal</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxWithdraw-0')">
                                                <input type="checkbox" id="myCheckboxWithdraw-0" name="myCheckboxWithdraw-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setgroupbank">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                    </g>
                                                                </svg>
                                                                <span>Edit</span>
                                                            </div>
                                                        </a>
                                                        <a href="#" >
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>delete</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td class="tdnamabank">groupwd4</td>
                                            <td>
                                                <div class="inputtablebank">
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="mincount_grp4" value="101">
                                                        <label for="mincount_grp4" class="textparam">Minimal</label>
                                                    </div>
                                                    <div class="gapcount">-</div>
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="maxcount_grp4" value="200">
                                                        <label for="maxcount_grp4" class="textparam">Maksimal</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxWithdraw-0')">
                                                <input type="checkbox" id="myCheckboxWithdraw-0" name="myCheckboxWithdraw-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setgroupbank">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                    </g>
                                                                </svg>
                                                                <span>Edit</span>
                                                            </div>
                                                        </a>
                                                        <a href="#" >
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>delete</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td class="tdnamabank">groupwd5</td>
                                            <td>
                                                <div class="inputtablebank">
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="mincount_grp5" value="201">
                                                        <label for="mincount_grp5" class="textparam">Minimal</label>
                                                    </div>
                                                    <div class="gapcount">-</div>
                                                    <div class="listinputtablebank">
                                                        <input type="number" class="inputnew" id="maxcount_grp5" value="500">
                                                        <label for="maxcount_grp5" class="textparam">Maksimal</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box" onclick="toggleCheckbox('myCheckboxWithdraw-0')">
                                                <input type="checkbox" id="myCheckboxWithdraw-0" name="myCheckboxWithdraw-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                            </td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setgroupbank">
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                                        <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                                                    </g>
                                                                </svg>
                                                                <span>Edit</span>
                                                            </div>
                                                        </a>
                                                        <a href="#" >
                                                            <div class="list_action">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                                                </svg>
                                                                <span>delete</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td class="tdnamabank">top level</td>
                                            <td>
                                                <div class="inputtablebank single">
                                                    <div class="listinputtablebank">
                                                        <input type="text" class="inputnew" id="toplevel" disabled value="∞">
                                                        <label for="toplevel" class="textparam">> dari count maksimal xwithdraw</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="check_box"></td>
                                            <td></td>
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
            $('#myCheckboxDeposit').change(function() {
                var isChecked = $(this).is(':checked');

                $('tbody tr:not([style="display: none;"]) [id^="myCheckboxDeposit-"]').prop('checked', isChecked);
            });
        });
        $(document).ready(function() {
            $('#myCheckboxDeposit, [id^="myCheckboxDeposit-"]').change(function() {
                var isChecked = $('#myCheckboxDeposit:checked, [id^="myCheckboxDeposit-"]:checked').length > 0;
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

                $('tbody tr:not([style="display: none;"]) [id^="myCheckboxWithdraw-"]').prop('checked', isChecked);
            });
        });
        $(document).ready(function() {
            $('#myCheckboxWithdraw, [id^="myCheckboxWithdraw-"]').change(function() {
                var isChecked = $('#myCheckboxWithdraw:checked, [id^="myCheckboxWithdraw-"]:checked').length > 0;
                if (isChecked) {
                    $('.all_act_butt').css('display', 'flex');
                } else {
                    $('.all_act_butt').hide();
                }
            });

        });

        // checked radio button berdasarkan value dari status bank 1, 2, 3
        $(document).ready(function(){
            $('tr[data-chekcedbank]').each(function(){
                var checkedBankValue = $(this).attr('data-chekcedbank');
                $(this).find('.listgrpstatusbank input[type="radio"][value="' + checkedBankValue + '"]').prop('checked', true);
            });
        });
    </script>
@endsection
