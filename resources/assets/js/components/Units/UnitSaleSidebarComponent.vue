<template> 
    <div class="row" v-if="unit != null">
        <div class="col-sm-12 px-0">
            <div id="imageCarousel" class="carousel slide" style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                <div class="carousel-inner" v-if="unit.unit_type.media != undefined">
                    <div class="carousel-item" v-bind:class="[ key == 0 ? 'active' : '']" v-for="(obj, key) in unit.unit_type.media">
                        <img class="d-block w-100" :src="obj.url">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="d-flex p-3 justify-content-between w-100">
            <div class="w-100">
                <h4 class="mb-0">{{ unit.code }}</h4>
                <a href="#">{{ unit.unit_type.name }}</a> | <a href="#" class="d-inline-block">{{ unit.unit_type.project.name_en }}</a>
                <div v-html="unit.action.status_html"></div>
            </div>
            <div class="align-self-end align-self-md-start text-right" style="min-width: 150px">
                <span>Price ($)</span>
                <h4 class="font-weight-bold">{{ unit.price | toCurrencyUSD }}</h4>
            </div>            
        </div>
        <div class="col-sm-12">
            <h6 class="bg-secondary p-2 text-white">Property Detail:</h6>
            <ul class="border-buttom-list">                  
                <li v-for="obj in propertyFeatures">
                    <span><span class="icon"><i v-bind:class="obj.icon"></i></span> {{ obj.title }}:</span>
                    <span>{{ obj.value }}</span>
                </li>      
            </ul>
        </div>
    </div>
    <div class="row h-100" v-else>
        <div class="col-12 d-flex flex-column justify-content-center">
            <h4 class="text-center mt-4">No unit was selected.</h4>
            <p class="text-center text-muted">Please select any unit in the masterplan on the left side to display the unit information.</p>
        </div>
    </div>    
</template>

<style scoped>
.border-buttom-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.border-buttom-list li {
    display: flex;
    color: #7a7a7a;
    margin-bottom: 8px;
    padding-bottom: 8px;
    justify-content: space-between;
    border-bottom: 1px solid #e2e2e2;
}

.border-buttom-list li:last-child {
    border-bottom: 0px;
}

.border-buttom-list li span.icon {
    min-width: 20px;
    display: inline-block;
    margin-right: 8px;
    color: #179bee;
}
</style>

<script>
    // import UnitConstructionProgress from '../Units/UnitConstructionProgressComponent';
    // import UnitCommentList from '../Units/UnitCommentListComponent';

    export default {
        components: {
            // 'unit-comment-list': UnitCommentList,
            // 'unit-construction-progress': UnitConstructionProgress,
        },
        props: {
            unit_code: null,           
        },
        data () {
            return {
                unit: null,
                error: null,
             
            };
        },
        mounted() {
            if ( this.unit_code != null ) {
               this.getUnit();  
            }
        },
        methods: {
            getUnit: function () {
                axios.get(`/admin/units/${this.unit_code}/code?embed=action,action.createdBy,unitType,unitType.media,unitType.project`)
                .then( response => { this.unit = response.data; })
                .catch( error => {
                    this.error = error.response;
                });
            },
        },
        computed: {         
            propertyFeatures: function () {
                let r = [];
                if ( this.unit.hasOwnProperty('bedroom') && this.unit.bedroom > 0 ) {
                    r.push({ title: 'Bedroom', value: this.unit.bedroom, icon: "fa fa-bed" });
                }
                if ( this.unit.hasOwnProperty('bathroom') && this.unit.bathroom > 0 ) {
                    r.push({ title: 'Bathroom', value: this.unit.bathroom, icon: "fas fa-bath" });
                }
                if ( this.unit.hasOwnProperty('living_room') && this.unit.living_room > 0 ) {
                    r.push({ title: 'Living Room', value: this.unit.living_room, icon: "fas fa-tv"  });
                }
                if ( this.unit.hasOwnProperty('kitchen') && this.unit.kitchen > 0 ) {
                    r.push({ title: 'Kitchen', value: this.unit.kitchen, icon: "fas fa-utensils"  });
                }
                if ( this.unit.hasOwnProperty('swimming_pool') && this.unit.swimming_pool > 0 ) {
                    r.push({ title: 'Swimming Pool', value: this.unit.swimming_pool, icon: "fas fa-swimmer"  });
                }
                if ( this.unit.hasOwnProperty('building_area') && this.unit.building_area > 0 ) {
                    if ( this.unit.building_size_width > 0 && this.unit.building_size_length > 0 ) {
                        r.push({ title: 'Building Area', value: `${this.unit.building_size_width} x ${this.unit.building_size_length}`, icon: "fas fa-home"  });
                    } else {
                        r.push({ title: 'Building Area', value: this.unit.building_area, icon: "fas fa-home"  });
                    }                    
                }
                if ( this.unit.hasOwnProperty('land_area') && this.unit.land_area > 0 ) {
                    if ( this.unit.land_size_width > 0 && this.unit.land_size_length > 0 ) {
                       r.push({ title: 'Land Area', value: `${this.unit.land_size_width} x ${this.unit.land_size_length}`, icon: "fa fa-map" });
                    } else {
                       r.push({ title: 'Land Area', value: this.unit.land_area, icon: "fa fa-map" });
                    }
                }
                return r;
            }
        }
    };
</script>