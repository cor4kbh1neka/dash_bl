// epxpand side-nav
$(document).ready(function () {
    var initialLogoSrc = $('.gmb_logo').attr('src');
    var initialContainerClass = $('.sec_container_utama').attr('class');
    var isExpanded = false;
    $(document).on('click', '#icon_expand', function () {
        isExpanded = !isExpanded;
        if (isExpanded) {
            $('.gmb_logo').attr('src', function (index, oldSrc) {
                return oldSrc.replace('lucky-wheel-l21.png', 'icon-spinner.png');
            });
            $('.sec_container_utama').addClass('noexpand');
            $('.data_sidejsx').removeClass('active');
            $('.sub_data_sidejsx').css('display', 'none');
        } else {
            $('.gmb_logo').attr('src', initialLogoSrc);
            $('.sec_container_utama').attr('class', initialContainerClass);
            $('.sub_data_sidejsx').css('display', '');
        }
    });
    $(document).on('mouseenter', '.sec_sidebar', function () {
        if (isExpanded) {
            $('.gmb_logo').attr('src', function (index, oldSrc) {
                return oldSrc.replace('icon-spinner.png', 'lucky-wheel-l21.png');
            });
            $('.sec_container_utama').removeClass('noexpand');
        }
    });
    $(document).on('mouseleave', '.sec_sidebar', function () {
        if (isExpanded) {
            $('.gmb_logo').attr('src', function (index, oldSrc) {
                return oldSrc.replace('lucky-wheel-l21.png', 'icon-spinner.png');
            });
            $('.sec_container_utama').addClass('noexpand');
        }
    });
    $(document).on('click', '.data_sidejsx, .sub_data_sidejsx', function () {
        $('.gmb_logo').attr('src', initialLogoSrc);
        $('.sec_container_utama').attr('class', initialContainerClass);
        isExpanded = false;
    });
});

// copy komponent
document.addEventListener('click', function (event) {
    var target = event.target;
    if (target.classList.contains('copy_element')) {
        var elementId = target.previousElementSibling.firstElementChild.id;
        copyElement(elementId);
    }
});
function copyElement(elementId) {
    var element = document.getElementById(elementId);
    var range = document.createRange();
    range.selectNode(element);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();
    Swal.fire({
        icon: 'success',
        title: 'Element berhasil disalin!',
        showConfirmButton: false,
        timer: 1500
    });
}

// crud
$(document).ready(function () {
    $(document).on('click', '.dot_action', function () {
        var actionCrud = $(this).next('.action_crud');
        $('.action_crud').not(actionCrud).slideUp('fast');
        if (actionCrud.is(':hidden')) {
            actionCrud.slideDown('fast');
        } else {
            actionCrud.slideUp('fast');
        }
    });
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.dot_action, .action_crud').length) {
            $('.action_crud').slideUp('fast');
        }
    });
});

// img show tabel
$(document).ready(function () {
    $(document).on('mouseenter', '.td_img_show', function () {
        $(this).next('.table_img').css('display', 'block');
    });
    $(document).on('mouseleave', '.td_img_show', function () {
        $(this).next('.table_img').css('display', 'none');
    });
});

// show modal
$(document).ready(function () {
    $(document).on('click', '.triggermodal', function () {
        var target = $(this).data('target');
        $('#' + target).css('display', 'flex');
    });
    $(document).on('click', '.closemodal', function () {
        $(this).closest('.sec_modal').css('display', '');
    });
    $(document).on('click', function (event) {
        var target = $(event.target);
        if (!target.closest('.componen_modal').length && !target.closest('.triggermodal').length) {
            $('.sec_modal').css('display', 'none');
        }
    });
});

// search table
$(document).ready(function () {
    $('body').on('keyup', 'input[id^="searchData-"]', function () {
        var searchValue = $(this).val().toLowerCase().trim();
        var targetClass = $(this).attr('id').split('-')[1];
        $('tr.filter_row').nextAll('tr').each(function () {
            var text = $(this).find('td').find('.' + targetClass).text().toLowerCase().trim();
            if (text.includes(searchValue)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});


function salinTeks(teks) {
    getDataUrl(function (url) {
        teks = url.url + teks;
        const el = document.createElement('textarea');
        el.value = teks;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);

        Swal.fire({
            icon: 'success',
            title: 'Berhasil disalin!',
            showConfirmButton: false,
            timer: 1500
        });
    });
}

function getDataUrl(callback) {
    $.ajax({
        url: '/getDataUrl',
        type: 'GET',
        success: function (data) {
            callback(data);
        },
        error: function () {
            callback('');
        }
    });
}

// full screen
$(document).ready(function () {
    var isFullscreen = false;

    $('.fullscreen').click(function () {
        if (!isFullscreen) {
            $('.title_main_content, .sec_top_navbar, .sec_sidebar, .footer').css('display', 'none');

            $('.content_body').css('max-height', '100vh');
            $('.tabelproses').css('margin-bottom', '5vh');

            $('.fullscreen svg').html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3M3 16h3a2 2 0 0 1 2 2v3m8 0v-3a2 2 0 0 1 2-2h3" /></svg>');

            isFullscreen = true;
        } else {
            $('.title_main_content, .sec_top_navbar, .sec_sidebar, .footer').css('display', '');

            $('.content_body').css('max-height', '');
            $('.tabelproses').css('margin-bottom', '');

            $('.fullscreen svg').html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16"><path fill="currentColor" d="m5.3 6.7l1.4-1.4l-3-3L5 1H1v4l1.3-1.3zm1.4 4L5.3 9.3l-3 3L1 11v4h4l-1.3-1.3zm4-1.4l-1.4 1.4l3 3L11 15h4v-4l-1.3 1.3zM11 1l1.3 1.3l-3 3l1.4 1.4l3-3L15 5V1z" /></svg>');

            isFullscreen = false;
        }
    });
});

// Time dashboard
function updateDateTime() {
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.toLocaleString('default', { month: 'long' });
    var year = currentDate.getFullYear();

    var hours = currentDate.getHours();
    var minutes = currentDate.getMinutes();
    var seconds = currentDate.getSeconds();

    hours = (hours < 10 ? "0" : "") + hours;
    minutes = (minutes < 10 ? "0" : "") + minutes;
    seconds = (seconds < 10 ? "0" : "") + seconds;

    document.getElementById("root_breadtime").textContent = day + " " + month + " " + year + " | " + hours + ":" + minutes + ":" + seconds + " WIB";
}
updateDateTime();
setInterval(updateDateTime, 1000);

// histori coin
$(document).ready(function () {
    $(".toggleshowsidedata").click(function () {
        $(".groupdataside").toggleClass("expanded");
        $(".sec_container_utama").toggleClass("noexpand");
    });
});


// show modal
$(document).ready(function () {
    $('.showmodal').click(function () {
        var target = $(this).data('modal');
        var username = $(this).data('username');
        var jenis = $(this).data('jenis');

        var title = "RIWAYAT DEPOSIT USER: " + username;
        $(".titlemodalhistory").text(title);

        // Tampilkan indikator loading
        $("#loadingIndicator").show();

        $.getJSON('/getDataHistory/' + username + '/' + jenis, function (data) {
            // Mengosongkan elemen-elemen di bawah baris "hdtable" (tetapi tidak termasuk baris itu sendiri)
            $(".hdtable").nextUntil(":not(.hdtable)").remove();

            $.each(data, function (index, response) {
                if (jenis != 'ALL') {
                    var newRow = $("<tr class='hdtable'>");

                    var date = new Date(response.created_at);
                    var options = { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
                    var tanggal = date.toLocaleString('id-ID', options);

                    newRow.append("<td>" + response.username + "</td>");
                    newRow.append("<td class='hsjenistrans'>" + tanggal + "</td>");
                    newRow.append("<td class='hsjenistrans'>" + response.mbank.toUpperCase() + ", " + response.mnamarek.toUpperCase() + ", " + response.mnorek.toUpperCase() + "</td>");
                    newRow.append("<td>" + response.amount + "</td>");
                    newRow.append("<td class='hsjenistrans' data-proses='" + (response.status == 1 ? "accept" : "cancel") + "'>" + (response.status == 1 ? "Accept Deposit" : "Reject Deposit") + "</td>");

                    $("#dataTableHistory").append(newRow);
                } else {
                    var newRow = $("<tr class='hdtable'>");

                    var date = new Date(response.created_at);
                    var options = { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
                    var tanggal = date.toLocaleString('id-ID', options);

                    newRow.append("<td class='hsjenistrans'>" + (index + 1) + "</td>");
                    newRow.append("<td class='hsjenistrans'>" + tanggal + "</td>");
                    newRow.append("<td class='hsjenistrans' data-proses='" + (response.status == 1 ? "accept" : "cancel") + "'>" + (response.status == 1 ? "Accept Deposit" : "Reject Deposit") + "</td>");
                    newRow.append("<td>" + response.approved_by + "</td>");
                    newRow.append("<td>" + response.amount + "</td>");
                    newRow.append("<td>" + response.balance + "</td>");



                    $("#dataTableHistory").append(newRow);
                }
            });

            $("#loadingIndicator").hide();

            $('.modalhistory[data-target="' + target + '"]').css('display', 'flex');
        })
            .fail(function (jqxhr, textStatus, error) {
                const err = textStatus + ", " + error;
                console.error("Request failed: " + err);

                $("#loadingIndicator").hide();
            });

    });
    $('.closetrigger').click(function () {
        $('.modalhistory').css('display', 'none');
    });


    $(document).mouseup(function (e) {
        var container = $(".secmodalhistory");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('.modalhistory').css('display', 'none');
        }
    });

    $(document).ready(function () {
        $('.listbankproses input[type="checkbox"]').on('click', function () {
            var checkedIds = [];

            $('.listbankproses input[type="checkbox"]:checked').each(function () {
                var checkboxId = $(this).attr('id');
                var idWithoutCheckbox = checkboxId.split('Checkbox')[0];
                checkedIds.push(idWithoutCheckbox);
            });

            if (checkedIds.length === 0) {
                $('.tabelproses tr').show();
            } else {
                $('.tabelproses tr').each(function () {
                    if ($(this).hasClass('hdtable')) {
                        return true;
                    }

                    var dataBank = $(this).data('bank');
                    if (checkedIds.includes(dataBank)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                        $(this).find('input[type="checkbox"]').prop('checked', false);
                    }
                });
            }
        });
    });

});

// display none notifikasi data h2
$(document).ready(function () {
    checkCountPendingData();

    function checkCountPendingData() {
        $('.countpendingdata, .countdatapend').each(function () {
            var countValue = $(this).text().trim();
            if (countValue === '' || countValue === '0') {
                $(this).css('display', 'none');
            } else {
                $(this).css('display', '');
            }
        });
    }

    $('.countpendingdata').bind('DOMSubtreeModified', function () {
        checkCountPendingData();
    });
});

// show logout
$(document).ready(function () {
    $('.sec_top_navbar').load('/topnav');
    $(document).on('click', '.profile_nav', function () {
        $('.list_menu_profile').slideToggle('fast');
    });
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.list_menu_profile, .profile_nav').length) {
            $('.list_menu_profile').slideUp('fast');
        }
    });
});

// cari menu
$('#sec_sidebar').on('input', '#searchTabel', function () {
    var searchText = $(this).val().toLowerCase();
    $('.nav_title1, .sub_title1').each(function () {
        var titleText = $(this).text().toLowerCase();
        var $parentData = $(this).closest('.data_sidejsx');
        var $parentSubData = $(this).closest('.sub_data_sidejsx');

        if (searchText === '') {
            $(this).show();
            $parentData.show();
            $parentSubData.hide();
            $parentData.removeClass('active');
            $parentSubData.removeClass('active');
        } else if (titleText.includes(searchText) || $parentSubData.find('.sub_title1').text().toLowerCase().includes(searchText)) {
            $(this).show();
            $parentData.show();
            $parentSubData.show();
            $parentData.addClass('active');
            $parentSubData.addClass('active');
        } else {
            $(this).hide();
            $parentData.hide();
            $parentSubData.hide();
            $parentData.removeClass('active');
            $parentSubData.removeClass('active');
        }
    });
});

