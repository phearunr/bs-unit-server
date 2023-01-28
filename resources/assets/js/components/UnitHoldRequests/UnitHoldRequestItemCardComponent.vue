<template>       
    <div class="hold-item-card d-flex">
        <div class="unit-info">
            <a v-bind:href="self_link" class="unit-code"><strong>{{ hold.unit.code }}</strong></a> 
            - <a v-bind:href="unit_type_self_link" class="unit-type text-muted"><small>{{ hold.unit.unit_type.name }}</small></a> 
            | <a v-bind:href="project_self_link" class="project text-muted"><small>{{ hold.unit.unit_type.project.name_en }}</small></a>                
            <span class="text-muted d-block"><small>Created at: <strong>{{ hold.created_at }}</strong>, Hold Duration: <strong>{{ hold.hold_day }}</strong> Day</small></span>
        </div>
        <div class="unit-status d-flex align-items-center">
            <span :class="statusClassObject">{{ hold.status }}</span>
        </div>     
    </div>
</template>

<style scoped>   
.hold-item-card {
    background: #fff;    
    padding: 10px;
    border: 1px solid #d0d0d0;   
}
.hold-item-card .unit-info {
    width: 100%;
}
.hold-item-card .unit-status {
    width: 80px;
}
.unit-info a.text-muted:hover{
   text-decoration: underline;
}
</style>

<script>
    export default {        
        props: [
            'hold'
        ],
        computed: {            
            self_link: function() {
                return `/admin/units/${this.hold.unit.id}/edit`;
            },
            unit_type_self_link: function() {
                return `/admin/unit_types/${this.hold.unit.unit_type.id}/edit`
            },
            project_self_link: function() {
                return `/admin/projects/${this.hold.unit.unit_type.project.id}/edit`
            },
            statusClassObject: function() {
                return {
                    'badge badge-pill badge-success': this.hold.status == 'APPROVE',
                    'badge badge-pill badge-warning': this.hold.status == 'PENDING',                    
                    'badge badge-pill badge-danger': this.hold.status == 'OVERDUE' 
                    || this.hold.status == 'CANCELLED'
                    || this.hold.status == 'REJECTED',
                    'badge badge-pill badge-primary': this.hold.status == 'RELEASE',
                }
            } 
        },
        methods: {            
        }
    };
</script>
