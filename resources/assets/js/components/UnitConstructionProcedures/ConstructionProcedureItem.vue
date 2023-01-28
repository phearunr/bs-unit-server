<template>
    <div class="progress-item-container mb-3">
        <div class="header">
            <span><strong>{{ unit_construction_procedure.name_km }} ({{ unit_construction_procedure.name }})</strong></span>
        </div>
        <div class="row">
            <div class="col-5">
                <label for="progress"><small>Progress (%)</small></label>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <button :disabled="completed == true || editable == false" class="btn btn-primary" type="button" @click="minusProgress(5)">-</button>
                    </div>
                    <input :disabled="completed == true || editable == false" type="text" v-model.number="unit_construction_procedure.pivot.progress" class="form-control form-control-sm text-center" />
                    <div class="input-group-append">
                        <button :disabled="completed == true || editable == false" class="btn btn-primary" type="button" @click="increaseProgress(5)">+</button>
                    </div>
                </div>
            </div>
            <div class="col-5 pl-0">
                <label for="estimate_completed_at"><small>Estimate Completed At</small></label>
                <datepicker :disabled="completed == true || editable == false" v-model="unit_construction_procedure.pivot.estimate_completed_at" input-class="form-control form-control-sm" format="YYYY-MM-DD" value-type="YYYY-MM-DD"></datepicker> </div>
            <div class="col-2 pl-0 d-flex">
                <button :disabled="completed == true || editable == false" class="btn btn-primary btn-sm align-self-end w-100" @click="save">Save</button>    
            </div>
        </div>
        <div v-if="error != null">
            <ul v-if="error.status == 422">
                <li v-for="(v,k) of error.data.errors"><span class="text-danger">{{ v[0] }}</span></li>
            </ul>
            <span v-else class="text-danger">{{ error.data.error.message }}</span>
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
    props: {      
        item: null,   
        editable:{
            default: false,
            type: Boolean
        }
    },
    data : () => {
        return {
            unit_construction_procedure: null,
            error: null,
        }
    },
    created() {
        this.unit_construction_procedure = this.item;
    },
    methods: {
        minusProgress : function (number) {
            this.item.pivot.progress = (this.unit_construction_procedure.pivot.progress - number <= 0) ? 0 : this.unit_construction_procedure.pivot.progress - number;
        },
        increaseProgress : function (number) {
            this.item.pivot.progress = (this.unit_construction_procedure.pivot.progress + number >= 100) ? 100 : this.unit_construction_procedure.pivot.progress + number;
        },
        save: function () {
            this.error = null;           
            let formData = new FormData();           
            formData.append('estimate_completed_at', this.unit_construction_procedure.pivot.estimate_completed_at);
            formData.append('progress', this.unit_construction_procedure.pivot.progress);
            axios.post( `/api/units/${this.unit_construction_procedure.pivot.unit_id}/construction_procedures/${this.unit_construction_procedure.pivot.construction_procedure_id}`,
                formData
            ).then( response => {
                this.unit_construction_procedure.pivot = response.data;
                Swal.fire({
                    icon: 'success',
                    title: 'Record has been saved successfully.',
                    showConfirmButton: false,
                    timer: 1000
                })
            })
            .catch( error => {

                this.error = error.response;

                console.log(this.error.data.error.message);
            });
        },
    },
    computed: {
        // a computed getter
        completed: function () {       
            return this.unit_construction_procedure.pivot.progress == 100
            && this.unit_construction_procedure.pivot.actual_completed_at != null;
        }
    }
}
</script>

