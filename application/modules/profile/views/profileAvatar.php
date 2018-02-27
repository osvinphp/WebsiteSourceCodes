<div id="avatar-modal">
    <form class="avatar-form" action="<?php echo base_url('profile/cropAvatar'); ?>" enctype="multipart/form-data" method="post">
        <div class="avatar-body">
            <!-- Upload image and data -->
            <div class="avatar-upload">
                <input type="hidden" name="is_ajax" value="true">
                <input type="hidden" class="avatar-src" name="avatar_src">
                <input type="hidden" class="avatar-data" name="avatar_data">
                <label for="avatarInput">Choose Photo</label>
                <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
            </div>

            <!-- Crop and preview -->
            <div class="row">
                <div class="col-md-12">
                    <div class="avatar-wrapper"></div>
                </div>
            </div>

            <div class="row avatar-btns">
                <div class="col-md-9">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Rotate Left</button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate Right</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="change_avatar" value="true" class="btn btn-primary btn-block avatar-save">Finish</button>
                </div>
            </div>
        </div>
    </div>
</div>