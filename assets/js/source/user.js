// User element
var userGrid = $('#user-grid');
var addUser = $('#add-user');

// User action
var User = function() {

    return {

        // Execute js module 
        init: function() {
            User.main();
            User.loadGrid();
        },

        // Main function of the module
        main: function() {

            // Load add form modal
            addUser.click(function() {
                User.add();                
            });

            // Submit add form
            $(document).on('submit', '#add-form', function() {
                User.submitForm($('#add-form'), null);
                return false;
            });

            // Submit edit form
            $(document).on('submit', '#edit-form', function(data) {
                var userId = $(this).find('.submit').val();
                User.submitForm($('#edit-form'), userId);
                return false;
            });
        },

        // Submit function
        submitForm: function(form, id) {

            var submitButton = form.find('.submit');
            var url = App.baseUrl('user/insert');

            if (id) {
                url = App.baseUrl('user/update');
            }
            
            App.blockElement(form.parent());
            submitButton.attr('disabled', true);

            App.ajax(url, 'post', 'json', App.serializeForm(form))
                
            .error(function(err) {
                App.unblockElement(form.parent());
                submitButton.attr('disabled', false);
            })

            .done(function(data) {
                if (data.status) {
                    form.find('[data-dismiss="modal"]').click();
                    swal(data.action, data.message, "success");
                    User.reloadGrid();
                } else {
                    submitButton.attr('disabled', false);
                    App.unblockElement(form.parent());
                    swal({title: data.action, text: data.message, type: "error", html: true});
                }
            });

        },

        // Reload the table grid
        reloadGrid: function() {
            userGrid.bootgrid('reload');
        },

        // Table grid function
        loadGrid: function() {

            App.bootGrid(userGrid, {
                
                username: function(column, row) {
                    return '<a href="'+App.baseUrl('profile/' + row.username)+'">'+row.username+'</a>';
                },

                action: function(column, row) {
                    
                    var profileButton = '<a href="' + App.baseUrl('profile/') + row.id + '" class="btn btn-primary waves-effect action-profile" data-row-id="' + row.id + '"><span class="zmdi zmdi-face"></span></a>';

                    var editButton = '<button type="button" class="btn bgm-amber waves-effect action-edit" data-row-id="' + row.id + '"><span class="zmdi zmdi-edit"></span></button>';
                    
                    var deleteButton = '<button type="button" class="btn btn-danger waves-effect action-delete" data-row-id="' + row.id + '"><span class="zmdi zmdi-delete"></span></button>';
                    
                    return '<div class="btn-group">' + profileButton + editButton + deleteButton + '</div>';
                },

                profilePicture: function(column, row) {
                    if (row.profilePicture)
                        return '<img class="lgi-img" src="'+row.profilePicture+'" alt="">';
                    else
                        return '<img class="lgi-img" src="'+App.baseUrl('uploads/avatars/noavatar.png')+'" alt="">';
                }

            }).on("loaded.rs.jquery.bootgrid", function() {

                /* Executes after data is loaded and rendered */
                App.enableColumnResize('#user-grid th');

                userGrid.find('.action-edit').on('click', function(e) {

                    User.edit($(this).data('row-id'));
                
                });
                
                userGrid.find('.action-delete').on('click', function(e) {

                    User.delete($(this).data('row-id'));

                });

            });

        },

        // Add user
        add: function() {
            
            var modal = App.loadModal();
            var modalBody = modal.find('.modal-body');
            var modalTitle = modal.find('.modal-title');

            modalTitle.text('Add User');

            App.blockElement($(modalBody));

            App.ajax(App.baseUrl('user/loadAddForm'), 'get', 'html')
            
            .error(function(err) {
                modal.find('.close').click();
            })

            .done(function(data) {
                modalBody.html(data);
                App.loadChosen('.chosen');
                App.unblockElement($(modalBody));
            });
        },

        // Edit user data
        edit: function(id) {

            var modal = App.loadModal();
            var modalBody = modal.find('.modal-body');
            var modalTitle = modal.find('.modal-title');

            modalTitle.text('Edit User');

            App.blockElement($(modalBody));

            App.ajax(App.baseUrl('user/loadEditForm'), 'get', 'html', {id:id})
                
            .error(function(err) {
                modal.find('.close').click();
            })

            .done(function(data) {
                modalBody.html(data);
                App.loadChosen('.chosen');
                App.unblockElement($(modalBody));
            });

        },

        // Delete user data
        delete: function(id) {

            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover the data!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: false
            }, function(){

                App.ajax(App.baseUrl('user/delete'), 'post', 'json', {id: id, parse_csrf_token: Cookies.get('parse_csrf_cookie')})
                    
                .done(function(data) {
                    if (data.status) {
                        User.reloadGrid();
                        swal(data.action, data.message, "success");
                    } else {
                        swal(data.action, data.message, "error");
                    }
                });

            });

        }

    }

}();