<div class="card" id="profile-main">
    <div class="pm-overview c-overflow">
        <div class="pmo-pic">
            <div class="p-relative" class="avatar-container" id="crop-avatar">
                <a href="javascript:void(0);" class="avatar-view">
                    <img class="img-responsive" src="<?php echo base_url('uploads/avatars/'.$currentUser->avatar); ?>" alt="<?php echo $currentUser->fullName; ?> profile picture">
                </a>
            </div>
        </div>

        <div class="pmo-block pmo-contact hidden-xs">
            <h2>Contact</h2>

            <ul>
                <li><i class="zmdi zmdi-phone"></i> <?php echo $currentUser->phone; ?></li>
                <li><i class="zmdi zmdi-email"></i> <?php echo $currentUser->email; ?></li>
                <li>
                    <i class="zmdi zmdi-pin"></i>
                    <address class="m-b-0 ng-binding">
                        <?php echo $currentUser->address; ?>
                    </address>
                </li>
            </ul>
        </div>
    </div>

    <div class="pm-body clearfix">
        <div role="tabpanel">
            <ul class="tab-nav tn-justified" role="tablist">
                <li class="active"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">About</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="about">
                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-account m-r-10"></i> Basic Information</h2>
                        </div>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                                <dl class="dl-horizontal">
                                    <dt>First Name</dt>
                                    <dd><?php echo $currentUser->first_name; ?></dd>
                                </dl>
                                 <dl class="dl-horizontal">
                                    <dt>Last Name</dt>
                                    <dd><?php echo $currentUser->last_name; ?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Gender</dt>
                                    <dd><?php echo $currentUser->gender; ?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Date of Birth</dt>
                                    <dd><?php echo date_view($currentUser->dob); ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-phone m-r-10"></i> Contact Information</h2>
                        </div>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                                <dl class="dl-horizontal">
                                    <dt>Home Address</dt>
                                    <dd><?php echo $currentUser->address; ?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Mobile Phone</dt>
                                    <dd><?php echo $currentUser->phone; ?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Email Address</dt>
                                    <dd><?php echo $currentUser->email; ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
