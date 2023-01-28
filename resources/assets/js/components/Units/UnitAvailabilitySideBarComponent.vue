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
            <h6 class="bg-secondary p-2 text-white" @click="toggleUnitFeatureSection()">Property Detail: <i :class="[showUnitFeatureSection ? 'fa-chevron-up' : 'fa-chevron-down', 'fa float-right']"></i></h6>
            <ul class="border-buttom-list" v-if="showUnitFeatureSection">                  
                <li v-for="obj in propertyFeatures">
                    <span><span class="icon"><i v-bind:class="obj.icon"></i></span> {{ obj.title }}:</span>
                    <span>{{ obj.value }}</span>
                </li>
            </ul>
        </div>
        <div class="col-sm-12">
            <h6 class="bg-secondary p-2 text-white" @click="toggleUnitConstructionProgressSection()">Construction Progression: <i :class="[showConstructionProgressSection ? 'fa-chevron-up' : 'fa-chevron-down', 'fa float-right']"></i>
            </h6>         
            <unit-construction-procedure-list v-if="showConstructionProgressSection" :unit-id="unit.id" v-bind:editable="unit_construction_editable" :key="unit.id"></unit-construction-procedure-list>
        </div> 
        <div class="col-sm-12">
            <h6 class="bg-secondary p-2 text-white" @click="toggleCommentSection()">Comments: <i @click="toggleCommentSection()" :class="[showCommentSection ? 'fa-chevron-up' : 'fa-chevron-down', 'fa float-right']"></i>
            </h6>
            <unit-comment-list v-if="showCommentSection" :unit-id="unit.id" :key="unit.id"></unit-comment-list>
        </div>
        <div class="col-sm-12">
            <h6 class="bg-secondary p-2 text-white" @click="toggleEngineerSection()">Engineers Info: <i :class="[showEngineerSection ? 'fa-chevron-up' : 'fa-chevron-down', 'fa float-right']"></i>
            </h6>
            <div v-if="showEngineerSection">
                <div v-if="siteEngineers.length == 0" class="alert alert-danger" role="alert">
                    This unit is not under managed by any site engineer.
                </div>             
                <div v-else class="site-engineer-wrapper">
                    <div v-for="user in siteEngineers" class="d-flex bg-light my-2 p-2">
                        <img class="rounded-circle" :src="user.avatar_url" height="50px" width="50px">  
                        <div class="flex-grow-1 px-2">
                            <p class="font-weight-bold mb-0">{{ user.name }}</p>                          
                            <ul class="list-unstyled my-0">
                                <li class="text-muted"><i class="fas fa-phone-square mr-1"></i>{{ user.phone_number | formatPhoneNumber }}</li>
                                <li class="text-muted"><i class="fas fa-tag"></i>
                                    <span v-if="user.position != ''">{{ user.position }}</span>
                                    <span v-else>N/A</span>
                                </li>
                                <li class="text-muted">
                                    <i class="far fa-calendar-alt"></i> {{ user.created_at | formatDate }}
                                </li>

                            </ul> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <h6 class="bg-secondary p-2 text-white" @click="toggleshowSubConstructorSection()">Sub Constructors Info: <i :class="[showSubConstructorSection ? 'fa-chevron-up' : 'fa-chevron-down', 'fa float-right']"></i>
            </h6> 
            <div v-if="showSubConstructorSection">
                <div v-if="subConstructors.length == 0" class="alert alert-danger" role="alert">
                    This unit is not under managed by any sub constructor.
                </div>
                <div class="d-flex bg-light p-2 mb-2 border shadow-sm" v-for="subConstructor in subConstructors">
                    <div class="user-avatar-container">
                        <img :src="subConstructor.avatar_url" class="user-avatar-50 rounded-circle">
                    </div>
                    <div class="flex-grow pl-3">
                        <p class="mb-0 font-weight-bold">{{ subConstructor.name }}</p>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="p-0">
                                    <small class="text-muted">Workers:</small>
                                </td>
                                <td class="py-0">
                                    <small>{{ subConstructor.worker | number('0,0') }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0">
                                    <small class="text-muted">Join Date:</small>
                                </td>
                                <td class="py-0">
                                    <small>{{ subConstructor.join_date | formatDate }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0">
                                    <small class="text-muted">Contact:</small>
                                </td>
                                <td class="py-0">
                                    <ul class="mb-0" v-if="subConstructor.contacts.length > 0">
                                        <li v-for="contact in subConstructor.contacts"><small>{{ contact.value }}</small>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0">
                                   <small class="text-muted">Skills:</small>
                                </td>
                                <td class="py-0">
                                    <ul class="mb-0" v-if="subConstructor.skills.length > 0">
                                        <li v-for="skill in subConstructor.skills"><small>{{ skill.name_km }} ({{ skill.name }})</small></li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <h6 class="bg-secondary p-2 text-white" @click="toggleMaterialOrderSection()">Material Orders Info: <i :class="[showMaterialOrderSection ? 'fa-chevron-up' : 'fa-chevron-down', 'fa float-right']"></i>
            </h6>
            <div v-if="showMaterialOrderSection">Opp! This functionality is under construction.</div>
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
    import UnitConstructionProcedureList from '../UnitConstructionProcedures/UnitConstructionProcedureList'
    import UnitCommentList from '../Units/UnitCommentListComponent';

    export default {
        components: {
            'unit-comment-list': UnitCommentList,
            'unit-construction-procedure-list': UnitConstructionProcedureList,
        },
        props: {
            unit_code: null,
            unit_construction_editable: {
                default: false,
                type: Boolean
            },
        },
        data () {
            return {
                unit: null,
                siteEngineers: [],
                subConstructors: [],
                error: null,
                showUnitFeatureSection: false,
                showConstructionProgressSection: false,
                showCommentSection: false,
                showEngineerSection: false,
                showSubConstructorSection: false,
                showMaterialOrderSection: false
            };
        },
        mounted() {
            if ( this.unit_code != null ) {
               this.getUnit();  
            }
        },
        methods: {
            getUnit: function () {
                axios.get(`/admin/units/${this.unit_code}/code?embed=action,action.createdBy,unitType,unitType.media,unitType.project,subConstructors,subConstructors.skills,subConstructors.contacts`)
                .then( response => { 
                    this.unit = response.data;
                    this.subConstructors = this.unit.sub_constructors;
                })
                .then( response => {
                    if ( this.unit.zone_id != null ) {
                        axios.get(`/api/zones/${this.unit.zone_id}/site_engineers`)
                        .then( res => {
                            this.siteEngineers = res.data.data;
                        })
                        .catch( err => {
                            this.error = err.response;
                        });
                    }
                })
                .catch( error => {
                    this.error = error.response;
                });
            },
            toggleUnitFeatureSection: function () { this.showUnitFeatureSection = !this.showUnitFeatureSection; },
            toggleUnitConstructionProgressSection: function () { this.showConstructionProgressSection = !this.showConstructionProgressSection; },
            toggleCommentSection: function () { this.showCommentSection = !this.showCommentSection },
            toggleEngineerSection: function () { this.showEngineerSection = !this.showEngineerSection },
            toggleshowSubConstructorSection: function () { this.showSubConstructorSection = !this.showSubConstructorSection },
            toggleMaterialOrderSection: function () { this.showMaterialOrderSection = !this.showMaterialOrderSection }
        },
        filters: {
            formatPhoneNumber : (str) => {
                //Filter only numbers from the input
                let cleaned = ('' + str).replace(/\D/g, '');              
                //Check if the input is of correct
                let match = cleaned.match(/^(\d{3})(\d{3})(\d{3,4})$/);
                if (match) {
                    return  match[1] + ' ' + match[2] + ' ' + match[3]
                };              
                return str;
            },
            formatDate: (date) => {
                return moment(date).format("DD MMM, YYYY");
            }
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