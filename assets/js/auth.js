"use strict";var submitButton={loading:function(t){t.find(".zmdi").removeClass("zmdi-arrow-forward"),t.find(".zmdi").addClass("zmdi-refresh rotate")},arrow:function(t){t.find(".zmdi").removeClass("zmdi-refresh rotate"),t.find(".zmdi").addClass("zmdi-arrow-forward")},valid:function(t){t.find(".zmdi").removeClass("zmdi-refresh rotate"),t.find(".zmdi").addClass("zmdi-check")}},loginForm=$("#login-form"),loginButton=$(".btn-login"),Login={init:function(){Login.main()},main:function(){loginForm.submit(function(){return Login.submitForm(),!1})},submitForm:function(){App.validateForm(loginForm,{identity:{required:!0},password:{required:!0}}),loginForm.valid()&&(loginButton.attr("disabled",!0),submitButton.loading(loginButton),App.ajax(App.baseUrl("auth/checkLogin"),"post","json",loginForm.serialize()).error(function(t){Login.loginFailed()}).success(function(t){t.status?(submitButton.valid(loginButton),window.location=App.getUrlParameter("redirect")?App.getUrlParameter("redirect"):App.baseUrl("dashboard?welcome=1")):Login.loginFailed()}))},loginFailed:function(){$("#login-form").addClass("animated shake"),loginButton.attr("disabled",!1),submitButton.arrow(loginButton),setTimeout(function(){$("#login-form").removeClass("animated shake")},1e3)}},registerForm=$("#register-form"),registerButton=$(".btn-register"),Register={init:function(){Register.main()},main:function(){registerForm.submit(function(){return swal({title:"Apakah Anda Yakin?",text:"Silahkan periksa kembali data yang Anda masukkan sebelum mengirim",type:"warning",showCancelButton:!0,cancelButtonText:"Tidak",confirmButtonText:"Ya",closeOnConfirm:!0},function(){Register.submitForm()}),!1})},submitForm:function(){App.validateForm(registerForm,{username:{required:!0,minlength:6,maxlength:20},email:{required:!0,email:!0},password:{required:!0,minlength:6,maxlength:20},password_confirm:{required:!0,equalTo:"#password"},first_name:{required:!0,minlength:3},phone:{required:!0},address:{required:!0}}),registerForm.valid()&&(registerButton.attr("disabled",!0),submitButton.loading(registerButton),App.ajax(App.baseUrl("auth/register"),"post","json",registerForm.serialize()).error(function(t){registerButton.attr("disabled",!1),submitButton.arrow(registerButton)}).success(function(t){t.status?(submitButton.valid(registerButton),swal({title:"Berhasil",text:"Terima kasih akun Anda berhasil dibuat, sebelum login silahkan melakukan konfirmasi melalui email yang kami kirimkan di "+t.email,type:"success"},function(){location.reload()})):(swal({title:t.action,text:t.message,type:"error",html:!0}),registerButton.attr("disabled",!1),submitButton.arrow(registerButton),$("#register-form").addClass("animated shake"),setTimeout(function(){$("#register-form").removeClass("animated shake")},1e3))}))}},forgotForm=$("#forgot-form"),forgotButton=$(".btn-forgot"),Forgot={init:function(){Forgot.main()},main:function(){forgotForm.submit(function(){return Forgot.submitForm(),!1})},submitForm:function(){App.validateForm(forgotForm,{identity:{required:!0,minlength:6}}),forgotForm.valid()&&(forgotButton.attr("disabled",!0),submitButton.loading(forgotButton),App.ajax(App.baseUrl("auth/forgotPassword"),"post","json",forgotForm.serialize()).error(function(t){forgotButton.attr("disabled",!1),submitButton.arrow(forgotButton)}).success(function(t){t.status?(submitButton.valid(forgotButton),swal({title:"Berhasil",text:t.message,type:"success"},function(){location.reload()})):(swal({title:"Oops",text:t.message,type:"error",html:!0}),forgotButton.attr("disabled",!1),submitButton.arrow(forgotButton),$("#forgot-form").addClass("animated shake"),setTimeout(function(){$("#forgot-form").removeClass("animated shake")},1e3))}))}};