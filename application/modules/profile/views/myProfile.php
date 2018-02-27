<div class="card" id="profile-main">
    <div class="pm-overview c-overflow">
        <div class="pmo-pic">
            <div class="p-relative" class="avatar-container" id="crop-avatar">
                <a href="javascript:void(0);" class="avatar-view">
                    <img class="img-responsive" src="<?php echo $user->profilePicture; ?>" alt="<?php echo $user->fullName; ?> profile picture">
                </a>
                <div class="dropdown pmop-message">
                    <a data-toggle="dropdown" href="" class="btn bgm-white btn-float z-depth-1 waves-effect waves-circle waves-float">
                        <i class="zmdi zmdi-comment-text-alt"></i>
                    </a>

                    <div class="dropdown-menu">
                        <textarea placeholder="Write something..."></textarea>

                        <button class="btn bgm-green btn-float waves-effect waves-circle waves-float"><i class="zmdi zmdi-mail-send"></i>
                        </button>
                    </div>
                </div>
                <a href="javascript:void(0);" id="update-avatar" class="pmop-edit">
                    <i class="zmdi zmdi-camera"></i> <span
                        class="hidden-xs">Update Profile Picture</span>
                </a>
            </div>
            <div class="pmo-stat">
                <h2 class="m-0 c-white">1562</h2>
                Total Connections
            </div>
        </div>

         <div class="pmo-block pmo-contact hidden-xs">
            <h2>Contact</h2>

            <ul>
                <li><i class="zmdi zmdi-phone"></i> <?php echo $user->phoneNumber; ?></li>
                <li><i class="zmdi zmdi-email"></i> <?php echo $user->email; ?></li>
                <li>
                    <i class="zmdi zmdi-pin"></i>
                    <address class="m-b-0 ng-binding">
                        -
                    </address>
                </li>
            </ul>
        </div> 
    </div>

     <div class="pm-body clearfix">
        <div role="tabpanel">
            <ul class="tab-nav tn-justified" role="tablist">
                <li class="active"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">About</a></li>
                <li><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="about">
                    
                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-equalizer m-r-10"></i> Summary</h2>

                            <ul class="actions">
                                <li class="dropdown">
                                    <a href="" data-toggle="dropdown" aria-expanded="false">
                                        <i class="zmdi zmdi-more-vert"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a data-ma-action="profile-edit" href="">Edit</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                                Sed eu est vulputate, fringilla ligula ac, maximus arcu. Donec sed felis vel
                                magna mattis ornare ut non turpis. Sed id arcu elit. Sed nec sagittis tortor.
                                Mauris ante urna, ornare sit amet mollis eu, aliquet ac ligula. Nullam dolor
                                metus, suscipit ac imperdiet nec, consectetur sed ex. Sed cursus porttitor leo.
                            </div>

                            <div class="pmbb-edit">
                                <div class="fg-line">
                                    <textarea class="form-control" rows="5" placeholder="Summary...">Sed eu est vulputate, fringilla ligula ac, maximus arcu. Donec sed felis vel magna mattis ornare ut non turpis. Sed id arcu elit. Sed nec sagittis tortor. Mauris ante urna, ornare sit amet mollis eu, aliquet ac ligula. Nullam dolor metus, suscipit ac imperdiet nec, consectetur sed ex. Sed cursus porttitor leo.</textarea>
                                </div>
                                <div class="m-t-10">
                                    <button class="btn btn-primary btn-sm waves-effect">Save</button>
                                    <button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm waves-effect">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-account m-r-10"></i> Basic Information</h2>

                            <ul class="actions">
                                <li class="dropdown">
                                    <a href="" data-toggle="dropdown">
                                        <i class="zmdi zmdi-more-vert"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a data-ma-action="profile-edit" href="">Edit</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                                <dl class="dl-horizontal">
                                    <dt>First Name</dt>
                                    <dd><?php echo $user->firstName; ?></dd>
                                </dl>
                                 <dl class="dl-horizontal">
                                    <dt>Last Name</dt>
                                    <dd><?php echo $user->lastName; ?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Gender</dt>
                                    <dd><?php echo $user->gender; ?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Date of Birth</dt>
                                    <dd><?php //echo date_view($currentUser->dob); ?></dd>
                                </dl>
                            </div>

                            <div class="pmbb-edit">
                                <?php echo form_open(); ?>
                                    <dl class="dl-horizontal">
                                        <dt class="p-t-10">First Name</dt>
                                        <dd>
                                            <div class="fg-line">
                                                <input type="text" class="form-control" name="firstName" placeholder="eg. Daeng Baco" value="<?php echo $user->firstName; ?>">
                                            </div>

                                        </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt class="p-t-10">Last Name</dt>
                                        <dd>
                                            <div class="fg-line">
                                                <input type="text" class="form-control" name="lastName" value="<?php echo $user->lastName; ?>">
                                            </div>
                                        </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt class="p-t-10">Gender</dt>
                                        <dd>
                                            <div class="fg-line">
                                                <select class="form-control" name="gender">
                                                    <option <?php echo ($user->gender == 'Man') ? 'selected' : ''; ?>>Man</option>
                                                    <option <?php echo ($user->gender == 'Woman') ? 'selected' : ''; ?>>Woman</option>
                                                </select>
                                            </div>
                                        </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt class="p-t-10">Date of Birth</dt>
                                        <dd>
                                            <div class="dtp-container dropdown fg-line">
                                                <input type="text" name="dob" class="form-control date-picker" data-toggle="dropdown" value="<?php //echo date_view($currentUser->dob); ?>">
                                            </div>
                                        </dd>
                                    </dl>
                                    <div class="m-t-30">
                                        <button type="submit" name="action" class="submit btn btn-primary btn-sm" value="update-identity">Save</button>
                                        <button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-phone m-r-10"></i> Contact Information</h2>

                            <ul class="actions">
                                <li class="dropdown">
                                    <a href="" data-toggle="dropdown">
                                        <i class="zmdi zmdi-more-vert"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a data-ma-action="profile-edit" href="">Edit</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                                <dl class="dl-horizontal">
                                    <dt>Home Address</dt>
                                    <dd>-</dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Mobile Phone</dt>
                                    <dd><?php echo $user->phoneNumber; ?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Email Address</dt>
                                    <dd><?php echo $user->email; ?></dd>
                                </dl>
                            </div>

                            <div class="pmbb-edit">
                                <?php echo form_open(); ?>
                                    <dl class="dl-horizontal">
                                        <dt class="p-t-10">Home Address</dt>
                                        <dd>
                                            <div class="fg-line">
                                                <input type="text" name="address" class="form-control" placeholder="eg. Jl. Maju Terus" value="-">
                                            </div>
                                        </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt class="p-t-10">Mobile Phone</dt>
                                        <dd>
                                            <div class="fg-line">
                                                <input type="text" name="phoneNumber" class="form-control" placeholder="eg. 00971 12345678 9" value="<?php echo $user->phoneNumber; ?>">
                                            </div>
                                        </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt class="p-t-10">Email Address</dt>
                                        <dd>
                                            <div class="fg-line">
                                                <input type="email" class="form-control" placeholder="eg. malinda.h@gmail.com" value="<?php echo $user->email; ?>" disabled>
                                            </div>
                                        </dd>
                                    </dl>
                                    <div class="m-t-30">
                                        <button type="submit" name="action" class="submit btn btn-primary btn-sm" value="update-contact">Save</button>
                                        <button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div role="tabpanel" class="tab-pane" id="settings">
                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-lock m-r-10"></i> Change Password</h2>
                        </div>
                        <div class="pmbb-body p-l-30">
                            <?php echo form_open(); ?>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Old Password</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="password" name="old_password" class="form-control">
                                        </div>
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">New Password</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="password" name="new_password" id="new-password" class="form-control">
                                        </div>
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Confirm Password</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="password" name="confirm_password" class="form-control">
                                        </div>
                                    </dd>
                                </dl>
                                <div class="m-t-30">
                                    <button type="submit" name="action" class="submit btn btn-primary btn-sm" value="update-password">Save</button>
                                    <button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> 
</div>
