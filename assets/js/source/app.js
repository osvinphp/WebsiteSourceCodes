var App = function() {

    return {
        
        ajax: function(url, method, dataType, data) {
            return $.ajax({
                url: url,
                type: method,
                datatype: dataType,
                data: data,
                error: function(err) {
                    // swal(err.status.toString(), err.statusText, 'error');
                    console.log('Error fetching data from ' + url, err);
                }
            });
        },

        ajaxFile: function(url, method, dataType, data) {
            return $.ajax({
                url: url,
                type: method,
                datatype: dataType,
                data: data,
                error: function(err) {
                    console.log('Error fetching data from ' + url, err);
                },
                contentType: false,
                processData: false
            });
        },

        smartjax: function(url, method, dataType, data, store) {
            return Smartjax.ajax({
                url: url,
                type: method,
                datatype: dataType,
                data: data,
                store: store,
                error: function(err) {
                    // swal(err.status.toString(), err.statusText, 'error');
                    console.log('Error fetching data from ' + url, err);
                },
            });
        },

        getUrlParameter: function(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        },

        welcomeMessage: function(message, type) {
            $.growl({
                message: message
            },{
                type: type,
                allow_dismiss: false,
                label: 'Cancel',
                className: 'btn-xs btn-inverse',
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
                delay: 2500,
                animate: {
                    enter: 'animated fadeInUp',
                    exit: 'animated fadeOutDown'
                },
                offset: {
                    x: 30,
                    y: 30
                }
            });
        },

        randomBetween: function(min, max) {
            return Math.floor(Math.random()*(max-min+1)+min);
        },

        randomColor: function() {
            var colors = ['#2ecc71', '#3498db', '#9b59b6', '#34495e', '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#2c3e50', '#f1c40f', '#e67e22', '#e74c3c', '#f39c12', '#d35400', '#c0392b'];
            var randomIndex = App.randomBetween(0, colors.length - 1);
            
            return colors[randomIndex];
        },
        
        isInArray: function(value, array) {
            return array.indexOf(value) > -1;
        },

        serializeForm: function(form) {
            var data = form.serializeArray();
            var submit = form.find('.submit');

            $.each(submit, function() {
                var name = $(this).attr('name');
                var value = $(this).attr('value');
                var text = $(this).text();
                if (name && (value || text)) {
                    data.push({ name: name, value: (value) ? value : text });
                }
            });

            return data;
        },

        baseUrl: function(url) {
            if (url) return window.base_url + url;
            else return window.base_url;
        },

        loadModal: function(size) {
            
            var modalId = 'modal-' + new Date().getTime();
            var modal = '<div id="'+modalId+'" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">\
                <div class="modal-dialog modal-'+size+'">\
                    <div class="modal-content">\
                        <div class="modal-header text-center">\
                            <h4 class="modal-title">Modal title</h4>\
                        </div>\
                        <div class="modal-body" style="min-height: 80px;"></div>\
                    </div>\
                </div>\
            </div>';

            $('body').append(modal);

            $('#'+modalId).modal('show')
                .on('hidden.bs.modal', function(e) {
                    $(this).remove();
                });
            
            return $('#'+modalId);
        },
        
        blockElement: function(el) {
            $(el).block({ 
                message: '<div class="preloader pl-lg">\
                            <svg class="pl-circular" viewBox="25 25 50 50">\
                                <circle class="plc-path" cx="50" cy="50" r="20"></circle>\
                            </svg>\
                        </div>',
                baseZ: 1000,
                // centerY: true,
                // centerX: true,
                css: {
                    border: 'none',
                    backgroundColor: 'transparent',
                    width: '100%',
                    position: 'absolute',
                    top: '50%',
                    left: '50%',
                    zIndex: '1000'
                },
                overlayCSS: {
                    backgroundColor: '#555',
                    cursor: 'wait',
                    zIndex: '1000'
                }
            }); 
        },

        unblockElement: function(el) {
            $(el).unblock();
        },

        validateForm: function(form, rules) {
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
            
            // $.extend($.validator.messages, {
            //     required: "Tidak boleh kosong.",
            //     remote: "Silahkan periksa kembali.",
            //     email: "Masukkan alamat email yang valid.",
            //     url: "Masukkan alamat url yang valid.",
            //     date: "Masukkan format tanggal yang valid.",
            //     dateISO: "Please enter a valid date (ISO).",
            //     number: "Masukkan nomor yang benar.",
            //     digits: "Please enter only digits.",
            //     creditcard: "Please enter a valid credit card number.",
            //     equalTo: "Masukkan kembali nilai yang sama.",
            //     accept: "Please enter a value with a valid extension.",
            //     maxlength: $.validator.format("Maksimal {0} karakter."),
            //     minlength: $.validator.format("Minimal {0} karakter."),
            //     rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
            //     range: $.validator.format("Please enter a value between {0} and {1}."),
            //     max: $.validator.format("Tidak boleh lebih dari {0}."),
            //     min: $.validator.format("Tidak boleh kurang dari {0}.")
            // });

            return form.validate({
                errorElement: 'small', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: ':hidden:not(.chosen)',  // validate all fields including form hidden input
                rules: rules,

                errorPlacement: function(error, element) {
                    if (element.closest('.input-group').size() === 1) { // insert checkbox errors after the container
                        error.insertAfter(element.closest('.input-group')); // <- the default
                    } else {
                        error.insertAfter(element.closest('.fg-line'));
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success.hide();
                    error.show();
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                }
            });

        },

        bootGrid: function(table, formatters) {

            return table.bootgrid({
                columnSelection: true,
                css: {
                    icon: 'zmdi icon',
                    iconColumns: 'zmdi-view-module',
                    iconDown: 'zmdi-sort-amount-desc',
                    iconRefresh: 'zmdi-refresh',
                    iconUp: 'zmdi-sort-amount-asc'
                },
                formatters: formatters,
                ajaxSettings: {
                    method: 'GET',
                    cache: true
                },
                rowCount: [10, 25, 50, 100]
            });

        },

        loadSelectPicker: function(el) {
            $(el).selectpicker();
        },

        loadChosen: function(el) {
            $(el).chosen({width: 'inherit', search_contains: true});
        },

        loadChosenIcon: function(el) {
            $(el).chosenIcon({width: 'inherit', search_contains: true});
        },

        loadDatePicker: function(el) {
            $(el).datetimepicker({format: 'DD-MM-YYYY', debug: true});
        },

        loadDateTimePicker: function(el) {
            $(el).datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
        },

        loadSummernote: function(el, options) {
            $(el).summernote(options);
        },

        loadMoneyFormat: function(el) {
            $(el).priceFormat({
                prefix: '$ ',
                thousandsSeparator: ',',
                centsLimit: 0
            });
        },

        loadTooltip: function() {
            $('[data-toggle="tooltip"]').tooltip();
        },

        loadGoogleMap: function(el, lat, lng) {
            var map;
            var ParseMap = new google.maps.StyledMapType(
            [
                {
                    "featureType": "administrative",
                    "elementType": "geometry",
                    "stylers": [
                        { "visibility": "on" }
                    ]
                },
                {
                    "featureType": "poi",
                    "stylers": [
                        { "visibility": "on" }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.icon",
                    "stylers": [
                        { "visibility": "on" }
                    ]
                },
                {
                    "featureType": "transit",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                }
            ],
            { name: 'Parse Map' });

            map = new google.maps.Map(document.getElementById(el), {
                center: {lat: lat, lng: lng},
                zoom: 8
            });

            //Associate the styled map with the MapTypeId and set it to display.
            map.mapTypes.set('Parse_map', ParseMap);
            map.setMapTypeId('Parse_map');

            return map;
        },

        loadTagsInput: function(el) {
            $(el).tagsinput();
        },

        loadRangeSlider: function(el, options) {
            $(el).ionRangeSlider($.extend({}, options));
        },

        placeMarker: function(options) {
            return new google.maps.Marker(options);
        },

        loadNotifications: function(data)
        {
            Parse.emptyNotifications();

            $('.him-notification').removeClass('empty');
            $('.him-counts').show().text(data.count);

            data = data.result.slice(0, 5);

            $.each(data, function(index, value) {
                $('#notification-content').append('\
                    <a class="list-group-item media" href="">\
                        <div class="media-body">\
                            <div class="lgi-heading">'+value.title+'</div>\
                            <small class="lgi-text">'+value.message+'</small>\
                        </div>\
                    </a>\
                ');
            });

            ion.sound.play("water_droplet_3");
            
        },

        emptyNotifications: function()
        {
            $('#notification-content').empty();
            $('.him-notification').addClass('empty');
            $('.him-counts').hide();
        },

        getNotification: function(userId)
        {
            Parse.ajax(Parse.baseUrl('notifications/getById'), 'get', 'json', {userId: userId})
            
                .error(function(err) {
                    swal('Error', 'Gagal Memuat Pemberitahuan', 'error');
                })

                .done(function(data) {
                    if (data) {
                        Parse.loadNotifications(data);
                    } else {
                        swal('Error', 'Gagal Memuat Pemberitahuan', 'error');
                    }
                });
        },

        enableColumnResize: function(el) 
        {
            var pressed = false;
            var start = undefined;
            var startX, startWidth;
            
            $(el).mousedown(function(e) {
                start = $(this);
                pressed = true;
                startX = e.pageX;
                startWidth = $(this).width();
                $(start).addClass("resizing");
            });
            
            $(document).mousemove(function(e) {
                if(pressed) {
                    $(start).width(startWidth+(e.pageX-startX));
                }
            });
            
            $(document).mouseup(function() {
                if(pressed) {
                    $(start).removeClass("resizing");
                    pressed = false;
                }
            });

            $(document).on('dragstart', '.column-header-anchor', function() {
                return false;
            });

        }
    };

}();
