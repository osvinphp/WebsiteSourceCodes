<style>
    
    .tab-nav {
        box-shadow: initial;
    }

    .tab-nav li>a:after {
        top: 0;
        bottom: initial;
    }

    h2.overview-count {
        margin: 5px 0px;
        font-weight: 300;
        font-size: 28px;
    }

    h2.tooltip-overview-count {
        margin: 0px 0px 10px 0px;
        font-weight: 300;
        font-size: 22px;
    }

    span.overview-percentage {
        font-size: 11px;
    }

    span.overview-percentage.up {
        color: green;
    }

    span.overview-percentage.down {
        color: red;
    }

    .card-footer {
        border-top: 1px solid #eee;
        padding: 10px;
        bottom: 0; 
        position: absolute; 
        width: 100%; 
    }

    .analytic-section {
        min-height: 557px;
    }

    .device-icon {
        min-width: 30px;
        font-size: 25px;
        padding: 0px !important;
    }

    .card-title {
        font-size: 14px;
    }

    #realtime-report .card-subtitle {
        border-bottom: 1px dashed rgba(255,255,255,0.5);
    }

    #realtime-report .card-footer {
        border-top: 1px solid rgba(255,255,255,0.5);
    }

    .realtime-count {
        font-size: 50px;
        font-weight: 300;
    }

    #realtime-report .table>thead>tr>th {
        background-color: transparent; 
        color: #FFF;
        text-transform: initial; 
        border-bottom: 1px dashed rgba(255,255,255,0.5);
    }

    #realtime-report .table>thead>tr>th:first-child,
    #realtime-report .table>tbody>tr>td:first-child,
    #realtime-report .table>tbody>tr>td:last-child,
    #realtime-report .table>thead>tr>th:last-child {
        padding-left: initial;
        padding-right: initial;
    }

    #realtime-report .table>tbody>tr>td, 
    #realtime-report .table>tbody>tr>th, 
    #realtime-report .table>tfoot>tr>td, 
    #realtime-report .table>tfoot>tr>th, 
    #realtime-report .table>thead>tr>td, 
    #realtime-report .table>thead>tr>th {
        border-top: none;
    }

    #location-overview-map {
        height: 200px;
    }

    #devices-report .card-body,
    #screens-report .card-body {
        max-height: 507px;
        overflow: auto;
    }

    #cohort-analysis-report .table>tbody>tr:last-child>td, 
    #cohort-analysis-report .table>tfoot>tr:last-child>td {
        padding-bottom: 10px;
    }

    #cohort-analysis-report .table>thead>tr>th:first-child,
    #cohort-analysis-report .table>tbody>tr>td:first-child,
    #cohort-analysis-report .table>tbody>tr>td:last-child,
    #cohort-analysis-report .table>thead>tr>th:last-child {
        padding-right: 10px;
    }

    #cohort-analysis-report .table>tbody>tr {
        /* outline: thin solid #f5f5f5 !important; */
        box-shadow: -10px 0.5px 0.5px rgba(0,0,0,.15)
    }

    .user-retention {
        border-right: 1px solid #fff;
    }

    .popover-title {
        font-weight: bold;
    }

    .popover-content {
        color: initial !important;
        font-weight: 300;
    }
    
    .daterangepicker_input input {
        padding-left: 27px !important;
    }
</style>