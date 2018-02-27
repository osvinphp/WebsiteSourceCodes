<div class="block-header">
    <h2><?php echo $pageTitle; ?></h2>
    <ul class="actions btnact_new1">
        <li>
            <button type="submit" class="submit btn btn-block btn-primary waves-effect" onclick="<?php echo base_url()?>canvas/iosPush">Create Event</button>
        </li>
    </ul>
    <ul class="actions">
        <li>
            <a href="">
                <i class="zmdi zmdi-trending-up"></i>
            </a>
        </li>
        <li>
            <a href="">
                <i class="zmdi zmdi-check-all"></i>
            </a>
        </li>
        <li class="dropdown">
            <a href="" data-toggle="dropdown">
                <i class="zmdi zmdi-more-vert"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-right">
                <li>
                    <a href="">Refresh</a>
                </li>
                <li>
                    <a href="">Manage Widgets</a>
                </li>
                <li>
                    <a href="">Widgets Settings</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-2">
        <div class="card">
            <div class="card-header ch-alt">
                <h2>Data Sources</h2>
            </div>
            <div class="card-body card-palette">
                <form id="form-palette">
                    <div class="input-group text-filter">
                        <div class="fg-line">
                            <input type="text" class="form-control" placeholder="Search">
                            <i class="zmdi zmdi-search"></i>
                        </div>
                    </div>
                </form>
                <div role="tabpanel" style="height: 445.5px; overflow: auto;">
                    <ul class="tab-nav tn-justified" role="tablist">
                        <li>
                            <a href="#all-tab" aria-controls="all-tab" role="tab" data-toggle="tab" aria-expanded="true">Biometric</a>
                             <!-- <a href="#all-tab" aria-controls="all-tab" role="tab" data-toggle="tab" aria-expanded="true">All</a> -->
                        </li>
                        <li>
                             <!-- <a href="#group-tab" aria-controls="group-tab" role="tab" data-toggle="tab" aria-expanded="true">Group</a> -->
                            <a href="#group-tab" aria-controls="group-tab" role="tab" data-toggle="tab" aria-expanded="true">Contextual</a>
                        </li>
                        <li>
                            <!-- <a href="#status-tab" aria-controls="status-tab" role="tab" data-toggle="tab" aria-expanded="true">Status</a> -->
                            <a href="#status-tab" aria-controls="status-tab" role="tab" data-toggle="tab" aria-expanded="true">Self Report</a>
                        </li>
                        <li>
                           <!--  <a href="#type-tab" aria-controls="type-tab" role="tab" data-toggle="tab" aria-expanded="true">Type</a> -->
                            <a href="#type-tab" aria-controls="type-tab" role="tab" data-toggle="tab" aria-expanded="true">Models</a> 
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel custom_class" class="tab-pane active" id="all-tab">
                            <?php foreach ($buildingBlocks as $key => $items): ?>
                                <div id="<?php echo str_replace(' ', '-', $key); ?>" >
                                    <?php foreach ($items as $buildingBlock): ?>
                                        <span 
                                            class="building-blocks hidden" 
                                            data-id="<?php echo $buildingBlock->id; ?>"
                                            data-icon="<?php echo $buildingBlock->svgIcon; ?>"
                                            data-name="<?php echo $buildingBlock->name; ?>"
                                            data-description="<?php echo $buildingBlock->description; ?>"
                                            data-color="<?php echo $buildingBlock->color; ?>"
                                            data-is-molecule="<?php echo $buildingBlock->isMolecule; ?>"
                                            data-size="<?php echo $buildingBlock->size; ?>"
                                            data-tags="<?php echo implode(',', $buildingBlock->tags); ?>"
                                            data-status="<?php echo $buildingBlock->status; ?>"
                                            data-data-source="<?php echo $buildingBlock->dataSource; ?>"
                                            data-privacy="<?php echo $buildingBlock->privacy; ?>"
                                            data-svg-icon="<?php echo $buildingBlock->svgPathString; ?>"><?php echo $buildingBlock->model; ?></span>
                                    <?php endforeach; ?>
                                    <div style="padding: 0px 0px 5px 25px; font-size: 11pt;">
                                    <!--     <b><?php echo $key; ?></b> -->
                                    </div>
                                    <div 
                                        class="palette" 
                                        id="palette-<?php echo str_replace(' ', '-', $key); ?>" 
                                        data-tab-id="#<?php echo str_replace(' ', '-', $key); ?>"
                                        style="height: 100%; width: 100%; margin: auto;">
                                    </div>
                                </div>                           
                            <?php endforeach; ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="group-tab">
                            <div class="form-group">
                                <div class="fg-line">
                                    <select class="form-control chosen" data-placeholder="Select Group" name="group" id="palette-group">
                                        <option value="All">All</option>
                                        <option value="Depression">Depression</option>
                                        <option value="Anxiety">Anxiety</option>
                                        <option value="Stress">Stress</option>
                                        <option value="Happiness">Happiness</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="status-tab">
                            <div class="form-group">
                                <div class="fg-line">
                                    <select class="form-control chosen" data-placeholder="Select Status" name="status" id="palette-status">
                                        <option value="All">All</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="type-tab">
                            <div class="form-group">
                                <div class="fg-line">
                                    <select class="form-control chosen" data-placeholder="Select Type" name="type" id="palette-type">
                                        <option value="All">All</option>
                                        <option value="Atom">Atom</option>
                                        <option value="Type">Type</option>
                                        <option value="Model">Model</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header ch-alt">
                <h2>Canvas</h2>

            </div>
            <div class="card-body">
                <div role="tabpanel">
                    <ul class="tab-nav tn-justified" role="tablist">
                        <li>
                            <a href="#molecule-tab" aria-controls="molecule-tab" role="tab" data-toggle="tab" aria-expanded="true" id="new-molecule-title">New Model</a>
                            <!-- <a href="#molecule-tab" aria-controls="molecule-tab" role="tab" data-toggle="tab" aria-expanded="true" id="new-molecule-title">UNNAMED MOLECULE</a> -->
                        </li>
                <!--         <li>
                            <a href="#context-tab" aria-controls="context-tab" role="tab" data-toggle="tab" aria-expanded="true">Context</a>
                        </li>
                        <li>
                            <a href="#drill-down-tab" aria-controls="drill-down-tab" role="tab" data-toggle="tab" aria-expanded="true">Drill Down</a>
                        </li> -->
                    </ul>
                    <div class="tab-content no-padding" style="height: 452px;">
                        <div role="tabpanel" class="tab-pane active" id="molecule-tab">
                            <div id="myDiagramDiv" style="height: 100%"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="context-tab">
                            <p>  </p>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="drill-down-tab">
                            <p>  </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-header ch-alt">
                <h2 id="property-box-title">Model Properties</h2>
                <!-- <h2 id="property-box-title">Molec123ule Properties</h2> -->
            </div>
            <div class="card-body" style="min-height: 499px;">
                <div role="tabpanel" class="tabpanel-properties hidden" id="element-properties">
                    <ul class="tab-nav tn-justified" role="tablist">
                        <li>
                            <a href="#element-identity-tab" aria-controls="element-identity-tab" role="tab" data-toggle="tab" aria-expanded="true">Identity</a>
                        </li>
                 <!--        <li>
                            <a href="#element-values-tab" aria-controls="element-values-tab" role="tab" data-toggle="tab" aria-expanded="true">Values</a>
                        </li> -->
                    </ul>
                    <div class="tab-content no-padding">
                        <div role="tabpanel" class="tab-pane active" id="element-identity-tab" style="height: 452px; overflow: auto;">
                            <?php echo form_open('#', 'id="element-identity-form" enctype="multipart/form-data"'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Enter Name" name="name" id="element-identity-name">
                                            </div>
                                        </div>
              <!--                           <div class="form-group">
                                            <div class="fg-line">
                                                <label>Tags</label>
                                                <select type="text" multiple class="form-control tagsinput" placeholder="Enter Tags" name="tags" id="element-identity-tags"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Status</label>
                                                <select class="form-control chosen" data-placeholder="Select Status" name="status" id="element-identity-status">
                                                    <option value=""></option>
                                                    <option value="Trial">Trial</option>
                                                    <option value="Live">Live</option>
                                                    <option value="In Review">In Review</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Privacy</label>
                                                <select class="form-control chosen" data-placeholder="Select Privacy" name="privacy" id="element-identity-privacy">
                                                    <option value=""></option>
                                                    <option value="Only Me">Only Me</option>
                                                    <option value="Company">Company</option>
                                                    <option value="Group">Group</option>
                                                    <option value="Public">Public</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Data Source</label>
                                                <select class="form-control chosen" name="dataSource" id="element-identity-data-source">
                                                    <option value="Individual">Individual</option>
                                                    <option value="Group">Group</option>
                                                    <option value="Anyone">Anyone</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Value Range</label>
                                                <input type="range" min="0" max="200" value="0" class="slider" placeholder="Enter Range" name="valueRange" id="element-identity-range11" onchange="updateTextInput(this.value);">
                                                <input type="text" class="form-control" id="element-identity-range" value=0 >
                                                 <input type="range" min="0" max="200" value="0" class="slider" placeholder="Enter Range" name="valueRange" id="element-identity-range22" onchange="updateTextInput1(this.value);">
                                                <input type="text" class="form-control" id="element-identity-range1" value=0 >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Value</label>
                                                <input type="text" class="form-control" placeholder="Enter value" name="value" id="element-identity-value">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Description</label>
                                                <textarea class="form-control" name="description" id="element-identity-description" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center submit-section">
                                        <div class="form-group">
                                            <input type="hidden" name="key" />
                                            <button type="submit" class="submit btn btn-block btn-primary waves-effect">Save</button>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="element-values-tab" style="height: 452px; overflow: auto;">
                            <?php echo form_open('#', 'id="element-values-form"'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>User</label>
                                                <select class="form-control chosen" data-placeholder="Select User" name="anyone" id="element-values-anyone" readonly>
                                                    <option value="All" selected>All</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group hidden">
                                            <div class="fg-line">
                                                <label>User</label>
                                                <select class="form-control chosen" data-placeholder="Select User" name="user" id="element-values-user">
                                                    <?php foreach ($users as $key => $user): ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $user->firstName; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group hidden">
                                            <div class="fg-line">
                                                <label>Group</label>
                                                <select class="form-control chosen" data-placeholder="Select Group" name="group" id="element-values-group">
                                                    <option value=""></option>
                                                    <?php foreach ($userGroups as $key => $value): ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $value->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Data Type</label>
                                                <select class="form-control chosen" data-placeholder="Select Data Type" name="dataType" id="element-values-data-type">
                                                    <option value=""></option>
                                                    <option value="DataBRProfit">Black Rock - Profit and Loss</option>
                                                    <option value="DataBRSale">Black Rock - Execute Sale</option>
                                                    <option value="DataBRBuy">Black Rock - Execute Buy</option>
                                                    <option value="DataAccelerometer">Data Accelerometer</option>
                                                    <option value="DataAltitude">Data Altitude</option>
                                                    <option value="DataBattery">Data Battery</option>
                                                    <option value="DataBloodPressure">Data Blood Pressure</option>
                                                    <option value="DataGalvanicSkinResponse">Data GSR</option>
                                                    <option value="DataGravity">Data Gravity</option>
                                                    <option value="DataGyro">Data Gyro</option>
                                                    <option value="DataHeartRate">Data Heart Rate</option>
                                                    <option value="DataHRV">Data HRV</option>
                                                    <option value="DataLocation">Data Location</option>
                                                    <option value="DataMagnetic">Data Magnetic</option>
                                                    <option value="DataSteps">Data Steps</option>
                                                    <option value="DataUV">Data UV</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group hidden">
                                            <div class="fg-line">
                                                <label>Field to Query</label>
                                                <select class="form-control chosen" data-placeholder="Select Field" name="fieldToQuery" id="element-values-field-to-query">
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <div class="fg-line">
                                                <label>Results</label>
                                                <select class="form-control chosen" data-placeholder="Select User" name="user" id="element-values-user">
                                                    <option value="TRUE">TRUE</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Records Match</label>
                                                <input type="text" class="form-control" value="10">
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-md-12 text-center submit-section">
                                        <div class="form-group">
                                            <input type="hidden" name="key" />
                                            <input type="hidden" name="dataSource" value="User" id="element-values-data-source" />
                                            <button type="submit" class="submit btn btn-block btn-primary waves-effect">Save</button>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tabpanel-properties hidden" id="saved-molecule-properties">
                    <ul class="tab-nav tn-justified" role="tablist">
                        <li>
                            <a href="#saved-molecule-identity-tab" aria-controls="saved-molecule-identity-tab" role="tab" data-toggle="tab" aria-expanded="true">Identity</a>
                        </li>
                  <!--       <li>
                            <a href="#saved-molecule-population-tab" aria-controls="saved-molecule-population-tab" role="tab" data-toggle="tab" aria-expanded="true">Population</a>
                        </li>
                        <li>
                            <a href="#saved-molecule-status-tab" aria-controls="saved-molecule-status-tab" role="tab" data-toggle="tab" aria-expanded="true">Status</a>
                        </li -->
                    </ul>
                    <div class="tab-content no-padding">
                        <div role="tabpanel" class="tab-pane active" id="saved-molecule-identity-tab" style="height: 452px; overflow: auto;">
                            <?php echo form_open('#', 'id="saved-molecule-identity-form" enctype="multipart/form-data"'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Enter Name" name="name" disabled />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>SVG Icon</label>
                                                <input type="file" class="form-control" placeholder="Enter Name" name="svgIcon" disabled />
                                            </div>
                                        </div>
         <!--                                   <div class="form-group">
                                            <div class="fg-line">
                                                <label>Tags</label>
                                                <input type="text" class="form-control tagsinput" placeholder="Enter Tags" name="tags" disabled />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Status</label>
                                                <select class="form-control chosen" data-placeholder="Select Status" name="status" disabled>
                                                    <option value=""></option>
                                                    <?php foreach ($buildingBlockStatus as $key => $status): ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $status->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Data Source</label>
                                                <select class="form-control chosen" data-placeholder="Select Data Source" name="dataSource" id="saved-molecule-identity-data-source" disabled>
                                                    <option value="Individual">Individual</option>
                                                    <option value="Group">Group</option>
                                                    <option value="Anyone">Anyone</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Privacy</label>
                                                <select class="form-control chosen" data-placeholder="Select Privacy" name="privacy" disabled>
                                                    <option value=""></option>
                                                    <option value="Only Me">Only Me</option>
                                                    <option value="Company">Company</option>
                                                    <option value="Group">Group</option>
                                                    <option value="Public">Public</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Description</label>
                                                <textarea class="form-control" name="description" rows="3" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="saved-molecule-population-tab" style="height: 452px; overflow: initial;">
                            <?php echo form_open('#', 'id="saved-molecule-population-form"'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>User</label>
                                                <select class="form-control chosen" data-placeholder="Select User" name="user" id="saved-molecule-values-user" disabled>
                                                    <option value="All">All</option>
                                                    <?php foreach ($users as $key => $user): ?>
                                                        <option 
                                                            value="<?php echo $key; ?>"
                                                            data-gender="<?php echo $user->gender; ?>"
                                                            data-location="<?php echo $user->location; ?>"
                                                            data-age="<?php echo $user->age; ?>"><?php echo $user->fullName; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group hidden">
                                            <div class="fg-line">
                                                <label>Group</label>
                                                <select class="form-control chosen" data-placeholder="Select Group" name="group" id="saved-molecule-values-group" disabled>
                                                    <option value=""></option>
                                                    <?php foreach ($userGroups as $key => $value): ?>
                                                        <option 
                                                            data-female="<?php echo $value->femaleUsers; ?>"
                                                            data-male="<?php echo $value->maleUsers; ?>"
                                                            data-age="<?php echo $value->averageAge; ?>"
                                                            data-members="<?php echo $value->membersCount; ?>"
                                                            value="<?php echo $key; ?>"><?php echo $value->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group hidden">
                                            <div class="fg-line">
                                                <label>Num of Users in Molecule</label>
                                                <input 
                                                    class="form-control" 
                                                    name="usersCount" 
                                                    id="saved-molecule-values-users-count"
                                                    data-female="0"
                                                    data-male="0"
                                                    data-age="0"
                                                    value="0"
                                                    disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="saved-molecule-status-tab" style="height: 452px;">
                            <form action="#" id="saved-molecule-status-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Trait Quality</label>
                                                <div class="progress progress-striped active m-t-10" id="saved-molecule-status-trait">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">0% Complete</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Conditions Met</label>
                                                <table class="table table-hover m-t-10" style="width: 100%;" id="saved-molecule-conditions-table">
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tabpanel-properties" id="molecule-properties">
                    <ul class="tab-nav tn-justified" role="tablist">
                        <li>
                            <a href="#molecule-identity-tab" aria-controls="molecule-identity-tab" role="tab" data-toggle="tab" aria-expanded="true">Identity</a>
                        </li>
          <!--               <li>
                            <a href="#molecule-population-tab" aria-controls="molecule-population-tab" role="tab" data-toggle="tab" aria-expanded="true">Population</a>
                        </li>
                        <li>
                            <a href="#molecule-status-tab" aria-controls="molecule-status-tab" role="tab" data-toggle="tab" aria-expanded="true">Status</a>
                        </li> -->
                    </ul>
                    <div class="tab-content no-padding">
                        <div role="tabpanel" class="tab-pane active" id="molecule-identity-tab" style="height: 452px; overflow: auto;">
                            <?php echo form_open('#', 'id="molecule-identity-form" enctype="multipart/form-data"'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Enter Name" name="name" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>SVG Icon</label>
                                                <input type="file" class="form-control" placeholder="Enter Name" name="svgIcon" />
                                            </div>
                                        </div>
                       <!--                  <div class="form-group">
                                            <div class="fg-line">
                                                <label>Tags</label>
                                                <input type="text" class="form-control tagsinput" placeholder="Enter Tags" name="tags" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Status</label>
                                                <select class="form-control chosen" data-placeholder="Select Status" name="status">
                                                    <option value=""></option>
                                                    <?php foreach ($buildingBlockStatus as $key => $status): ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $status->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Data Source</label>
                                                <select class="form-control chosen" data-placeholder="Select Data Source" name="dataSource" id="molecule-identity-data-source">
                                                    <option value="Individual">Individual</option>
                                                    <option value="Group">Group</option>
                                                    <option value="Anyone">Anyone</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Privacy</label>
                                                <select class="form-control chosen" data-placeholder="Select Privacy" name="privacy">
                                                    <option value=""></option>
                                                    <option value="Only Me">Only Me</option>
                                                    <option value="Company">Company</option>
                                                    <option value="Group">Group</option>
                                                    <option value="Public">Public</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Description</label>
                                                <textarea class="form-control" name="description" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center submit-section">
                                        <div class="form-group">
                                            <button type="submit" class="submit btn btn-block btn-primary waves-effect">Save</button>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="molecule-population-tab" style="height: 452px; overflow: initial;">
                            <?php echo form_open('#', 'id="molecule-population-form"'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>User</label>
                                                <select class="form-control chosen" data-placeholder="Select User" name="user" id="molecule-values-user" readonly>
                                                    <option value="All">All</option>
                                                    <?php foreach ($users as $key => $user): ?>
                                                        <option 
                                                            value="<?php echo $key; ?>"
                                                            data-gender="<?php echo $user->gender; ?>"
                                                            data-location="<?php echo $user->location; ?>"
                                                            data-age="<?php echo $user->age; ?>"><?php echo $user->fullName; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group hidden">
                                            <div class="fg-line">
                                                <label>Group</label>
                                                <select class="form-control chosen" data-placeholder="Select Group" name="group" id="molecule-values-group">
                                                    <option value=""></option>
                                                    <?php foreach ($userGroups as $key => $value): ?>
                                                        <option 
                                                            data-female="<?php echo $value->femaleUsers; ?>"
                                                            data-male="<?php echo $value->maleUsers; ?>"
                                                            data-age="<?php echo $value->averageAge; ?>"
                                                            data-members="<?php echo $value->membersCount; ?>"
                                                            value="<?php echo $key; ?>"><?php echo $value->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group hidden">
                                            <div class="fg-line">
                                                <label>Num of Users in Molecule</label>
                                                <input 
                                                    class="form-control" 
                                                    name="usersCount" 
                                                    id="molecule-values-users-count"
                                                    data-female="0"
                                                    data-male="0"
                                                    data-age="0"
                                                    value="0"
                                                    readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center submit-section">
                                        <div class="form-group">
                                            <input type="hidden" name="key" />
                                            <button type="submit" class="submit btn btn-block btn-primary waves-effect">Save</button>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="molecule-status-tab" style="height: 452px;">
                            <form action="#" id="molecule-status-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Trait Quality</label>
                                                <div class="progress progress-striped active m-t-10" id="molecule-status-trait">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">0% Complete</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label>Conditions Met</label>
                                                <table class="table table-hover m-t-10" style="width: 100%;" id="molecule-conditions-table">
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <div class="card">
            <div class="card-header ch-alt">
                <h2>Active Elements</h2>
            </div>
            <div class="card-body">
                <form id="form-on-screen">
                    <div class="input-group text-filter">
                        <div class="fg-line">
                            <input type="text" class="form-control" placeholder="Search">
                            <i class="zmdi zmdi-search"></i>
                        </div>
                    </div>
                </form>
                <div class="list-group" id="on-screen-block-list"></div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header ch-alt">
                <h2>Contextual Analytics &amp; Research Tools</h2>
            </div>
            <div class="card-body card-padding" style="height: 380px; overflow: auto;">
                <div class="row">
                    <div class="col-md-6 text-center" style="position: relative; height: 100%">
                        <canvas id="bar-chart"></canvas>
                    </div>
                    <div class="col-md-6 text-center" style="position: relative; height: 100%">
                        <canvas id="scatter-chart"></canvas>
                    </div>
                    <!-- <div class="col-md-4 text-center">
                        <div id="co-variance-chart"></div>
                    </div>
                    <div class="col-md-4 text-center">
                        <canvas id="population-chart" width="400" height="300"></canvas>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-header ch-alt">
                <h2>Drill Down</h2>
            </div>
            <div class="card-body" style="height: 380px;">
                <table class="table table-hover" style="width: 100%;" id="drill-down-table">
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body card-padding">
                <?php if (my_role() === 'Administrator'): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Diagram Model saved in JSON format:</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary m-r-10" onclick="Canvas.load()">Load</button>
                            <button class="btn btn-primary" id="SaveButton" onclick="Canvas.save()">Save</button>
                        </div>
                    </div>
                <?php endif; ?>
                <textarea class="m-t-20" id="mySavedModel" style="width:100%;height:200px" contenteditable="true">
                    { 
                        "class": "go.GraphLinksModel",
                        "linkFromPortIdProperty": "fromPort",
                        "linkToPortIdProperty": "toPort",
                        "nodeDataArray": [],
                        "linkDataArray": []
                    }
                </textarea>
            </div>
        </div>
    </div>
</div>