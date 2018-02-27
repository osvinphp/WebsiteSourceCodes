<div class="s-profile">
    <a href="" data-ma-action="profile-menu-toggle">
        <div class="sp-pic">
            <img src="<?php echo base_url('uploads/avatars/noavatar.png'); ?>" alt="">
        </div>

        <div class="sp-info">
            <?php echo $_SESSION['parseData']['user']->get('firstName'); ?>

            <i class="zmdi zmdi-caret-down"></i>
        </div>
    </a>

    <ul class="main-menu">
        <li class="<?php echo ($module === 'Profile') ? 'active' : ''; ?>">
            <a href="<?php echo base_url('profile/' . $_SESSION['parseData']['user']->get('username')); ?>"><i class="zmdi zmdi-account"></i> View Profile</a>
        </li>
    </ul>
</div>