<div class="row">
    <div class="col-md-6">
        <div class="block-header">
            <h2>Audience Overview</h2>
        </div>
        <div class="card analytic-section" id="audience-overview">
            <div class="card-body">
            </div>
            <div class="card-footer">
                <button id="audience-overview-rangepicker" class="btn btn-default waves-effect rangepicker"><span>Last 7 Days</span> <i class="caret"></i></button>
                <a href="https://analytics.google.com/analytics/web/#report/visitors-overview/a71767609w132017930p135966535/%3F_u.dateOption%3Dlast7days" class="btn btn-default waves-effect pull-right">AUDIENCE OVERVIEW <i class="zmdi zmdi-chevron-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="block-header">
            <h2>Sessions By Device</h2>
        </div>
        <div class="card analytic-section" id="devices-report">
            <div class="card-body">
            </div>
            <div class="card-footer">
                <button id="devices-report-rangepicker" class="btn btn-default waves-effect rangepicker"><span>Last 7 Days</span> <i class="caret"></i></button>
                <a href="https://analytics.google.com/analytics/web/#report/app-visitors-mobile-devices/a71767609w132017930p135966535/%3F_u.dateOption%3Dlast7days" class="btn btn-default waves-effect pull-right">DEVICES REPORT <i class="zmdi zmdi-chevron-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="block-header">
            <h2>Realtime Report</h2>
        </div>
        <div class="card analytic-section default-primary-color" id="realtime-report">
            <div class="card-body card-padding c-white">
                <div class="card-title">Users right now</div>
                <div class="realtime-count" id="active-users-count">-</div>
                <div class="card-subtitle m-t-10 p-b-10">Screen views per minute</div>
                <div id="realtime-report-screen-chart" style="height: 130px;"></div>
                <div class="table-responsive">
                    <table class="table table-condensed" id="realtime-report-active-screen">
                        <thead>
                            <tr>
                                <th>Top Active Screens</th>
                                <th style="text-align: right;">Users</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="2">No data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="https://analytics.google.com/analytics/web/#report/rt-overview/a71767609w132017930p135966535" class="btn c-white default-primary-color waves-effect pull-right">REAL-TIME REPORT <i class="zmdi zmdi-chevron-right"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="block-header">
            <h2>How are your active users trending over time?</h2>
        </div>
        <div class="card analytic-section" id="active-users-trending">
            <div class="card-body card-padding">
                <div class="card-title">Active Users</div>
                <div class="row">
                    <div class="col-md-10">
                        <div id="active-users-trending-chart" style="height: 450px; "></div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-title">
                            <!-- <i class="zmdi zmdi-circle" style="font-size: 10px; color: rgb(144, 237, 125);"></i>  -->
                            Monthly
                        </div>
                        <h2 class="overview-count m-b-30 active-users-trending-monthly">-</h2>

                        <div class="card-title">
                            <!-- <i class="zmdi zmdi-circle" style="font-size: 10px; color: rgb(67, 67, 72);"></i>  -->
                            Weekly
                        </div>
                        <h2 class="overview-count m-b-30 active-users-trending-weekly">-</h2>
                        
                        <div class="card-title">
                            <!-- <i class="zmdi zmdi-circle" style="font-size: 10px; color: rgb(124, 181, 236);"></i>  -->
                            Daily
                        </div>
                        <h2 class="overview-count active-users-trending-daily">-</h2>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button id="active-users-trending-rangepicker" class="btn btn-default waves-effect rangepicker"><span>Last 7 Days</span> <i class="caret"></i></button>
                <a href="https://analytics.google.com/analytics/web/#report/visitors-actives/a71767609w132017930p135966535/%3F_u.dateOption%3Dlast30days" class="btn btn-default waves-effect pull-right">ACTIVE USERS REPORT <i class="zmdi zmdi-chevron-right"></i></a>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-4">
        <div class="block-header">
            <h2>What are your most popular app versions?</h2>
        </div>
        <div class="card analytic-section" id="app-versions-report">
            <div class="card-body card-padding">
                <div class="card-title">App Versions</div>
                <div id="app-versions-report-chart" style="height: 450px;"></div>
            </div>
            <div class="card-footer">
                <button id="app-versions-report-rangepicker" class="btn btn-default waves-effect rangepicker"><span>Last 7 Days</span> <i class="caret"></i></button>
                <a href="https://analytics.google.com/analytics/web/#report/app-visitors-app-versions/a71767609w132017930p135966535/%3F_u.dateOption%3Dlast7days" class="btn btn-default waves-effect pull-right">APP VERSIONS REPORT <i class="zmdi zmdi-chevron-right"></i></a>
            </div>
        </div>
    </div> -->
    <div class="col-md-6">
        <div class="block-header">
            <h2>Where are your users?</h2>
        </div>
        <div class="card analytic-section" id="location-overview">
            <div class="card-body card-padding">
                <div class="card-title">Sessions by country</div>
                <div id="location-overview-map" class="map-sm"></div>
                <div id="location-overview-chart" style="height: 250px;"></div>
            </div>
            <div class="card-footer">
                <button id="location-overview-rangepicker" class="btn btn-default waves-effect rangepicker"><span>Last 7 Days</span> <i class="caret"></i></button>
                <a href="https://analytics.google.com/analytics/web/#report/visitors-geo/a71767609w132017930p135966535/%3F_u.dateOption%3Dlast7days" class="btn btn-default waves-effect pull-right">LOCATION OVERVIEW <i class="zmdi zmdi-chevron-right"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="block-header">
            <h2>How well do you retain users?</h2>
        </div>
        <div class="card analytic-section" id="cohort-analysis-report">
            <div class="card-body card-padding">
            </div>
            <div class="card-footer">
                <button id="cohort-analysis-report-rangepicker" class="btn btn-default waves-effect cohort-rangepicker"><span>Last 7 Days</span> <i class="caret"></i></button>
                <a href="https://analytics.google.com/analytics/web/#report/visitors-cohort/a71767609w132017930p135966535/%3FcohortTab-cohortOption.granularity%3DWEEKLY%26cohortTab-cohortOption.dateRange%3D6" class="btn btn-default waves-effect pull-right">COHORT ANALYSIS REPORT <i class="zmdi zmdi-chevron-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="block-header">
            <h2>What are your top screens?</h2>
        </div>
        <div class="card analytic-section" id="screens-report">
            <div class="card-body">
            </div>
            <div class="card-footer">
                <button id="screens-report-rangepicker" class="btn btn-default waves-effect rangepicker"><span>Last 7 Days</span> <i class="caret"></i></button>
                <a href="https://analytics.google.com/analytics/web/#report/app-content-pages/a71767609w132017930p135966535/%3F_u.dateOption%3Dlast7days" class="btn btn-default waves-effect pull-right">SCREENS REPORT <i class="zmdi zmdi-chevron-right"></i></a>
            </div>
        </div>
    </div>
</div>

