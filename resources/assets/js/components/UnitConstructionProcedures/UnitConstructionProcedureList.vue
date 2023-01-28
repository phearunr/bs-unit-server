<template>
    <div class="unit-construction-progress-component" >
        <div v-if="showSummary" class="d-flex rounded bg-secondary pt-2 px-3 mb-3" style="color: rgb(255, 255, 255);">
            <h5 class="flex-fill">Total Progress Average</h5> 
            <h5><strong>{{ overallProgressPercentage | number('0') }} %</strong></h5>
        </div>
        <construction-procedure-item
            v-for="(item, index) in items" 
            :key="index"
            :item="item"
            :editable="editable">
        </construction-procedure-item>
    </div>
</template>

<style lang="scss" scoped>
    .mx-datepicker {
        width: 100%;
    }
</style>
<script>
import ConstructionProcedureItem from '../UnitConstructionProcedures/ConstructionProcedureItem';

export default {   
    components: {
        'construction-procedure-item': ConstructionProcedureItem,
    },
    props: {     
        unitId: null,
        showSummary:false,
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
            let queryString = ``; 

            axios.get(`/api/units/${this.unitId}/construction_procedures?${queryString}`)
            .then( response => {
                this.items = response.data.data;
            })
            .catch( error => {   
                console.log(error);
            });
        },
        onConstructionFormSumbitted : function (event) { 
        }
    },
    mounted() { 
        if ( this.unitId ) {
            this.getData();
        }
    },
    computed: {
        overallProgressPercentage: function() {
            if ( !Array.isArray(this.items) ) {
                return 0;
            }            
            var total = 0;
            this.items.forEach( (obj) => { total = obj.pivot.progress + total });

            return (total/ this.items.length);
        }
    }
}
</script>

