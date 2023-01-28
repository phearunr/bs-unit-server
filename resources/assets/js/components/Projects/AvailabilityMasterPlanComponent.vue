<template>	
	<div class="d-flex justify-content-center" style="min-height: calc(100vh - 62px);">
		<div class="flex-grow-1 position-relative p-0 bg-white">
			<div class="btn-group-vertical position-absolute btn-group-sm btn-group-zoom-control">
				<button type="button" class="btn btn-secondary btn-no-click" @click="pzZoomIn"><i class="fas fa-search-plus"></i></button>
				<button type="button" class="btn btn-secondary btn-no-click" @click="pzZoomReset"><i class="fas fa-sync-alt"></i></button>
			    <button type="button" class="btn btn-secondary btn-no-click" @click="pzZoomOut"><i class="fas fa-search-minus"></i></button>
			</div>
			<div class="h-100 d-flex flex-column">
				<div class="bg-light p-2" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-bottom: 1px solid rgba(0,0,0,.125); min-height: 45px;">
					<ul class="list-inline mb-0 text-center unit-type-container">
					  	<li v-for="(obj, k) in unitTypes" :key="k" class="list-inline-item">
					  		<button type="button" class="btn btn-secondary btn-sm" v-on:click="onUnitTypeSelectionChanged(obj.id)">
					  			<span v-bind:class="{ active: !obj.selected }">{{ obj.name }}</span>
					  		</button>
						</li>
					</ul>
				</div>
				<svg id="viewer-box" class="flex-grow-1"></svg>				
				<div class="bg-light p-2" style="box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1); border-bottom: 1px solid rgba(0,0,0,.125);">
					<ul class="list-inline mb-0 text-center">
					  	<li  v-for="(obj, k) in unitStatus" :key="k" class="list-inline-item">
					  		<button type="button" class="btn btn-sm" v-on:click="onStatusButtonClick(obj.status)" v-bind:style="{ color: '#fff', backgroundColor: obj.bgColor, borderColor: obj.bgColor }">
  								<span v-bind:class="{ active: !obj.selected }">{{ obj.status }}</span>
							</button>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="position-relative p-0 bg-white open" id="unit-info-sidebar" style="box-shadow: -2px 2px 4px 0 rgba(0,0,0,.2); max-height: calc(100vh - 62px); overflow-y:auto;">
			<span id="side-bar-toggle" @click="sidebarToggle"><i class="fas fa-bars"></i></span>
			<div class="h-100" >
		        <div class="col-12 d-flex flex-column justify-content-center" v-if="unit == null">
		            <h2 class="text-center mt-4">No unit was selected.</h2>
		            <p class="text-center text-muted">Please select any unit in the masterplan on the left side to display the unit information.</p>
		        </div>
		        <div class="col-12 d-flex flex-column justify-content-center" v-else-if="unit.hasOwnProperty('status') && unit['status'] != '200'">
		            <h2 class="text-center  mt-4">The selected unit is not exist.</h2>
		            <p class="text-center text-muted">Please contact unit controller or system administrator if you are sure that the selected unit is available for sale.</p>
		        </div>
		        <div class="container" v-else>
		        	<unit-availability-sidebar :unit="unit"></unit-availability-sidebar>
		        </div>
		        
		    </div>
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
	span.active {
		text-decoration: line-through;
	}
	.unit-type-container {
		display: flex;
		align-items: center;
  		justify-content: center;
		overflow: auto;
		white-space: nowrap;
	}
	.unit-type-container::-webkit-scrollbar { display: none; }
	.unit-type-container button {
		min-width: 80px;
	}
	.btn-no-click:focus {
    	outline: none !important;
    	box-shadow: none !important;
	}

	.btn-group-zoom-control {
		right: 1rem;
		bottom: 3.5rem;
	}
</style>

<script>
	import UnitAvailabilitySidebar from '../Units/UnitAvailabilitySideBarComponent';
	import Snap from "snapsvg"; 
	import Hammer from "hammerjs";
	window.pz = require('svg-pan-zoom');

    export default {
    	components: {
    		'unit-availability-sidebar' : UnitAvailabilitySidebar,
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
		   		unit: null, 
		   		units: [],
		   		filteredUnits: [],
		   		unitTypes:[],	   		
		   		unitStatus: [
		   			{status: "AVAILABLE", bgColor: '#38c172', selected: true},
		   			{status: "UNAVAILABLE", bgColor: '#FF6347', selected: true},
		   			{status: "HOLD", bgColor: '#6c757d', selected: true},
		   			{status: "DEPOSIT", bgColor: '#ffa500', selected: true},
		   			{status: "CONTRACT", bgColor: '#3490dc', selected: true},
		   		],
		   		error: false
		   	};
		},
		mounted() { 
			this.a = Snap("#viewer-box");
			this.getUnitTypes();
  			this.renderExternalSvg(this.filePath);  
  			this.getUnits();	
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
									'font-weight': 'normal',
									'text-decoration': '', 
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
			getUnits: function (arg) {
				axios.get(`units`, { params : arg})
				.then( (r) => {	this.units = r.data })
				.then( (r) => {
					this.a.selectAll("[data-object='ub']").forEach( e => {
						e.attr('style', "fill:white;")
					});

					// I think it is kid's code but to improve performance I will write like this
					let bgColors = new Object();
					this.unitStatus.forEach( o => { bgColors[o.status] = o.bgColor });

					this.units.forEach( i => {  
						let obj = this.a.select(`[data-object="ub"][data-id="${i.code}"`);
						if ( obj != undefined ) {
							obj.attr("style", `fill:${bgColors[i.availability_status]}`);
						}
					});
				})
				.catch( (e) => {
					console.log(e);
				});
			},
			getFilteredUnits: function () {
				this.filteredUnits = this.units;
				this.setUnitBoundaryBackground(this.filteredUnits, '#FFF');

				this.unitStatus.forEach( obj => {
					if ( obj.selected == false ) { 
						this.filteredUnits = this.filteredUnits.filter( u => { return u.availability_status != obj.status }) 
					}
				});

				this.unitTypes.forEach( obj => {
					if ( obj.selected == false ) {						
						this.filteredUnits = this.filteredUnits.filter( u => { return u.unit_type_id != obj.id })
					}
				});

				// I think is kid's code but to improve performance I will write like this
				let bgColors = new Object();
				this.unitStatus.forEach( o => { bgColors[o.status] = o.bgColor });

				this.filteredUnits.forEach( i => {
					let obj = this.a.select(`[data-object="ub"][data-id="${i.code}"`);
					if ( obj != undefined ) {
						obj.attr("style", `fill:${bgColors[i.availability_status]}`);
					}
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
			onStatusButtonClick: function(s) {
				let selectedUnitStatuses = this.unitStatus.filter( o => o.selected );
				let selectedUnitStatus = this.unitStatus.find( o => o.status == s );
				if ( selectedUnitStatuses.length == this.unitStatus.length ) {
					this.unitStatus.forEach( o => { o.selected = false } );	
					selectedUnitStatus.selected = true;
				} else {
					if ( selectedUnitStatus.selected ) {
						this.unitStatus.forEach( o => { o.selected = true } );
					} else {
						this.unitStatus.forEach( o => { o.selected = false } );
						selectedUnitStatus.selected = true;
					}
					// this.unitStatus.forEach( o => { o.selected = true } );	
				}

				this.getFilteredUnits();
			},
			onUnitLabelClicked: function(event) {
				if ( event.target.dataset.id != undefined ) {
					axios.get(`/admin/units/${event.target.dataset.id}?embed=action,action.createdBy,unitType,unitType.media,unitType.project`)
					.then( response => { this.unit = response.data; this.sidebar.classList.add("open"); })
					.catch( error => {
						this.unit = error.response;
					});
				}
			},
			onUnitTypeSelectionChanged: function (s) {
				let o = this.unitTypes.find( o => o.id == s );
				o.selected = !o.selected;
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
			}
		}
    };
</script>
