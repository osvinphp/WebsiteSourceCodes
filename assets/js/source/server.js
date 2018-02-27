var dateStart = moment().subtract(1, 'hour').format('YYYY-MM-DD H:mm:ss');
var dateEnd = moment().format('YYYY-MM-DD H:mm:ss');

var cpuUsage = $('#cpu-usage');
var cpuUsageRange = $('.btn-range-cpu');

var diskUsage = $('#disk-usage');
var diskUsageRange = $('.btn-range-disk');

var diskOperationUsage = $('#disk-operation-usage');
var diskOperationUsageRange = $('.btn-range-disk-operation');

var networkBytes = $('#network-bytes');
var networkBytesRange = $('.btn-network-bytes');

var serverLogs = $('#server-logs');
var serverLogsList = $('#server-logs-list');
var serverLogsLoadMore = $('#server-logs-load-more');
var serverLogsPageToken = null;

// Server action
var Server = function() {

    return {

        // Execute js module 
        init: function() {
            Server.main();
            Server.fetchCpuUsage(dateStart, dateEnd);
            Server.fetchDiskUsage(dateStart, dateEnd);
            Server.fetchDiskOperationUsage(dateStart, dateEnd);
            Server.fetchNetworkBytes(dateStart, dateEnd);
            Server.fetchServerLogs();
        },

        // Main function of the module
        main: function() {
            
            $('.btn-range').click(function() {
                $(this).closest('.btn-group')
                    .find('.btn-range')
                    .removeClass('btn-primary btn-default')
                    .addClass('btn-default');
                $(this).addClass('btn-primary');
            });

            $(document).on('click', '.btn-expand', function() {
                $(this)
                    .removeClass('btn-expand')
                    .addClass('btn-collapse')
                    .find('.zmdi')
                    .removeClass('zmdi-plus')
                    .addClass('zmdi-minus');
                $(this)
                    .closest('.list-group-item')
                    .find('.media-content')
                    .slideDown();
            });

            $(document).on('click', '.btn-collapse', function() {
                $(this)
                    .removeClass('btn-collapse')
                    .addClass('btn-expand')
                    .find('.zmdi')
                    .removeClass('zmdi-minus')
                    .addClass('zmdi-plus');
                $(this)
                    .closest('.list-group-item')
                    .find('.media-content')
                    .slideUp();
            });

            cpuUsageRange.click(function() {
                var count = $(this).data('count');
                var units = $(this).data('units');
                dateStart = moment().subtract(count, units).format('YYYY-MM-DD H:mm:ss');

                Server.fetchCpuUsage(dateStart, dateEnd);
            });

            diskUsageRange.click(function() {
                var count = $(this).data('count');
                var units = $(this).data('units');
                dateStart = moment().subtract(count, units).format('YYYY-MM-DD H:mm:ss');

                Server.fetchDiskUsage(dateStart, dateEnd);
            });

            diskOperationUsageRange.click(function() {
                var count = $(this).data('count');
                var units = $(this).data('units');
                dateStart = moment().subtract(count, units).format('YYYY-MM-DD H:mm:ss');

                Server.fetchDiskOperationUsage(dateStart, dateEnd);
            });

            networkBytesRange.click(function() {
                var count = $(this).data('count');
                var units = $(this).data('units');
                dateStart = moment().subtract(count, units).format('YYYY-MM-DD H:mm:ss');

                Server.fetchNetworkBytes(dateStart, dateEnd);
            });

            serverLogsLoadMore.find('button').click(function() {
                serverLogsPageToken = $(this).val();
                Server.fetchServerLogs();
            });
        },

        fetchCpuUsage: function(start, end) {

            App.blockElement(cpuUsage);

            App.ajax(App.baseUrl('server/getCpuUsage'), 'get', 'json', { start: start, end: end })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(cpuUsage);
                    Server.loadCpuUsage(data);
                    
                });

        },

        loadCpuUsage: function(data) {
            
            Highcharts.chart('cpu-usage-chart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: null
                },
                xAxis: {
                    type: 'datetime',
                    labels: {
                        formatter: function() {
                            return moment.unix(this.value).format('hh:mm A');
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: '% CPU'
                    }
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var s = '<b>' + moment.unix(this.x).format('MMM D, YYYY hh:mm A') + '</b><br/>';
                        
                        $.each(this.points, function (index, point) {
                            s += '<span style="color:'+point.color+'">\u25CF</span> ' + point.series.name + ': ' + '<b>' + point.y.toFixed(2) + '%</b><br/>';
                        });
            
                        return s;
                    }
                },
                credits: {
                    enabled: false
                },
                series: data.series
            });

        },

        fetchDiskUsage: function(start, end) {

            App.blockElement(diskUsage);

            App.ajax(App.baseUrl('server/getDiskUsage'), 'get', 'json', { start: start, end: end })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(diskUsage);
                    Server.loadDiskUsage(data);
                    
                });

        },

        loadDiskUsage: function(data) {
            
            Highcharts.chart('disk-usage-chart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: null
                },
                xAxis: {
                    type: 'datetime',
                    labels: {
                        formatter: function() {
                            return moment.unix(this.value).format('hh:mm A');
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: '% DISK'
                    },
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var s = '<b>' + moment.unix(this.x).format('MMM D, YYYY hh:mm A') + '</b><br/>';
                        
                        $.each(this.points, function (index, point) {
                            s += '<span style="color:'+point.color+'">\u25CF</span> ' + point.series.name + ': ' + '<b>' + point.y + '</b><br/>';
                        });
            
                        return s;
                    }
                },
                credits: {
                    enabled: false
                },
                series: data.series
            });

        },

        fetchDiskOperationUsage: function(start, end) {
            
            App.blockElement(diskOperationUsage);

            App.ajax(App.baseUrl('server/getDiskOperationUsage'), 'get', 'json', { start: start, end: end })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(diskOperationUsage);
                    Server.loadDiskOperationUsage(data);
                    
                });

        },

        loadDiskOperationUsage: function(data) {
            
            Highcharts.chart('disk-operation-usage-chart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: null
                },
                xAxis: {
                    type: 'datetime',
                    labels: {
                        formatter: function() {
                            return moment.unix(this.value).format('hh:mm A');
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: '% DISK'
                    },
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var s = '<b>' + moment.unix(this.x).format('MMM D, YYYY hh:mm A') + '</b><br/>';
                        
                        $.each(this.points, function (index, point) {
                            s += '<span style="color:'+point.color+'">\u25CF</span> ' + point.series.name + ': ' + '<b>' + point.y + '</b><br/>';
                        });
            
                        return s;
                    }
                },
                credits: {
                    enabled: false
                },
                series: data.series
            });

        },

        fetchNetworkBytes: function(start, end) {
            
            App.blockElement(networkBytes);

            App.ajax(App.baseUrl('server/getNetworkBytes'), 'get', 'json', { start: start, end: end })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(networkBytes);
                    Server.loadNetworkBytes(data);
                    
                });

        },

        loadNetworkBytes: function(data) {
            
            Highcharts.chart('network-bytes-chart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: null
                },
                xAxis: {
                    type: 'datetime',
                    labels: {
                        formatter: function() {
                            return moment.unix(this.value).format('hh:mm A');
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: 'Bytes/sec'
                    },
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var s = '<b>' + moment.unix(this.x).format('MMM D, YYYY hh:mm A') + '</b><br/>';
                        
                        $.each(this.points, function (index, point) {
                            s += '<span style="color:'+point.color+'">\u25CF</span> ' + point.series.name + ': ' + '<b>' + point.y + '</b><br/>';
                        });
            
                        return s;
                    }
                },
                credits: {
                    enabled: false
                },
                series: data.series
            });

        },

        fetchServerLogs: function() {
            
            App.blockElement(serverLogs);

            App.ajax(App.baseUrl('server/getServerLogs'), 'get', 'json', { pageToken: serverLogsPageToken })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(serverLogs);
                    Server.loadServerLogs(data);
                    
                });

        },

        loadServerLogs: function(data) {

            $.each(data.entries, function(index, value) {
                
                var logId = 'log' + value.insertId;

                $('\
                    <div class="list-group-item media">\
                        <span class="pull-left">\
                            <button class="btn btn-default btn-icon btn-logs btn-expand waves-effect waves-circle">\
                                <i class="zmdi zmdi-plus"></i>\
                            </button>\
                        </span>\
                        <div class="media-body">\
                            <div class="lgi-heading"> '+ moment(value.timestamp).format('MMM DD, YYYY hh:mm:ss') +  ' - ' + value.textPayload + '</div>\
                        </div>\
                        <div class="media-body media-content" style="display: none;">\
                            <pre id="' + logId + '"></pre>\
                        </div>\
                    </div>\
                ').insertBefore('#server-logs-load-more');
                
                $('#' + logId).jJsonViewer(JSON.stringify(value, null, 4));

            });

            serverLogsLoadMore.find('button').val(data.pageToken);
        }
    }

}();