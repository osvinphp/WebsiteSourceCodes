<div class="block-header">
    <h2>Monitoring <small>Check the health and operations of the Flicklink Parse Server</small></h2>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card" id="cpu-usage">
            <div class="card-header">
                <h2>CPU Usage</h2>
                <ul class="actions">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-range btn-range-cpu waves-effect" data-count="1" data-units="hour">1 Hour</button>
                        <button type="button" class="btn btn-default btn-range btn-range-cpu waves-effect" data-count="6" data-units="hours">6 Hours</button>
                        <button type="button" class="btn btn-default btn-range btn-range-cpu waves-effect" data-count="12" data-units="hours">12 Hours</button>
                        <button type="button" class="btn btn-default btn-range btn-range-cpu waves-effect" data-count="1" data-units="day">1 Day</button>
                        <button type="button" class="btn btn-default btn-range btn-range-cpu waves-effect" data-count="2" data-units="days">2 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-cpu waves-effect" data-count="4" data-units="days">4 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-cpu waves-effect" data-count="7" data-units="days">7 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-cpu waves-effect" data-count="14" data-units="days">14 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-cpu waves-effect" data-count="30" data-units="days">30 Days</button>
                    </div>
                </ul>
            </div>
            <div class="card-body">
                <div id="cpu-usage-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card" id="disk-usage">
            <div class="card-header">
                <h2>Disk I/O Bytes</h2>
                <ul class="actions">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-range btn-range-disk waves-effect" data-count="1" data-units="hour">1 Hour</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk waves-effect" data-count="6" data-units="hours">6 Hours</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk waves-effect" data-count="12" data-units="hours">12 Hours</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk waves-effect" data-count="1" data-units="day">1 Day</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk waves-effect" data-count="2" data-units="days">2 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk waves-effect" data-count="4" data-units="days">4 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk waves-effect" data-count="7" data-units="days">7 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk waves-effect" data-count="14" data-units="days">14 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk waves-effect" data-count="30" data-units="days">30 Days</button>
                    </div>
                </ul>
            </div>
            <div class="card-body">
                <div id="disk-usage-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card" id="disk-operation-usage">
            <div class="card-header">
                <h2>Disk I/O (Operations)</h2>
                <ul class="actions">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-range btn-range-disk-operation waves-effect" data-count="1" data-units="hour">1 Hour</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk-operation waves-effect" data-count="6" data-units="hours">6 Hours</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk-operation waves-effect" data-count="12" data-units="hours">12 Hours</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk-operation waves-effect" data-count="1" data-units="day">1 Day</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk-operation waves-effect" data-count="2" data-units="days">2 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk-operation waves-effect" data-count="4" data-units="days">4 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk-operation waves-effect" data-count="7" data-units="days">7 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk-operation waves-effect" data-count="14" data-units="days">14 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-range-disk-operation waves-effect" data-count="30" data-units="days">30 Days</button>
                    </div>
                </ul>
            </div>
            <div class="card-body">
                <div id="disk-operation-usage-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card" id="network-bytes">
            <div class="card-header">
                <h2>Network Bytes</h2>
                <ul class="actions">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-range btn-network-bytes waves-effect" data-count="1" data-units="hour">1 Hour</button>
                        <button type="button" class="btn btn-default btn-range btn-network-bytes waves-effect" data-count="6" data-units="hours">6 Hours</button>
                        <button type="button" class="btn btn-default btn-range btn-network-bytes waves-effect" data-count="12" data-units="hours">12 Hours</button>
                        <button type="button" class="btn btn-default btn-range btn-network-bytes waves-effect" data-count="1" data-units="day">1 Day</button>
                        <button type="button" class="btn btn-default btn-range btn-network-bytes waves-effect" data-count="2" data-units="days">2 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-network-bytes waves-effect" data-count="4" data-units="days">4 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-network-bytes waves-effect" data-count="7" data-units="days">7 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-network-bytes waves-effect" data-count="14" data-units="days">14 Days</button>
                        <button type="button" class="btn btn-default btn-range btn-network-bytes waves-effect" data-count="30" data-units="days">30 Days</button>
                    </div>
                </ul>
            </div>
            <div class="card-body">
                <div id="network-bytes-chart"></div>
            </div>
        </div>
    </div>
</div>
<div class="block-header">
    <h2>Server Logs <small>Verbose logging. Hello... is this thing on?</small></h2>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card" id="server-logs">
            <div class="list-group lg-odd-black" id="server-logs-list">
                <div class="list-group-item media" id="server-logs-load-more">
                    <div class="media-body text-center">
                        <button class="btn btn-primary waves-effect" value="">Load More</button>
                    </div>
                </div>
            <div>
        </div>
    </div>
</div>