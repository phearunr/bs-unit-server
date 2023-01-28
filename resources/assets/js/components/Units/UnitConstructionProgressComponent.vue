<template>
    <div class="unit-construction-progress-component">
        <div class="progress-item-container mb-3" v-for="item in items">
            <div class="header">
                <span><strong>{{ item.name_km }} ({{ item.name }})</strong></span>
            </div>
            <div class="row">
                <div class="col-5">
                    <label for="progress"><small>Progress</small></label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <button class="btn btn-primary" type="button" id="button-addon1">-</button>
                        </div>
                        <input type="text" class="form-control form-control-sm text-center" step="5" min="0" max="100" name="progress" id="progress">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="button-addon1">+</button>
                        </div>
                    </div>
                </div>
                <div class="col-5 pl-0">
                    <label for="estimate_completed_at"><small>Estimate Completed At</small></label>
                    <datepicker input-class="form-control form-control-sm" format="YYYY-MM-DD" value-type="YYYY-MM-DD"></datepicker>
                </div>
                <div class="col-2 pl-0 d-flex">
                    <button class="btn btn-primary btn-sm align-self-end w-100">Save</button>    
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .mx-datepicker {
        width: 100%;
    }
</style>
<script>

export default {   
    components: {
    },
    props: {     
        unitId: null,
        editable:{
            default: false,
            type: Boolean
        }
    },
    data : () => {
        return {
           items:null
        }
    },
    methods: {
        getData: function() {
            this.isLoading = true;
            let queryString = ``; 

            axios.get(`/api/units/${this.unitId}/construction_procedures?${queryString}`)
            .then( response => {
                this.items = response.data;
            })
            .catch( error => {   
                console.log(error);
            })
            .finally( () => {
                
            });
        },
        onConstructionFormSumbitted : function (event) { 
            this.isError = false;
            this.errorMsg = '';           
            if ( this.unitId == null ) {
                this.isError = true;
                this.errorMsg = 'No Unit selected';
                return;
            }
            let formData = new FormData();
            formData.append('foundation', this.foundation);
            formData.append('structure', this.structure);
            formData.append('finishing', this.finishing);
            formData.append('infrastructure', this.infrastructure);
            formData.append('mep', this.mep);            
            formData.append('estimate_completed_at', moment(this.estimateCompletedAt).format('YYYY-MM-DD'));            
            axios.post( `/api/units/${this.unitId}/unit_construction`,
                formData
            ).then( response => {
                this.createdBy = response.data.data.created_by.name;
                this.actualCompletedAt = response.data.data.actual_completed_at;
                this.updatedAt = response.data.data.updated_at;
            })
            .catch( error => {              
                this.isError = true;
                this.errorMsg = error.response.data.error.message ? error.response.data.error.message : error.response.data.message;
            });
        }
    },
    mounted() { 
        if ( this.unitId ) {
            this.getData();
        }
    }  
}
</script>

