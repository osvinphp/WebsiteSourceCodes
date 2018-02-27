<?php echo form_open('#', 'id="add-form"'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="fg-line">
                    <label>Reward Name</label>
                    <input type="text" class="form-control" placeholder="Enter Reward Name"  name="rewardName">
                </div>
            </div>
            <div class="form-group">
                <div class="fg-line">
                    <label>Reward Description</label>
                    <input type="text" class="form-control" placeholder="Enter Reward Description"  name="rewardDescription">
                </div>
            </div>
            <div class="form-group">
                <div class="fg-line">
                    <label>Reward Redemption</label>
                    <input type="text" class="form-control" placeholder="Enter Reward Redemption"  name="rewardRedemption">
                </div>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <div class="form-group">
                <button type="button" data-dismiss="modal" class="btn btn-default waves-effect">Close</button>&nbsp;&nbsp;
                <button type="submit" class="submit btn btn-success waves-effect">Save</button>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>