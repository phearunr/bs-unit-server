<template>	
	<div class="d-flex justify-content-center" style="min-height: calc(100vh - 64px); border-top: 1px solid #CCC; border-top: 1px solid #CCC;">	
		<div class="flex-grow-1 p-0 bg-white position-relative">
			<div class="h-100 d-flex flex-column">				
				<svg id="viewer-box" class="flex-grow-1"></svg>
				<button class="btn btn-primary btn-sm position-absolute label-toggle-button btn-no-click" @click="toggleUnitLabel">{{ buttonText }}</button>
				<div class="btn-group-vertical position-absolute btn-group-sm btn-group-zoom-control">
					<button type="button" class="btn btn-secondary btn-no-click" @click="pzZoomIn"><i class="fas fa-search-plus"></i></button>
					<button type="button" class="btn btn-secondary btn-no-click" @click="pzZoomReset"><i class="fas fa-sync-alt"></i></button>
				    <button type="button" class="btn btn-secondary btn-no-click" @click="pzZoomOut"><i class="fas fa-search-minus"></i></button>
				</div>
				<div class="row position-absolute legend-container">
		        	<div class="col-lg-12 mt-3">
			        	<h5>Payment Type</h5>
			        	<ul class="list-unstyled">
			        		<li><i class="fas fa-square" style="color: #e9c46a;"></i> Pay off, Prepaid, Pay on time</li>
			        		<li><i class="fas fa-square" style="color: #264653"></i> Late Payment (1m -> 3m)</li>
			        		<li><i class="fas fa-square" style="color: #2a9d8f"></i> Late Payment (4m -> 6m)</li>
			        		<li><i class="fas fa-square" style="color: #f4a261"></i> Late Payment (7m -> Up)</li>
			        		<li><i class="fas fa-square" style="color: #ccc"></i> N/A (Data Unavailable)</li>
			        	</ul>
			        	<h5>Deadline Type</h5>
			        	<ul class="list-unstyled">
			        		<li><span class="text-danger">(A)</span> Not Yet Deadline (7m -> Up)</li>
			        		<li><span class="text-danger">(B)</span> Not Yet Deadline (1m -> 6m)</li>
			        		<li><span class="text-danger">(C)</span> Late Deadline (0m -> 6m)</li>
			        		<li><span class="text-danger">(D)</span> Late Deadline (7m -> 12m)</li>
			        		<li><span class="text-danger">(E)</span> Late Deadline (13m -> Up)</li>
			        		<li><span class="text-danger">(N/A)</span> Data Unavailable</li>
			        	</ul>
			        </div>
			    </div>
			</div>
		</div>
		<div class="p-0 bg-white position-relative open" id="unit-info-sidebar" style="box-shadow: -2px 2px 4px 0 rgba(0,0,0,.2); max-height: calc(100vh - 64px); overflow-y:auto;">
			<span id="side-bar-toggle" @click="sidebarToggle"><i class="fas fa-bars"></i></span>
			<div class="unit-handover-container bg-light">
				<div class="unit-handover-info-container bg-white px-4">
					<h5 class="pt-4 px-4 text-center">Unit Information:</h5>
					<table class="table table-sm table-bordered">
						<tbody>
							<tr>
								<th scope="row" class="bg-light" width="180px">Unit Code</th>
								<td class="text-right">{{ selectedUnitCode }}</td>
							</tr>
							<tr>
								<th scope="row" class="bg-light" width="180px">Customer Name</th>
								<td class="text-right" v-if="unit">{{ unit.customer_name  }}</td>
								<td class="text-right" v-else>N/A</td>
							</tr>
							<tr>
								<th scope="row" class="bg-light">Net Selling</th>
								<td class="text-right" v-if="unit">{{ unit.net_selling_price | toCurrencyUSD  }}</td>
								<td class="text-right" v-else>N/A</td>							
							</tr>
							<tr>
								<th scope="row" class="bg-light">Total Payment</th>
								<td class="text-right" v-if="unit">{{ unit.total_payment | toCurrencyUSD  }}</td>
								<td class="text-right" v-else>N/A</td>							
							</tr>
							<tr>
								<th scope="row" class="bg-light">Ending Balance</th>
								<td class="text-right" v-if="unit">{{ unit.ending_balance | toCurrencyUSD }}</td>
								<td class="text-right" v-else>N/A</td>							
							</tr>
							
							<tr>
								<th scope="row" class="bg-light">Last Posting Date</th>
								<td class="text-right" v-if="unit">{{ unit.last_posting_date | formatDate }}</td>
								<td class="text-right" v-else>N/A</td>
							</tr>
							<tr>
								<th scope="row" class="bg-light">Last Payment Date</th>
								<td class="text-right" v-if="unit">{{ unit.last_payment_date | formatDate }}</td>
								<td class="text-right" v-else>N/A</td>
							</tr>
							<tr>
								<th scope="row" class="bg-light">Late Payment Month</th>
								<td class="text-right" v-if="unit">{{ unit.late_payment_month }}</td>
								<td class="text-right" v-else>N/A</td>
							</tr>
							<tr>
								<th scope="row" class="bg-light">Contract Signed Date</th>
								<td class="text-right" v-if="unit">{{ unit.contract_signed_date | formatDate }}</td>
								<td class="text-right" v-else>N/A</td>
							</tr>
							<tr>
								<th scope="row" class="bg-light">Contract Deadline Date</th>
								<td class="text-right" v-if="unit">{{ unit.contract_deadline_date | formatDate }}</td>
								<td class="text-right" v-else>N/A</td>
							</tr>
							<tr>
								<th scope="row" class="bg-light">Late Deadline Month</th>
								<td class="text-right" v-if="unit">{{ unit.late_deadline_month  }}</td>
								<td class="text-right" v-else>N/A</td>
							</tr>
						</tbody>
					</table>
				</div>	
			</div>
			<div class="unit-construction-progress-container bg-light p-4">
				<h5 class="text-center">Construction Progress:</h5>
           		<unit-construction-progress :unit-id="unitId" :key="unitId"></unit-construction-progress>
	        </div>
	        <h5 class="pt-4 px-4 mb-0 text-center">Comment List:</h5>
	        <unit-comment-list :unit-id="unitId" :key="unitId"></unit-comment-list>
		</div>
	</div>
</template>
<style type="text/css" scoped>
	#unit-info-sidebar {
		width: 0px;
		transition: width 0.5s;
	}
	#unit-info-sidebar.open {
		width: 450px;
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
		bottom: 3rem;
		left: 2rem;
		background-color: rgba(0,0,0,0.1);
		border-radius: 6px;
		-webkit-border-radius:;
		-moz-border-radius:;
	}

	.legend-container {
		font-size: 0.75rem;
	}

	.legend-container h5 {
		font-size: 1rem;
	}

	.label-toggle-button {
		left: 1rem;
		bottom: 1rem;
	}

	.btn-no-click:focus {
    	outline: none !important;
    	box-shadow: none !important;
	}

	.btn-group-zoom-control {
		right: 1rem;
		bottom: 1rem;
	}
</style>

<script>
	import UnitConstructionProgress from '../Units/UnitConstructionProgressComponent';
	import UnitCommentList from '../Units/UnitCommentListComponent';
	import Snap from "snapsvg"; 
	import Hammer from "hammerjs";
	
	window.pz = require('svg-pan-zoom');

    export default {
    	components: {    		
    		'unit-comment-list': UnitCommentList,    
        	'unit-construction-progress': UnitConstructionProgress,
    	},
    	props : {
    		filePath: String, 
    		projectId: Number
    	},
    	data() {
		   	return {
		   		a: null, 
		   		pz: null,
		   		sidebar:null,
		   		sidebarToggleButton:null,
		   		units: [],
		   		unit: null,
		   		selectedUnitCode:null,
		   		error: false,
		   		buttonText: "Show Deadline",
		   		showDeadline: false,
		   		unitId: null,
		   	};
		},
		mounted() { 
			this.a = Snap("#viewer-box");
  			this.renderExternalSvg(this.filePath);
  			this.getUnitHandovers();
			this.sidebar = document.getElementById('unit-info-sidebar');
			this.sidebarToggleButton =  document.getElementById('side-bar-toggle');
  		},
		methods:{
			renderExternalSvg: function(url) {
				Snap.load(url, function (f) {				
					f.selectAll("[data-object='ul']").forEach( e => {
						e.hover(
							function () {
								this.attr({
									'font-weight': 'bold',
									'text-decoration': 'underline', 
									'cursor': 'pointer'
								});
							},

							function () {
								this.attr({
									'font-weight' : 'normal',
									'text-decoration' : '', 
								});
							}
						);
						e.click( this.onUnitLabelClicked );
					});					
					this.a.append(f);
					this.pz = this.svgZoomEnable("#viewer-box");								
				}, this);
			},
			svgZoomEnable: function (o) {
				return pz(o, {
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
			getUnitHandovers: function (arg) {
				axios.get(`unit_handovers`, { params : arg})
				.then( (r) => {	this.units = r.data })
				.then( (r) => {
					this.a.selectAll("[data-object='ub']").forEach( e => {
						e.attr('style', "fill:white;")
					});

					this.units.forEach( i => {  
						let obj = this.a.select(`[data-object="ub"][data-id="${i.unit.code}"]`);						
						if ( obj != undefined ) {
							obj.attr("style", `fill:${i.late_payment_color_code}`);
						}
					});
				})
				.catch( (e) => {
					console.log(e);
				});
			},			
			getUnitBoundaryByCode: function (c) {
				return this.a.select(`[data-object="ub"][data-id="${c}"]`);
			},
			setUnitBoundaryBackground: function(arr, c) {
				arr.forEach( i => {
					let ele = this.a.select(`[data-object="ub"][data-id="${i.code}"]`)
					if ( ele != null ) {
  						ele.attr('style', `fill:${c}`);
  					}
		   		})
			},	
			onUnitLabelClicked: function(e) {
				if ( e.target.dataset.id != undefined ) {
					this.selectedUnitCode = e.target.dataset.id;
					const units = this.units.filter( unit => {  return unit.unit.code == this.selectedUnitCode ; });
					if ( units.length > 0 ) {
						this.unit = units[0];
					} else {
						this.unit = null;
					}	

					axios.get(`/admin/units/${e.target.dataset.id}`)
					.then( response => { this.unitId = response.data.id; this.sidebar.classList.add("open"); })
					.catch( error => {
						this.unitId = null;
					});
				}
			},
			toggleUnitLabel: function(e) {
				this.showDeadline = !this.showDeadline;
				this.units.forEach( i => {  
					let l = this.a.select(`[data-object="ul"][data-id="${i.unit.code}"]`);
					if ( l != undefined ) {
						if ( this.showDeadline ) {
							l.attr('text', i.late_deadline_label);
						} else {
							l.attr('text', l.attr('data-id'));
						}
					}
				});
				this.showDeadline ? this.buttonText = "Show Unit Code" : this.buttonText = "Show Deadline";
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
			}
		}
    };
</script>
