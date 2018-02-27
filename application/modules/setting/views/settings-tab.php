<div class="block-header">
    <h2><?php echo $pageTitle; ?></h2>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div role="tabpanel">
                    <ul class="tab-nav tn-justified" role="tablist">
                        <li class="active">
                            <a href="#general-tab" aria-controls="general-tab" role="tab" data-toggle="tab">General</a>
                        </li>
                        <li>
                            <a href="#company-tab" aria-controls="company-tab" role="tab" data-toggle="tab">Company</a>
                        </li>
                        <li>
                            <a href="#invoice-tab" aria-controls="invoice-tab" role="tab" data-toggle="tab">Invoice</a>
                        </li>
                        <li>
                            <a href="#stripe-tab" aria-controls="stripe-tab" role="tab" data-toggle="tab">Stripe</a>
                        </li>
                        <li>
                            <a href="#onesignal-tab" aria-controls="onesignal-tab" role="tab" data-toggle="tab">OneSignal</a>
                        </li>
                        <li>
                            <a href="#analytic-tab" aria-controls="analytic-tab" role="tab" data-toggle="tab">Google Analytics</a>
                        </li>
                    </ul>
                    <?php echo form_open('#', 'id="settings-form"'); ?>
                        <div class="tab-content card-padding">
                            
                            <div role="tabpanel" class="tab-pane active" id="general-tab">
                                <div class="row">
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
                            </div>

                            <div role="tabpanel" class="tab-pane" id="company-tab">
                                <div class="row">
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
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="invoice-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Tax Code</label>
                                                <input type="text" class="form-control" placeholder="Enter Tax Code"  name="invoiceTaxCode" value="<?php echo $settings->invoiceTaxCode; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Tax Rate (%)</label>
                                                <input type="number" class="form-control" placeholder="Enter Tax Rate"  name="invoiceTaxRate" value="<?php echo $settings->invoiceTaxRate; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Payment Terms</label>
                                                <input type="number" class="form-control" placeholder="Enter Tax Rate"  name="invoicePaymentTerms" value="<?php echo $settings->invoicePaymentTerms; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Remarks</label>
                                                <textarea class="form-control" rows="3" placeholder="Enter Remarks Text" name="invoiceRemarks"><?php echo $settings->invoiceRemarks; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Mercy for your business</label>
                                                <textarea class="form-control" rows="3" placeholder="Enter Mercy For Your Business Text" name="invoiceMercyForBusiness"><?php echo $settings->invoiceMercyForBusiness; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="stripe-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Debug API Key</label>
                                                <input type="text" class="form-control" placeholder="Enter Debug API Key"  name="stripeDebugApiKey" value="<?php echo $settings->stripeDebugApiKey; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Debug Secret Key</label>
                                                <input type="text" class="form-control" placeholder="Enter Debug Secret Key"  name="stripeDebugSecretKey" value="<?php echo $settings->stripeDebugSecretKey; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Live API Key</label>
                                                <input type="text" class="form-control" placeholder="Enter Live API Key"  name="stripeLiveApiKey" value="<?php echo $settings->stripeLiveApiKey; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Live Secret Key</label>
                                                <input type="text" class="form-control" placeholder="Enter Live Secret Key"  name="stripeLiveSecretKey" value="<?php echo $settings->stripeLiveSecretKey; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Payment Mode</label>
                                                <select class="chosen form-control" name="stripePaymentMode">
                                                    <option <?php echo ($settings->stripePaymentMode == 'Debug') ? 'selected' : '' ?> >Debug</option>
                                                    <option <?php echo ($settings->stripePaymentMode == 'Live') ? 'selected' : '' ?>>Live</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div role="tabpanel" class="tab-pane" id="onesignal-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>API Key</label>
                                                <input type="text" class="form-control" placeholder="Enter API Key"  name="oneSignalApiKey" value="<?php echo $settings->oneSignalApiKey; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>App ID</label>
                                                <input type="text" class="form-control" placeholder="Enter App ID"  name="oneSignalAppId" value="<?php echo $settings->oneSignalAppId; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="analytic-tab">
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
                            </div>

                            <button class="btn btn-primary btn-block waves-effect submit" name="id" value="<?php echo $settings->id; ?>">Save</button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

