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
    $('body').on('click', '.user-menu-link ', function (e) {
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
    $('body').on('click', 'a.vote-replay-up, a.vote-replay-down', function (e) {
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

    $('body').on('submit', '#rating-vote-form', function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var selectData = $('#rating-vote-form').serialize();
        var imgClass = 'positive-vote-img';
        $.ajax({
            type: 'POST',
            url: url,
            data: selectData,
            success: function (response) {
                if (response.message) {
                    if (response.user_rating === "-1") {
                        imgClass = 'negative-vote-img';
                    }
                    if (response.user_rating === undefined) {
                        imgClass = '';
                    }
                    $('#vote-modal').find('.modal-body .unregistered-info-wrapper').addClass('active');
                    $('#vote-modal').find('.modal-body .unregistered-info-wrapper .notice').html(response.message);
                    $('#vote-modal').find('.modal-body' + ' .' + imgClass).addClass('active');
                } else {
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
    $('body').on('click', '.quotetop', function (e) {
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
                email: { required: true, email: true },
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

    if ($(".vote-form").length > 0) {
        for (var i = 0; i < $(".vote-form").length; i++) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /**view results*/
            $('#view-answer-results-' + i).on('click', function (e) {
                e.preventDefault();
                var num = $(this).attr('data-num');
                var url = $(this).attr('data-url');
                $.ajax({
                    type: 'POST',
                    url: url,
                    success: function (html) {
                        $('#view-results-response-' + num).html(html);
                    },
                    error: function () {

                    }
                });
            });
        }
        /**Vote Form - Right Sidebar*/

        $(".vote-form").each(function (index) {
            var voteForm = $(this);
            if (voteForm.length > 0) {
                /**Validation*/
                voteForm.validate({
                    rules: {
                        answer_id: { required: true }
                    },
                    messages: {
                        answer_id: {
                            required: "Выберите вариант ответа"
                        }
                    },
                    errorPlacement: function (error, element) {
                        if (element.attr("name") === "answer_id") {
                            error.appendTo(voteForm.find(".display-error-" + voteForm.attr('data-num')));
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
                                $('#view-results-response-' + voteForm.attr('data-num')).html(html);
                            },
                            error: function () {

                            }
                        });
                    }
                });
            }
        })
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
                email: { required: true, email: true },
                password: { required: true }
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
$(function () {
    var btnUp = $('.button-up');
    var body = $("html, body");
    var sc;
    var content = $('.main-content');
    var menuPosition = parseInt(content.offset().top);

    /**start scroll function */
    document.onscroll = my_func;

    function my_func() {
        sc = parseInt($(document).scrollTop());
        if (sc > menuPosition) {
            btnUp.addClass('fixed in');
        } else {
            btnUp.removeClass('fixed in');
        }
    }

    btnUp.on('click', function (e) {
        e.preventDefault();
        body.animate({ scrollTop: 0 }, 800, 'swing', function () {
        });
    });
});

/**
 * Move to Comment Form
 * */
$(function () {
    $('body').on('click', '.move-to-add-comment', function () {
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
        }, 1200, 'swing', function () {
        });

    commentForm.find('input[name=title]').focus();
}

/**
 * Move to top after load page data
 * */
function moveToTop(container) {

    var body = $("html, body");
    var moveFormPosition = parseInt(container.offset().top);
    body.animate(
        {
            scrollTop: moveFormPosition
        }, 2000, 'swing', function () {
        });
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
        key = ':' + smile + i + ':';
        result = path + smile + i + extension;
        smilesObject[key] = result;
    }
    return smilesObject
}

/**Get additional smiles for HTML text editor*/
function getMoreSmiles() {
    var path = 'emoticons/smiles/';
    var smilesObject = {
        ':silver:': path + 'silver.png',
        ':terran:': path + 'terran.gif',
        ':zerg:': path + 'zerg.gif',
        ':gold:': path + 'gold.png',
        ':protoss:': path + 'protoss.gif',
        ':random:': path + 'random.png'
    };
    return smilesObject
}

/**race's images array for custom command of HTML text editor SCEditor */
function getRacesImg() {
    return ['terran.gif', 'zerg.gif', 'protoss.gif', 'random.png'];
}

/**countries's code array for custom command of HTML text editor SCEditor */
function getCountries() {
    return [
        'RU',
        'KR',
        'KZ',
        'BY',
        'PL',
        'UA',
        'UZ',
        'CN',
        'TW',
        'GR',
        'AL',
        'DZ',
        'AD',
        'AO',
        'AR',
        'AM',
        'AU',
        'AT',
        'AZ',
        'BS',
        'BH',
        'BD',
        'BB',
        'AF',
        'CF',
        'BE',
        'BZ',
        'BJ',
        'BT',
        'BO',
        'BA',
        'BW',
        'BR',
        'BN',
        'BG',
        'BF',
        'BI',
        'KH',
        'CM',
        'CA',
        'CV',
        'CL',
        'CO',
        'CG',
        'HR',
        'CU',
        'CY',
        'CZ',
        'DK',
        'EC',
        'EG',
        'ER',
        'EE',
        'ET',
        'EU',
        'FJ',
        'FI',
        'FR',
        'GA',
        'GE',
        'DE',
        'GT',
        'GN',
        'GY',
        'HT',
        'HK',
        'HR',
        'HU',
        'IS',
        'IN',
        'ID',
        'IR',
        'IQ',
        'IE',
        'IL',
        'IT',
        'CI',
        'JM',
        'JP',
        'JO',
        'KE',
        'KP',
        'KG',
        'LV',
        'LB',
        'LY',
        'LT',
        'LU',
        'MG',
        'MY',
        'MR',
        'MX',
        'MD',
        'MC',
        'MN',
        'MA',
        'MZ',
        'NA',
        'NR',
        'NP',
        'NL',
        'NZ',
        'NO',
        'OM',
        'PK',
        'PA',
        'PY',
        'PE',
        'PH',
        'PT',
        'QA',
        'RO',
        'SA',
        'RS',
        'SL',
        'SG',
        'SK',
        'SI',
        'SO',
        'ZA',
        'ES',
        'SD',
        'SE',
        'CH',
        'TZ',
        'TW',
        'TH',
        'TG',
        'TO',
        'TT',
        'TN',
        'TR',
        'TV',
        'UK',
        'US',
        'UG',
        'UY',
        'VE',
        'VN',
        'YE',
        'ZW'
    ];
}

/**
 * Add custom command: "races" into HTML text editor SCEditor
 * https://www.sceditor.com/posts/how-to-add-custom-commands/
 * https://www.sceditor.com/
 * */
function addRaces() {
    sceditor.command.set("races", {
        exec: function (caller) {
            // Store the editor instance so it can be used
            // in the click handler
            var races = getRacesImg();
            var editor = this;
            var $content = $("<div />");
            // Create country flags options
            for (var i = 0; i < races.length; i++) {
                $(
                    '<img src="/images/smiles/' + races[i] + '" alt="">'
                )
                    .data('race', races[i])
                    .click(function (e) {
                        editor.insert('<img src="/images/smiles/' + $(this).data('race') + '" alt="">');
                        editor.closeDropDown(true);

                        e.preventDefault();
                    })
                    .appendTo($content);
            }
            editor.createDropDown(caller, "race-picker", $content.get(0));
        },
        tooltip: "Race"
    });
}

/**
 * Add custom command: "countries" into HTML text editor SCEditor
 * https://www.sceditor.com/posts/how-to-add-custom-commands/
 * https://www.sceditor.com/
 * */
function addCountries() {
    sceditor.command.set("countries", {
        exec: function (caller) {
            // Store the editor instance so it can be used
            // in the click handler
            var flags = getCountries().map(function (value) {
                return value.toLowerCase();
            });
            var editor = this;
            var $content = $("<div />");
            // Create country flags options
            for (var i = 0; i < flags.length; i++) {
                $(
                    '<span class="flag-icon flag-icon-' + flags[i] + '" title="' + flags[i] + '"></span>'
                )
                    .data('flag', flags[i])
                    .click(function (e) {
                        editor.insert('<img src="/flags/editor/' + $(this).data('flag') + '.png" alt=""/>');
                        editor.closeDropDown(true);

                        e.preventDefault();
                    })
                    .appendTo($content);
            }
            editor.createDropDown(caller, "country-picker", $content.get(0));
        },
        tooltip: "Countries flags"
    });
}

function addUpload() {
    sceditor.command.set("upload", {
        exec: function (caller) {
            var editor = this;
            var content = document.createElement("DIV");
            var div = '<label class="prev_imgs">All Images</label>'+
                      '<form id="upload_form"><label for="upload">Upload</label> ' +
                      '<input type="file" id="upload" dir="ltr"  /></div>' +
                      '<div><input type="button" class="button" value="Upload" />' +
                      '</form>';
            $(content).append(div);
            $(content).on("click", '.prev_imgs', function(){ 
                $("body").addClass('upload-overlay-open')               
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '/forum/topic/get_prev_images',                 
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                    data: [],
                    datatype: 'JSON',
                    success: function (result) {
                        $(".all_images").append(result)
                    },
                    error: function (e) {
                        console.log(e)
                    }
                });
              
            });

            $("body").on('click', '.upload-overlay .showImages .close_overlay', function(e) {
                $(".all_images").children().remove()
                $("body").removeClass('upload-overlay-open')            
            })

            $("body").on('click', '.upload-overlay .showImages .open_img', function(e){
                $(".prev_image").each(function(index){
                    if($(this).find('input[type=checkbox]').prop("checked")) {
                        editor.insert('<img src="' + $(this).find('img').attr('src') + '" alt="" style="max-width: 95%;">');
                    }
                })
                $(".all_images").children().remove()
                $("body").removeClass('upload-overlay-open') 
                editor.closeDropDown(true);
                e.preventDefault();
            })
            $(content).on('click', '.button', function (e) {
                var input = $(content).find("#upload")[0];
                if (input.value) {
                    if (input.files && input.files[0]) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        var formdata = new FormData();
                        formdata.append("file", input.files[0]);
                        $.ajax({
                            type: 'POST',
                            url: '/forum/topic/img_upload',
                            data: formdata,
                            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                            processData: false, // NEEDED, DON'T OMIT THIS
                            success: function (result) {
                                if (result.success) {
                                    editor.insert('<img src="' + result.data + '" alt="" style="max-width: 95%;">');
                                } else {
                                    alert(result.data) //
                                }
                            },
                            error: function (e) {
                                console.log(e)
                            }
                        });
                    }
                } else {
                    alert("Please select file");
                }
                editor.closeDropDown(true);
                e.preventDefault();
            });

            editor.createDropDown(caller, 'uploadimage', content);
        },
        tooltip: 'Upload Image'
    });
}

function addStream() {
    sceditor.command.set("streams", {
        exec: function (caller) {
            var	editor  = this;
            var content =document.createElement("DIV");
            var div = 
                '<label for="link" unselectable="on">Stream URL:</label> '+
                '<input type="text" id="stream" dir="ltr" placeholder="https://">'+
                '</div>'+
                '<div unselectable="on">'+
                '<label for="width" unselectable="on">Ширина (необязательно):</label>'+
                '<input type="text" id="width" size="2" dir="ltr">'+
                '</div>'+
                '<div unselectable="on">'+
                '<label for="height" unselectable="on">Высота (необязательно):</label>'+
                '<input type="text" id="height" size="2" dir="ltr">'+
                '</div>'+
                '<div unselectable="on">'+
                '<input type="button" class="button" value="Вставить">'
                ;
            $(content).append(div);
            $(content).on('click', '.button', function (e) {
                var	input = $(content).find("#stream");
                if(input.val()) {
                    var width = ($('#width').val()) ? $('#width').val() : '640';
                    var height = ($('#height').val()) ? $('#height').val() : '510';
                    editor.insert('<iframe src="'+input.val()+'" height="'+height+'" width="'+width+'" frameborder="0" scrolling="no" allowfullscreen="true">'+
                    '</iframe>');
                }
                editor.closeDropDown(true);
                e.preventDefault();
            })
            editor.createDropDown(caller, "insertstream", content);
        },
        tooltip: "Video Stream"
    });
}

function addSpoiler() {
    var IE_VER = sceditor.ie;
	// In IE < 11 a BR at the end of a block level element
	// causes a double line break.
	var IE_BR_FIX = IE_VER && IE_VER < 11;
    $.sceditor.command.set("spoiler", {
        exec: function(caller, html) {
            // Store the editor instance so it can be used
            // in the click handler
            var editor   = this
           
            var	before = '[spoiler]',
            end    = '[/spoiler]';

            // if there is HTML passed set end to null so any selected
            // text is replaced
            if (html) {               
                before = before + html + end;
                end    = null;
            // if not add a newline to the end of the inserted quote
            } else if (this.getRangeHelper().selectedHtml() === '') {
             
            }
            this.wysiwygEditorInsertHtml(before, end);        
        },
        tooltip: "Spoiler"
    });

}