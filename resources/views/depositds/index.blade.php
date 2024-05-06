@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <div class="secgrouptitle">
            <h2>{{ $title }} </h2>
            <span class="countpendingdata">40</span>
            <div class="fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor" d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" />
                </svg>
            </div>
        </div>
        <div class="secdepositds">
            <div class="groupdatamaster">
                <div class="groupdeposittopbar">
                    <a href="/manualds" class="tombol proses">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20.7 7c-.3.4-.7.7-.7 1s.3.6.6 1c.5.5 1 .9.9 1.4c0 .5-.5 1-1 1.5L16.4 16L15 14.7l4.2-4.2l-1-1l-1.4 1.4L13 7.1l4-3.8c.4-.4 1-.4 1.4 0l2.3 2.3c.4.4.4 1.1 0 1.4M3 17.2l9.6-9.6l3.7 3.8L6.8 21H3zM7 2v3h3v2H7v3H5V7H2V5h3V2z" />
                        </svg>
                        <span class="texttombol">TRANSAKSI MANUAL</span>
                    </a>
                    <div class="groupbankproses">
                        <div class="listbankproses">
                            <input type="checkbox" id="bcaCheckbox" name="bcaCheckbox">
                            <label for="bcaCheckbox" data-pending="12">bca (12)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="bca1Checkbox" name="bca1Checkbox">
                            <label for="bca1Checkbox" data-pending="12">bca1 (2)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="bniCheckbox" name="bniCheckbox">
                            <label for="bniCheckbox" data-pending="0">bni (0)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="briCheckbox" name="briCheckbox">
                            <label for="briCheckbox" data-pending="0">bri (0)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="mandiriCheckbox" name="mandiriCheckbox">
                            <label for="mandiriCheckbox" data-pending="5">mandiri (5)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="cimbCheckbox" name="cimbCheckbox">
                            <label for="cimbCheckbox" data-pending="1">CIMB (1)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="danamonCheckbox" name="danamonCheckbox">
                            <label for="danamonCheckbox" data-pending="0">danamon (0)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="permataCheckbox" name="permataCheckbox">
                            <label for="permataCheckbox" data-pending="0">permata (0)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="paninCheckbox" name="paninCheckbox">
                            <label for="paninCheckbox" data-pending="0">panin (0)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="bsiCheckbox" name="bsiCheckbox">
                            <label for="bsiCheckbox" data-pending="0">bsi (0)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="danaCheckbox" name="danaCheckbox">
                            <label for="danaCheckbox" data-pending="20">dana (20)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="gopayCheckbox" name="gopayCheckbox">
                            <label for="gopayCheckbox" data-pending="0">gopay (0)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="ovoCheckbox" name="ovoCheckbox">
                            <label for="ovoCheckbox" data-pending="0">ovo (0)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="pulsaCheckbox" name="pulsaCheckbox">
                            <label for="pulsaCheckbox" data-pending="0">pulsa (0)</label>
                        </div>
                        <div class="listbankproses">
                            <input type="checkbox" id="linkajaCheckbox" name="linkajaCheckbox">
                            <label for="linkajaCheckbox" data-pending="0">linkaja (0)</label>
                        </div>
                    </div>
                </div>

                <div class="tabelproses">
                    <table>
                        <tbody>
                            <tr class="hdtable">
                                <th class="bagno">#</th>
                                <th class="check_box">
                                    <input type="checkbox" id="myCheckbox" name="myCheckbox">
                                </th>
                                <th class="baguser">Username</th>
                                <th class="bagtanggal">tanggal</th>
                                <th class="bagnominal">jumlah deposit</th>
                                <th>transfer dari</th>
                                <th class="bagnominal">saldo terakhir</th>
                                <th>diterima oleh</th>
                                <th class="bagketerangan">keterangan</th>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="4">1</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="suka ngibul">
                                        <span class="userpending">
                                            thanos9898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="1">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193536</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193535</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="9">2</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="2">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">3</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="3">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="4">4</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="suka spam form deposit">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="4">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">5</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="5">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">6</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="6">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">7</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="7">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">8</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="8">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">9</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="9">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">10</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="10">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">11</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="11">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">12</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="12">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">13</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="13">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">14</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailuser showmodal" data-modal="14">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="statusmember" data-status="1">15</div>
                                </td>
                                <td class="check_box" onclick="toggleCheckbox('myCheckbox-0')">
                                    <input type="checkbox" id="myCheckbox-0" name="myCheckbox-0" data-id=" c93a3488-cd97-4350-9835-0138e6a04aa9">
                                </td>
                                <td>
                                    <div class="splitcollum" title="">
                                        <span class="userpending">
                                            thanos989898
                                            <a href="/memberlistds/edit" class="iconprofile openviewport" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="datadetailusershowmodal" data-modal="15">Deposit</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td class="valuenominal">100,000,000</td>
                                <td class="valuebank">BRI, DAMIANUS PARSI, 472501058193537</td>
                                <td class="valuenominal">15,100,000</td>
                                <td class="valuebank">BRI, BAMBANG ASLI MANA GITU, 472501058193538</td>
                                <td>maksimal 20 karakter</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="groupbuttonproses">
                        <button class="tombol proses">
                            <span class="texttombol">PROSES</span>
                        </button>
                        <button class="tombol cancel">
                            <span class="texttombol">REJECT</span>
                        </button>
                    </div>
                </div>
                <div class="modalhistory" data-target="1">
                    <div class="secmodalhistory">
                        <span class="closetrigger">x</span>
                        <span class="titlemodalhistory">RIWAYAT DEPOSIT USER : thanos989898</span>
                        <table>
                            <tbody>
                                <tr class="hdtable">
                                    <th class="baguser">user</th>
                                    <th class="bagtanggal">tanggal</th>
                                    <th class="transfer">transfer dari</th>
                                    <th class="bagnominal">jumlah</th>
                                    <th>status</th>
                                </tr>
                                <tr>
                                    <td>thanos989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>thanos989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:08:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="cancel">Reject Deposit</td>
                                </tr>
                                <tr>
                                    <td>thanos989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Manual Deposit</td>
                                </tr>
                                <tr>
                                    <td>thanos989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>thanos989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>thanos989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>thanos989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:08:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="cancel">Reject Deposit</td>
                                </tr>
                                <tr>
                                    <td>thanos989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>thanos989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>thanos989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="informasihistorycoin">
                            <span>*data yang di tampilkan saat ini, selengkapnya di menu <a href="/historycoinds">history</a></span>
                        </div>
                    </div>
                </div>
                <div class="modalhistory" data-target="2">
                    <div class="secmodalhistory">
                        <span class="closetrigger">x</span>
                        <span class="titlemodalhistory">RIWAYAT DEPOSIT USER : lontong989898</span>
                        <table>
                            <tbody>
                                <tr class="hdtable">
                                    <th class="baguser">user</th>
                                    <th class="bagtanggal">tanggal</th>
                                    <th class="transfer">transfer dari</th>
                                    <th class="bagnominal">jumlah</th>
                                    <th>status</th>
                                </tr>
                                <tr>
                                    <td>lontong989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>lontong989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:08:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="cancel">Reject Deposit</td>
                                </tr>
                                <tr>
                                    <td>lontong989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Manual Deposit</td>
                                </tr>
                                <tr>
                                    <td>lontong989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>lontong989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>lontong989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>lontong989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:08:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="cancel">Reject Deposit</td>
                                </tr>
                                <tr>
                                    <td>lontong989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>lontong989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                                <tr>
                                    <td>lontong989898</td>
                                    <td class="hsjenistrans">2024-04-05 21:09:03</td>
                                    <td class="hsjenistrans">BRI, DAMIANUS PARSI, 472501058193536</td>
                                    <td>100,000</td>
                                    <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="informasihistorycoin">
                            <span>*data yang di tampilkan saat ini, selengkapnya di menu <a href="/historycoinds">history</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="groupdataside">
                <span class="toggleshowsidedata">
                    H
                    I
                    S
                    T
                    O
                    R
                    Y
                     
                    C
                    O
                    I
                    N
                </span>
                <div class="tabelhistory">
                    <table>
                        <tbody>
                            <tr class="hdtabtle">
                                <th class="hsusername">username</th>
                                <th>waktu</th>
                                <th>Nominal</th>
                                <th>Agent</th>
                                <th>Jenis Transaksi</th>
                            </tr>
                            <tr>
                                <td>thanos98</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos98</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="cancel">Reject Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Manual Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                            <tr>
                                <td>thanos989898</td>
                                <td>
                                    <div class="splitcollum">
                                        <span class="tanggal">2024-04-05 </span >
                                        <span class="waktu">21:09:03</span>
                                    </div>
                                </td>
                                <td>100,000</td>
                                <td>CSAG01</td>
                                <td class="hsjenistrans" data-proses="accept">Accept Deposit</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="informasihistorycoin">
                        <span>*data yang di tampilkan saat ini, selengkapnya di menu <a href="/historycoinds">history</a></span>
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

        //open jendela detail
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.6;
                var windowLeft = ($(window).width() - windowWidth) / 2.3;
                var windowTop = ($(window).height() - windowHeight) / 1.5;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + windowLeft + ", top=" + windowTop);
            });
        });
    </script>
@endsection
