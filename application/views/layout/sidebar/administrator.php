<ul class="main-menu">
    
    <!-- Account Section-->
    <li class="categories">Account</li>
    <li class="<?php echo ($module === 'User_Dashboard') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('dashboard'); ?>"><i class="zmdi zmdi-view-dashboard"></i> Dashboard</a>
    </li>
    <li class="<?php echo ($module === 'Canvas') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('canvas'); ?>"><i class="zmdi zmdi-palette"></i> Canvas</a>
    </li>
    <li class="divider"></li>

    <!-- Administration Section-->
    <li class="categories">Administration</li>
    <li class="<?php echo ($module === 'Analytic') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('analytic'); ?>"><i class="zmdi zmdi-chart"></i> Analytics</a>
    </li>
    <li class="<?php echo ($module === 'Server') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('server'); ?>"><i class="zmdi zmdi-dns"></i> Server</a>
    </li>
    <li class="<?php echo ($module === 'User') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('user'); ?>"><i class="zmdi zmdi-accounts"></i> Users</a>
    </li>
    <li class="<?php echo ($module === 'Setting') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('setting'); ?>"><i class="zmdi zmdi-settings"></i> Settings</a>
    </li>
    <li class="divider"></li>

</ul>