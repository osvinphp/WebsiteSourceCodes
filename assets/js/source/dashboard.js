// Dashboard action
var Dashboard = function() {

    return {

        // Execute js module 
        init: function() {
            Dashboard.main();
            // Dashboard.loadWidget();
            // Dashboard.loadFlotChart();
            // Dashboard.loadWorldMap();
            
            // Dashboard.fetchRealtimeVisitors();
            // Dashboard.fetchTodayVisitors();
            // Dashboard.fetchTodayHits();
            // Dashboard.fetchUserVisitData();
            // Dashboard.fetchTimeVisitData();
            // Dashboard.fetchServerStatusData();
            // Dashboard.fetchAppVersionData();
        },

        // Main function of the module
        main: function() {

            // If welcome message is set
            if (App.getUrlParameter('welcome')) App.welcomeMessage('Welcome back ' + window.firstName, 'inverse');

        },

        fetchRealtimeVisitors: function() {

            // App.blockElement($('#visitors-right-now').parent());

            App.ajax(App.baseUrl('google_analytics/getRealtimeVisitors'), 'get', 'json', null)
                
                .error(function(err) {
                })

                .done(function(data) {
                    // App.unblockElement($('#visitors-right-now').parent());
                    $('#visitors-right-now').text(data);
                    setTimeout(Dashboard.fetchRealtimeVisitors, 60000);
                });
        },

        fetchTodayVisitors: function() {

            // App.blockElement($('.visitors-today').parent());

            App.ajax(App.baseUrl('dashboard/todayVisitors'), 'get', 'json', null)
                
                .error(function(err) {
                })

                .done(function(data) {
                    // App.unblockElement($('.visitors-today').parent());
                    Dashboard.loadWorldMap(data.country);

                    $('#visitors-12-hours').text(data.last12);
                    $('#visitors-24-hours').text(data.last24);

                    setTimeout(Dashboard.fetchRealtimeVisitors, 360000);
                });
        },

        fetchTodayHits: function() {

            App.blockElement($('#realtime-visitor-list').parent());

            App.ajax(App.baseUrl('dashboard/todayHits'), 'get', 'json', null)
                
                .error(function(err) {
                })

                .done(function(data) {
                    App.unblockElement($('#realtime-visitor-list').parent());
                    Dashboard.loadTodayHits(data);
                });
        },

        loadTodayHits: function(data) {

            $('#realtime-visitor-list').empty();
            
            $.each(data, function(index, value) {

                var time = moment.tz(value.time, 'Australia/Sydney').format('dddd, MMMM D, HH:mm:ss');
                var fromNow = moment.tz(value.time, 'Australia/Sydney').fromNow();
                var timeString = time + ' (' + fromNow + ')';

                $('#realtime-visitor-list').append('\
                    <div class="list-group-item">\
                        <div class="lgi-text">'+timeString+'</div>\
                        <ul class="lgi-attrs">\
                            <li><img class="analytics-img-country" src="assets/img/flags/'+value.country+'.png" alt="">'+value.country+'</li>\
                            <li>'+value.operatingSystem+'</li>\
                            <li>'+value.appVersion+'</li>\
                        </ul>\
                    </div>\
                ');

            });

            $('#realtime-visitor-list').mCustomScrollbar({
                theme: 'minimal-dark',
                scrollInertia: 100,
                axis:'yx',
                mouseWheel: {
                    enable: true,
                    axis: 'y',
                    preventDefault: true
                }
            });

        },

        loadWorldMap: function(region) {

            $('#map-world').empty();

            $('#map-world').vectorMap({
                map: 'world_en',
                backgroundColor: null,
                color: '#eee',
                borderColor: '#eee',
                hoverOpacity: 1,
                selectedColor: '#00BCD4',
                enableZoom: true,
                showTooltip: true,
                normalizeFunction: 'polynomial',
                selectedRegions: region,
                onRegionClick: function (event) {
                    event.preventDefault();
                }
            });

        },

        loadFlotChart: function() {

                /*-----------------------------------------
                    Make some random data for the Chart
                -----------------------------------------*/
                var d1 = [];
                for (var i = 0; i <= 10; i += 1) {
                    d1.push([i, parseInt(Math.random() * 30)]);
                }
                var d2 = [];
                for (var i = 0; i <= 20; i += 1) {
                    d2.push([i, parseInt(Math.random() * 30)]);
                }    
                var d3 = [];
                for (var i = 0; i <= 10; i += 1) {
                    d3.push([i, parseInt(Math.random() * 30)]);
                }

                /*---------------------------------
                    Chart Options
                ---------------------------------*/
                var options = {
                    series: {
                        shadowSize: 0,
                        curvedLines: { //This is a third party plugin to make curved lines
                            apply: true,
                            active: true,
                            monotonicFit: true
                        },
                        lines: {
                            show: false,
                            lineWidth: 0,
                            fill: 1
                        },
                    },
                    grid: {
                        borderWidth: 0,
                        labelMargin:10,
                        hoverable: true,
                        clickable: true,
                        mouseActiveRadius:6,
                        
                    },
                    xaxis: {
                        tickDecimals: 0,
                        ticks: false
                    },
                    
                    yaxis: {
                        tickDecimals: 0,
                        ticks: false
                    },
                    
                    legend: {
                        show: false
                    }
                };

                /*---------------------------------
                    Let's create the chart
                ---------------------------------*/
                if ($("#curved-line-chart")[0]) {
                    $.plot($("#curved-line-chart"), [
                        {data: d1, lines: { show: true, fill: 0.98 }, label: 'Product 1', stack: true, color: '#e3e3e3' },
                        {data: d3, lines: { show: true, fill: 0.98 }, label: 'Product 2', stack: true, color: '#f1dd2c' }
                    ], options);
                }

                /*---------------------------------
                    Tooltips for Flot Charts
                ---------------------------------*/
                if ($(".flot-chart")[0]) {
                    $(".flot-chart").bind("plothover", function (event, pos, item) {
                        if (item) {
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            $(".flot-tooltip").html(item.series.label + " of " + x + " = " + y).css({top: item.pageY+5, left: item.pageX+5}).show();
                        }
                        else {
                            $(".flot-tooltip").hide();
                        }
                    });
                    
                    $("<div class='flot-tooltip' class='chart-tooltip'></div>").appendTo("body");
                }

        },

        loadWidget: function() {

            /*-------------------------------------------
                Sparkline
            ---------------------------------------------*/
            function sparklineBar(id, values, height, barWidth, barColor, barSpacing) {
                $('.'+id).sparkline(values, {
                    type: 'bar',
                    height: height,
                    barWidth: barWidth,
                    barColor: barColor,
                    barSpacing: barSpacing
                })
            }
            
            function sparklineLine(id, values, width, height, lineColor, fillColor, lineWidth, maxSpotColor, minSpotColor, spotColor, spotRadius, hSpotColor, hLineColor) {
                $('.'+id).sparkline(values, {
                    type: 'line',
                    width: width,
                    height: height,
                    lineColor: lineColor,
                    fillColor: fillColor,
                    lineWidth: lineWidth,
                    maxSpotColor: maxSpotColor,
                    minSpotColor: minSpotColor,
                    spotColor: spotColor,
                    spotRadius: spotRadius,
                    highlightSpotColor: hSpotColor,
                    highlightLineColor: hLineColor
                });
            }
            
            // The first widget row
            var data = $('.stats-bar-worlwide-users').data('chart');
            sparklineBar('stats-bar-worlwide-users', data, '35px', 3, '#fff', 2);
            
            var data = $('.stats-bar-active-users').data('chart');
            sparklineBar('stats-bar-active-users', data, '35px', 3, '#fff', 2);
            
            var data = $('.stats-line-posts').data('chart');
            sparklineLine('stats-line-posts', data, 68, 35, '#fff', 'rgba(0,0,0,0)', 1.25, 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 3, '#fff', 'rgba(255,255,255,0.4)');
            
            var data = $('.stats-line-reports').data('chart');
            sparklineLine('stats-line-reports', data, 68, 35, '#fff', 'rgba(0,0,0,0)', 1.25, 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 3, '#fff', 'rgba(255,255,255,0.4)');
            
            // The second widget row
            if ($('.stats-bar-messages')[0]) {
                var data = $('.stats-bar-messages').data('chart');
                sparklineBar('stats-bar-messages', data, '35px', 3, '#fff', 2);
            }
            
            if ($('.stats-bar-calls')[0]) {
                var data = $('.stats-bar-calls').data('chart');
                sparklineBar('stats-bar-calls', data, '35px', 3, '#fff', 2);
            }
            
            if ($('.stats-line-flicklinks')[0]) {
                var data = $('.stats-line-flicklinks').data('chart');
                sparklineLine('stats-line-flicklinks', data, 68, 35, '#fff', 'rgba(0,0,0,0)', 1.25, 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 3, '#fff', 'rgba(255,255,255,0.4)');
            }
            
            if ($('.stats-line-comments')[0]) {
                var data = $('.stats-line-comments').data('chart');
                sparklineLine('stats-line-comments', data, 68, 35, '#fff', 'rgba(0,0,0,0)', 1.25, 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 3, '#fff', 'rgba(255,255,255,0.4)');
            }
        },

        fetchUserVisitData: function() {

            App.blockElement($('#visit-over-time').parent());

            App.ajax(App.baseUrl('dashboard/userVisits'), 'get', 'json', null)
                
                .error(function(err) {
                })

                .done(function(data) {
                    App.unblockElement($('#visit-over-time').parent());
                    Dashboard.loadUserVisitChart(data);
                    Dashboard.loadAppVersionChart(data);
                });
        },

        loadUserVisitChart: function(data) {

            var users = [];
            var newUsers = [];

            $.each(data.users, function(index, value) {
                var year = moment(index).format('YYYY');
                var month = moment(index).format('MM');
                var day = moment(index).format('DD');

                users.push([
                    gd(year, month, day), value
                ]);
            });

            $.each(data.newUsers, function(index, value) {
                var year = moment(index).format('YYYY');
                var month = moment(index).format('MM');
                var day = moment(index).format('DD');

                newUsers.push([
                    gd(year, month, day), value
                ]);
            });
            
            var dataset = [
                {
                    label: "Users",
                    data: users,
                    color: "#ff766c",
                    points: {
                        fillColor: "#ff766c",
                        show: true,
                        radius: 2
                    },
                    lines: {
                        show: true,
                        lineWidth: 1
                    }
                },
                {
                    label: "New Users",
                    data: newUsers,
                    xaxis:2,
                    color: "#03A9F4",
                    points: {
                        fillColor: "#03A9F4",
                        show: true,
                        radius: 2
                    },
                    lines: {
                        show: true,
                        lineWidth: 1
                    }
                }
            ];

            var dayOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat"];

            var options = {
                series: {
                    shadowSize: 0
                },
                grid : {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    show : true,
                    clickable : true,
                    hoverable: true,
                    mouseActiveRadius: 20,
                    labelMargin: 10
                },

                xaxes: [
                    {
                        color: '#f3f3f3',
                        mode: "time",
                        tickFormatter: function (val, axis) {
                            return dayOfWeek[new Date(val).getDay()];
                        },
                        position: "top",
                        font :{
                            lineHeight: 13,
                            style: "normal",
                            color: "#9f9f9f"
                        }
                    },
                    {
                        color: '#f3f3f3',
                        mode: "time",
                        timeformat: "%m/%d",
                        font :{
                            lineHeight: 13,
                            style: "normal",
                            color: "#9f9f9f"
                        }
                    }
                ],
                yaxis: {
                    ticks: 2,
                    color: "#f3f3f3",
                    tickDecimals: 0,
                    font :{
                        lineHeight: 13,
                        style: "normal",
                        color: "#9f9f9f"
                    },


                },
                legend: {
                    container: '.flc-visits',
                    backgroundOpacity: 0.5,
                    noColumns: 0,
                    font :{
                        lineHeight: 13,
                        style: "normal",
                        color: "#9f9f9f"
                    },
                }
            };

            function gd(year, month, day) {
                return new Date(year, month - 1, day).getTime();
            }

            if ($('#visit-over-time')[0]) {
                $.plot($("#visit-over-time"), dataset, options);
            }
        },

        fetchTimeVisitData: function() {

            App.blockElement($('#visit-server-time').parent());

            App.ajax(App.baseUrl('dashboard/timeVisits'), 'get', 'json', null)
                
                .error(function(err) {
                })

                .done(function(data) {
                    App.unblockElement($('#visit-server-time').parent());
                    Dashboard.loadServerTimeChart(data);
                });
        },

        loadServerTimeChart: function(data) {

            var timeData = [];

            $.each(data.users, function(index, value) {
                timeData.push([
                    parseInt(index),
                    value
                ]);
            });

            var dataset = [{
                data : timeData,
                label: 'Visits',
                bars : {
                    show : true,
                    barWidth : 0.4,
                    order : 1,
                    lineWidth: 0,
                    fillColor: '#ff766c'
                }
            }];

            var options = {
                grid : {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    show : true,
                    hoverable : true,
                    clickable : true,
                    labelMargin: 10
                },

                yaxis: {
                    tickColor: '#f3f3f3',
                    tickDecimals: 0,
                    font :{
                        lineHeight: 13,
                        style: "normal",
                        color: "#9f9f9f",
                    },
                    shadowSize: 0
                },

                xaxis: {
                    tickFormatter: function (value, axis) {
                        return value+'h'
                    },
                    tickColor: '#fff',
                    tickDecimals: 0,
                    font :{
                        lineHeight: 13,
                        style: "normal",
                        color: "#9f9f9f"
                    },
                    shadowSize: 0,
                },

                legend:{
                    show: false
                }
            }

            if ($('#visit-server-time')[0]) {
                $.plot($("#visit-server-time"), dataset, options);
            }

        },

        fetchServerStatusData: function() {

            App.blockElement($('#dynamic-chart').parent());

            App.ajax(App.baseUrl('google'), 'get', 'json', null)
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement($('#dynamic-chart').parent());
                    Dashboard.loadServerStatusChart(data);
                    setTimeout(Dashboard.fetchServerStatusData, 60000);
                    
                });
                
        },

        loadServerStatusChart: function(data) {
            
            var plot = $.plot("#dynamic-chart", [
                data.points
            ], {
                series: {
                    label: "Server Process Data",
                    lines: {
                        show: true,
                        lineWidth: 0.2,
                        fill: 0.6
                    },
        
                    color: (data.max >= 70) ? '#ff766c' : '#00BCD4',
                    shadowSize: 0,
                },
                yaxis: {
                    min: 0,
                    max: data.max,
                    tickColor: '#eee',
                    font :{
                        lineHeight: 13,
                        style: "normal",
                        color: "#9f9f9f",
                    },
                    shadowSize: 0,
        
                },
                xaxis: {
                    tickColor: '#eee',
                    show: true,
                    font :{
                        lineHeight: 13,
                        style: "normal",
                        color: "#9f9f9f",
                    },
                    shadowSize: 0,
                    min: 0,
                    max: 250
                },
                grid: {
                    borderWidth: 1,
                    borderColor: '#eee',
                    labelMargin:10,
                    hoverable: true,
                    clickable: true,
                    mouseActiveRadius:6
                },
                legend:{
                    show: false
                }
            });

        },

        fetchAppVersionData: function(data) {

            App.blockElement($('#app-version-chart').parent());

            App.ajax(App.baseUrl('dashboard/appVersion'), 'get', 'json', null)
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement($('#app-version-chart').parent());
                    Dashboard.loadAppVersionChart(data);
                    
                });

        },

        loadAppVersionChart: function(data) {

            Highcharts.chart('app-version-chart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: data.categories
                },
                yAxis: {
                    min: 0,
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: false,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                        }
                    },
                    series: {
                        stacking: 'normal',
                        borderColor: 'transparent'
                    }

                },
                colors: [
                    '#0275a8',
                    '#0286c2',
                    '#0398db',
                    '#03a9f4',
                    '#14b4fc',
                    '#2ebcfc',
                    '#47c4fd'
                ],
                series: data.series
            });

        }

    }

}();