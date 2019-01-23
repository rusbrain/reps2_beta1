/**
 * Menu - plugin "metisMenu"
 * https://www.jqueryscript.net/menu/jQuery-Accordion-Menu-Plugin-For-Bootstrap-3-metisMenu.html
 * **/
$(function () {
    if ($('#menu').length > 0) {
        var menu = $('#menu');
        menu.metisMenu({
            // enabled/disable the auto collapse.
            toggle: true,

            // prevent default event
            preventDefault: true,

            // default classes
            activeClass: 'active',
            collapseClass: 'collapse',
            collapseInClass: 'in',
            collapsingClass: 'collapsing',

            // .nav-link for Bootstrap 4
            triggerElement: 'a',

            // .nav-item for Bootstrap 4
            parentTrigger: 'li',

            // .nav.flex-column for Bootstrap 4
            subMenu: 'ul'
        });
    }
});

/**
 * Comments box is the same for all pages
 *SCEditor -  WYSIWYG BBCode editor
 * https://www.sceditor.com/
 * */
$(function () {
    if ($('#comment-content').length > 0) {
        var textarea = document.getElementById('comment-content');

        sceditor.create(textarea, {
            format: 'bbcode',
            style: 'js/sceditor/minified/themes/content/default.min.css',
            emoticonsRoot: 'js/sceditor/',
            locale: 'ru'
        });
    }
});

/**
 * Logged user menu
 * Show by click on icon with class .logged-user-menu
 * */
$(function () {
    if ($('.logged-user-menu').length > 0) {
        $('.logged-user-menu').on('click', function (e) {
            e.preventDefault();
            $('.logged-user-menu-links').toggleClass('active');
        });

        $('body').on('click', function (e) {
            var div = $('.logged-user-menu-links');
            var link = $('.logged-user-menu');

            if (!div.is(e.target) && !link.is(e.target)) {
                div.removeClass('active');
            }
        });
    }
});

/**
 * User Account edit page
 *
 * SCEditor -  WYSIWYG BBCode editor
 * https://www.sceditor.com/
 * */
$(function () {
    if ($('.user-account-edit-form').length > 0) {
        var textarea = document.getElementById('signature');

        sceditor.create(textarea, {
            format: 'bbcode',
            style: 'js/sceditor/minified/themes/content/default.min.css',
            emoticonsRoot: 'js/sceditor/',
            locale: 'ru'
        });

        $("#avatar").filestyle(
            {
                input: true,
                text: "Загрузить фото",
                btnClass: 'btn-blue upload-avatar'
            });
    }
});

/**
 * User Gallery page
 * */
$(function () {
    if ($('.user-gallery-form').length > 0) {
        $(".image").filestyle(
            {
                input: true,
                text: "Выбрать файл",
                btnClass: 'btn-blue upload-avatar'
            });
    }
});

/**
 * User Post / Themes pages
 * */
$(function () {
    if ($('#user-posts').length > 0) {
        var accordion = $('#user-posts');
        accordion.on('hide.bs.collapse', function (e) {
            $('#' + e.target.id).prev('.card-header').find('a .icon_collapse').toggleClass('open');
        });
        accordion.on('show.bs.collapse', function (e) {
            $('#' + e.target.id).prev('.card-header').find('a .icon_collapse').toggleClass('open');
        });
    }
});

/**
 * User Create Theme page
 * */
$(function () {
    if ($('.user-create-theme-form').length > 0) {
        var preview_content = document.getElementById('preview_content');
        var content = document.getElementById('content');

        $("#preview_img").filestyle(
            {
                input: true,
                text: "Выбрать файл",
                btnClass: 'btn-blue upload-avatar'
            });

        sceditor.create(preview_content, {
            format: 'bbcode',
            style: 'js/sceditor/minified/themes/content/default.min.css',
            emoticonsRoot: 'js/sceditor/',
            locale: 'ru'
        });
        sceditor.create(content, {
            format: 'bbcode',
            style: 'js/sceditor/minified/themes/content/default.min.css',
            emoticonsRoot: 'js/sceditor/',
            locale: 'ru'
        });
    }
});

/**
 * User Create Replay page
 * */
$(function () {
    if ($('.user-create-replay-form').length > 0) {
        var content = document.getElementById('content');
        $("#replay").filestyle(
            {
                input: true,
                text: "Выбрать файл",
                btnClass: 'btn-blue upload-avatar'
            });
        sceditor.create(content, {
            format: 'bbcode',
            style: 'js/sceditor/minified/themes/content/default.min.css',
            emoticonsRoot: 'js/sceditor/',
            locale: 'ru'
        });
    }
});

/**
 * User Messages Page
 * */
$(function () {
    if ($('.user-message-form').length > 0) {
        var content = document.getElementById('message');
        $(".user-message-form button").filestyle(
            {
                input: true,
                text: "Выбрать файл",
                btnClass: 'btn-blue upload-avatar'
            });
        sceditor.create(content, {
            format: 'bbcode',
            style: 'js/sceditor/minified/themes/content/default.min.css',
            emoticonsRoot: 'js/sceditor/',
            locale: 'ru'
        });
    }
});

/**
 * Single Replay page
 * */
$(function () {
    if ($('.user-menu-link').length > 0) {
        $('.user-menu-link').on('click', function (e) {
            e.preventDefault();
            $('.user-menu').each(function () {
                $(this).removeClass('active');
            });
            $(this).next('.user-menu').toggleClass('active');
        });

        $('body').on('click', function (e) {
            var menuDiv = $('.user-menu');
            var userLink = $('.user-menu-link');

            if (!menuDiv.is(e.target) && !userLink.is(e.target)) {
                menuDiv.removeClass('active');
            }
        });
    }
});