<ul class="main-menu">

    <!-- Account Section-->
    <li class="categories">Account</li>
    <li class="<?php echo ($module === 'User_Dashboard') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('dashboard/user'); ?>"><i class="zmdi zmdi-view-dashboard"></i> User Dashboard</a>
    </li>
    <li class="<?php echo ($module === 'Manager_Dashboard') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('dashboard/manager'); ?>"><i class="zmdi zmdi-case"></i> Manager Dashboard</a>
    </li>
    <li class="divider"></li>

    <!-- Training Section-->
    <li class="categories">Training</li>
    <li class="<?php echo ($module === 'Career_Tree') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('career_tree'); ?>"><i class="zmdi zmdi-arrow-split"></i> Career Tree</a>
    </li>
    <li class="<?php echo ($module === 'Side_Quest') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('side_quest'); ?>"><i class="zmdi zmdi-swap"></i> Side Quests</a>
    </li>
    <li class="<?php echo ($module === 'Task') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('task'); ?>"><i class="zmdi zmdi-assignment"></i> Tasks</a>
    </li>
    <li class="<?php echo ($module === 'Subtask') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('subtask'); ?>"><i class="zmdi zmdi-assignment-returned"></i> Subtasks</a>
    </li>
    <li class="<?php echo ($module === 'Reward') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('reward'); ?>"><i class="zmdi zmdi-card-giftcard"></i> Rewards</a>
    </li>
    <li class="<?php echo ($module === 'Trophy') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('trophy'); ?>"><i class="zmdi zmdi-star-circle"></i> Trophies</a>
    </li>
    <li class="<?php echo ($module === 'Statistic') ? 'active' : ''; ?>">
        <a href="<?php echo base_url('statistic'); ?>"><i class="zmdi zmdi-trending-up"></i> Statistics</a>
    </li>
    <li class="divider"></li>

</ul>