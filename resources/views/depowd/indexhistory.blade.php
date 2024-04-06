@extends('layouts.index')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/themes/prism.css">
    <div class="sec_table">
        <h2>{{ $title }}</h2>
        <div class="group_act_butt">

        </div>
        <table>
            <tbody>
                <tr class="head_table">
                    <th>Jenis</th>
                    <th>Username</th>
                    <th>Bank</th>
                    <th>Nama Rek</th>
                    <th>No.Rek</th>
                    <th>Ket</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Approved By</th>
                    {{-- <th>Action</th> --}}
                </tr>
                <tr class="filter_row">
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td></td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                    <td>
                        <div class="grubsearchtable">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                            <input type="text" placeholder="Cari data..." id="searchData-name">
                        </div>
                    </td>
                </tr>

                @foreach ($data as $index => $d)
                    <tr>
                        <td><span class="name">
                                @php
                                    if ($d->jenis === 'DP') {
                                        echo '<h3>Deposit</h3>';
                                    } elseif ($d->jenis === 'WD') {
                                        echo '<h3>Withdrawal</h3>';
                                    } elseif ($d->jenis === 'DPM') {
                                        echo '<h3>Manual Deposit</h3>';
                                    } elseif ($d->jenis === 'WDM') {
                                        echo '<h3>Manual Withdrawal</h3>';
                                    }
                                @endphp
                            </span></td>
                        <td><span class="name">{{ $d->username }}</span></td>
                        <td><span class="name">{{ $d->mbank == '' ? '-' : $d->mbank }}</span></td>
                        <td><span class="name">{{ $d->mnamarek == '' ? '-' : $d->mnamarek }}</span></td>
                        <td><span class="name">{{ $d->mnorek == '' ? '-' : $d->mnorek }}</span></td>
                        <td><span class="name">{{ $d->keterangan == '' ? '-' : $d->keterangan }}</span></td>
                        <td><span class="name">
                                @php
                                    if ($d->status === 0) {
                                        echo '<button class="sec_botton btn_secondary" onclick="salinTeks("voucher24837_AOtx8urR5r")">WAITING</button>';
                                    } elseif ($d->status === 1) {
                                        echo '<button class="sec_botton btn_success" onclick="salinTeks("voucher24837_AOtx8urR5r")">ACCEPT</button>';
                                    } else {
                                        echo '<button class="sec_botton btn_danger" onclick="salinTeks("voucher24837_AOtx8urR5r")">CANCEL</button>';
                                    }
                                @endphp</span></td>

                        <td><span class="name">{{ number_format($d->amount, 3, ',', '.') }}</span></td>
                        <td><span class="name">
                                {{ $d->approved_by == '' ? '-' : $d->approved_by }}</br>
                                ({{ date('d-m-Y H:i:s', strtotime($d->updated_at)) }})
                            </span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
