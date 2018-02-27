// Profile action
var Profile = function() {

    return {

        // Execute js module 
        init: function() {
            Profile.main();
        },

        // Main function of the module
        main: function() {

            App.loadDatePicker('.date-picker');

            // Load avatar form modal
            $(document).on('click', '#update-avatar', function() {
                Profile.avatar();
            });

            // Submit form
            $(document).on('submit', 'form', function() {
                var userId = $(this).find('.submit').val();
                Profile.submitForm($(this), userId);
                return false;
            });

        },

        // Update avatar
        avatar: function(id) {
            var modal = App.loadModal('lg');
            var modalBody = modal.find('.modal-body');
            var modalTitle = modal.find('.modal-title');

            modalTitle.text('Update Avatar');

            App.blockElement($(modalBody));

            App.ajax(App.baseUrl('profile/loadAvatarForm'), 'get', 'html')
            
            .error(function(err) {
                modal.find('.close').click();
            })

            .done(function(data) {
                App.unblockElement($(modalBody));
                modalBody.html(data);
                Avatar.init();
            });
        },

        // Submit function
        submitForm: function(form, id) {

            var submitButton = form.find('.submit');

            // If form is valid run submit through ajax request
            if (form.valid()) {
                
                var url = App.baseUrl('profile/update');

                if (submitButton.val() == 'update-password') {
                    url = App.baseUrl('profile/updatePassword');
                }

                App.blockElement(form.parent());
                submitButton.attr('disabled', true);

                App.ajax(url, 'post', 'json', App.serializeForm(form))
                    
                .error(function(err) {
                    App.unblockElement(form.parent());
                    submitButton.attr('disabled', false);
                })

                .done(function(data) { console.log(data);
                    
                    if (data.status) {
                        $('#profile-main').load(location.href + ' #profile-main>*', '');
                        $('.s-profile').load(location.href + ' .s-profile>*', '');
                        App.loadDatePicker('.date-picker');
                        swal(data.action, data.message, 'success');
                    } else {
                        swal({title: data.action, text: data.message, type: 'error', html: true});
                    }

                    submitButton.attr('disabled', false);
                    App.unblockElement(form.parent());
                });

            }
        },

    }

}();