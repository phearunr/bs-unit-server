<template>
    <div class="unit-construction-progress-component">
        <div class="form-group">
            <label for="foundation">Foundation: <strong>{{ foundation }}%</strong></label>
            <input type="range" min="0" max="100" v-model="foundation" name="foundation" id="foundation" class="form-control-range" v-bind:disabled="!editable" />
        </div>
        <div class="form-group">
            <label for="structure">Structure: <strong>{{ structure }}%</strong></label>
            <input type="range" min="0" max="100" v-model="structure" name="structure" id="structure" class="form-control-range" v-bind:disabled="!editable" />
        </div>
        <div class="form-group">
            <label for="finishing">Finishing: <strong>{{ finishing }}%</strong></label>
            <input type="range" min="0" max="100" v-model="finishing" name="finishing" id="finishing" class="form-control-range" v-bind:disabled="!editable" />
        </div>
        <div class="form-group">
            <label for="infrastructure">Infrastructure: <strong>{{ infrastructure }}%</strong></label>
            <input type="range" min="0" max="100" v-model="infrastructure" name="infrastructure" id="infrastructure" class="form-control-range" v-bind:disabled="!editable" >
        </div>
        <div class="form-group">
            <label for="mep">MEP: <strong>{{ mep }}%</strong></label>
            <input type="range" min="0" max="100" v-model="mep" name="mep" id="mep" class="form-control-range" v-bind:disabled="!editable" />
        </div>
        <div class="form-row">
            <div class="col form-group">
                <label for="estimate-completed-at">Est. Completed At</label>
                <datepicker v-model="estimateCompletedAt" name="estimate-completed-at" input-class="form-control" format="YYYY-MM-DD" value-type="YYYY-MM-DD" v-bind:disabled="!editable"></datepicker>
            </div>
            <div class="col form-group">
                <label for="actual-completed-at">Actual Completed At:</label>
                <input type="text" class="form-control" name="actual-completed-at" id="actual-completed-at" readonly="readonly" v-model="actualCompletedAt">
            </div>
        </div>
        <div class="form-row">
            <div class="col form-group">
                <label for="user_id">Updated By</label>
                <input type="text" class="form-control" name="user_id" id="user_id" readonly="readonly" v-model="createdBy">
            </div>
            <div class="col form-group">
                <label for="updated_at">Updated At</label>
                <input type="text" class="form-control" name="updated_at" id="updated_at" readonly="readonly" v-model="updatedAt">
            </div>
        </div>    
        <p class="text-danger" v-if="isError">{{ errorMsg }}</p>
        <button type="submit" v-if="editable" class="btn btn-sm btn-primary mb-2" @click="onConstructionFormSumbitted"><i class="fas fa-save"></i> Save</button>
        <button v-if="unitConstructionId" class="btn btn-sm btn-danger float-right mb-2" @click="showModal"><i class="fas fa-history"></i> History</button>
      
        <v-modal v-if="isModalVisible" size="v-modal-md" @close="closeModal">
            <template v-slot:header>
               <h4>Unit Construction update history</h4>               
               <button type="button" class="btn btn-sm btn-danger" @click="closeModal" aria-label="Close modal">x</button>
            </template>
            <template v-slot:body>
                <audit-log-list type="UnitConstruction" v-bind:id="unitConstructionId" :key="unitConstructionId"></audit-log-list>
            </template>
        </v-modal>
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
            unitConstructionId: null,
            foundation:0,
            structure:0,
            finishing:0,
            infrastructure:0,
            mep:0,            
            estimateCompletedAt:null,
            actualCompletedAt:null,
            createdBy:'',
            updatedAt:null,
            isError:false,
            errorMsg:'',
            isModalVisible : false,
        }
    },
    methods: {
        getData: function() {
            this.isLoading = true;
            let queryString = ``;  
            
            axios.get(`/api/units/${this.unitId}/unit_construction?${queryString}`)
            .then( response => {
                if ( response.data.data.hasOwnProperty('__type') ) {
                    this.unitConstructionId = response.data.data.id;
                    this.foundation = response.data.data.foundation;
                    this.structure = response.data.data.structure;
                    this.finishing = response.data.data.finishing;
                    this.infrastructure = response.data.data.infrastructure;
                    this.mep = response.data.data.mep;
                    this.estimateCompletedAt = response.data.data.estimate_completed_at;
                    this.actualCompletedAt = response.data.data.actual_completed_at;
                    this.createdBy = response.data.data.created_by.name;
                    this.updatedAt = response.data.data.updated_at;
                } else {
                    this.unitConstructionId = null;
                    this.foundation = 0;
                    this.structure = 0;
                    this.finishing = 0;
                    this.infrastructure = 0;
                    this.mep = 0;
                    this.estimateCompletedAt = null;
                    this.actualCompletedAt = null;
                    this.createdBy = '';
                    this.updatedAt = null;
                }
            })
            .catch( error => { 
                this.unitConstructionId = null;
                this.foundation = 0;
                this.structure = 0;
                this.finishing = 0;
                this.infrastructure = 0;
                this.mep = 0;
                this.estimateCompletedAt = null;
                this.actualCompletedAt = null;
                this.createdBy = '';
                this.updatedAt = null;
                console.log(error);
            })
            .finally( () => {
                this.isLoading = false;
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
        },
        showModal () {
            this.isModalVisible = true;
        },
        closeModal () {
            this.isModalVisible = false;
        }
    },
    mounted() { 
        if ( this.unitId ) {
            this.getData();
        }
        
    }  
}
</script>

