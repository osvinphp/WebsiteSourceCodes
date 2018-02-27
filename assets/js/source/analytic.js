var dateStart = moment().subtract(7, 'days').format('YYYY-MM-DD');
var dateEnd = moment().subtract(1, 'days').format('YYYY-MM-DD');

var audienceOverview = $('#audience-overview');
var audienceOverviewRangePicker = $('#audience-overview-rangepicker');
var selectedAudienceOverview = null;
var audienceOverviewCategories = null;
var audienceOverviewSeries = null;

var devicesReport = $('#devices-report');
var devicesReportRangePicker = $('#devices-report-rangepicker');

var realtimeReportactiveUsersCount = $('#active-users-count');
var realtimeReportActiveScreen = $('#realtime-report-active-screen');
var realtimeReportActiveScreenList = '';

var activeUsersTrending = $('#active-users-trending');
var activeUsersTrendingChart = $('#active-users-trending-chart');
var activeUsersTrendingRangePicker = $('#active-users-trending-rangepicker');
var activeUsersTrendingMonthly = $('.active-users-trending-monthly');
var activeUsersTrendingWeekly = $('.active-users-trending-weekly');
var activeUsersTrendingDaily = $('.active-users-trending-daily');

var appVersionsReport = $('#app-versions-report');
var appVersionsReportChart = $('#app-versions-report-chart');
var appVersionsReportRangePicker = $('#app-versions-report-rangepicker');

var locationOverview = $('#location-overview');
var locationOverviewMap = $('#location-overview-map');
var locationOverviewChart = $('#location-overview-chart');
var locationOverviewRangePicker = $('#location-overview-rangepicker');

var screensReport = $('#screens-report');
var screensReportRangePicker = $('#screens-report-rangepicker');

var cohortAnalysisReport = $('#cohort-analysis-report');
var cohortAnalysisReportChart = $('#cohort-analysis-report-chart');
var cohortAnalysisReportRangePicker = $('#cohort-analysis-report-rangepicker');

// Analytic action
var Analytic = function() {

    return {

        // Execute js module 
        init: function() {
            Analytic.main();
            Analytic.fetchAudienceOverview(dateStart, dateEnd);
            Analytic.fetchDevicesReport(dateStart, dateEnd);
            Analytic.fetchRealtimeReport();
            Analytic.fetchActiveUsersTrending(dateStart, dateEnd);
            // Analytic.fetchAppVersionsReport(dateStart, dateEnd);
            Analytic.fetchLocationOverview(dateStart, dateEnd);
            Analytic.fetchScreensReport(dateStart, dateEnd);
            Analytic.fetchCohortAnalysisReport(dateStart, dateEnd);
        },

        // Main function of the module
        main: function() {
            
            $('.rangepicker').daterangepicker({
                drops: 'up',
                buttonClasses: 'btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-default',
                format: 'YYYY/MM/DD',
                startDate: moment().subtract(7, 'days'),
                endDate: moment().subtract(1, 'days'),
                ranges: {
                    "Today": [
                        moment(),
                        moment()
                    ],
                    "Yesterday": [
                        moment().subtract(1, 'days'),
                        moment()
                    ],
                    "Last 7 Days": [
                        moment().subtract(7, 'days'),
                        moment().subtract(1, 'days')
                    ],
                    "Last 30 Days": [
                        moment().subtract(30, 'days'),
                        moment().subtract(1, 'days')
                    ],
                    "This Month": [
                        moment().startOf('month'),
                        moment().endOf('month')
                    ],
                    "Last Month": [
                        moment().subtract(1, 'month').startOf('month'),
                        moment().subtract(1, 'month').endOf('month'),
                    ]
                }
            });

            $('.cohort-rangepicker').daterangepicker({
                drops: 'up',
                buttonClasses: 'btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-default',
                format: 'YYYY/MM/DD',
                startDate: moment().subtract(7, 'days'),
                endDate: moment().subtract(1, 'days'),
                showCustomRangeLabel: false,
                autoApply: true,
                ranges: {
                    "Last 7 Days": [
                        moment().subtract(7, 'days'),
                        moment().subtract(1, 'days')
                    ],
                    "Last 3 Weeks": [
                        moment().subtract(3, 'weeks').startOf('week'),
                        moment().subtract(1, 'weeks').endOf('week'),
                    ],
                    "Last 6 Weeks": [
                        moment().subtract(6, 'weeks').startOf('week'),
                        moment().subtract(1, 'weeks').endOf('week'),
                    ],
                    "Last 3 Months": [
                        moment().subtract(3, 'month').startOf('month'),
                        moment().subtract(1, 'month').endOf('month'),
                    ]
                }
            });

            audienceOverviewRangePicker.on('apply.daterangepicker', function(event, picker) {
                $(this).find('span').text(picker.chosenLabel);
                Analytic.fetchAudienceOverview(
                    picker.startDate.format('YYYY-MM-DD'),
                    picker.endDate.format('YYYY-MM-DD')
                );
            });

            $(document).on('click', '.audience-overview-tab', function() {
                audienceOverviewCategories = $(this).find('a').data('categories');
                audienceOverviewSeries = $(this).find('a').data('series');
                Analytic.loadAudienceOverview(audienceOverviewCategories, audienceOverviewSeries);
            });

            devicesReportRangePicker.on('apply.daterangepicker', function(event, picker) {
                $(this).find('span').text(picker.chosenLabel);
                
                Analytic.fetchDevicesReport(
                    picker.startDate.format('YYYY-MM-DD'),
                    picker.endDate.format('YYYY-MM-DD')
                );
            });

            activeUsersTrendingRangePicker.on('apply.daterangepicker', function(event, picker) {
                $(this).find('span').text(picker.chosenLabel);
                
                Analytic.fetchActiveUsersTrending(
                    picker.startDate.format('YYYY-MM-DD'),
                    picker.endDate.format('YYYY-MM-DD')
                );
            });

            appVersionsReportRangePicker.on('apply.daterangepicker', function(event, picker) {
                $(this).find('span').text(picker.chosenLabel);
                
                Analytic.fetchAppVersionsReport(
                    picker.startDate.format('YYYY-MM-DD'),
                    picker.endDate.format('YYYY-MM-DD')
                );
            });

            locationOverviewRangePicker.on('apply.daterangepicker', function(event, picker) {
                $(this).find('span').text(picker.chosenLabel);
                
                Analytic.fetchLocationOverview(
                    picker.startDate.format('YYYY-MM-DD'),
                    picker.endDate.format('YYYY-MM-DD')
                );
            });

            screensReportRangePicker.on('apply.daterangepicker', function(event, picker) {
                $(this).find('span').text(picker.chosenLabel);
                
                Analytic.fetchScreensReport(
                    picker.startDate.format('YYYY-MM-DD'),
                    picker.endDate.format('YYYY-MM-DD')
                );
            });

            cohortAnalysisReportRangePicker.on('apply.daterangepicker', function(event, picker) {
                $(this).find('span').text(picker.chosenLabel);
                
                var start = picker.startDate;
                var end = picker.endDate;
                var difference = start.diff(end, 'days');
                
                Analytic.fetchCohortAnalysisReport(
                    picker.startDate.format('YYYY-MM-DD'),
                    picker.endDate.format('YYYY-MM-DD'),
                    Math.abs(difference)
                );
            });

        },

        fetchAudienceOverview: function(start, end) {

            App.blockElement(audienceOverview);

            App.ajax(App.baseUrl('analytic/getAudienceOverview'), 'get', 'json', { start: start, end: end })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(audienceOverview);
                    
                    audienceOverview.find('.card-body').html(data);
                    selectedAudienceOverview = audienceOverview.find('li.active');
                    audienceOverviewCategories = selectedAudienceOverview.find('a').data('categories');
                    audienceOverviewSeries = selectedAudienceOverview.find('a').data('series');
                    Analytic.loadAudienceOverview(audienceOverviewCategories, audienceOverviewSeries);
                    
                });

        },

        loadAudienceOverview: function(categories, series) {
            
            Highcharts.chart('audience-overview-chart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: categories,
                    labels: {
                        formatter: function() {
                            return moment(this.value).format('D MMM');
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    labels: {
                        enabled: false
                    }
                },
                tooltip: {
                    shared: true,
                },
                credits: {
                    enabled: false
                },
                series: series
            });

        },

        fetchDevicesReport: function(start, end) {

            App.blockElement(devicesReport);

            App.ajax(App.baseUrl('analytic/getDevicesReport'), 'get', 'json', { start: start, end: end })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(devicesReport);
                    devicesReport.find('.card-body').html(data);
                    
                });

        },

        fetchRealtimeReport: function() {
            
            App.ajax(App.baseUrl('analytic/getRealtimeReport'), 'get', 'json', null)
                
                .error(function(err) {
                })

                .done(function(data) {

                    realtimeReportactiveUsersCount.text(data.activeUsers);
                    
                    Highcharts.chart('realtime-report-screen-chart', {
                        chart: {
                            type: 'column',
                            backgroundColor: null
                        },
                        title: {
                            text: null
                        },
                        legend: {
                            enabled: false
                        },
                        credits: {
                            enabled: false
                        },
                        xAxis: {
                            gridLineWidth: 0,
                            tickWidth: 0,
                            lineWidth: 0,
                            labels: {
                                enabled: false
                            }
                        },
                        yAxis: {
                            gridLineWidth: 0,
                            minorGridLineWidth: 0,
                            maxPadding: 0.2,
                            title: {
                                text: null
                            },
                            labels: {
                                enabled: false
                            }
                        },
                        series: data.screenViews,
                        tooltip: {
                            formatter: function() {
                                var dataLength = this.series.data.length;
                                var pointIndex = this.series.data.indexOf(this.point); 
                                var tooltipLabel = dataLength - pointIndex + ' mins ago';
                                
                                return '<div>\
                                    <span>'+tooltipLabel+'<span>\
                                    <h2 class="overview-count">'+this.point.y+'</h2>\
                                    <span>Screen Views</span>\
                                </div>';//this.point.y + ' Users ' + tooltipLabel;
                            },
                            useHTML: true
                        }
                    });

                    realtimeReportActiveScreenList = '';
                    realtimeReportActiveScreen.find('tbody').empty();
                    
                    $.each(data.screenName, function(index, value) {
                        realtimeReportActiveScreenList += '<tr><td>'+value[0]+'</td><td class="text-right">'+value[1]+'</td></tr>';
                    });

                    if (data.screenName)
                        realtimeReportActiveScreen.find('tbody').append(realtimeReportActiveScreenList);
                    else
                        realtimeReportActiveScreen.find('tbody').append('<tr><td class="text-center" colspan="2">No data</td></tr>');

                    setTimeout(Analytic.fetchRealtimeReport, 30000);

                });
        },

        fetchActiveUsersTrending: function(start, end) {
            
            App.blockElement(activeUsersTrending);

            App.ajax(App.baseUrl('analytic/getActiveUsersTrending'), 'get', 'json', { start: start, end: end })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(activeUsersTrending);

                    activeUsersTrendingMonthly.text(data.current.Monthly);
                    activeUsersTrendingWeekly.text(data.current.Weekly);
                    activeUsersTrendingDaily.text(data.current.Daily);
                    Analytic.loadActiveUsersTrending(data.categories, data.series);
                    
                });

        },

        loadActiveUsersTrending: function(categories, series) {
            
            Highcharts.chart('active-users-trending-chart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: categories,
                    labels: {
                        formatter: function() {
                            return moment(this.value).format('D MMM');
                        }
                    }
                },
                legend: {
                    enabled: false
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    labels: {
                        enabled: false
                    }
                },
                tooltip: {
                    formatter: function() {
                        var tooltip = '<div><span>'+moment(this.x).format('ddd D MMM')+'<span><br><br>';
                        this.points.reverse();

                        $.each(this.points, function() {
                            tooltip += '<span>'+this.series.name+'</span><h2 class="tooltip-overview-count">'+this.point.y+'</h2>';
                        });    
                            
                        tooltip += '</div>';

                        return tooltip;
                    },
                    useHTML: true,
                    shared: true
                },
                credits: {
                    enabled: false
                },
                series: series
            });

        },

        fetchAppVersionsReport: function(start, end) {
            
            App.blockElement(appVersionsReport);

            App.ajax(App.baseUrl('analytic/getAppVersionsReport'), 'get', 'json', { start: start, end: end })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(appVersionsReport);
                    Analytic.loadAppVersionsReport(data.categories, data.series);
                    
                });

        },

        loadAppVersionsReport: function(categories, series) {
            
            Highcharts.chart('app-versions-report-chart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: categories,
                    labels: {
                        formatter: function() {
                            return moment(this.value).format('D MMM');
                        }
                    }
                },
                legend: {
                    enabled: true
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    labels: {
                        enabled: false
                    }
                },
                tooltip: {
                    formatter: function() {
                        var tooltip = '<div><span>'+moment(this.x).format('ddd D MMM')+'<span><br><br>';
                        this.points.reverse();

                        $.each(this.points, function() {
                            tooltip += '<span>'+this.series.name+'</span><h2 class="tooltip-overview-count">'+this.point.y+'</h2>';
                        });    
                            
                        tooltip += '</div>';

                        return tooltip;
                    },
                    useHTML: true,
                    shared: true
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        stacking: 'normal',
                        borderColor: 'transparent'
                    }
                },
                colors: [
                    '#03a9f4',
                    // '#1cb1f5',
                    '#35baf6',
                    // '#4ec2f7',
                    '#67cbf8',
                    // '#81d4f9',
                    '#9adcfa',
                    // '#b3e5fb',
                    '#ccedfc',
                    // '#e5f6fd',
                    '#0298db',
                    '#0287c3',
                    '#0276aa',
                    '#016592',
                    '#01547a',
                    '#014361'
                ],
                series: series
            });

        },

        fetchLocationOverview: function(start, end) {
            
            App.blockElement(locationOverview);

            App.ajax(App.baseUrl('analytic/getLocationOverview'), 'get', 'json', { start: start, end: end })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(locationOverview);
                    Analytic.loadLocationOverview(data.regions, data.categories, data.series, data.count);
                    
                });

        },

        loadLocationOverview: function(region, categories, series, dataSum) {

            locationOverviewMap.empty();

            locationOverviewMap.vectorMap({
                map: 'world_en',
                backgroundColor: null,
                color: '#eee',
                borderColor: '#eee',
                hoverOpacity: 1,
                selectedColor: '#4caf50',
                enableZoom: true,
                showTooltip: true,
                normalizeFunction: 'polynomial',
                selectedRegions: region,
                onRegionClick: function (event) {
                    console.log(event);
                    event.preventDefault();
                }
            });

            Highcharts.chart('location-overview-chart', {
                chart: {
                    type:'bar'
                },
                title:{
                    text: null
                },
                credits: {
                    enabled:false
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        shadow: false,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                var pcnt = (this.y / dataSum) * 100;
                                return Highcharts.numberFormat(pcnt) + '%';
                            }
                        }
                    }
                },
                xAxis: {
                    tickWidth: 0,
                    lineWidth: 0,
                    labels: {
                        enabled: false
                    }
                },
                yAxis: {
                    maxPadding: 0.1,
                    title: {
                        text: null
                    },
                    labels: {
                        formatter:function() {
                            var pcnt = (this.value / dataSum) * 100;
                            return Highcharts.numberFormat(pcnt, 0, ',') + '%';
                        }
                    }
                },
                tooltip: {
                    formatter: function() {
                        return '<div>\
                            <span>'+this.series.name+'<span>\
                            <h2 class="overview-count">'+this.point.y+'</h2>\
                            <span>Sessions</span>\
                        </div>';
                    },
                    useHTML: true
                },
                colors: [
                    '#4caf50',
                    '#449d48',
                    '#3c8c40',
                    '#357a38',
                    '#2d6930',
                    '#265728',
                    '#1e4620',
                    '#163418'
                ],
                series: series
            });


        },

        fetchScreensReport: function(start, end) {

            App.blockElement(screensReport);

            App.ajax(App.baseUrl('analytic/getScreensReport'), 'get', 'json', { start: start, end: end })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(screensReport);
                    screensReport.find('.card-body').html(data);
                    
                });

        },

        fetchCohortAnalysisReport: function(start, end, difference) {

            App.blockElement(cohortAnalysisReport);

            App.ajax(App.baseUrl('analytic/getCohortAnalysisReport'), 'get', 'json', { start: start, end: end, difference: difference })
                
                .error(function(err) {
                })

                .done(function(data) {
                    
                    App.unblockElement(cohortAnalysisReport);
                    cohortAnalysisReport.find('.card-body').html(data);

                    // Function to get the max value in an Array
                    Array.max = function(array){
                        return Math.max.apply(Math,array);
                    };
                
                    // Get all data values from our table cells making sure to ignore the first column of text
                    // Use the parseInt function to convert the text string to a number
                
                    var counts= $('.user-retention').map(function() {
                        return parseInt($(this).text());
                    }).get();
                
                    // run max value function and store in variable
                    var max = Array.max(counts);
                
                    var n = 100; // Declare the number of groups
                
                    // Define the ending colour, which is white
                    var xr = 255; // Red value
                    var xg = 255; // Green value
                    var xb = 255; // Blue value
                
                    // Define the starting colour #f32075
                    var yr = 51; // Red value
                    var yg = 103; // Green value
                    var yb = 214; // Blue value
                
                    // Loop through each data point and calculate its % value
                    $('.user-retention').each(function(){
                        var val = parseInt($(this).text());
                        var pos = parseInt((Math.round((val/max)*100)).toFixed(0));
                        var red = parseInt((xr + (( pos * (yr - xr)) / (n-1))).toFixed(0));
                        var green = parseInt((xg + (( pos * (yg - xg)) / (n-1))).toFixed(0));
                        var blue = parseInt((xb + (( pos * (yb - xb)) / (n-1))).toFixed(0));
                        var clr = 'rgb('+red+','+green+','+blue+')';
                        var none = 'rgb(220,220,220)';

                        $(this).css({background:clr, color: clr});

                        if ($(this).text() == 0) {
                            $(this).css({background: none, color: none});
                        }

                    });

                    $('[data-toggle="popover"]').popover();

                });

        },

        loadCohortAnalysisReport: function(data) {

            // The initial date is the date displayed
            // in the first column of the first row
            var initialDate = moment('2017-08-03').toDate(),

            // DOM Element where the Cohort Chart will be inserted
            container = document.getElementById('cohort-analysis-report-chart');

            Cornelius.draw({
                initialDate: initialDate,
                container: container,
                cohort: data,
                title: null,
                timeInterval: 'daily',
                rawNumberOnHover: true,
                displayAbsoluteValues: true,
                labels: {
                    people: 'Active Users',
                    time: 'Period'
                },
                formatHeaderLabel: function(i) {
                    return 'Day ' + (--i);
                }
            });

        }

    }

}();