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

$(document).ready(function () {
    $('#sec_sidebar').load('/sidenav', function () {
        $('#sec_sidebar').on('click', '.data_sidejsx', function (event) {
            event.preventDefault();
            $(this).toggleClass('active');
            $(this).next('.sub_data_sidejsx').slideToggle('fast');
            $('.data_sidejsx').not(this).removeClass('active');
            $('.data_sidejsx').not(this).next('.sub_data_sidejsx').slideUp('fast');
        });

        $('#sec_sidebar').on('click', '.list_subdata', function (event) {
            event.preventDefault();
            $('.list_subdata').not(this).removeClass('active');
            $(this).toggleClass('active');
        });

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
    });
});

$(document).on('click', '#codeDashboardLink', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/generatevoucher', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/generatevoucher');
    });
});

$(document).on('click', '#notesview', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/notesview', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/notesview');
    });
});

$(document).on('click', '#codeBoxLink', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/codebox', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/codebox');
    });
});

$(document).on('click', '#codeTableLink', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/codetable', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/codetable');
    });
});

$(document).on('click', '#codeFormLink', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/codeform', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/codeform');
    });
});

$(document).on('click', '#codeModalLink', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/codemodal', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/komponen/codemodal.html');
    });
});

$(document).on('click', '#codeButtonLink', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/codebutton', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/codebutton');
    });
});

$(document).on('click', '#codeCardLink', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/codecard', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/codecard');
    });
});

$(document).on('click', '#codeOtherLink', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/codeother', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/codeother');
    });
});





/* ========================= Vocuher ======================== */
$(document).on('click', '#Jenisvoucher', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/jenisvoucher', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/jenisvoucher');
    });
});
$(document).on('click', '#Url_spin', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/urlspin/index', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/urlspin/index');
    });
});
$(document).on('click', '#Keterangan', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/keterangan', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/keterangan');
    });
});
$(document).on('click', '#DataWebsite', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/website', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/website');
    });
});
$(document).on('click', '#Voucher', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/voucher', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/voucher');
    });
});
// $(document).on('click', '#Generatevoucher', function(event) {
//     event.preventDefault();
//     $('.aplay_code').load('/generatevoucher', function() {
//         adjustElementSize();
//         localStorage.setItem('lastPage', '/generatevoucher');
//     });
// });

$(document).on('click', '#Generatevoucher', function (event) {
    var $button = $(this);

    event.preventDefault();

    $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/generatevoucher', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/generatevoucher');
    });
});


$(document).on('click', '#Prosesvoucher', function (event) {
    var $button = $(this);

    event.preventDefault();

    $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/voucherprosesall', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/voucherprosesall');
    });
});
// $(document).on('click', '#GeneratevoucherDemo', function(event) {
//     event.preventDefault();
//     $('.aplay_code').load('/generatevoucherdemo/1', function() {
//         adjustElementSize();
//         localStorage.setItem('lastPage', '/generatevoucherdemo/1');
//     });
// });
$(document).on('click', '#GeneratevoucherDemo', function (event) {
    var $button = $(this);

    event.preventDefault();

    $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/generatevoucherdemo/1', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/generatevoucherdemo/1');
    });
});



// $(document).on('click', '#GeneratevoucherFind', function(event) {
//     event.preventDefault();
//     $('.aplay_code').load('/voucher_search/0', function() {
//         adjustElementSize();
//         localStorage.setItem('lastPage', '/voucher_search/0');
//     });
// });
$(document).on('click', '#GeneratevoucherFind', function (event) {
    var $button = $(this);

    event.preventDefault();

    $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/voucher_search/0', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/voucher_search/0');
    });
});


$(document).on('click', '#Urlevent', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/urlevent/index', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/urlevent/index');
    });
});

$(document).on('click', '#Hadiahevent', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/hadiah/index', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/hadiah/index');
    });
});
$(document).on('click', '#Contactevent', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/contact/index', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/contact/index');
    });
});
$(document).on('click', '#ListPrizeevent', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/listprize/index', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/listprize/index');
    });
});

$(document).on('click', '#Budgetevent', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/budget/index', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/budget/index');
    });
});

$(document).on('click', '#Buttonevent', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/buttonsetting/index', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/buttonsetting/index');
    });
});

$(document).on('click', '#Jenisevent', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/jenis/index', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/jenis/index');
    });
});



$(document).on('click', '#Gambarevent', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/gambar/index', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/gambar/index');
    });
});

$(document).on('click', '#Allowedip', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/allowedip', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/allowedip');
    });
});

$(document).on('click', '#Agent', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/agents', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/agents');
    });
});

$(document).on('click', '#Player', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/players', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/players');
    });
});

$(document).on('click', '#Deposit', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/indexdeposit', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/indexdeposit');
    });
});

$(document).on('click', '#History', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/indexhistory', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/indexhistory');
    });
});

$(document).on('click', '#Transaction', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/transactions', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/transactions');
    });
});

$(document).on('click', '#Settings', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/settings', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/settings');
    });
});

$(document).on('click', '#Usermanagement', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/user', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/user');
    });
});

$(document).on('click', '#Linksettings', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/linksettings', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/linksettings');
    });
});

/* ========================= Event ======================== */
// $(document).on('click', '[id^="event_"]', function(event) {
//     event.preventDefault();

//     var fullId = $(this).attr('id');

//     var eventId = fullId.substring(6);

//     $('.aplay_code').load('/event/index/' + eventId, function() {
//         adjustElementSize();
//         localStorage.setItem('lastPage', '/event/index/' + eventId);
//     });

// });
// $(document).on('click', '#Data-event', function(event) {
//     event.preventDefault();
//     $('.aplay_code').load('/dataevent/index', function() {
//         adjustElementSize();
//         localStorage.setItem('lastPage', '/dataevent/index');
//     });
// });

$(document).on('click', '#Data-event', function (event) {
    var $button = $(this);

    event.preventDefault();

    $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/dataevent/index/0', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/dataevent/index/0');
    });
});

$(document).on('click', '#Data-event-2', function (event) {
    var $button = $(this);

    event.preventDefault();

    $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/dataevent/index/1', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/dataevent/index/1');
    });
});

// $(document).on('click', '#Proses-event', function(event) {
//     event.preventDefault();
//     $('.aplay_code').load('/prosesevent/indexproses', function() {
//         adjustElementSize();
//         localStorage.setItem('lastPage', '/prosesevent/indexproses');
//     });
// });

$(document).on('click', '#Proses-event', function (event) {
    var $button = $(this);

    event.preventDefault();

    $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/prosesevent/indexproses/0', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/prosesevent/indexproses/0');
    });
});

$(document).on('click', '#Proses-event-2', function (event) {
    var $button = $(this);

    event.preventDefault();

    $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/prosesevent/indexproses/1', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/prosesevent/indexproses/1');
    });
});

$(document).on('click', '#Approval-event-2', function (event) {
    var $button = $(this);

    event.preventDefault();

    $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/approvalevent/indexapproval/1', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/approvalevent/indexapproval/1');
    });
});


$(document).on('click', '#Findkode-event', function (event) {
    var $button = $(this);

    event.preventDefault();

    $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/findkodeevent/0', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/findkodeevent/0');
    });
});

$(document).on('click', '#Findkode-event-2', function (event) {
    var $button = $(this);

    event.preventDefault();
    +
        $button.prop('disabled', true);

    setTimeout(function () {
        $button.prop('disabled', false);
    }, 1500);

    $('.aplay_code').load('/findkodeevent/1', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/findkodeevent/1');
    });
});



/* ========================= Profile ======================== */
$(document).on('click', '#Profile', function (event) {
    event.preventDefault();
    $('.aplay_code').load('/profile', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', '/profile');
    });
});


$(document).on('click', '.Menuleft', function (event) {
    event.preventDefault();
    var jenisMenu = $(this).data('jenismenu');
    var menuId = $(this).data('menuid');
    var menu1 = $(this).data('menu1');
    var menu2 = $(this).data('menu2');
    var menu3 = $(this).data('menu3');
    var menuUrl99 = $(this).data('url');

    if (typeof menuUrl99 === 'undefined') {
        var menuUrl = '';

        if (jenisMenu != '') {
            menuUrl = '/' + jenisMenu + '/' + menuId;
        } else {
            menuUrl = '/' + menuId;
        }
    } else {
        menuUrl = menuUrl99;
    }
    $('.aplay_code').load('/codetest', function () {
        adjustElementSize();
        localStorage.setItem('lastPage', menuUrl);

        $('.aplay_code').load(menuUrl, function () {
            adjustElementSize();
            localStorage.setItem('lastPage', menuUrl);
            Breadcrumb_menu(menu1, menu2, menu3, menuUrl);
            $('.aplay_code').find('#codetest').remove();
            $('tr:gt(' + (22 - 1) + ')').hide();

        });
    });
});


function Breadcrumb_menu(menu1, menu2, menu3, menuUrl) {

    $('.induk').text(menu1);
    $('.arrow_seperator').show();
    if (typeof menu3 !== 'undefined') {
        $('.arrow_seperator4').hide();
        $('.anak4').hide();
        $('.anak1').removeClass('Menuleft');
        $('.anak1').empty();
        $('.anak1').removeAttr('data-url');
        $('.anak1').show().text(menu2);
        $('.arrow_seperator2').show();
        $('.anak2').show();
        $('.anak2').empty(); // Menghapus konten sebelumnya (jika ada)
        $('.anak2').removeClass('Menuleft');
        // $('.anak2').addClass('Menuleft');
        $('.anak2').append(`<a href="#">${menu3}</a>`);
        $('.anak2').removeAttr('data-url');
        $('.anak2').attr('data-url', menuUrl);
        $('.anak2').removeAttr('data-menu1');
        $('.anak2').attr('data-menu1', menu1);
        $('.anak2').removeAttr('data-menu2');
        $('.anak2').attr('data-menu2', menu2);
        $('.anak2').removeAttr('data-menu3');
        $('.anak2').attr('data-menu3', menu3);
    } else {
        $('.arrow_seperator4').hide();
        $('.anak4').hide();
        $('.anak1').removeClass('Menuleft');
        // $('.anak1').addClass('Menuleft');
        $('.anak1').empty();
        $('.anak1').append(`<a href="#">${menu2}</a>`);
        $('.anak1').removeAttr('data-url');
        $('.anak1').attr('data-url', menuUrl);
        $('.anak1').removeAttr('data-menu1');
        $('.anak1').attr('data-menu1', menu1);
        $('.anak1').removeAttr('data-menu2');
        $('.anak1').attr('data-menu2', menu2);
        $('.anak1').removeAttr('data-menu3');
        $('.anak1').attr('data-menu3', menu3);
        $('.arrow_seperator2').hide();
        $('.anak2').removeClass('Menuleft');
        $('.anak2').empty();
        $('.anak2').hide();

    }

}

function handleButtonAddClick(buttonId) {
    if (buttonId.startsWith("add-")) {
        $('.arrow_seperator4').show();
        $('.anak4').show();
        $('.anak4').text('Add New');
    }
}

function handleButtonEditClick(buttonId) {
    if (buttonId.startsWith("update-") || buttonId.startsWith("edit")) {
        $('.arrow_seperator4').show();
        $('.anak4').show();
        $('.anak4').text('Edit');
    }

}

function handleButtonCancelClick(buttonId) {
    if (buttonId.startsWith("cancel")) {
        $('.arrow_seperator4').hide();
        $('.anak4').hide();
    }
}