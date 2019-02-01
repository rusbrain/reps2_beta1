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
        $("#preview_img").filestyle(
            {
                input: true,
                text: "Выбрать файл",
                btnClass: 'btn-blue upload-avatar'
            });
    }
});

/**
 * User Create Replay page
 * */
$(function () {
    if ($('.user-create-replay-form').length > 0) {
        $("#replay").filestyle(
            {
                input: true,
                text: "Выбрать файл",
                btnClass: 'btn-blue upload-avatar'
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

    /**Vote - positive / negative vote - Separate Replay Page*/
    $('a.vote-replay-up, a.vote-replay-down').on('click', function (e) {
        var rating = $(this).attr('data-rating');
        var modal = $('#vote-modal');
        modal.find('form input#rating').val(rating);

        if (rating === '1') {
            modal.find('.negative').removeClass('active');
            modal.find('.positive').addClass('active');
        }
        if (rating === '-1') {
            modal.find('.negative').addClass('active');
            modal.find('.positive').removeClass('active');
        }
    });

    $('#vote-form').on('submit', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var comment = $(this).find('input[name=comment]').val();
        var rating = $(this).find('input[name=rating]').val();
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                comment: comment,
                rating: rating
            },
            success: function (response) {
                location.reload();
            },
            error: function () {

            }
        });
    });
});

/**
 * Hidden text - hide/show
 * */
$(function () {
    $('.quotetop').on('click', function (e) {
        $(this).siblings('.spoilmain').toggleClass('active');
    });
});

/**
 * Registration Form Page
 * */
$(function () {
    if ($('#register-form').length > 0) {
        var registrationForm = $('#register-form');
        /**Validation*/
        registrationForm.validate({
            rules: {
                name: "required",
                email: {required: true, email: true},
                password: "required",
                password_confirmation: "required"
            },
            messages: {
                name: {
                    required: "Заполните это поле"
                },
                email: {
                    required: "Заполните это поле",
                    email: "Неверный формат электронной почты"
                },
                password: "Заполните это поле",
                password_confirmation: "Заполните это поле"
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "name") {
                    error.insertAfter(registrationForm.find("input[name=name]"));
                }
                if (element.attr("name") === "email") {
                    error.insertAfter(registrationForm.find("input[name=email]"));
                }
                if (element.attr("name") === "password") {
                    error.insertAfter(registrationForm.find("input[name=password]"));
                }
                if (element.attr("name") === "password_confirmation") {
                    error.insertAfter(registrationForm.find("input[name=password_confirmation]"));
                }
            },
            errorElement: "div",
            submitHandler: function (form) {
                form.submit();
            }
        });
    }
});

/**View vote results ->  LEFT SIDEBAR */
$(function () {
    if($('#vote-question-form').length > 0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**view results*/
        $('#view-answer-results').on('click', function (e) {
            e.preventDefault();
            var url = $(this).attr('data-url');
            console.log(url);
            $.ajax({
                type: 'POST',
                url: url,
                success: function (html) {
                    $('#view-results-response').html(html);
                },
                error: function () {

                }
            });
        });

        /**send vote form*/
        $('#vote-question-form').on('submit', function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var answer_id = $(this).find('input[name=answer_id]').val();

            console.log(url);
            console.log(answer_id);

            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    answer_id: answer_id
                },
                success: function (html) {
                    $('#view-results-response').html(html);
                },
                error: function () {

                }
            });
        });
    }
});