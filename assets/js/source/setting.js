// Setting action
var Setting = function() {

    return {

        // Execute js module 
        init: function() {
            Setting.main();
        },

        // Main function of the module
        main: function() {

            App.loadChosen('.chosen');

            // $('[name="analyticApiKey"]').html(JSON.stringify($(this).text), undefined, 2);

            // Submit form
            $(document).on('submit', '#settings-form', function(data) {
                var id = $(this).find('.submit').val();
                Setting.submitForm($('#settings-form'), id);
                return false;
            });
        },

        // Submit function
        submitForm: function(form, id) {

            var submitButton = form.find('.submit');
            var url = App.baseUrl('setting/update');
            
            App.blockElement(form.parent());
            submitButton.attr('disabled', true);

            App.ajax(url, 'post', 'json', App.serializeForm(form))
            
            .error(function(err) {
                App.unblockElement(form.parent());
                submitButton.attr('disabled', false);
            })

            .done(function(data) {
                if (data.status) {
                    swal(data.action, data.message, "success");
                } else {
                    swal({title: data.action, text: data.message, type: "error", html: true});
                }
                submitButton.attr('disabled', false);
                App.unblockElement(form.parent());
            });

        },

    }

}();