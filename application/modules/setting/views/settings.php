<div class="block-header">
    <h2><?php echo $pageTitle; ?></h2>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body card-padding">
                <?php echo form_open('#', 'id="settings-form"'); ?>
                    
                    <h2 class="section-title">General Settings</h2>
                    <div class="row m-b-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="fg-line">
                                    <label>Admin Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Admin Email Address"  name="generalAdminEmail" value="<?php echo $settings->generalAdminEmail; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="fg-line">
                                    <label>Site Title</label>
                                    <input type="text" class="form-control" placeholder="Enter Site Title"  name="generalSiteTitle" value="<?php echo $settings->generalSiteTitle; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <h2 class="section-title">Company Settings</h2>
                    <div class="row m-b-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="fg-line">
                                    <label>Company Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Company Email Address"  name="companyEmail" value="<?php echo $settings->companyEmail; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fg-line">
                                    <label>Company Address (Line 1)</label>
                                    <input type="text" class="form-control" placeholder="Enter Company Address"  name="companyAddress[]" value="<?php echo $settings->companyAddress[0]; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fg-line">
                                    <label>Company Address (Line 2)</label>
                                    <input type="text" class="form-control" placeholder="Enter Company Address"  name="companyAddress[]" value="<?php echo $settings->companyAddress[1]; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="fg-line">
                                    <label>ABN / ACN</label>
                                    <input type="text" class="form-control" placeholder="Enter Business/Company Number"  name="companyBusinessNumber" value="<?php echo $settings->companyBusinessNumber; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fg-line">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" placeholder="Enter Company Phone Number"  name="companyPhoneNumber" value="<?php echo $settings->companyPhoneNumber; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fg-line">
                                    <label>Website</label>
                                    <input type="text" class="form-control" placeholder="Enter Company Website"  name="companyWebsite" value="<?php echo $settings->companyWebsite; ?>">
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <h2 class="section-title">Google Analytic Settings</h2>                                            
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="fg-line">
                                    <label>Service Account JSON</label>
                                    <pre contenteditable="true" name="analyticServiceAccount" class="submit"><?php echo json_encode(json_decode($settings->analyticServiceAccount), JSON_PRETTY_PRINT); ?></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary btn-block waves-effect submit" name="id" value="<?php echo $settings->id; ?>">Save</button>
                    
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

