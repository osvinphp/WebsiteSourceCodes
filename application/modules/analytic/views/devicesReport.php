<div class="list-group lg-odd-black">
    <?php foreach ($devices as $row): ?>
        <a class="list-group-item media" href="#">
            <div class="pull-left device-icon text-center">
                <i class="zmdi zmdi-<?php echo ($row->category == 'mobile') ? 'smartphone' : 'tablet'; ?>"></i>
            </div>
            <div class="media-body">
                <div class="lgi-heading m-l-20"><?php echo $row->device; ?></div>
                <small class="lgi-text m-l-20"><?php echo $row->sessions; ?> | <?php echo $row->percentage; ?>%</small>
            </div>
        </a>
    <?php endforeach; ?>
    <?php if (empty($devices)): ?>
        <a class="list-group-item media" href="#">
            <div class="media-body text-center">
                <div class="lgi-heading">No Devices Data</div>
            </div>
        </a>
    <?php endif; ?>
</div>