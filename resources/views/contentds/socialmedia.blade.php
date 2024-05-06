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
        <div class="seccontentds">
            <div class="groupseccontentds">
                <div class="headseccontentds">
                    <a href="/contentds" class="tombol grey">
                        <span class="texttombol">GENERAL</span>
                    </a>
                    <a href="/contentds/promo" class="tombol grey">
                        <span class="texttombol">PROMO</span>
                    </a>
                    <a href="/contentds/slider" class="tombol grey">
                        <span class="texttombol">SLIDER</span>
                    </a>
                    <a href="/contentds/link" class="tombol grey">
                        <span class="texttombol">LINK</span>
                    </a>
                    <a href="/contentds/socialmedia" class="tombol grey active">
                        <span class="texttombol">SOCIAL MEDIA</span>
                    </a>
                </div>
                <div class="groupdatasecagentds">
                    <div class="tabelproses slider">
                        <table id="sortable-table">
                            <tbody>
                                <tr class="hdtable">
                                    <th class="bagno">#</th>
                                    <th class="bagiconmedia">icon media</th>
                                    <th class="bagtitle">name</th>
                                    <th class="bagurltarget">url target</th>
                                    <th class="bagstatus">status</th>
                                    <th class="action">tools</th>
                                </tr>
                                <tr class="dinamicrow">
                                    <td>
                                        <div class="statuspromorow slider">1</div>
                                    </td>
                                    <td class="iconmedia">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 258">
                                            <defs>
                                                <linearGradient id="logosWhatsappIcon0" x1="50%" x2="50%" y1="100%" y2="0%">
                                                    <stop offset="0%" stop-color="#1faf38" />
                                                    <stop offset="100%" stop-color="#60d669" />
                                                </linearGradient>
                                                <linearGradient id="logosWhatsappIcon1" x1="50%" x2="50%" y1="100%" y2="0%">
                                                    <stop offset="0%" stop-color="#f9f9f9" />
                                                    <stop offset="100%" stop-color="#fff" />
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#logosWhatsappIcon0)" d="M5.463 127.456c-.006 21.677 5.658 42.843 16.428 61.499L4.433 252.697l65.232-17.104a122.994 122.994 0 0 0 58.8 14.97h.054c67.815 0 123.018-55.183 123.047-123.01c.013-32.867-12.775-63.773-36.009-87.025c-23.23-23.25-54.125-36.061-87.043-36.076c-67.823 0-123.022 55.18-123.05 123.004" />
                                            <path fill="url(#logosWhatsappIcon1)" d="M1.07 127.416c-.007 22.457 5.86 44.38 17.014 63.704L0 257.147l67.571-17.717c18.618 10.151 39.58 15.503 60.91 15.511h.055c70.248 0 127.434-57.168 127.464-127.423c.012-34.048-13.236-66.065-37.3-90.15C194.633 13.286 162.633.014 128.536 0C58.276 0 1.099 57.16 1.071 127.416m40.24 60.376l-2.523-4.005c-10.606-16.864-16.204-36.352-16.196-56.363C22.614 69.029 70.138 21.52 128.576 21.52c28.3.012 54.896 11.044 74.9 31.06c20.003 20.018 31.01 46.628 31.003 74.93c-.026 58.395-47.551 105.91-105.943 105.91h-.042c-19.013-.01-37.66-5.116-53.922-14.765l-3.87-2.295l-40.098 10.513z" />
                                            <path fill="#fff" d="M96.678 74.148c-2.386-5.303-4.897-5.41-7.166-5.503c-1.858-.08-3.982-.074-6.104-.074c-2.124 0-5.575.799-8.492 3.984c-2.92 3.188-11.148 10.892-11.148 26.561c0 15.67 11.413 30.813 13.004 32.94c1.593 2.123 22.033 35.307 54.405 48.073c26.904 10.609 32.379 8.499 38.218 7.967c5.84-.53 18.844-7.702 21.497-15.139c2.655-7.436 2.655-13.81 1.859-15.142c-.796-1.327-2.92-2.124-6.105-3.716c-3.186-1.593-18.844-9.298-21.763-10.361c-2.92-1.062-5.043-1.592-7.167 1.597c-2.124 3.184-8.223 10.356-10.082 12.48c-1.857 2.129-3.716 2.394-6.9.801c-3.187-1.598-13.444-4.957-25.613-15.806c-9.468-8.442-15.86-18.867-17.718-22.056c-1.858-3.184-.199-4.91 1.398-6.497c1.431-1.427 3.186-3.719 4.78-5.578c1.588-1.86 2.118-3.187 3.18-5.311c1.063-2.126.531-3.986-.264-5.579c-.798-1.593-6.987-17.343-9.819-23.64" />
                                        </svg>
                                    </td>
                                    <td class="datamini">whatsapp 1</td>
                                    <td class="datamini">https://wa.me/628123456789</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/socialmedia/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow">
                                    <td>
                                        <div class="statuspromorow slider">2</div>
                                    </td>
                                    <td class="iconmedia">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 258">
                                            <defs>
                                                <linearGradient id="logosWhatsappIcon0" x1="50%" x2="50%" y1="100%" y2="0%">
                                                    <stop offset="0%" stop-color="#1faf38" />
                                                    <stop offset="100%" stop-color="#60d669" />
                                                </linearGradient>
                                                <linearGradient id="logosWhatsappIcon1" x1="50%" x2="50%" y1="100%" y2="0%">
                                                    <stop offset="0%" stop-color="#f9f9f9" />
                                                    <stop offset="100%" stop-color="#fff" />
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#logosWhatsappIcon0)" d="M5.463 127.456c-.006 21.677 5.658 42.843 16.428 61.499L4.433 252.697l65.232-17.104a122.994 122.994 0 0 0 58.8 14.97h.054c67.815 0 123.018-55.183 123.047-123.01c.013-32.867-12.775-63.773-36.009-87.025c-23.23-23.25-54.125-36.061-87.043-36.076c-67.823 0-123.022 55.18-123.05 123.004" />
                                            <path fill="url(#logosWhatsappIcon1)" d="M1.07 127.416c-.007 22.457 5.86 44.38 17.014 63.704L0 257.147l67.571-17.717c18.618 10.151 39.58 15.503 60.91 15.511h.055c70.248 0 127.434-57.168 127.464-127.423c.012-34.048-13.236-66.065-37.3-90.15C194.633 13.286 162.633.014 128.536 0C58.276 0 1.099 57.16 1.071 127.416m40.24 60.376l-2.523-4.005c-10.606-16.864-16.204-36.352-16.196-56.363C22.614 69.029 70.138 21.52 128.576 21.52c28.3.012 54.896 11.044 74.9 31.06c20.003 20.018 31.01 46.628 31.003 74.93c-.026 58.395-47.551 105.91-105.943 105.91h-.042c-19.013-.01-37.66-5.116-53.922-14.765l-3.87-2.295l-40.098 10.513z" />
                                            <path fill="#fff" d="M96.678 74.148c-2.386-5.303-4.897-5.41-7.166-5.503c-1.858-.08-3.982-.074-6.104-.074c-2.124 0-5.575.799-8.492 3.984c-2.92 3.188-11.148 10.892-11.148 26.561c0 15.67 11.413 30.813 13.004 32.94c1.593 2.123 22.033 35.307 54.405 48.073c26.904 10.609 32.379 8.499 38.218 7.967c5.84-.53 18.844-7.702 21.497-15.139c2.655-7.436 2.655-13.81 1.859-15.142c-.796-1.327-2.92-2.124-6.105-3.716c-3.186-1.593-18.844-9.298-21.763-10.361c-2.92-1.062-5.043-1.592-7.167 1.597c-2.124 3.184-8.223 10.356-10.082 12.48c-1.857 2.129-3.716 2.394-6.9.801c-3.187-1.598-13.444-4.957-25.613-15.806c-9.468-8.442-15.86-18.867-17.718-22.056c-1.858-3.184-.199-4.91 1.398-6.497c1.431-1.427 3.186-3.719 4.78-5.578c1.588-1.86 2.118-3.187 3.18-5.311c1.063-2.126.531-3.986-.264-5.579c-.798-1.593-6.987-17.343-9.819-23.64" />
                                        </svg>
                                    </td>
                                    <td class="datamini">whatsapp 2</td>
                                    <td class="datamini">https://wa.me/628123456789</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/socialmedia/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow">
                                    <td>
                                        <div class="statuspromorow slider">3</div>
                                    </td>
                                    <td class="iconmedia">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
                                            <defs>
                                                <linearGradient id="logosTelegram0" x1="50%" x2="50%" y1="0%" y2="100%">
                                                    <stop offset="0%" stop-color="#2aabee" />
                                                    <stop offset="100%" stop-color="#229ed9" />
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#logosTelegram0)" d="M128 0C94.06 0 61.48 13.494 37.5 37.49A128.038 128.038 0 0 0 0 128c0 33.934 13.5 66.514 37.5 90.51C61.48 242.506 94.06 256 128 256s66.52-13.494 90.5-37.49c24-23.996 37.5-56.576 37.5-90.51c0-33.934-13.5-66.514-37.5-90.51C194.52 13.494 161.94 0 128 0" />
                                            <path fill="#fff" d="M57.94 126.648c37.32-16.256 62.2-26.974 74.64-32.152c35.56-14.786 42.94-17.354 47.76-17.441c1.06-.017 3.42.245 4.96 1.49c1.28 1.05 1.64 2.47 1.82 3.467c.16.996.38 3.266.2 5.038c-1.92 20.24-10.26 69.356-14.5 92.026c-1.78 9.592-5.32 12.808-8.74 13.122c-7.44.684-13.08-4.912-20.28-9.63c-11.26-7.386-17.62-11.982-28.56-19.188c-12.64-8.328-4.44-12.906 2.76-20.386c1.88-1.958 34.64-31.748 35.26-34.45c.08-.338.16-1.598-.6-2.262c-.74-.666-1.84-.438-2.64-.258c-1.14.256-19.12 12.152-54 35.686c-5.1 3.508-9.72 5.218-13.88 5.128c-4.56-.098-13.36-2.584-19.9-4.708c-8-2.606-14.38-3.984-13.82-8.41c.28-2.304 3.46-4.662 9.52-7.072" />
                                        </svg>
                                    </td>
                                    <td class="datamini">telegram</td>
                                    <td class="datamini">https://t.me/083232326598</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/socialmedia/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow">
                                    <td>
                                        <div class="statuspromorow slider">4</div>
                                    </td>
                                    <td class="iconmedia">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                            <path fill="#41f71d" d="M311 196.8v81.3c0 2.1-1.6 3.7-3.7 3.7h-13c-1.3 0-2.4-.7-3-1.5L254 230v48.2c0 2.1-1.6 3.7-3.7 3.7h-13c-2.1 0-3.7-1.6-3.7-3.7v-81.3c0-2.1 1.6-3.7 3.7-3.7h12.9c1.1 0 2.4.6 3 1.6l37.3 50.3v-48.2c0-2.1 1.6-3.7 3.7-3.7h13c2.1-.1 3.8 1.6 3.8 3.5zm-93.7-3.7h-13c-2.1 0-3.7 1.6-3.7 3.7v81.3c0 2.1 1.6 3.7 3.7 3.7h13c2.1 0 3.7-1.6 3.7-3.7v-81.3c0-1.9-1.6-3.7-3.7-3.7m-31.4 68.1h-35.6v-64.4c0-2.1-1.6-3.7-3.7-3.7h-13c-2.1 0-3.7 1.6-3.7 3.7v81.3c0 1 .3 1.8 1 2.5c.7.6 1.5 1 2.5 1h52.2c2.1 0 3.7-1.6 3.7-3.7v-13c0-1.9-1.6-3.7-3.5-3.7zm193.7-68.1h-52.3c-1.9 0-3.7 1.6-3.7 3.7v81.3c0 1.9 1.6 3.7 3.7 3.7h52.2c2.1 0 3.7-1.6 3.7-3.7V265c0-2.1-1.6-3.7-3.7-3.7H344v-13.6h35.5c2.1 0 3.7-1.6 3.7-3.7v-13.1c0-2.1-1.6-3.7-3.7-3.7H344v-13.7h35.5c2.1 0 3.7-1.6 3.7-3.7v-13c-.1-1.9-1.7-3.7-3.7-3.7zM512 93.4v326c-.1 51.2-42.1 92.7-93.4 92.6h-326C41.4 511.9-.1 469.8 0 418.6v-326C.1 41.4 42.2-.1 93.4 0h326c51.2.1 92.7 42.1 92.6 93.4m-70.4 140.1c0-83.4-83.7-151.3-186.4-151.3S68.8 150.1 68.8 233.5c0 74.7 66.3 137.4 155.9 149.3c21.8 4.7 19.3 12.7 14.4 42.1c-.8 4.7-3.8 18.4 16.1 10.1s107.3-63.2 146.5-108.2c27-29.7 39.9-59.8 39.9-93.1z" />
                                        </svg>
                                    </td>
                                    <td class="datamini">line</td>
                                    <td class="datamini">https://line.me/</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/socialmedia/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow">
                                    <td>
                                        <div class="statuspromorow slider">5</div>
                                    </td>
                                    <td class="iconmedia">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
                                            <path fill="#1877f2" d="M256 128C256 57.308 198.692 0 128 0C57.308 0 0 57.308 0 128c0 63.888 46.808 116.843 108 126.445V165H75.5v-37H108V99.8c0-32.08 19.11-49.8 48.348-49.8C170.352 50 185 52.5 185 52.5V84h-16.14C152.959 84 148 93.867 148 103.99V128h35.5l-5.675 37H148v89.445c61.192-9.602 108-62.556 108-126.445" />
                                            <path fill="#fff" d="m177.825 165l5.675-37H148v-24.01C148 93.866 152.959 84 168.86 84H185V52.5S170.352 50 156.347 50C127.11 50 108 67.72 108 99.8V128H75.5v37H108v89.445A128.959 128.959 0 0 0 128 256a128.9 128.9 0 0 0 20-1.555V165z" />
                                        </svg>
                                    </td>
                                    <td class="datamini">facebook</td>
                                    <td class="datamini">https://facebook.com/</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/socialmedia/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow">
                                    <td>
                                        <div class="statuspromorow slider">6</div>
                                    </td>
                                    <td class="iconmedia">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
                                            <g fill="none">
                                                <rect width="256" height="256" fill="url(#skillIconsInstagram0)" rx="60" />
                                                <rect width="256" height="256" fill="url(#skillIconsInstagram1)" rx="60" />
                                                <path fill="#fff" d="M128.009 28c-27.158 0-30.567.119-41.233.604c-10.646.488-17.913 2.173-24.271 4.646c-6.578 2.554-12.157 5.971-17.715 11.531c-5.563 5.559-8.98 11.138-11.542 17.713c-2.48 6.36-4.167 13.63-4.646 24.271c-.477 10.667-.602 14.077-.602 41.236s.12 30.557.604 41.223c.49 10.646 2.175 17.913 4.646 24.271c2.556 6.578 5.973 12.157 11.533 17.715c5.557 5.563 11.136 8.988 17.709 11.542c6.363 2.473 13.631 4.158 24.275 4.646c10.667.485 14.073.604 41.23.604c27.161 0 30.559-.119 41.225-.604c10.646-.488 17.921-2.173 24.284-4.646c6.575-2.554 12.146-5.979 17.702-11.542c5.563-5.558 8.979-11.137 11.542-17.712c2.458-6.361 4.146-13.63 4.646-24.272c.479-10.666.604-14.066.604-41.225s-.125-30.567-.604-41.234c-.5-10.646-2.188-17.912-4.646-24.27c-2.563-6.578-5.979-12.157-11.542-17.716c-5.562-5.562-11.125-8.979-17.708-11.53c-6.375-2.474-13.646-4.16-24.292-4.647c-10.667-.485-14.063-.604-41.23-.604zm-8.971 18.021c2.663-.004 5.634 0 8.971 0c26.701 0 29.865.096 40.409.575c9.75.446 15.042 2.075 18.567 3.444c4.667 1.812 7.994 3.979 11.492 7.48c3.5 3.5 5.666 6.833 7.483 11.5c1.369 3.52 3 8.812 3.444 18.562c.479 10.542.583 13.708.583 40.396c0 26.688-.104 29.855-.583 40.396c-.446 9.75-2.075 15.042-3.444 18.563c-1.812 4.667-3.983 7.99-7.483 11.488c-3.5 3.5-6.823 5.666-11.492 7.479c-3.521 1.375-8.817 3-18.567 3.446c-10.542.479-13.708.583-40.409.583c-26.702 0-29.867-.104-40.408-.583c-9.75-.45-15.042-2.079-18.57-3.448c-4.666-1.813-8-3.979-11.5-7.479s-5.666-6.825-7.483-11.494c-1.369-3.521-3-8.813-3.444-18.563c-.479-10.542-.575-13.708-.575-40.413c0-26.704.096-29.854.575-40.396c.446-9.75 2.075-15.042 3.444-18.567c1.813-4.667 3.983-8 7.484-11.5c3.5-3.5 6.833-5.667 11.5-7.483c3.525-1.375 8.819-3 18.569-3.448c9.225-.417 12.8-.542 31.437-.563zm62.351 16.604c-6.625 0-12 5.37-12 11.996c0 6.625 5.375 12 12 12s12-5.375 12-12s-5.375-12-12-12zm-53.38 14.021c-28.36 0-51.354 22.994-51.354 51.355c0 28.361 22.994 51.344 51.354 51.344c28.361 0 51.347-22.983 51.347-51.344c0-28.36-22.988-51.355-51.349-51.355zm0 18.021c18.409 0 33.334 14.923 33.334 33.334c0 18.409-14.925 33.334-33.334 33.334c-18.41 0-33.333-14.925-33.333-33.334c0-18.411 14.923-33.334 33.333-33.334" />
                                                <defs>
                                                    <radialGradient id="skillIconsInstagram0" cx="0" cy="0" r="1" gradientTransform="matrix(0 -253.715 235.975 0 68 275.717)" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#fd5" />
                                                        <stop offset=".1" stop-color="#fd5" />
                                                        <stop offset=".5" stop-color="#ff543e" />
                                                        <stop offset="1" stop-color="#c837ab" />
                                                    </radialGradient>
                                                    <radialGradient id="skillIconsInstagram1" cx="0" cy="0" r="1" gradientTransform="matrix(22.25952 111.2061 -458.39518 91.75449 -42.881 18.441)" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#3771c8" />
                                                        <stop offset=".128" stop-color="#3771c8" />
                                                        <stop offset="1" stop-color="#60f" stop-opacity="0" />
                                                    </radialGradient>
                                                </defs>
                                            </g>
                                        </svg>
                                    </td>
                                    <td class="datamini">instagram</td>
                                    <td class="datamini">https://www.instagram.com/</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/socialmedia/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow">
                                    <td>
                                        <div class="statuspromorow slider">7</div>
                                    </td>
                                    <td class="iconmedia">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="0.89em" height="1em" viewBox="0 0 256 290">
                                            <path fill="#ff004f" d="M189.72 104.421c18.678 13.345 41.56 21.197 66.273 21.197v-47.53a67.115 67.115 0 0 1-13.918-1.456v37.413c-24.711 0-47.59-7.851-66.272-21.195v96.996c0 48.523-39.356 87.855-87.9 87.855c-18.113 0-34.949-5.473-48.934-14.86c15.962 16.313 38.222 26.432 62.848 26.432c48.548 0 87.905-39.332 87.905-87.857v-96.995zm17.17-47.952c-9.546-10.423-15.814-23.893-17.17-38.785v-6.113h-13.189c3.32 18.927 14.644 35.097 30.358 44.898M69.673 225.607a40.008 40.008 0 0 1-8.203-24.33c0-22.192 18.001-40.186 40.21-40.186a40.313 40.313 0 0 1 12.197 1.883v-48.593c-4.61-.631-9.262-.9-13.912-.801v37.822a40.268 40.268 0 0 0-12.203-1.882c-22.208 0-40.208 17.992-40.208 40.187c0 15.694 8.997 29.281 22.119 35.9" />
                                            <path d="M175.803 92.849c18.683 13.344 41.56 21.195 66.272 21.195V76.631c-13.794-2.937-26.005-10.141-35.186-20.162c-15.715-9.802-27.038-25.972-30.358-44.898h-34.643v189.843c-.079 22.132-18.049 40.052-40.21 40.052c-13.058 0-24.66-6.221-32.007-15.86c-13.12-6.618-22.118-20.206-22.118-35.898c0-22.193 18-40.187 40.208-40.187c4.255 0 8.356.662 12.203 1.882v-37.822c-47.692.985-86.047 39.933-86.047 87.834c0 23.912 9.551 45.589 25.053 61.428c13.985 9.385 30.82 14.86 48.934 14.86c48.545 0 87.9-39.335 87.9-87.857z" />
                                            <path fill="#00f2ea" d="M242.075 76.63V66.516a66.285 66.285 0 0 1-35.186-10.047a66.47 66.47 0 0 0 35.186 20.163M176.53 11.57a67.788 67.788 0 0 1-.728-5.457V0h-47.834v189.845c-.076 22.13-18.046 40.05-40.208 40.05a40.06 40.06 0 0 1-18.09-4.287c7.347 9.637 18.949 15.857 32.007 15.857c22.16 0 40.132-17.918 40.21-40.05V11.571zM99.966 113.58v-10.769a88.787 88.787 0 0 0-12.061-.818C39.355 101.993 0 141.327 0 189.845c0 30.419 15.467 57.227 38.971 72.996c-15.502-15.838-25.053-37.516-25.053-61.427c0-47.9 38.354-86.848 86.048-87.833" />
                                        </svg>
                                    </td>
                                    <td class="datamini">tiktok</td>
                                    <td class="datamini">https://www.tiktok.com/</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/socialmedia/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow">
                                    <td>
                                        <div class="statuspromorow slider">8</div>
                                    </td>
                                    <td class="iconmedia">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
                                            <g fill="none">
                                                <rect width="256" height="256" fill="#fff" rx="60" />
                                                <rect width="256" height="256" fill="#1d9bf0" rx="60" />
                                                <path fill="#fff" d="M199.572 91.411c.11 1.587.11 3.174.11 4.776c0 48.797-37.148 105.075-105.075 105.075v-.03A104.54 104.54 0 0 1 38 184.677c2.918.351 5.85.526 8.79.533a74.154 74.154 0 0 0 45.865-15.839a36.976 36.976 0 0 1-34.501-25.645a36.811 36.811 0 0 0 16.672-.636c-17.228-3.481-29.623-18.618-29.623-36.198v-.468a36.705 36.705 0 0 0 16.76 4.622c-16.226-10.845-21.228-32.432-11.43-49.31a104.814 104.814 0 0 0 76.111 38.582a36.95 36.95 0 0 1 10.683-35.283c14.874-13.982 38.267-13.265 52.249 1.601a74.105 74.105 0 0 0 23.451-8.965a37.061 37.061 0 0 1-16.234 20.424A73.446 73.446 0 0 0 218 72.282a75.023 75.023 0 0 1-18.428 19.13" />
                                            </g>
                                        </svg>
                                    </td>
                                    <td class="datamini">twitter</td>
                                    <td class="datamini">https://twitter.com/</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/socialmedia/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow">
                                    <td>
                                        <div class="statuspromorow slider">9</div>
                                    </td>
                                    <td class="iconmedia">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
                                            <defs>
                                                <linearGradient id="logosSkype0" x1="42.173%" x2="57.827%" y1=".584%" y2="99.416%">
                                                    <stop offset="1%" stop-color="#00b7f0" />
                                                    <stop offset="34%" stop-color="#009de5" />
                                                    <stop offset="76%" stop-color="#0082d9" />
                                                    <stop offset="100%" stop-color="#0078d4" />
                                                </linearGradient>
                                                <linearGradient id="logosSkype1" x1="6.659%" x2="93.341%" y1="75%" y2="25%">
                                                    <stop offset="0%" stop-color="#0078d4" />
                                                    <stop offset="37%" stop-color="#007ad5" />
                                                    <stop offset="57%" stop-color="#0082d9" />
                                                    <stop offset="74%" stop-color="#0090df" />
                                                    <stop offset="88%" stop-color="#00a3e7" />
                                                    <stop offset="100%" stop-color="#00bcf2" />
                                                </linearGradient>
                                                <linearGradient id="logosSkype2" x1="30.436%" x2="80.436%" y1="16.124%" y2="102.737%">
                                                    <stop offset="0%" stop-color="#00b7f0" />
                                                    <stop offset="100%" stop-color="#007cc1" />
                                                </linearGradient>
                                                <linearGradient id="logosSkype3" x1="45.636%" x2="54.364%" y1="99.815%" y2=".185%">
                                                    <stop offset="0%" stop-color="#0078d4" />
                                                    <stop offset="100%" stop-color="#00bcf2" />
                                                </linearGradient>
                                                <radialGradient id="logosSkype4" cx="48.539%" cy="50%" r="50.021%" fx="48.539%" fy="50%">
                                                    <stop offset="0%" />
                                                    <stop offset="100%" stop-opacity="0" />
                                                </radialGradient>
                                                <path id="logosSkype5" d="M179.903 104.187a75.715 75.715 0 0 0-38.567 10.55c19.535-32.94 11.499-75.273-18.749-98.764C92.34-7.52 49.337-4.827 22.255 22.255C-4.826 49.336-7.519 92.34 15.973 122.587c23.491 30.248 65.823 38.284 98.765 18.749c-17.49 29.642-12.843 67.344 11.322 91.852c24.166 24.508 61.798 29.685 91.684 12.613c29.886-17.071 44.542-52.118 35.705-85.382c-8.836-33.265-38.95-56.418-73.37-56.409z" />
                                            </defs>
                                            <path fill="#fff" d="M246.663 143.907a115.26 115.26 0 0 0 1.153-15.782A119.868 119.868 0 0 0 127.948 8.258c-5.28.022-10.553.407-15.781 1.152C82.62-6.514 46.125-1.165 22.392 22.57C-1.342 46.303-6.691 82.797 9.233 112.344c-.745 5.228-1.13 10.5-1.153 15.781c0 66.202 53.667 119.868 119.868 119.868c5.28-.022 10.554-.407 15.782-1.152c29.546 15.924 66.04 10.575 89.775-13.16c23.733-23.733 29.083-60.228 13.158-89.774" />
                                            <circle cx="75.994" cy="76.171" r="75.893" fill="url(#logosSkype0)" />
                                            <circle cx="179.903" cy="180.08" r="75.893" fill="url(#logosSkype1)" />
                                            <mask id="logosSkype6" fill="#fff">
                                                <use href="#logosSkype5" />
                                            </mask>
                                            <circle cx="125.547" cy="133.578" r="141.812" fill="url(#logosSkype4)" mask="url(#logosSkype6)" />
                                            <circle cx="127.948" cy="128.125" r="119.868" fill="url(#logosSkype2)" />
                                            <circle cx="127.948" cy="128.125" r="119.868" fill="url(#logosSkype3)" />
                                            <path fill="#fff" d="M84.239 113.408a34.755 34.755 0 0 1-4.078-17.2a31.12 31.12 0 0 1 7.27-20.746a44.33 44.33 0 0 1 18.973-12.59a73.144 73.144 0 0 1 24.736-4.167a100.83 100.83 0 0 1 16.49 1.241a70.041 70.041 0 0 1 11.438 2.926a21.899 21.899 0 0 1 8.866 5.763a11.26 11.26 0 0 1 2.837 7.625a11.171 11.171 0 0 1-2.926 8.068a9.575 9.575 0 0 1-7.27 3.014a13.742 13.742 0 0 1-5.497-1.241a102.988 102.988 0 0 0-12.856-4.7a46.458 46.458 0 0 0-12.5-1.506a29.258 29.258 0 0 0-15.605 3.9a12.944 12.944 0 0 0-6.206 11.704a11.703 11.703 0 0 0 3.192 8.156a29.79 29.79 0 0 0 8.866 6.295c3.635 1.773 8.866 4.167 16.313 7.182l2.305.886a111.356 111.356 0 0 1 20.126 10.107a40.783 40.783 0 0 1 12.501 12.767a33.602 33.602 0 0 1 4.522 17.732a35.464 35.464 0 0 1-6.295 21.367a36.705 36.705 0 0 1-17.732 12.945a73.499 73.499 0 0 1-26.155 4.255a82.365 82.365 0 0 1-35.464-6.738a20.037 20.037 0 0 1-7.358-5.674a13.476 13.476 0 0 1-2.305-7.802a9.93 9.93 0 0 1 3.103-7.89a11.348 11.348 0 0 1 8.068-2.838a21.19 21.19 0 0 1 9.486 2.394c3.635 1.773 6.472 3.192 8.866 4.078a40.163 40.163 0 0 0 7.359 2.305a39.454 39.454 0 0 0 9.487.976a25.18 25.18 0 0 0 15.958-4.256a13.83 13.83 0 0 0 5.408-11.614a12.501 12.501 0 0 0-3.369-8.866a37.858 37.858 0 0 0-9.93-7.27c-4.344-2.306-10.55-5.054-18.44-8.423a118.183 118.183 0 0 1-20.304-10.462c-4.796-3.19-8.977-6.727-11.88-11.703" />
                                        </svg>
                                    </td>
                                    <td class="datamini">skype</td>
                                    <td class="datamini">https://www.skype.com/</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/socialmedia/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="dinamicrow">
                                    <td>
                                        <div class="statuspromorow slider">10</div>
                                    </td>
                                    <td class="iconmedia">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
                                            <g fill="none">
                                                <rect width="256" height="256" fill="#f4f2ed" rx="60" />
                                                <path fill="#4285f4" d="M41.636 203.039h31.818v-77.273L28 91.676v97.727c0 7.545 6.114 13.636 13.636 13.636" />
                                                <path fill="#34a853" d="M182.545 203.039h31.819c7.545 0 13.636-6.114 13.636-13.636V91.675l-45.455 34.091" />
                                                <path fill="#fbbc04" d="M182.545 66.675v59.091L228 91.676V73.492c0-16.863-19.25-26.477-32.727-16.363" />
                                                <path fill="#ea4335" d="M73.455 125.766v-59.09L128 107.583l54.545-40.909v59.091L128 166.675" />
                                                <path fill="#c5221f" d="M28 73.493v18.182l45.454 34.091v-59.09L60.727 57.13C47.227 47.016 28 56.63 28 73.493" />
                                            </g>
                                        </svg>
                                    </td>
                                    <td class="datamini">email</td>
                                    <td class="datamini">globalbola@gmail.com</td>
                                    <td class="statuspromo" data-status="1"></td>
                                    <td>
                                        <div class="grouptools">
                                            <a href="/contentds/socialmedia/edit" target="_blank" class="tombol grey openviewport">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                        <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                                                    </g>
                                                </svg>
                                                <span class="texttombol">edit</span>
                                            </a>
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


    <script>
        //open jendela edit agent
        $(document).ready(function() {
            $(".openviewport").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 700;
                var windowHeight = $(window).height() * 0.6;
                var windowLeft = ($(window).width() - windowWidth) / 1.3;
                var windowTop = ($(window).height() - windowHeight) / 1.5;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + windowLeft + ", top=" + windowTop);
            });
        });

        //open jendela info agent
        $(document).ready(function() {
            $(".openviewportinfo").click(function(event) {
                event.preventDefault();

                var url = $(this).attr("href");
                var windowWidth = 300;
                var windowHeight = $(window).height() * 0.20;
                var windowLeft = ($(window).width() - windowWidth) / 1.6;
                var windowTop = ($(window).height() - windowHeight) / 1.8;

                window.open(url, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + windowLeft + ", top=" + windowTop);
            });
        });

        // print text status
        $(document).ready(function(){
            $('.statuspromo').each(function(){
                var statusValue = $(this).attr('data-status');
                switch(statusValue) {
                    case '1':
                        $(this).text('Active');
                        break;
                    case '2':
                        $(this).text('in-active');
                        break;
                    default:
                        break;
                }
            });
        });
    </script>
@endsection
