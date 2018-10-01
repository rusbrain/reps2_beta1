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
                password_confirmation: "required",
                country : "required"
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
                password_confirmation: "Заполните это поле",
                country: "Заполните это поле"
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "name") {
                    error.insertBefore(registrationForm.find("input[name=name]"))
                }
                if (element.attr("name") === "email") {
                    error.insertBefore(registrationForm.find("input[name=email]"))
                }
                if (element.attr("name") === "country") {
                    error.insertBefore(registrationForm.find("select[name=country]"))
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