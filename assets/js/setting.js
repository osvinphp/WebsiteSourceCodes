"use strict";var Setting={init:function(){Setting.main()},main:function(){App.loadChosen(".chosen"),$(document).on("submit","#settings-form",function(t){var n=$(this).find(".submit").val();return Setting.submitForm($("#settings-form"),n),!1})},submitForm:function(t,n){var e=t.find(".submit"),i=App.baseUrl("setting/update");App.blockElement(t.parent()),e.attr("disabled",!0),App.ajax(i,"post","json",App.serializeForm(t)).error(function(n){App.unblockElement(t.parent()),e.attr("disabled",!1)}).done(function(n){n.status?swal(n.action,n.message,"success"):swal({title:n.action,text:n.message,type:"error",html:!0}),e.attr("disabled",!1),App.unblockElement(t.parent())})}};