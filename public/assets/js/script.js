// epxpand side-nav
$(document).ready(function() {
    var initialLogoSrc = $('.gmb_logo').attr('src');
    var initialContainerClass = $('.sec_container_utama').attr('class');
    var isExpanded = false;
$(document).on('click', '#icon_expand', function() {
    isExpanded = !isExpanded;
    if (isExpanded) {
    $('.gmb_logo').attr('src', function(index, oldSrc) {
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
$(document).on('mouseenter', '.sec_sidebar', function() {
    if (isExpanded) {
    $('.gmb_logo').attr('src', function(index, oldSrc) {
        return oldSrc.replace('icon-spinner.png', 'lucky-wheel-l21.png');
    });
    $('.sec_container_utama').removeClass('noexpand');
    }
});
$(document).on('mouseleave', '.sec_sidebar', function() {
    if (isExpanded) {
    $('.gmb_logo').attr('src', function(index, oldSrc) {
        return oldSrc.replace('lucky-wheel-l21.png', 'icon-spinner.png');
    });
    $('.sec_container_utama').addClass('noexpand');
    }
});
$(document).on('click', '.data_sidejsx, .sub_data_sidejsx', function() {
    $('.gmb_logo').attr('src', initialLogoSrc);
    $('.sec_container_utama').attr('class', initialContainerClass);
    isExpanded = false;
});
});

// copy komponent
document.addEventListener('click', function(event) {
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
$(document).ready(function() {
    $(document).on('click', '.dot_action', function() {
    var actionCrud = $(this).next('.action_crud');
    $('.action_crud').not(actionCrud).slideUp('fast');
    if (actionCrud.is(':hidden')) {
    actionCrud.slideDown('fast');
    } else {
    actionCrud.slideUp('fast');
    }
});
$(document).on('click', function(event) {
    if (!$(event.target).closest('.dot_action, .action_crud').length) {
    $('.action_crud').slideUp('fast');
    }
});
});

// img show tabel
$(document).ready(function() {
    $(document).on('mouseenter', '.td_img_show', function() {
    $(this).next('.table_img').css('display', 'block');
});
$(document).on('mouseleave', '.td_img_show', function() {
    $(this).next('.table_img').css('display', 'none');
});
});

// show modal
$(document).ready(function() {
    $(document).on('click', '.triggermodal', function() {
    var target = $(this).data('target');
    $('#' + target).css('display', 'flex');
});
$(document).on('click', '.closemodal', function() {
    $(this).closest('.sec_modal').css('display', '');
});
$(document).on('click', function(event) {
    var target = $(event.target);
    if (!target.closest('.componen_modal').length && !target.closest('.triggermodal').length) {
    $('.sec_modal').css('display', 'none');
    }
});
});

// search table
$(document).ready(function() {
    $('body').on('keyup', 'input[id^="searchData-"]', function() {
    var searchValue = $(this).val().toLowerCase().trim();
    var targetClass = $(this).attr('id').split('-')[1];
    $('tr.filter_row').nextAll('tr').each(function() {
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
    getDataUrl(function(url) {
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
        success: function(data) {
            callback(data);
        },
        error: function() {
            callback('');
        }
    });
}

