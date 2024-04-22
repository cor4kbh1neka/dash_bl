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
                    <span class="titlebankmaster">LIST BANK MASTER</span>
                    <div class="groupactivebank">
                        <div class="listgroupbank">
                            <div class="grouptablebank">
                                <table>
                                    <tbody>
                                        <tr class="titlelistgroupbank">
                                            <th colspan="6" class="texttitle">LIST BANK</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <tbody>
                                        <tr class="thead">
                                            <th class="bknomor">#</th>
                                            <th class="bknama">nama bank</th>
                                            <th class="bkactionss">actions</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td class="tdnamabank">bca</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td class="tdnamabank">bni</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td class="tdnamabank">bri</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td class="tdnamabank">mandiri</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td class="tdnamabank">cimb</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td class="tdnamabank">danamon</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td>7</td>
                                            <td class="tdnamabank">panin</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td>8</td>
                                            <td class="tdnamabank">permata</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td>9</td>
                                            <td class="tdnamabank">bsi</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td>10</td>
                                            <td class="tdnamabank">dana</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td>11</td>
                                            <td class="tdnamabank">gopay</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td>12</td>
                                            <td class="tdnamabank">ovo</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td>13</td>
                                            <td class="tdnamabank">pulsa</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td>14</td>
                                            <td class="tdnamabank">linkaja</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                            <td>15</td>
                                            <td class="tdnamabank">qris</td>
                                            <td>
                                                <div class="kolom_action">
                                                    <div class="dot_action">
                                                        <span>•</span>
                                                        <span>•</span>
                                                        <span>•</span>
                                                    </div>
                                                    <div class="action_crud">
                                                        <a href="/bankds/setbankmaster">
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
                                    </tbody>
                                </table>
                            </div>
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