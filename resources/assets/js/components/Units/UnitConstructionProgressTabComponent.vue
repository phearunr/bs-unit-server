<template>    
    <div class="unit-construction-progress-tab-container">
        <div class="unit-construction-progress-container bg-light p-4">
            <h5>Construction Progress:</h5>
            <unit-construction-progress :unit-id="unitId"></unit-construction-progress>
        </div>
        <div class="unit-comment-container  p-4">
            <h5>Comment List:</h5>
            <unit-comment-list :unit-id="unitId"></unit-comment-list>
        </div>
    </div>
</template>

<style lang="scss" scoped>       
</style>
<script>

import UnitConstructionProgress from '../Units/UnitConstructionProgressComponent';
import UnitCommentList from '../Units/UnitCommentListComponent';

export default {
    components : {       
        'unit-comment-list': UnitCommentList,    
        'unit-construction-progress': UnitConstructionProgress,
    },
    props: {     
        unitId: null,
    },
    data : () => {
        return {
            
        }
    },
    methods: {
    },
    mounted() { 
    }  
}
</script>

