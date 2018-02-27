<?php echo form_open('#', 'id="add-form"'); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="fg-line">
                    <label>Email</label>
                    <input type="email" class="form-control" placeholder="Enter Email Address"  name="email">
                </div>
            </div>
            <div class="form-group">
                <div class="fg-line">
                    <label>First Name</label>
                    <input type="text" class="form-control" placeholder="Enter First Name" name="firstName">
                </div>
            </div>
            <div class="form-group">
                <div class="fg-line">
                    <label>Last Name</label>
                    <input type="text" class="form-control" placeholder="Enter Last Name" name="lastName">
                </div>
            </div>
            <div class="form-group">
                <div class="fg-line">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" placeholder="Enter Phone Number" name="phoneNumber">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="fg-line">
                    <label>Username</label>
                    <input type="username" class="form-control" placeholder="Enter Username"  name="username">
                </div>
            </div>
            <div class="form-group">
                <div class="fg-line">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Enter Password"  name="password">
                </div>
            </div>
            <div class="form-group">
                <div class="fg-line">
                    <label>Permission Level</label>
                    <select class="form-control chosen" data-placeholder="Select Permission Level" name="role">
                        <option value=""></option>
                        <?php foreach($roles as $row): ?>
                        <option value="<?php echo $row->name; ?>"><?php echo $row->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <div class="form-group">
                <button type="button" data-dismiss="modal" class="btn btn-default waves-effect">Close</button>&nbsp;&nbsp;
                <button type="submit" class="submit btn btn-primary waves-effect">Save</button>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>