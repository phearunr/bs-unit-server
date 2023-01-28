<template>	
	<div class="d-flex justify-content-center" style="min-height: calc(100vh - 62px);">
		<div class="position-relative p-0 bg-white open" id="fitler-sidebar" style="border: 1px solid #CCC ;box-shadow: 0px 6px 6px 2px rgba(0,0,0,.2); z-index: 2; max-height: calc(100vh - 62px);">
			<div class="h-100" style="overflow-y:auto;">
				<section class="filter-block">
					<h5>Unit Types</h5>										
					<div class="form-group mb-0 form-check" v-for="(unitType, k) in unitTypes" :key="k">
						<input type="checkbox" class="form-check-input" v-model="unitType.selected" v-on:click="onUnitTypeSelectionChanged(unitType)">
						<label class="form-check-label">{{ unitType.name }}</label>
					</div>
					<div class="d-flex mt-2">
						<button class="btn btn-primary btn-sm w-50 mr-1" @click="toggleAllUnitTypeSelection(true)">Check All</button>
						<button class="btn btn-danger btn-sm w-50 ml-1" @click="toggleAllUnitTypeSelection(false)">Uncheck All</button>	
					</div>
				</section>
				<section class="filter-block">
					<div class="input-group input-group-sm mb-2">
						<div class="input-group-prepend">
							<label class="input-group-text">View as</label>
						</div>					
						<select class="custom-select" v-model="viewerMode" @change="onViewerTypeChanged">
							<option value="AVAILABILITY">Availability Status</option>
							<option value="PAYMENT">Payment Status</option>							
							<!-- <option value="CONSTRUCTION_PROGRESS">Construction Progress</option> -->
						</select>
					</div>
					<div v-if="viewerMode == 'AVAILABILITY'">
						<h5>Availability Status</h5>
			        	<div class="form-group mb-0 form-check" v-for="(obj, k) in availability_status" :key="k">
						    <input type="checkbox" class="form-check-input" :id="obj.name" v-model="obj.selected" v-on:click="onAvailabilityStatusSelectionChanged(obj.name)">
						    <label class="form-check-label" :for="obj.name" ><i class="fas fa-square" v-bind:style="{ color: obj.colorCode }"></i> {{ obj.name }}</label>
						</div>
						<div class="d-flex mt-2">
							<button class="btn btn-primary btn-sm w-50 mr-1" @click="toggleAllAvailabilityStatusSelection(true)">Check All</button>
							<button class="btn btn-danger btn-sm w-50 ml-1" @click="toggleAllAvailabilityStatusSelection(false)">Uncheck All</button>
						</div>
						
					</div>
					<div class="filter-block"  v-else-if="viewerMode == 'PAYMENT'">
						<h5 class="mt-2">Late Payment Type</h5>
						<div class="form-group mb-0 form-check" v-for="(obj, k) in late_payment_status">
						    <input type="checkbox" class="form-check-input" :id="obj.code" v-model="obj.selected" v-on:click="onLatePaymentStatusSelectionChanged(obj.code)">
						    <label class="form-check-label" :for="obj.code"><i class="fas fa-square" v-bind:style="{ color: obj.colorCode }"></i> {{ obj.name }}</label>
						</div>
						<div class="d-flex mt-2">
							<button class="btn btn-primary btn-sm w-50 mr-1" @click="toggleAllLatePaymentStatusSelection(true)">Check All</button>
							<button class="btn btn-danger btn-sm w-50 ml-1" @click="toggleAllLatePaymentStatusSelection(false)">Uncheck All</button>
						</div>

						<hr />
						<h5 class="mt-2">Late Deadline Type</h5>
						<div class="form-group mb-0 form-check" v-for="(obj, k) in late_deadline_status">
						    <input type="checkbox" class="form-check-input" :id="obj.code" v-model="obj.selected" v-on:click="onLateDeadlineStatusSelectionChanged(obj.code)">
						    <label class="form-check-label" :for="obj.code"> ({{ obj.code }}) {{ obj.name }}</label>
						</div>
						<div class="d-flex mt-2">
							<button class="btn btn-primary btn-sm w-50 mr-1" @click="toggleAllLateDeadlineStatusSelection(true)">Check All</button>
							<button class="btn btn-danger btn-sm w-50 ml-1" @click="toggleAllLateDeadlineStatusSelection(false)">Uncheck All</button>
						</div>

						<hr />
						<div class="form-group mb-0 form-check">
						    <input type="checkbox" id="unit-label-toggle" class="form-check-input" v-on:click="toggleUnitLabel()">
						    <label class="form-check-label" for="unit-label-toggle">Show Late Deadline Type</label>
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="flex-grow-1 position-relative p-0 bg-white">
			<div class="h-100 d-flex flex-column">
				<svg id="viewer-box" class="flex-grow-1"></svg>	
			</div>
			<div class="btn-group-vertical position-absolute btn-group-sm btn-group-zoom-control">
				<button type="button" class="btn btn-secondary" @click="saveToImage"><i class="fas fa-file-image"></i></button>
				<button type="button" class="btn btn-secondary" @click="pzZoomIn"><i class="fas fa-search-plus"></i></button>
				<button type="button" class="btn btn-secondary" @click="pzZoomReset"><i class="fas fa-sync-alt"></i></button>
			    <button type="button" class="btn btn-secondary" @click="pzZoomOut"><i class="fas fa-search-minus"></i></button>
			</div>
		</div>
		<div class="position-relative p-0 bg-white" id="unit-info-sidebar" style="box-shadow: -2px 2px 4px 0 rgba(0,0,0,.2); max-height: calc(100vh - 62px); overflow-y:auto;">
			<span id="side-bar-toggle" @click="sidebarToggle"><i class="fas fa-bars"></i></span>
			<div class="container h-100" style="overflow-y:auto;">		
				<unit-availability-sidebar v-bind:unit_construction_editable="UnitConstructionEditable" :unit_code="selected_unit_code" :key="selected_unit_code" v-if="viewerMode == 'AVAILABILITY'"></unit-availability-sidebar>
				<unit-payment-status-sidebar :unit_code="selected_unit_code" :key="selected_unit_code" v-else-if="viewerMode == 'PAYMENT'"></unit-payment-status-sidebar>
		    </div>
		</div>
	</div>
</template>
<style type="text/css" scoped>
	#viewer-box {
		border: 1px solid #d5d5d5;
	}
	#unit-info-sidebar {
		width: 0px;
		transition: width 0.5s;
	}
	#unit-info-sidebar.open {
		width: 450px;
	}

	#fitler-sidebar {
		width: 0px;
		transition: width 0.5s;
	}

	#fitler-sidebar.open {
		width: 250px;
	}

	section.filter-block {
		margin:10px;
		padding: 10px 0px;
		border-bottom: 1px solid #ccc; 
	}

	section.filter-block:last-child {
		border-bottom: none;
	}

	#side-bar-toggle {
		padding: 10px;
	    font-size: 16px;
	    line-height: 1px;
	    background: dodgerblue;
	    position: fixed;
	    color: #FFF;	
	    margin-left: -34px;	
	}	

	.legend-container {
		bottom: 1rem;
		left: 2rem;
		background-color: rgba(255,255,255, 0.8);
		border: 1px solid #CCC;
		border-radius: 6px;
		-webkit-border-radius:;
		-moz-border-radius:;
	}

	.legend-container h5 {
		font-size: 1rem;
	}

	span.active {
		text-decoration: line-through;
	}	
	.btn:focus {
    	outline: none !important;
    	box-shadow: none !important;
	}
	.btn-group-zoom-control {
		right: 1rem;
		bottom: 1rem;
	}
</style>

<script>
	import UnitAvailabilitySidebar from '../Units/UnitAvailabilitySideBarComponent';
	import UnitPaymentStatusSidebar from '../Units/UnitPaymentStatusSideBarComponent';
	import Snap from "snapsvg"; 
	import Hammer from "hammerjs";
	window.pz = require('svg-pan-zoom');

    export default {
    	components: {
    		'unit-availability-sidebar' : UnitAvailabilitySidebar,
    		'unit-payment-status-sidebar' : UnitPaymentStatusSidebar
    	},    
    	props : {
    		filePath: String, 
    		projectId: Number,
    		UnitConstructionEditable: {
    			default: false,
    			type: Boolean
    		},	
    	},   
    	data() {
		   	return {
		   		svgViewer: null, 
		   		pz: null,
		   		sidebar:null,
		   		sidebarToggleButton:null,
		   		selected_unit_code: null,
		   		units: [],
		   		unitTypes: [],
		   		availability_status: [
		   			{
		   				name: 'AVAILABLE',
		   				colorCode: '#38C172',
		   				selected: true
		   			},
		   			{
		   				name: 'UNAVAILABLE',
		   				colorCode: '#FF6347',
		   				selected: true
		   			},		   			
		   			{
		   				name: 'DEPOSIT',
		   				colorCode: '#FFA500',
		   				selected: true
		   			},
		   			{
		   				name: 'PENDING CONTRACT',
		   				colorCode: '#ffcc2e',
		   				selected: true
		   			},
		   			{
		   				name: 'CONTRACT',
		   				colorCode: '#3490dc',
		   				selected: true
		   			},
		   			{
		   				name: 'HANDOVERED',
		   				colorCode: '#4744e1',
		   				selected: true
		   			},
		   		],
		   		late_payment_status: [
		   			{
		   				code: 'PAYOFF',
		   				name: 'Pay off, Prepaid, Pay on time',
		   				colorCode: '#f7b267',
		   				selected: true
		   			},{
		   				code: 'LATE_0_3',
		   				name: 'Late Payment (1m -> 3m)',
		   				colorCode: '#f79d65',
		   				selected: true
		   			},{
		   				code: 'LATE_4_6',
		   				name: 'Late Payment (4m -> 6m)',
		   				colorCode: '#f27059',
		   				selected: true
		   			},{
		   				code: 'LATE_7_I',
		   				name: 'Late Payment (7m -> Up)',
		   				colorCode: '#f25c54',
		   				selected: true
		   			},
		   		],
		   		late_deadline_status: [
		   			{
		   				code: 'A',
		   				name: 'Not Yet Deadline (7m -> Up)',
		   				colorCode: '#01CC00',
		   				selected: true
		   			},
		   			{
		   				code: 'B',
		   				name: 'Not Yet Deadline (1m -> 6m)',
		   				colorCode: '#9FEE00',
		   				selected: true
		   			},
		   			{
		   				code: 'C',
		   				name: 'Late Deadline (0m -> 6m)',
		   				colorCode: '#FDD100',
		   				selected: true
		   			},
		   			{
		   				code: 'D',
		   				name: 'Late Deadline (7m -> 12m)',
		   				colorCode: '#FF7300',
		   				selected: true
		   			},
		   			{
		   				code: 'E',
		   				name: 'Late Deadline (13 -> Up)',
		   				colorCode: '#FE0000',
		   				selected: true
		   			},
		   			{
		   				code: 'N/A',
		   				name: 'Data Not Available',
		   				colorCode: '#CCCCCC',
		   				selected: true
		   			},
		   		],
		   		viewerMode: 'AVAILABILITY',		   	
		   		showUnitCode: false,
		   		error: false
		   	};
		},
		mounted() { 
			this.sidebar = document.getElementById('unit-info-sidebar');
			this.sidebarToggleButton =  document.getElementById('side-bar-toggle');

			axios
			.get(this.filePath)
			.then( response => { 	
				const viewer = document.getElementById('viewer-box');
				viewer.insertAdjacentHTML('afterbegin', response.data);
			})
			.then( response => {
				this.svgViewer = Snap("#viewer-box");
				this.pz = this.svgZoomEnable("#viewer-box");			
				this.svgViewer.selectAll("[data-object='ul']").forEach( obj => {
					obj.hover(
						function () {
							this.attr({
								'font-weight': 'bold',
								'text-decoration': 'underline', 
								'cursor': 'pointer'
							});
						},

						function () {
							this.attr({
								'font-weight': 'normal',
								'text-decoration': '', 
							});
						}
					);							
					obj.click( this.onUnitLabelClicked );
				});				
			})
			.then( response => {
				this.getUnitTypes();
				this.getUnitsAvailability();
			});			
  		},
		methods:{
			svgZoomEnable: function (obj) {
				return pz(obj, {
					zoomEnabled: true,
					controlIconsEnabled: false,
					fit: true,
					center: true,
					zoomScaleSensitivity: 0.5,
					dblClickZoomEnabled: false,
					customEventsHandler: {
		    			// Halt all touch events
		    			haltEventListeners: ['touchstart', 'touchend', 'touchmove', 'touchleave', 'touchcancel']
		    			// Init custom events handler
		    			, init: function(options) {
		    				var instance = options.instance
		    				, initialScale = 1
		    				, pannedX = 0
		    				, pannedY = 0

				            // Init Hammer
				            // Listen only for pointer and touch events
				            this.hammer = Hammer(options.svgElement, {
				            	inputClass: Hammer.SUPPORT_POINTER_EVENTS ? Hammer.PointerEventInput : Hammer.TouchInput
				            })

				            // Enable pinch
				            this.hammer.get('pinch').set({enable: true})

				            // Handle double tap
				            this.hammer.on('doubletap', function(ev){
				            	instance.zoomIn()
				            })

				            // Handle pan
				            this.hammer.on('panstart panmove', function(ev){
					            // On pan start reset panned variables
					            if (ev.type === 'panstart') {
					              	pannedX = 0
					              	pannedY = 0
					            }

					            // Pan only the difference
					            instance.panBy({x: ev.deltaX - pannedX, y: ev.deltaY - pannedY})
					            pannedX = ev.deltaX
				              	pannedY = ev.deltaY
				          	})

				            // Handle pinch
				            this.hammer.on('pinchstart pinchmove', function(ev){
					            // On pinch start remember initial zoom
					            if (ev.type === 'pinchstart') {
					              	initialScale = instance.getZoom()
					              	instance.zoomAtPoint(initialScale * ev.scale, {x: ev.center.x, y: ev.center.y})
					            }

					            instance.zoomAtPoint(initialScale * ev.scale, {x: ev.center.x, y: ev.center.y})
					        })

				            // Prevent moving the page on some devices when panning over SVG
				            options.svgElement.addEventListener('touchmove', function(e){ e.preventDefault(); });
				        }
				        , destroy: function(){
				        	this.hammer.destroy()
				    	}
		    		}
				});
			},
			getUnitTypes: function () {
				axios.get('unit_types')
				.then( (r) => { 
					r.data.forEach( obj => {
						obj.selected = true;
						this.unitTypes.push(obj);
					})				
				})				
				.catch( (e) => { console.log(e) } ); 
			},
			getUnitsAvailability: function (arg) {
				axios.get(`getUnitsForMasterPlan`, { params : arg})
				.then( (response) => { this.units = response.data; })
				.then( (response) => { this.getFilteredUnits(); })
				.catch( (e) => {
					console.log(e);
				});
			},
			getUnitHandovers: function (arg) {
				axios.get(`unit_handovers`, { params : arg})
				.then( (response) => { this.units = response.data })
				.then( (response) => { this.getFilteredUnits(); })
				.catch( (e) => {
					console.log(e);
				});
			},
			getFilteredUnits: function () {				
				this.filteredUnits = this.units;	
				// Fill All unit boundary as white				
				this.svgViewer.selectAll('[data-object="ub"]').forEach( obj => {
					obj.attr("style", `fill:#FFF`);
				});

				this.unitTypes.forEach( unitType => {
					if ( unitType.selected == false ) {						
						this.filteredUnits = this.filteredUnits.filter( 
							unit => { 
								return unit.unit_type_id != unitType.id 
							} 
						)
					}
				});
				
				if ( this.viewerMode == "AVAILABILITY" ) {					
					this.availability_status.forEach( obj => {
						if ( obj.selected == false ) { 
							this.filteredUnits = this.filteredUnits.filter( 
								unit => { 
									return unit.availability_status != obj.name 
								} 
							) 
						}
					});
				}

				if ( this.viewerMode == "PAYMENT" ) {
					this.late_payment_status.forEach( obj => {
						if ( obj.selected == false ) { 
							this.filteredUnits = this.filteredUnits.filter( 
								unit => { 
									return unit.unit_handover.late_payment_code != obj.code
								}
							) 
						}
					});

					this.late_deadline_status.forEach( obj => {
						if ( obj.selected == false ) { 
							this.filteredUnits = this.filteredUnits.filter( 
								unit => { 
									return unit.unit_handover.late_deadline_code != obj.code
								}
							) 
						}
					});
				}

				if ( this.viewerMode == "AVAILABILITY" ) {				
					this.filteredUnits.forEach( unit => {
						let obj = this.svgViewer.select(`[data-object="ub"][data-id="${unit.code}"`);
						if ( obj != undefined ) {
							obj.attr("style", `fill:${unit.availability_status_color_code}`);
						}
					});				
				} else if ( this.viewerMode == "PAYMENT" ) {
					this.filteredUnits.forEach( unit => {
						let obj = this.svgViewer.select(`[data-object="ub"][data-id="${unit.code}"`);
						if ( obj != undefined ) {
							obj.attr("style", `fill:${unit.unit_handover.late_payment_color_code}`);
						}
					});
				}				
			},
			onAvailabilityStatusSelectionChanged: function (status) {
				let obj = this.availability_status.find( obj  => obj.name == status );
				obj.selected = !obj.selected;
				this.getFilteredUnits();
			},
			onLatePaymentStatusSelectionChanged: function (code) {
				let obj = this.late_payment_status.find( obj  => obj.code == code );
				obj.selected = !obj.selected;
				this.getFilteredUnits();
			},
			onLateDeadlineStatusSelectionChanged: function (code) {
				let obj = this.late_deadline_status.find( obj  => obj.code == code );
				obj.selected = !obj.selected;
				this.getFilteredUnits();
			},			
			onUnitTypeSelectionChanged: function (unitType) {
				let obj = this.unitTypes.find( obj => obj.id == unitType.id );
				obj.selected = !obj.selected;
				this.getFilteredUnits();				
			},
			getUnitBoundaryByCode: function (c) {
				return this.svgViewer.select(`[data-object="ub"][data-id="${c}"]`);
			},
			onViewerTypeChanged: function (event) {
				this.setUnitBoundaryBackground(this.units, '#FFF')
				this.selected_unit_code = null;

				if ( this.viewerMode == 'AVAILABILITY' ) {
					this.getUnitsAvailability();
					this.showUnitCode = true;
					this.toggleUnitLabel();				
				} else if ( this.viewerMode == 'PAYMENT' ) {
					this.getUnitHandovers();
				}
				else {
					this.setUnitBoundaryBackground(this.units, 'black');
				}
			},
			toggleUnitLabel: function() {	
				this.showUnitCode = !this.showUnitCode;
				this.units.forEach( unit  => {  
					let unitLabel = this.svgViewer.select(`[data-object="ul"][data-id="${unit.code}"]`);
					if ( unitLabel != undefined ) {
						if ( this.showUnitCode ) {
							unitLabel.attr('text', unit.unit_handover.late_deadline_code);
						} else {
							unitLabel.attr('text', unitLabel.attr('data-id'));
						}
					}
				});
			},
			setUnitBoundaryBackground: function(arr, c) {
				arr.forEach( i => {
					let ele = this.svgViewer.select(`[data-object="ub"][data-id="${i.code}"]`)
					if ( ele != null ) {
  						ele.attr('style', `fill:${c}`);
  					}
		   		})
			},			
			onUnitLabelClicked: function(event) {
				if ( event.target.dataset.id != undefined ) {
					this.selected_unit_code = event.target.dataset.id;
					this.sidebar.classList.add("open");
				}
			},
			toggleAllUnitTypeSelection: function (state) {				
				this.unitTypes.filter( obj => obj.selected = state );
				this.getFilteredUnits();
			},
			toggleAllAvailabilityStatusSelection: function (state) {
				this.availability_status.filter( obj => obj.selected = state );
				this.getFilteredUnits();
			},
			toggleAllLatePaymentStatusSelection: function (state) {
				this.late_payment_status.filter( obj => obj.selected = state );
				this.getFilteredUnits();
			},
			toggleAllLateDeadlineStatusSelection: function (state) {
				this.late_deadline_status.filter( obj => obj.selected = state );
				this.getFilteredUnits();
			},
			sidebarToggle: function(e) {				
				this.sidebar.classList.toggle("open");
			},		
			pzZoomReset: function (e) {
				this.pz.reset();
			},
			pzZoomIn: function (e) {
				this.pz.zoomIn();
			},
			pzZoomOut: function (e) {
				this.pz.zoomOut();
			},
			saveToImage: function(e) {
				const svg = this.svgViewer.select('svg');
				
				// use to enlarge image pixel from original;
				// we need to keep the englarge image pixel not exceed 12,000 px in width
				// because some browser not allow
				var multiplier = 12;
				do {
				 	multiplier = multiplier -1;
				}
				while ( (svg.getBBox().width * multiplier) > 12000 );

				// set the svg to absolute size for image generation;
				svg.attr('width', svg.getBBox().width * multiplier);
				svg.attr('height', svg.getBBox().height * multiplier);

				// initize image from svg;
				const image = new Image();
				image.src = svg.toDataURL('image/jpeg');	
				image.width = svg.attr('width');
				image.height = svg.attr('height');

				// remove the absolute size from svg;
				// so that the svg viewport remain the same functionality;
				svg.attr('width', "");
				svg.attr('height', "");

				// write the image to the canvas;
				// convert the svg image to jpeg;
				// download the image with anchor tag;
				image.onload = () => {					
					const canvas = document.createElement('canvas');
					canvas.width = image.width;
					canvas.height = image.height;
					var ctx = canvas.getContext('2d');
					ctx.rect(0,0,image.width,image.height);
					ctx.fillStyle = "white";	
					ctx.fill();				
					ctx.drawImage(image, 0, 0);
					var a = document.createElement("a");
					a.href = canvas.toDataURL('image/jpeg');
					a.download = 'masterplan.jpg';
					a.click();
				}
				this.pz.reset();
			}
		}
    };
</script>
