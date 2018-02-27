<div role="tabpanel">
    <ul class="tab-nav tn-justified" role="tablist">
        <li class="active audience-overview-tab">
            <a href="#" role="tab" data-toggle="tab" 
                data-categories='<?php echo (isset($categories)) ? json_encode($categories) : ''; ?>' 
                data-series='<?php echo (isset($Users)) ? json_encode($Users->series) : ''; ?>'>
                Users
                <h2 class="overview-count"><?php echo (isset($Users)) ? $Users->currentCount : '0'; ?></h2>
                <span class="overview-percentage <?php echo (isset($Users)) ? $Users->status : '0'; ?>">
                    <i class="zmdi zmdi-long-arrow-<?php echo (isset($Users)) ? $Users->status : '0'; ?>"></i> <?php echo (isset($Users)) ? $Users->percentage : '0'; ?>%
                </span>
            </a>
        </li>
        <li class="audience-overview-tab">
            <a href="#" role="tab" data-toggle="tab" 
                data-categories='<?php echo (isset($categories)) ? json_encode($categories) : ''; ?>' 
                data-series='<?php echo (isset($Sessions)) ? json_encode($Sessions->series) : ''; ?>'>
                Sessions
                <h2 class="overview-count"><?php echo (isset($Sessions)) ? $Sessions->currentCount : '0'; ?></h2>
                <span class="overview-percentage <?php echo (isset($Sessions)) ? $Sessions->status : '0'; ?>">
                    <i class="zmdi zmdi-long-arrow-<?php echo (isset($Sessions)) ? $Sessions->status : '0'; ?>"></i> <?php echo (isset($Sessions)) ? $Sessions->percentage : '0'; ?>%
                </span>
            </a>
        </li>
        <li class="audience-overview-tab">
            <a href="#" role="tab" data-toggle="tab" 
                data-categories='<?php echo (isset($categories)) ? json_encode($categories) : ''; ?>' 
                data-series='<?php echo (isset($NewUsers)) ? json_encode($NewUsers->series): ''; ?>'>
                New Users
                <h2 class="overview-count"><?php echo (isset($NewUsers)) ? $NewUsers->currentCount : '0'; ?></h2>
                <span class="overview-percentage <?php echo (isset($NewUsers)) ? $NewUsers->status : '0'; ?>">
                    <i class="zmdi zmdi-long-arrow-<?php echo (isset($NewUsers)) ? $NewUsers->status : '0'; ?>"></i> <?php echo (isset($NewUsers)) ? $NewUsers->percentage : '0'; ?>%
                </span>
            </a>
        </li>
        <li class="audience-overview-tab">
            <a href="#" role="tab" data-toggle="tab" 
                data-categories='<?php echo (isset($categories)) ? json_encode($categories) : ''; ?>' 
                data-series='<?php echo (isset($SessionDuration)) ? json_encode($SessionDuration->series) : ''; ?>'>
                Session Duration
                <h2 class="overview-count"><?php echo (isset($SessionDuration)) ? $SessionDuration->currentCount : '0'; ?></h2>
                <span class="overview-percentage <?php echo (isset($SessionDuration)) ? $SessionDuration->status : '0'; ?>">
                    <i class="zmdi zmdi-long-arrow-<?php echo (isset($SessionDuration)) ? $SessionDuration->status : '0'; ?>"></i> <?php echo (isset($SessionDuration)) ? $SessionDuration->percentage : '0'; ?>%
                </span>
            </a>
        </li>
    </ul>
</div>
<div id="audience-overview-chart"></div>