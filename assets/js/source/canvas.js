// Canvas variables
var diagramPalette = {};
var availableBlocks = {};
var onScreenBlocks = {};
var blockIcons = {};
var myDiagram = null;
var usersColor = {};

// Canvas element
var newMoleculeTitle = $('#new-molecule-title');
var elementProperties = $('#element-properties');
var moleculeProperties = $('#molecule-properties');
var savedMoleculeProperties = $('#saved-molecule-properties');
var propertyBoxTitle = $('#property-box-title');
var drillDownTable = $('#drill-down-table');

var elementIdentityDataSource = $('#element-identity-data-source');
var elementValuesUser = $('#element-values-user');
var elementValuesAnyone = $('#element-values-anyone');
var elementValuesGroup = $('#element-values-group');
var elementValuesDataType = $('#element-values-data-type');
var elementValuesDataSource = $('#element-values-data-source');
var elementValuesFieldToQuery = $('#element-values-field-to-query');

var elementIdentityForm = $('#element-identity-form');
var elementValuesForm = $('#element-values-form');

var moleculeIdentityDataSource = $('#molecule-identity-data-source');
var moleculeValuesUser = $('#molecule-values-user');
var moleculeValuesGroup = $('#molecule-values-group');
var moleculeValuesUsersCount = $('#molecule-values-users-count');

var moleculeIdentityForm = $('#molecule-identity-form');
var moleculeValuesForm = $('#molecule-values-form');
var moleculeStatusForm = $('#molecule-status-form');

var savedMoleculeIdentityForm = $('#saved-molecule-identity-form');
var savedMoleculeValuesForm = $('#saved-molecule-values-form');
var savedMoleculeStatusForm = $('#saved-molecule-status-form');

var barChart = null;
var scatterChart = null;

// $$ for gojs, since $ is used by jquery
var $$ = go.GraphObject.make;

// Selected element
var selectedElementData = null;
var selectedMoleculeData = {
    identity: {},
    population: {}
};

// Canvas action
var Canvas = function() {

    return {

        // Execute js module 
        init: function() {
            Canvas.main();
            Canvas.frequencyChart();
            Canvas.scatterChart();
            // Canvas.coVarianceChart();
            // Canvas.populationChart();
        },

        // Main function of the module
        main: function() {

            // Load all the icons svg path
            $('.building-blocks').each(function(index, value) {
                let icon = $(this);
                let iconId = icon.data('id');
                let iconString = icon.data('svg-icon');

                blockIcons[iconId] = iconString;
            });
            
            $(document).on('click', '.on-screen-block', function() {
                let nodeKey = $(this).data('key');
                let node = myDiagram.findNodeForKey(nodeKey);
                
                myDiagram.select(node);
                myDiagram.centerRect(node.actualBounds);
                Canvas.showNodeProperty(null, node);
            });

            $(document).on('submit', '#form-palette', function(e) {
                Canvas.renderPaletteItem();
                e.preventDefault();
            });

            $(document).on('keyup', '#form-palette input', function(e) {
                Canvas.renderPaletteItem();
                e.preventDefault();
            });

            $(document).on('submit', '#form-on-screen', function(e) {
                Canvas.renderActiveScreen();
                e.preventDefault();
            });

            $(document).on('keyup', '#form-on-screen input', function(e) {
                Canvas.renderActiveScreen();
                e.preventDefault();
            });

            $(document).on('submit', '#element-identity-form', function(e) {
                let form = $(this);
                let formData = form.serializeArray();
                let key = form.find('[name="key"]').val();
                let data = myDiagram.model.findNodeDataForKey(key);
                
                $.each(formData, function(index, item) {
                    let name = item.name;
                    let value = item.value;
                    
                    switch (item.name) {
                        case 'tags':
                            value = form.find('[name="tags"]').val();
                        break;
                    }

                    myDiagram.model.setDataProperty(data, name, value);
                });

                Canvas.save();
                Canvas.renderActiveScreen();
                e.preventDefault();
            });

            $(document).on('submit', '#element-values-form', function(e) {
                let form = $(this);
                let formData = form.serializeArray();
                let key = form.find('[name="key"]').val();
                let data = myDiagram.model.findNodeDataForKey(key);
                let submitButton = form.find('.submit');
                let url = App.baseUrl('canvas/getElementQuery');
                
                let values = {
                    fields: {},
                    results: {}
                };

                $.each(formData, function(index, item) {
                    let name = item.name;
                    let value = item.value;
                    
                    switch (name) {
                        case 'user':
                        case 'group':
                        case 'dataType':
                        case 'key':
                            values[name] = value;
                        break;

                        default:
                            values.fields[name] = value;
                        break;
                    }
                });
                
                // Start submitting data
                App.blockElement(form);
                submitButton.attr('disabled', true);
                
                // Create new ajax request
                App.ajax(url, 'post', 'json', App.serializeForm(form))
                    
                    .error(function(err) {
                        App.unblockElement(form);
                        submitButton.attr('disabled', false);
                    })
        
                    .done(function(response) {
                        App.unblockElement(form);
                        submitButton.attr('disabled', false);
                        values.results = response;

                        // Save the element data
                        myDiagram.model.setDataProperty(data, 'values', values);
                        Canvas.save();
                        Canvas.renderActiveScreen();
                    });

                e.preventDefault();
            });

            $(document).on('submit', '#molecule-identity-form', function(e) {
                let form = $(this);
                let formDataArray = form.serializeArray();
                let formData = new FormData($(this)[0]);
                let submitButton = form.find('.submit');
                let url = App.baseUrl('canvas/saveMolecule');

                $.each(formDataArray, function(index, item) {
                    let name = item.name;
                    let value = item.value;
                    
                    switch (item.name) {
                        case 'tags':
                            value = form.find('[name="tags"]').val();
                        break;

                        case 'name': 
                            newMoleculeTitle.text(value);
                        break;
                    }

                    selectedMoleculeData.identity[name] = value;
                });

                // Save the element data
                Canvas.save();

                // Append json model to formData
                let jsonModel = $('#mySavedModel').val();
                formData.append('model', jsonModel);

                // Start submitting data
                App.blockElement(form);
                submitButton.attr('disabled', true);
                
                // Create new ajax request
                App.ajaxFile(url, 'post', 'json', formData)
                    
                    .error(function(err) {
                        App.unblockElement(form);
                        submitButton.attr('disabled', false);
                    })
        
                    .done(function(response) {
                        App.unblockElement(form);
                        submitButton.attr('disabled', false);

                        if (response.status) {
                            swal(response.action, response.message, "success");
                            $('#all-tab').load(location.href+' #all-tab>*', function() {
                                Canvas.buildPalette();
                            });
                        } else {
                            swal(response.action, response.message, "error");
                        }
                    });

                e.preventDefault();
            });

            $(document).on('submit', '#molecule-population-form', function(e) {
                let form = $(this);
                let formData = form.serializeArray();
                
                $.each(formData, function(index, item) {
                    let name = item.name;
                    let value = item.value;
                    
                    switch (item.name) {
                        case 'tags':
                            value = form.find('[name="tags"]').val();
                        break;

                        default: 
                            selectedMoleculeData.population[name] = value;
                        break;
                    }
                });

                Canvas.save();
                e.preventDefault();
            });
            
            App.loadChosen('.chosen');
            App.loadTagsInput('.tagsinput');
            // fixChoosen();

            Canvas.buildWorkspace();
            Canvas.buildPalette();

            elementIdentityDataSource.chosen({width: 'inherit', search_contains: true});
            moleculeIdentityDataSource.chosen({width: 'inherit', search_contains: true});

            // Element
            elementIdentityDataSource.on('change', function() {
                let value = $(this).val();

                switch (value) {
                    case 'Individual':
                        elementValuesUser
                            .closest('.form-group')
                            .removeClass('hidden');
                        elementValuesAnyone
                            .closest('.form-group')
                            .addClass('hidden');
                        elementValuesGroup
                            .closest('.form-group')
                            .addClass('hidden');
                    break;
                    case 'Anyone':
                        elementValuesAnyone
                            .closest('.form-group')
                            .removeClass('hidden');
                        elementValuesUser
                            .closest('.form-group')
                            .addClass('hidden');
                        elementValuesGroup
                            .closest('.form-group')
                            .addClass('hidden');
                    break;
                    case 'Group':
                        elementValuesGroup
                            .closest('.form-group')
                            .removeClass('hidden');
                        elementValuesUser
                            .closest('.form-group')
                            .addClass('hidden');
                        elementValuesAnyone
                            .closest('.form-group')
                            .addClass('hidden');
                    break;
                }

                elementValuesDataSource.val(value);
            });

            elementValuesDataType.on('change', function() {
                let thisContainer = $(this).closest('.form-group');
                let value = $(this).val();
                let fields = selectedElementData.values.fields;
                
                if (value === '') {
                   
                    elementValuesFieldToQuery
                        .empty()
                        .change()
                        .trigger('chosen:updated')
                        .closest('.form-group')
                        .addClass('hidden');

                } else {
                    
                    let options = [];
                    let optionString = '';

                    switch (value) {
                        case 'DataAccelerometer':
                        case 'DataGyro':
                        case 'DataMagnetic':
                            options = [
                                { name: 'xReading', label: 'xReading', type: 'range-unsigned' },
                                { name: 'yReading', label: 'yReading', type: 'range-unsigned' },
                                { name: 'zReading', label: 'zReading', type: 'range-unsigned' }
                            ];
                        break;
    
                        case 'DataGravity':
                            options = [
                                { name: 'xReading', label: 'xReading', type: 'range-unsigned' },
                                { name: 'yReading', label: 'yReading', type: 'range-unsigned' },
                                { name: 'zReading', label: 'zReading', type: 'range-unsigned' },
                                { name: 'rollReading', label: 'Roll Reading', type: 'range-unsigned' },
                                { name: 'pitchReading', label: 'Pitch Reading', type: 'range-unsigned' },
                                { name: 'azimuthReading', label: 'Azimuth Reading', type: 'range-unsigned' }
                            ];
                        break;
    
                        case 'DataSteps':
                            options = [
                                { name: 'stepsReading', label: 'Steps Reading', type: 'range-unsigned' },
                                { name: 'distanceReading', label: 'Distance Reading', type: 'range-unsigned' },
                                { name: 'ascendedReading', label: 'Ascended Reading', type: 'range-unsigned' },
                                { name: 'descendedReading', label: 'Descended Reading', type: 'range-unsigned' },
                                { name: 'paceReading', label: 'Pace Reading', type: 'range-unsigned' },
                                { name: 'cadenceReading', label: 'Cadence Reading', type: 'range-unsigned' }
                            ];
                        break;
    
                        case 'DataAltitude':
                            options = [
                                { name: 'pressureReading', label: 'Pressure Reading', type: 'range-unsigned' },
                                { name: 'relativeReading', label: 'Relative Reading', type: 'range-unsigned' }
                            ];
                        break;
    
                        case 'DataLocation':
                            options = [
                                { name: 'latLonReading', label: 'Lat Lon Reading', type: 'text' }
                            ];
                        break;
    
                        case 'DataBattery':
                            options = [
                                { name: 'levelReading', label: 'Level Reading', type: 'range-unsigned' },
                                { name: 'chargingReading', label: 'Charging Reading', type: 'boolean' },
                                { name: 'fullReading', label: 'Full Reading', type: 'boolean' }
                            ];
                        break;
    
                        case 'DataUV':
                            options = [
                                { name: 'exposureReading', label: 'Exposure Reading', type: 'range-unsigned' },
                                { name: 'temperatureReading', label: 'Temperature Reading', type: 'range-unsigned' }
                            ];
                        break;
    
                        case 'DataBloodPressure':
                            options = [
                                { name: 'systolicReading', label: 'Systolic Reading', type: 'range-unsigned' },
                                { name: 'diastolicReading', label: 'Diastolic Reading', type: 'range-unsigned' }
                            ];
                        break;
    
                        case 'DataHeartRate':
                            options = [
                                { name: 'opticalReading', label: 'Optical Reading', type: 'range-unsigned' },
                                { name: 'averageReading', label: 'Average Reading', type: 'range-unsigned' }
                            ];
                        break;
    
                        case 'DataHRV':
                            options = [
                                { name: 'peakFrequency', label: 'Peak Frequency', type: 'range-unsigned' }
                            ];
                        break;
    
                        case 'DataGalvanicSkinResponse':
                            options = [
                                { name: 'responseReading', label: 'Response Reading', type: 'range-unsigned' }
                            ];
                        break;
    
                        case 'DataBRProfit':
                        case 'DataBRBuy':
                        case 'DataBRSale':
                            options = [
                                { name: 'tradeValue', label: 'Trade Value', type: 'range-signed' }
                            ];
                        break;
                    }

                    options.map(item => {
                        optionString += `<option data-type="${item.type}" value="${item.name}">${item.label}</option>`;
                    });

                    elementValuesFieldToQuery
                        .empty()
                        .append(optionString)
                        .change()
                        .trigger('chosen:updated')
                        .closest('.form-group')
                        .removeClass('hidden');
                }

                if (fields.hasOwnProperty('fieldToQuery')) {
                    elementValuesFieldToQuery
                        .val(fields.fieldToQuery)
                        .change()
                        .trigger('chosen:updated');
                }

            });

            elementValuesFieldToQuery.on('change', function() { 
                
                let thisContainer = $(this).closest('.form-group');
                let selectedOption = $(this).find('option:selected');
                let dataType = selectedOption.data('type');
                let inputLabel = selectedOption.text();
                let inputName = selectedOption.attr('value');
                
                let inputString = '';
                let fields = selectedElementData.values.fields;
                
                // Remove all appended params
                $('.element-value-params').remove();
                
                if (dataType !== undefined) {
                    
                    switch (dataType) {
                        case 'boolean':
                            inputString += `
                                <div class="form-group element-value-params">
                                    <div class="fg-line">
                                        <label>${inputLabel}</label>
                                        <select class="form-control chosen" name=${inputName}>
                                            <option value="true">True</option>
                                            <option value="false">False</option>
                                        </select>
                                    </div>
                                </div>
                            `;
                        break;
                        
                        case 'range-signed':
                        case 'range-unsigned':
                            inputString += `
                                <div class="form-group element-value-params">
                                    <div class="fg-line">
                                        <label>${inputLabel}</label>
                                        <input 
                                            class="${dataType}" 
                                            name="${inputName}" 
                                            value="${(fields.hasOwnProperty('fieldToQuery')) ? fields[inputName] : ""}" />
                                    </div>
                                </div>
                            `;
                        break;
                    }

                    $(inputString).insertAfter(thisContainer);
                    
                    App.loadChosen('.chosen');
                    App.loadRangeSlider('.range-unsigned', {
                        type: 'double',
                        min: 0,
                        max: 1000,
                        prettify_enabled: true,
                        prettify_separator: "."
                    });
                    App.loadRangeSlider('.range-signed', {
                        type: 'double',
                        min: -1000,
                        max: 1000,
                        prettify_enabled: true,
                        prettify_separator: "."
                    });
                }
            });

            // Molecule
            moleculeIdentityDataSource.on('change', function() {
                let value = $(this).val();

                switch (value) {
                    case 'Individual':
                        moleculeValuesUser
                            .val('')
                            .change()
                            .trigger('chosen:updated')
                            .closest('.form-group')
                            .removeClass('hidden');
                        moleculeValuesGroup
                            .closest('.form-group')
                            .addClass('hidden');
                        moleculeValuesUsersCount
                            .closest('.form-group')
                            .addClass('hidden');
                    break;

                    case 'Group':
                        moleculeValuesGroup
                            .val('')
                            .change()
                            .trigger('chosen:updated')
                            .closest('.form-group')
                            .removeClass('hidden');
                        moleculeValuesUser
                            .closest('.form-group')
                            .addClass('hidden');
                        moleculeValuesUsersCount
                            .closest('.form-group')
                            .addClass('hidden');
                    break;

                    default:
                        moleculeValuesUsersCount
                            .change()
                            .closest('.form-group')
                            .removeClass('hidden');
                        moleculeValuesUser
                            .closest('.form-group')
                            .addClass('hidden');
                        moleculeValuesGroup
                            .closest('.form-group')
                            .addClass('hidden');
                    break;
                }
            });

            moleculeValuesUser.on('change', function() {
                let values = $(this).find('option:selected').data();
                let thisContainer = $(this).closest('.form-group');
                let input = '';

                // Remove all appended params
                $('.element-value-params').remove();

                for (let name in values) {
                    if (values.hasOwnProperty(name)) {
                        input += Canvas.renderElementParams([
                            { name: name, value: values[name], type: 'text', id: '', class: 'form-control' }
                        ]);
                    }
                }
                
                $(input).insertAfter(thisContainer);
                App.loadChosen('.chosen');
            });

            moleculeValuesGroup.on('change', function() {
                let values = $(this).find('option:selected').data();
                let thisContainer = $(this).closest('.form-group');
                let input = '';

                // Remove all appended params
                $('.element-value-params').remove();

                for (let name in values) {
                    if (values.hasOwnProperty(name)) {
                        input += Canvas.renderElementParams([
                            { name: name, value: values[name], type: 'text', id: '', class: 'form-control' }
                        ]);
                    }
                }
                
                $(input).insertAfter(thisContainer);
                App.loadChosen('.chosen');
            });

            moleculeValuesUsersCount.on('change', function() {
                let values = $(this).data();
                let thisContainer = $(this).closest('.form-group');
                let input = '';

                // Remove all appended params
                $('.element-value-params').remove();

                for (let name in values) {
                    if (values.hasOwnProperty(name)) {
                        input += Canvas.renderElementParams([
                            { name: name, value: values[name], type: 'text', id: '', class: 'form-control' }
                        ]);
                    }
                }
                
                $(input).insertAfter(thisContainer);
                App.loadChosen('.chosen');
            });

        },

        buildWorkspace: function() {

            let nodeSelectionAdornmentTemplate = $$(go.Adornment, "Auto",
                $$(go.Shape, 
                    { 
                        fill: null, 
                        stroke: "deepskyblue", 
                        strokeWidth: 1.5, 
                        strokeDashArray: [4, 2] 
                    }
                ),
                $$(go.Placeholder)
            );

            let nodeResizeAdornmentTemplate = $$(go.Adornment, "Spot",
                { 
                    locationSpot: go.Spot.Right 
                },
                $$(go.Placeholder),
                $$(go.Shape, 
                    { 
                        alignment: go.Spot.TopLeft, 
                        cursor: "nw-resize", 
                        desiredSize: new go.Size(6, 6), 
                        fill: "lightblue", 
                        stroke: "deepskyblue" 
                    }
                ),
                $$(go.Shape, 
                    { 
                        alignment: go.Spot.TopRight, 
                        cursor: "ne-resize", 
                        desiredSize: new go.Size(6, 6), 
                        fill: "lightblue", 
                        stroke: "deepskyblue" 
                    }
                ),
                $$(go.Shape, 
                    { 
                        alignment: go.Spot.BottomLeft, 
                        cursor: "se-resize", 
                        desiredSize: new go.Size(6, 6), 
                        fill: "lightblue", 
                        stroke: "deepskyblue" 
                    }
                ),
                $$(go.Shape, 
                    { 
                        alignment: go.Spot.BottomRight, 
                        cursor: "sw-resize", 
                        desiredSize: new go.Size(6, 6), 
                        fill: "lightblue", 
                        stroke: "deepskyblue" 
                    }
                )
            );

            let nodeRotateAdornmentTemplate = $$(go.Adornment,
                { 
                    locationSpot: go.Spot.Center, 
                    locationObjectName: "CIRCLE" 
                },
                $$(go.Shape, "Circle", 
                    { 
                        name: "CIRCLE", 
                        cursor: "pointer", 
                        desiredSize: new go.Size(7, 7), 
                        fill: "lightblue", 
                        stroke: "deepskyblue" 
                    }
                ),
                $$(go.Shape, 
                    { 
                        geometryString: "M3.5 7 L3.5 30", 
                        isGeometryPositioned: true, 
                        stroke: "deepskyblue", 
                        strokeWidth: 1.5, 
                        strokeDashArray: [4, 2] 
                    }
                )
            );
            
            let linkSelectionAdornmentTemplate = $$(go.Adornment, "Link",
                $$(go.Shape,
                // isPanelMain declares that this Shape shares the Link.geometry
                    { 
                        isPanelMain: true, 
                        fill: null, 
                        stroke: "deepskyblue", 
                        strokeWidth: 0 
                    }
                )  // use selection object's strokeWidth
            );
            
            // Define a function for creating a "port" that is normally transparent.
            // The "name" is used as the GraphObject.portId, the "spot" is used to control how links connect
            // and where the port is positioned on the node, and the boolean "output" and "input" arguments
            // control whether the user can draw links from or to the port.
            function makePort(name, spot, output, input) {
                // the port is basically just a small transparent square
                return $$(go.Shape, "Circle",
                    {
                        fill: null,  // not seen, by default; set to a translucent gray by showSmallPorts, defined below
                        stroke: null,
                        desiredSize: new go.Size(12, 12),
                        alignment: spot,  // align the port on the main Shape
                        alignmentFocus: (name === 'B') ? go.Spot.Top : spot,  // just inside the Shape
                        portId: name,  // declare this object to be a "port"
                        fromSpot: spot, toSpot: spot,  // declare where links may connect at this port
                        fromLinkable: output, toLinkable: input,  // declare whether the user may draw links to/from here
                        cursor: "pointer"  // show a different cursor to indicate potential link point
                    }
                );
            }

            function revertSpot(name) {
                switch (name) {
                    case 'T':
                        return go.Spot.Bottom;
                    case 'R':
                        return go.Spot.Left;
                    case 'B':
                        return go.Spot.Top;
                    case 'L':
                        return go.Spot.Right;
                }
            }

            function showSmallPorts(node, show) {
                node.ports.each(function(port) {
                    if (port.portId !== "") {  // don't change the default port, which is the big shape
                        port.fill = show ? "rgba(0,0,0,.3)" : null;
                    }
                });
            }

            function TopRotatingTool() {
                go.RotatingTool.call(this);
            }
            go.Diagram.inherit(TopRotatingTool, go.RotatingTool);
        
            /** @override */
            TopRotatingTool.prototype.updateAdornments = function(part) {
                go.RotatingTool.prototype.updateAdornments.call(this, part);
                var adornment = part.findAdornment("Rotating");
                if (adornment !== null) {
                    adornment.location = part.rotateObject.getDocumentPoint(new go.Spot(0.5, 0, 0, -30));  // above middle top
                }
            };
        
            /** @override */
            TopRotatingTool.prototype.rotate = function(newangle) {
                go.RotatingTool.prototype.rotate.call(this, newangle + 90);
            };
            // end of TopRotatingTool class

            myDiagram = $$(go.Diagram, "myDiagramDiv",  // must name or refer to the DIV HTML element
                {
                    grid: $$(go.Panel, "Grid",
                        $$(go.Shape, "LineH", { stroke: "lightgray", strokeWidth: 0.5 }),
                        $$(go.Shape, "LineH", { stroke: "gray", strokeWidth: 0.5, interval: 10 }),
                        $$(go.Shape, "LineV", { stroke: "lightgray", strokeWidth: 0.5 }),
                        $$(go.Shape, "LineV", { stroke: "gray", strokeWidth: 0.5, interval: 10 })
                    ),
                    allowDrop: true,  // must be true to accept drops from the Palette
                    "draggingTool.dragsLink": false,
                    "draggingTool.isGridSnapEnabled": true,
                    "linkingTool.isUnconnectedLinkValid": false,
                    "linkingTool.portGravity": 20,
                    "relinkingTool.isUnconnectedLinkValid": true,
                    "relinkingTool.portGravity": 20,
                    "relinkingTool.fromHandleArchetype":
                        $$(go.Shape, "Diamond", { segmentIndex: 0, cursor: "pointer", desiredSize: new go.Size(8, 8), fill: "tomato", stroke: "darkred" }),
                    "relinkingTool.toHandleArchetype":
                        $$(go.Shape, "Diamond", { segmentIndex: -1, cursor: "pointer", desiredSize: new go.Size(8, 8), fill: "darkred", stroke: "tomato" }),
                    "linkReshapingTool.handleArchetype":
                        $$(go.Shape, "Diamond", { desiredSize: new go.Size(7, 7), fill: "lightblue", stroke: "deepskyblue" }),
                    rotatingTool: $$(TopRotatingTool),  // defined below
                    "rotatingTool.snapAngleMultiple": 15,
                    "rotatingTool.snapAngleEpsilon": 15,
                    "undoManager.isEnabled": false,
                    "toolManager.hoverDelay": 0,
                    "toolManager.holdDelay": 70,
                    "resizingTool.computeReshape": function() { return false; }
                }
            );
            
            // when the document is modified, add a "*" to the title and enable the "Save" button
            myDiagram.addDiagramListener("Modified", function(e) {
                var button = document.getElementById("SaveButton");
                if (button) button.disabled = !myDiagram.isModified;
                var idx = document.title.indexOf("*");
                if (myDiagram.isModified) {
                    if (idx < 0) document.title += "*";
                } else {
                    if (idx >= 0) document.title = document.title.substr(0, idx);
                }
            });
    
            // when the document node is removed
            myDiagram.addDiagramListener('SelectionDeleted', function(e) {
                e.subject.each(function(item) {
                    let removedItem = item.part.data;
                    delete onScreenBlocks[removedItem.key];
                });
                Canvas.renderActiveScreen();
            });
            
            myDiagram.addDiagramListener('ExternalObjectsDropped', function(e) {
                // e.subject.each(function(part) {
                //     let partData = part.part.data;
                //     console.log(partData);
                //     if (partData.isMolecule) {
                //         myDiagram.currentTool.doCancel();
                //         $('#mySavedModel').val(partData.model);
                //     }
                // });
            });

            myDiagram.mouseDrop = function(e) {
                
                myDiagram.nodes.each(function(item) {
                    let partData = item.part.data;
                    
                    if (partData)
                        onScreenBlocks[partData.key] = partData;
                    
                    if (item.isSelected)
                        Canvas.showNodeProperty(null, item);
                });

                Canvas.renderActiveScreen();
            };

            myDiagram.mouseHold = function(e) {
                if (e.alt) {
                    myDiagram.toolManager.dragSelectingTool.delay = 50;
                    myDiagram.toolManager.dragSelectingTool.doActivate();
                } else {
                    myDiagram.toolManager.dragSelectingTool.delay = 1000;
                }
            };

            myDiagram.nodeTemplate = $$(go.Node, "Spot",
                { 
                    locationSpot: go.Spot.Center,
                    background: 'transparent'
                },
                new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
                { 
                    // selectable: true,
                    selectionAdornmentTemplate: nodeSelectionAdornmentTemplate,
                    selectionAdorned: false
                },
                { 
                    resizable: true, 
                    resizeObjectName: "PANEL", 
                    resizeAdornmentTemplate: nodeResizeAdornmentTemplate 
                },
                { 
                    rotatable: true, 
                    rotateAdornmentTemplate: nodeRotateAdornmentTemplate 
                },
                new go.Binding("angle").makeTwoWay(),
                // the main object is a Panel that surrounds a TextBlock with a Shape
                $$(go.Panel, "Auto",
                    { 
                        name: "PANEL" 
                    },
                    new go.Binding("desiredSize", "size", go.Size.parse).makeTwoWay(go.Size.stringify),
                    $$(go.Shape, "Rectangle",  // default figure
                        {
                            strokeWidth: 0,
                            fromLinkable: false, 
                            toLinkable: false,
                            fill: '#000000'
                        },
                        // new go.Binding("figure"),
                        new go.Binding('geometryString', 'icon', function(data) {
                            return go.Geometry.fillPath('F ' + Canvas.loadIcon(data));
                        })
                    )
                ),
                $$(go.TextBlock, 
                    {
                        alignment: go.Spot.BottomCenter,
                        alignmentFocus: go.Spot.TopCenter,
                        editable: false
                    },
                    new go.Binding('text', 'name')
                ),
                // four small named ports, one on each side:
                makePort("T", go.Spot.Top, true, true),
                makePort("L", go.Spot.Left, true, true),
                makePort("R", go.Spot.Right, true, true),
                makePort("B", go.Spot.Bottom, true, true ),
                { // handle mouse enter/leave events to show/hide the ports
                    mouseEnter: function(e, node) { showSmallPorts(node, true); },
                    mouseLeave: function(e, node) { showSmallPorts(node, false); },
                    click: Canvas.showNodeProperty,
                    selectionChanged: function(part) {
                        Canvas.setPropertyBox(part);
                    }
                }
            );

            myDiagram.paletteTemplate = $$(go.Part, "Vertical",
                { 
                    selectable: true, 
                    selectionAdornmentTemplate: nodeSelectionAdornmentTemplate 
                },
                new go.Binding("angle").makeTwoWay(),
                // the main object is a Panel that surrounds a TextBlock with a Shape
                $$(go.Panel, "Auto",
                    { 
                        name: "PANEL" 
                    },
                    new go.Binding("desiredSize", "size", go.Size.parse).makeTwoWay(go.Size.stringify),
                    $$(go.Shape, "Rectangle",  // default figure
                        {
                            strokeWidth: 0,
                            fromLinkable: false, 
                            toLinkable: false,
                            fill: '#000000',
                            name: 'SVG'
                        },
                        // new go.Binding("figure"),
                        new go.Binding('geometryString', 'icon', function(data) {
                            return go.Geometry.fillPath('F ' + Canvas.loadIcon(data));
                        })
                    )
                ),
                $$(go.TextBlock, 
                    {
                        editable: false,
                        name: 'TEXTBLOCK',
                        margin: 10
                    },
                    new go.Binding('text', 'name')
                ),
                {
                    mouseEnter: function(e, node) { 
                        let svg = node.findObject('SVG');
                        let textBlock = node.findObject("TEXTBLOCK");

                        svg.fill = '#6d6e71';
                        textBlock.font = '13px sans-serif';
                        textBlock.stroke = '#6d6e71';
                    },
                    mouseLeave: function(e, node) { 
                        let svg = node.findObject('SVG');
                        let textBlock = node.findObject("TEXTBLOCK");

                        svg.fill = '#000000';
                        textBlock.font =  '13px sans-serif';
                        textBlock.stroke = 'black';
                    },
                    background: 'transparent',
                    toolTip: $$(go.Adornment, "Auto",
                        $$(go.Shape, { fill: "#EFEFCC" }),
                        $$(go.TextBlock, { margin: 4, width: 100 },
                            new go.Binding("text", "description")
                        )
                    )
                }
            );

            myDiagram.linkTemplate = $$(go.Link,  // the whole link panel
                { 
                    selectable: true, 
                    selectionAdornmentTemplate: linkSelectionAdornmentTemplate 
                },
                { 
                    relinkableFrom: true, 
                    relinkableTo: true, 
                    reshapable: true 
                },
                {
                    routing: go.Link.AvoidsNodes,
                    curve: go.Link.JumpOver,
                    corner: 5,
                    toShortLength: 4
                },
                new go.Binding("points").makeTwoWay(),
                $$(go.Shape,  // the link path shape
                    { 
                        isPanelMain: true, 
                        strokeWidth: 2 
                    }
                ),
                $$(go.Shape,  // the arrowhead
                    { 
                        toArrow: "Standard", 
                        stroke: null 
                    }
                ),
                $$(go.Panel, "Auto",
                    // new go.Binding("visible", "isSelected").ofObject(),
                    $$(go.Shape, "RoundedRectangle",  // the link shape
                        { 
                            fill: "#F8F8F8", 
                            strokeWidth: 1
                        }
                    ),
                    $$(go.TextBlock, 'AND',
                        {
                            textAlign: "center",
                            font: "16pt helvetica, arial, sans-serif",
                            stroke: "#919191",
                            margin: 2,
                            minSize: new go.Size(10, NaN),
                            editable: true,
                            // textValidation: function(graphObject, oldString, newString) {
                            //     if (newString.toLowerCase() === 'and' || newString.toLowerCase() === 'or') {
                            //         return true;
                            //     } else {
                            //         return false;
                            //     }
                            // },
                            textEditor: window.TextEditorSelectBox,
                            choices: ['AND', 'OR', 'RETURNS']
                        },
                        new go.Binding("text").makeTwoWay()
                    )
                )
            );

            Canvas.load();
        },

        buildPalette: function() {

            // initialize the Palette that is on the left side of the page
            $('.palette').each(function() {
                var paletteId = $(this).attr('id');
                var categoryId = $(this).data('category-id');
                var tabId = $(this).data('tab-id');
                var buildingBlocks = $(tabId).find('.building-blocks');
                var graphLinkModel = [];
            
                buildingBlocks.each(function(index, value) {
                    var buildingBlock = $(value);
                    graphLinkModel.push({
                        name: buildingBlock.data('name'),
                        description: buildingBlock.data('description'),
                        values: {
                            fields: {},
                            results: {}
                        },
                        color: buildingBlock.data('color'),
                        icon: buildingBlock.data('id'),
                        iconURL: buildingBlock.data('icon'),
                        size: '60 60',
                        isMolecule: buildingBlock.data('is-molecule'),
                        model: buildingBlock.html(),
                        tags: buildingBlock.data('tags'),
                        status: buildingBlock.data('status'),
                        dataSource: buildingBlock.data('data-source'),
                        privacy: buildingBlock.data('privacy')
                    });

                });
                
                // Save all available bloks
                availableBlocks[categoryId] = graphLinkModel;

                var myPalette = $$(go.Palette, paletteId,  // must name or refer to the DIV HTML element
                    {
                        layout: $$(go.GridLayout, 
                            { 
                                alignment: go.GridLayout.Location,
                                wrappingColumn: 4,
                                spacing: new go.Size(13, 13)
                            }
                        ),
                        allowZoom: false,
                        maxSelectionCount: 1,
                        nodeTemplate: myDiagram.paletteTemplate,  // share the templates used by myDiagram
                        linkTemplate: // simplify the link template, just in this Palette
                            $$(go.Link,
                                { // because the GridLayout.alignment is Location and the nodes have locationSpot == Spot.Center,
                                    // to line up the Link in the same manner we have to pretend the Link has the same location spot
                                    locationSpot: go.Spot.Center,
                                    selectionAdornmentTemplate: 
                                        $$(go.Adornment, "Link",
                                            { 
                                                locationSpot: go.Spot.Center 
                                            },
                                            $$(go.Shape,
                                                { 
                                                    isPanelMain: true, 
                                                    fill: null, 
                                                    stroke: "deepskyblue", 
                                                    strokeWidth: 0 
                                                }
                                            ),
                                            $$(go.Shape,  // the arrowhead
                                                { 
                                                    toArrow: "Standard", stroke: null 
                                                }
                                            )
                                        )
                                },
                                {
                                    routing: go.Link.AvoidsNodes,
                                    curve: go.Link.JumpOver,
                                    corner: 5,
                                    toShortLength: 4
                                },
                                new go.Binding("points"),
                                $$(go.Shape,  // the link path shape
                                    { 
                                        isPanelMain: true, 
                                        strokeWidth: 2 
                                    }
                                ),
                                $$(go.Shape,  // the arrowhead
                                    { 
                                        toArrow: "Standard", 
                                        stroke: null 
                                    }
                                )
                            ),
                        // model: new go.GraphLinksModel(graphLinkModel, [])
                        model: new go.GraphLinksModel(graphLinkModel, []),
                        "InitialLayoutCompleted": function(e) {
                            var dia = e.diagram;
                            // add height for horizontal scrollbar
                            dia.div.style.height = (dia.documentBounds.height + 24) + "px";
                        }
                          
                    }
                );

                diagramPalette[categoryId] = myPalette;
            });

            $('.tab-nav li:first-child a').click();
            
        },
    
        save: function() {
            Canvas.saveDiagramProperties();  // do this first, before writing to JSON
            document.getElementById("mySavedModel").value = myDiagram.model.toJson();
            myDiagram.isModified = false;
        },

        load: function() {
            myDiagram.model = go.Model.fromJson($.parseJSON($('#mySavedModel').val()));
            Canvas.loadDiagramProperties();  // do this after the Model.modelData has been brought into memory
        },

        saveDiagramProperties: function () {
            myDiagram.model.modelData.position = go.Point.stringify(myDiagram.position);
        },

        loadDiagramProperties: function(e) {
            // set Diagram.initialPosition, not Diagram.position, to handle initialization side-effects
            var pos = myDiagram.model.modelData.position;
            if (pos) myDiagram.initialPosition = go.Point.parse(pos);
        },

        loadIcon: function(iconId) {
            return blockIcons[iconId];
        },

        renderPaletteItem: function() {

            let search = $('#form-palette input').val();

            $.each(diagramPalette, function(index, value) {
                let blocksToRender = availableBlocks[index];
                
                if (search !== '') {
                    blocksToRender = _.filter(blocksToRender, function(block) {
                        return block.name.toLowerCase().indexOf(search.toLowerCase()) !== -1;
                    });
                }
                
                value.model.nodeDataArray = blocksToRender;
                // value.model.linkDataArray = [
                //     // the Palette also has a disconnected Link, which the user can drag-and-drop
                //     { points: new go.List(go.Point).addAll([new go.Point(0, 0), new go.Point(30, 0), new go.Point(30, 40), new go.Point(60, 40)]) }
                // ];
                
            });

        },

        renderActiveScreen: function() {

            let search = $('#form-on-screen input').val();
            let blocksToRender = onScreenBlocks;
            
            if (search !== '') {
                blocksToRender = _.filter(onScreenBlocks, function(block) {
                    return block.name.toLowerCase().indexOf(search.toLowerCase()) !== -1;
                });
            }
            
            $('#on-screen-block-list').empty();
            $('#molecule-conditions-table > tbody').empty();
            
            $.each(blocksToRender, function(key, item) {
                $('#on-screen-block-list').append(`
                    <a class="list-group-item media on-screen-block" href="#" data-key="${item.key}">
                        <div class="pull-left">
                            <img src="${item.iconURL}" alt="${item.name}">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">${item.name}</div>
                        </div>
                    </a>
                `);
            });

            let totalBlocks = _.size(onScreenBlocks);
            let totalTrue = 0;
            let completion = 0;

            $.each(onScreenBlocks, function(key, item) {
                $('#molecule-conditions-table > tbody').append(`
                    <tr>
                        <td style="width: 10%;">
                            <img src="${item.iconURL}" alt="${item.name}">
                        </td>
                        <td style="width: 65%">${item.name}</td>
                        <td class="text-center" style="width: 25%">
                            <span class="label label-${(item.values.results.status) ? 'success' : 'danger'}">
                                ${(item.values.results.status) ? 'TRUE' : 'FALSE'}
                            </span>
                        </td>
                    </tr>
                `);

                if (item.values.results.status)
                    totalTrue++;
            });

            if (totalBlocks > 0) {
                completion = (totalTrue / totalBlocks) * 100;
            }
            
            $('#molecule-status-trait').find('.progress-bar').css('width', `${completion}%`);

            // Update chart
            Canvas.updateCharts(blocksToRender);
        },
        
        showNodeProperty: function(e, node) {
            let nodeData = node.part.data;
            let identityForm = elementIdentityForm;
            let valuesForm = elementValuesForm;
            selectedElementData = nodeData;
            
            if (nodeData.isMolecule) {
                Canvas.showMoleculeProperty(nodeData);
                return;
            }

            // Start set indentity form data
            identityForm.find('[name="name"]').val(nodeData.name);
            identityForm.find('[name="status"]').val(nodeData.status).trigger('chosen:updated');
            identityForm.find('[name="privacy"]').val(nodeData.privacy).trigger('chosen:updated');
            identityForm.find('[name="dataSource"]').val(nodeData.dataSource).change().trigger('chosen:updated');
            identityForm.find('[name="description"]').val(nodeData.description);
            identityForm.find('[name="key"]').val(nodeData.key);

            identityForm.find('[name="tags"]').tagsinput('destroy');
            identityForm.find('[name="tags"]').tagsinput();
            identityForm.find('[name="tags"]').tagsinput('removeAll');

            $.each(nodeData.tags.split(','), function() {
                identityForm.find('[name="tags"]').tagsinput('add', this);
            });

            // Start set values form data
            valuesForm.find('[name="key"]').val(nodeData.key);
            valuesForm.find('[name="user"]').val(nodeData.values.user).trigger('chosen:updated');
            valuesForm.find('[name="group"]').val(nodeData.values.group).trigger('chosen:updated');
            valuesForm.find('[name="dataType"]').val(nodeData.values.dataType).change().trigger('chosen:updated');

            $.each(nodeData.values.fields, function(name, value) {
                valuesForm.find(`[name="${name}"]`).val(value);
            });
        },

        showMoleculeProperty: function(data) {
            let model = JSON.parse(data.model);
            let identityForm = savedMoleculeIdentityForm;
            
            $.each(model.nodeDataArray, function(key, item) {
                $('#drill-down-table > tbody').append(`
                    <tr>
                        <td style="width: 10%;">
                            <img style="width: 30px;" src="${item.iconURL}" alt="${item.name}">
                        </td>
                        <td style="width: 65%">${item.name}</td>
                        <td class="text-center" style="width: 25%">
                            <span class="label label-${(item.values.results.status) ? 'success' : 'danger'}">
                                ${(item.values.results.status) ? 'TRUE' : 'FALSE'}
                            </span>
                        </td>
                    </tr>
                `);
            });

            // Start set indentity form data
            identityForm.find('[name="name"]').val(data.name);
            identityForm.find('[name="status"]').val(data.status).trigger('chosen:updated');
            identityForm.find('[name="privacy"]').val(data.privacy).trigger('chosen:updated');
            identityForm.find('[name="dataSource"]').val(data.dataSource).change().trigger('chosen:updated');
            identityForm.find('[name="description"]').val(data.description);
            identityForm.find('[name="key"]').val(data.key);

            identityForm.find('[name="tags"]').tagsinput('destroy');
            identityForm.find('[name="tags"]').tagsinput();
            identityForm.find('[name="tags"]').tagsinput('removeAll');

            $.each(data.tags.split(','), function() {
                identityForm.find('[name="tags"]').tagsinput('add', this);
            });

        },

        setPropertyBox: function(part) {
            if (part.isSelected) {
                propertyBoxTitle.text('Element Properties');
                elementProperties.removeClass('hidden');
                moleculeProperties.addClass('hidden');
                savedMoleculeProperties.addClass('hidden');

                if (part.data.isMolecule) {
                    propertyBoxTitle.text('Molecule Properties');
                    savedMoleculeProperties.removeClass('hidden');
                    elementProperties.addClass('hidden');
                    moleculeProperties.addClass('hidden');
                }

            } else {
                propertyBoxTitle.text('Molecule Properties');
                moleculeProperties.removeClass('hidden');
                elementProperties.addClass('hidden');
                savedMoleculeProperties.addClass('hidden');
            }

            drillDownTable.find('tbody').empty();
        },

        renderElementParams: function(params) {
            
            let options = '';

            for (let item in params) {
                
                switch (params[item].type) {
                    default:
                        options += `<option value="${params[item].name}">${params[item].name}</option>`;
                    break;
                }
            }

            let select = `<div class="form-group element-value-params">
                <div class="fg-line">
                    <label>Field to Query</label>
                    <select class="form-control chosen" name="fieldToQuery">${options}</select>
                </div>
            `;
            
            return (options !== '') ? select : options;
        },

        _renderElementParams_: function(params) {
            
            let fields = '';

            for (let item in params) {
                
                switch (params[item].type) {
                    case 'boolean':
                        fields += `
                            <div class="form-group element-value-params">
                                <div class="fg-line">
                                    <label>${params[item].name}</label>
                                    <select id="${params[item].id}" class="${params[item].class}" name=${params[item].name}>
                                        <option value="true">True</option>
                                        <option value="false">False</option>
                                    </select>
                                </div>
                            </div>
                        `;
                    break;
                    
                    default:
                        fields += `
                            <div class="form-group element-value-params">
                                <div class="fg-line">
                                    <label>${params[item].name}</label>
                                    <input id="${params[item].id}" class="${params[item].class}" name="${params[item].name}" value="${params[item].value}" />
                                </div>
                            </div>
                        `;
                    break;
                }
            }

            return fields;
        },

        // Submit function
        submitForm: function(form, id) {

            var submitButton = form.find('.submit');
            var url = App.baseUrl('canvas/getElementQuery');

            if (id) {
                url = App.baseUrl('user/update');
            }
            
            App.blockElement(form);
            submitButton.attr('disabled', true);
            
            App.ajax(url, 'post', 'json', App.serializeForm(form))
                
            .error(function(err) {
                App.unblockElement(form);
                submitButton.attr('disabled', false);
            })

            .done(function(data) {
                App.unblockElement(form);
                submitButton.attr('disabled', false);
                return data;
            });

        },

        // Add user
        add: function() {
            
            var modal = App.loadModal();
            var modalBody = modal.find('.modal-body');
            var modalTitle = modal.find('.modal-title');

            modalTitle.text('Add Canvas');

            App.blockElement($(modalBody));

            App.ajax(App.baseUrl('user/loadAddForm'), 'get', 'html')
            
            .error(function(err) {
                modal.find('.close').click();
            })

            .done(function(data) {
                modalBody.html(data);
                App.loadChosen('.chosen');
                App.unblockElement($(modalBody));
            });
        },

        // Edit user data
        edit: function(id) {

            var modal = App.loadModal();
            var modalBody = modal.find('.modal-body');
            var modalTitle = modal.find('.modal-title');

            modalTitle.text('Edit Canvas');

            App.blockElement($(modalBody));

            App.ajax(App.baseUrl('user/loadEditForm'), 'get', 'html', {id:id})
                
            .error(function(err) {
                modal.find('.close').click();
            })

            .done(function(data) {
                modalBody.html(data);
                App.loadChosen('.chosen');
                App.unblockElement($(modalBody));
            });

        },

        // Delete user data
        delete: function(id) {

            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover the data!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: false
            }, function(){

                App.ajax(App.baseUrl('user/delete'), 'post', 'json', {id: id, parse_csrf_token: Cookies.get('parse_csrf_cookie')})
                    
                .done(function(data) {
                    if (data.status) {
                        Canvas.reloadGrid();
                        swal(data.action, data.message, "success");
                    } else {
                        swal(data.action, data.message, "error");
                    }
                });

            });

        },

        frequencyChart: function() {

            var barChartData = {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: []
                }]
        
            };
            var ctx = document.getElementById("bar-chart").getContext("2d");
            barChart = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    title:{
                        display: false,
                        text:"Chart.js Bar Chart - Multi Axis"
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    },
                    legend: {
                        display: false
                    }
                }
            });
        },

        coVarianceChart: function() {
            var sets = [ 
                { sets: ['A'], size: 2 },
                { sets: ['B'], size: 2 },
                { sets: ['C'], size: 2 },
                { sets: ['A','B'], size: 0.5 },
                { sets: ['A','C'], size: 0.5 },
                { sets: ['C','B'], size: 0.5 },
            ];

            var chart = venn.VennDiagram().width(270).height(270);

            d3.select("#co-variance-chart").datum(sets).call(chart);
        },

        populationChart: function() {

            var ctx = document.getElementById("population-chart").getContext('2d');
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display: false
                    }
                }
            });
        },
        
        scatterChart: function() {

            var color = Chart.helpers.color;
            var scatterChartData = {
                labels: [],
                datasets: [{
                    label: "My First dataset",
                    borderColor: window.chartColors.red,
                    backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
                    data: []
                }]
            };

            window.onload = function() {
                var ctx = document.getElementById("scatter-chart").getContext("2d");
                scatterChart = Chart.Scatter(ctx, {
                    data: scatterChartData,
                    options: {
                        title: {
                            display: false,
                            text: 'Chart.js Scatter Chart'
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                type: 'linear',
                                position: 'bottom',
                                ticks: {
                                    min: 0
                                }
                            }]
                        },
                        events: ['click'],
                        onClick: function(event, elements) {
                            if (!elements.length) {
                                Canvas.updateCharts(onScreenBlocks);
                                return;
                            }
                            
                            let datasetIndex = elements[0]['_datasetIndex'];
                            let dataIndex = elements[0]['_index'];

                            let data = scatterChart.data.datasets[datasetIndex].data[dataIndex];

                            if (data.hasOwnProperty('key')) {
                                let blocksToRender = {};
                                blocksToRender[data.key] = onScreenBlocks[data.key];
                                Canvas.updateCharts(blocksToRender);
                            }
                        }
                    }
                });
            };

        },

        updateCharts: function(onScreenBlocks) {
            
            barChart.data.labels = [];
            barChart.data.datasets[0].data = [];

            scatterChart.data.labels = [];
            scatterChart.data.datasets[0].data = [];

            let index = 1;

            $.each(onScreenBlocks, function(key, element) {
                let fields = element.values.fields;
                let results = element.values.results;

                if (fields.hasOwnProperty('fieldToQuery')) {
                    let label = element.name;
                    let columnName = fields.fieldToQuery;
                    
                    barChart.data.datasets.forEach(dataset => {
                        $.each(results, function(user, item) {

                            if (!usersColor.hasOwnProperty(user)) {
                                usersColor[user] = App.randomColor();
                            }

                            dataset.data.push(item[columnName]);
                            dataset.backgroundColor.push(usersColor[user]);
                            barChart.data.labels.push(label);
                        });
                    });

                    scatterChart.data.datasets.forEach(dataset => {
                        $.each(results, function(user, item) {
                            dataset.data.push({
                                x: index,
                                y: item[columnName],
                                key: key
                            });
                        });
                    });

                    index++;
                }
            });

            barChart.update();
            scatterChart.update();
        }

    }

}();