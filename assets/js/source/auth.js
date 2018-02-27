var submitButton = function() {

    return {

        loading: function(element) {
            element.find('.zmdi').removeClass('zmdi-arrow-forward');
            element.find('.zmdi').addClass('zmdi-refresh rotate');
        }, 

        arrow: function(element) {
            element.find('.zmdi').removeClass('zmdi-refresh rotate');
            element.find('.zmdi').addClass('zmdi-arrow-forward');
        },

        valid: function(element) {
            element.find('.zmdi').removeClass('zmdi-refresh rotate');
            element.find('.zmdi').addClass('zmdi-check');
        }

    }

}();

// Login element
var loginForm = $('#login-form');
var loginButton = $('.btn-login');

// Login action
var Login = function() {

    return {

        init: function() {
            Login.main();
        },

        main: function() {

            loginForm.submit(function() {
                Login.submitForm();
                return false;
            });     
        },

        submitForm: function() {

            App.validateForm(loginForm, {
                identity: {
                    required: true
                },
                password: {
                    required: true
                }
            });

            if (loginForm.valid()) {
                
                loginButton.attr('disabled', true);
                submitButton.loading(loginButton);

                App.ajax(App.baseUrl('auth/checkLogin'), 'post', 'json', loginForm.serialize())
                    
                    .error(function(err) {
                        Login.loginFailed();
                    })

                    .success(function(data) {
                        if (data.status) {
                            submitButton.valid(loginButton);
                            window.location = (App.getUrlParameter('redirect')) ? App.getUrlParameter('redirect') : App.baseUrl('dashboard?welcome=1');
                        } else {
                            Login.loginFailed();
                        }
                    });

            }
        },

        loginFailed: function() {

            $('#login-form').addClass('animated shake');
            loginButton.attr('disabled', false);
            submitButton.arrow(loginButton);
            
            setTimeout(function(){
                $('#login-form').removeClass('animated shake');
            }, 1000);

        }

    }

}();

// Register element
var registerForm = $('#register-form');
var registerButton = $('.btn-register');

// Register action
var Register = function() {

    return {

        init: function() {
            Register.main();
        },

        main: function() {

            registerForm.submit(function() {
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Silahkan periksa kembali data yang Anda masukkan sebelum mengirim",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Tidak",
                    confirmButtonText: "Ya",
                    closeOnConfirm: true
                    },
                    function() {
                        Register.submitForm();
                });
                return false;
            });     
        },

        submitForm: function() {

            App.validateForm(registerForm, {
                username: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                password_confirm: {
                    required: true,
                    equalTo: '#password'
                },
                first_name: {
                    required: true,
                    minlength: 3
                },
                phone: {
                    required: true
                },
                address: {
                    required: true
                }
            });

            if (registerForm.valid()) {
                
                registerButton.attr('disabled', true);
                submitButton.loading(registerButton);

                App.ajax(App.baseUrl('auth/register'), 'post', 'json', registerForm.serialize())
                    
                    .error(function(err) {
                        registerButton.attr('disabled', false);
                        submitButton.arrow(registerButton);
                    })

                    .success(function(data) {

                        if (data.status) {
                            submitButton.valid(registerButton);
                            swal({
                                title: 'Berhasil', 
                                text: 'Terima kasih akun Anda berhasil dibuat, sebelum login silahkan melakukan konfirmasi melalui email yang kami kirimkan di ' + data.email, 
                                type: 'success',
                            },
                            function() {
                                location.reload();
                            });
                        } else {
                            swal({title: data.action, text: data.message, type: 'error', html: true});
                            registerButton.attr('disabled', false);
                            submitButton.arrow(registerButton);
                            
                            $('#register-form').addClass('animated shake');
                            setTimeout(function(){
                                $('#register-form').removeClass('animated shake');
                            }, 1000);      
                        }

                    });

            }
        }

    }

}();

// Forgot element
var forgotForm = $('#forgot-form');
var forgotButton = $('.btn-forgot');

// Forgot action
var Forgot = function() {

    return {

        init: function() {
            Forgot.main();
        },

        main: function() {

            forgotForm.submit(function() {
                Forgot.submitForm();
                return false;
            });     
        },

        submitForm: function() {

            App.validateForm(forgotForm, {
                identity: {
                    required: true,
                    minlength: 6
                }
            });

            if (forgotForm.valid()) {
                
                forgotButton.attr('disabled', true);
                submitButton.loading(forgotButton);

                App.ajax(App.baseUrl('auth/forgotPassword'), 'post', 'json', forgotForm.serialize())
                    
                    .error(function(err) {
                        forgotButton.attr('disabled', false);
                        submitButton.arrow(forgotButton);
                    })

                    .success(function(data) {

                        if (data.status) {
                            submitButton.valid(forgotButton);
                            swal({
                                title: 'Berhasil', 
                                text: data.message, 
                                type: 'success',
                            },
                            function() {
                                location.reload();
                            });
                        } else {
                            swal({title: 'Oops', text: data.message, type: 'error', html: true});
                            forgotButton.attr('disabled', false);
                            submitButton.arrow(forgotButton);

                            $('#forgot-form').addClass('animated shake');
                            setTimeout(function(){
                                $('#forgot-form').removeClass('animated shake');
                            }, 1000);      
                        }

                    });

            }
        }

    }

}();