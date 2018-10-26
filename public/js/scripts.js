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
                password: {required:true}
            },
            messages: {
                email: {
                    required: "Заполните это поле",
                    email: "Неверный формат электронной почты"
                },
                password: {
                    required : "Заполните это поле"
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "email") {
                    error.insertBefore(loginForm.find("input[name=email]"))
                }
                if (element.attr("name") === "password") {
                    error.insertBefore(loginForm.find("input[name=password]"))
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
 * Registration Form
 * */
$(function () {
    var registrationForm = $('#register-form');
    if (registrationForm.length > 0) {

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
                    error.insertBefore(registrationForm.find("input[name=name]"))
                }
                if (element.attr("name") === "email") {
                    error.insertBefore(registrationForm.find("input[name=email]"))
                }
                if (element.attr("name") === "password") {
                    error.insertBefore(registrationForm.find("input[name=password]"))
                }
                if (element.attr("name") === "password_confirmation") {
                    error.insertBefore(registrationForm.find("input[name=password_confirmation]"))
                }
            },
            errorElement: "div",
            submitHandler: function (form) {
                form.submit();
            }
        });
    }
});

/**Vote Form*/
$(function () {
    var voteForm = $('#vote-form');
    if (voteForm.length > 0) {
        console.log('hi');
        /**Validation*/
        voteForm.validate({
            rules: {
                answer_id: {required: true}
            },
            messages: {
                answer_id: {
                    required : "Выберете вариант ответа"
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "answer_id") {
                    error.appendTo(voteForm.find("#vote-form-error"))
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
                        $('#view-results-response').html(html)
                    },
                    error: function () {

                    }
                });
            }
        });
    }
});

/**View vote results ->  Right SideBar */
$(function () {
    $.ajaxSetup({
       headers:{
           'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
       }
    });
    $('#view-answer-results').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('data-url');
        $.ajax({
            type: 'POST',
            url: url,
            success: function (html) {
                $('#view-results-response').html(html)
            },
            error: function () {

            }
        });
    });
});