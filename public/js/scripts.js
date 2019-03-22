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

            if (!div.is(e.target) && !link.is(e.target) && !div.find('a').is(e.target)) {
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
    $('body').on('click','.user-menu-link ', function (e) {
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

    /**Vote - positive / negative vote - Separate Replay Page*/
    $('body').on('click','a.vote-replay-up, a.vote-replay-down', function (e) {
        var rating = $(this).attr('data-rating');
        var modal = $('#vote-modal');
        var url = $(this).attr('data-route');
        modal.find('form input#rating').val(rating);
        modal.find('form').attr('action', url);
        modal.find('.modal-body .unregistered-info-wrapper').removeClass('active');

        if (rating === '1') {
            modal.find('.negative').removeClass('active');
            modal.find('.positive').addClass('active');
        }
        if (rating === '-1') {
            modal.find('.negative').addClass('active');
            modal.find('.positive').removeClass('active');
        }
    });

    $('body').on('submit','#rating-vote-form', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var selectData = $('#rating-vote-form').serialize();
        var imgClass = 'positive-vote-img';
        $.ajax({
            type: 'POST',
            url: url,
            data: selectData,
            success: function (response) {
                if(response.message){
                    if(response.user_rating === "-1"){
                        imgClass = 'negative-vote-img';
                        console.log(response.user_rating);
                    }
                    $('#vote-modal').find('.modal-body .unregistered-info-wrapper').addClass('active');
                    $('#vote-modal').find('.modal-body .unregistered-info-wrapper .notice').html(response.message);
                    $('#vote-modal').find('.modal-body'+' .'+imgClass).addClass('active');
                }else{
                    location.reload();
                }
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

        /**Vote Form - Right Sidebar*/
        var voteForm = $('#vote-question-form');
        if (voteForm.length > 0) {
            /**Validation*/
            voteForm.validate({
                rules: {
                    answer_id: {required: true}
                },
                messages: {
                    answer_id: {
                        required: "Выберите вариант ответа"
                    }
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") === "answer_id") {
                        error.appendTo(voteForm.find(".display-error"));
                    }
                },
                errorElement: "div",
                submitHandler: function (form) {
                    var selectData = $(form).serialize();

                    $.ajax({
                        type: 'POST',
                        url: $(form).attr('action'),
                        data: selectData,
                        success: function (html) {
                            $('#view-results-response').html(html);
                        },
                        error: function () {

                        }
                    });
                }
            });
        }
    }
});

/**
 * Login Form
 * */
$(function () {
    var loginForm = $('#login-form');
    if (loginForm.length > 0) {

        /**Validation*/
        loginForm.validate({
            rules: {
                email: {required: true, email: true},
                password: {required: true}
            },
            messages: {
                email: {
                    required: "Заполните это поле",
                    email: "Неверный формат электронной почты"
                },
                password: {
                    required: "Заполните это поле"
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "email") {
                    error.insertAfter(loginForm.find("input[name=email]"));
                }
                if (element.attr("name") === "password") {
                    error.insertAfter(loginForm.find("input[name=password]"));
                }
            },
            errorElement: "div",
            submitHandler: function (form) {
                form.submit();
            }
        });
    }
});

/**
 * Scroll page Up Button
 * */
$(function(){
    var btnUp = $('.button-up');
    var body = $("html, body");
    var sc;
    var content = $('.main-content');
    var menuPosition = parseInt(content.offset().top);

    /**start scroll function */
    document.onscroll = my_func;
    function my_func() {
        sc = parseInt($(document).scrollTop());
        if(sc > menuPosition){
            btnUp.addClass('fixed in');
        }else{
            btnUp.removeClass('fixed in');
        }
    }
    btnUp.on('click', function (e) {
        e.preventDefault();
        body.animate({scrollTop:0}, 800, 'swing', function() { });
    });
});

/**
 * Move to Comment Form
 * */
$(function(){
    $('body').on('click','.move-to-add-comment', function () {
        moveToCommentForm();
    });
});

/**
 * Move to add comment form function
 * */
function moveToCommentForm() {
    var commentForm = $(".add-comment-form");
    var moveFormPosition = parseInt(commentForm.offset().top);
    var body = $("html, body");
    body.animate(
        {
            scrollTop: moveFormPosition
        }, 1200, 'swing', function() { });

    commentForm.find('input[name=title]').focus();
}

/**
 * Move to top after load page data
 * */
function moveToTop(container){

    var body = $("html, body");
    var moveFormPosition = parseInt(container.offset().top);
    body.animate(
        {
            scrollTop: moveFormPosition
        }, 2000, 'swing', function() { });
}

/**Get all smiles for HTML text editor*/
function getAllSmiles() {
    var path = 'emoticons/smiles/';
    var smile = 's';
    var extension = '.gif';
    var qty = 63;
    var smilesObject = {};
    var key;
    var result;

    for (var i = 0; i <= qty; i++) {
        key = smile + i;
        result = path + smile + i + extension;
        smilesObject[key] = result;
    }
    return smilesObject
}
/**Get additional smiles for HTML text editor*/
function getMoreSmiles() {
    var path = 'emoticons/smiles/';
    var smilesObject = {
        'silver': path + 'silver.png',
        'terran': path + 'terran.gif',
        'zerg': path + 'zerg.gif',
        'gold': path + 'gold.png',
        'protoss': path + 'protoss.gif'
    };
    return smilesObject
}