<template>       
    <div class="contract-item-card">
        <div class="unit-info d-flex">
            <div class="unit-info">
                <a v-bind:href="self_link" class="unit-code"><strong>{{ contract.unit.code }}</strong></a> 
                - <a v-bind:href="unit_type_self_link" class="unit-type text-muted"><small>{{ contract.unit.unit_type.name }}</small></a>  
                | <a v-bind:href="project_self_link" class="project text-muted"><small>{{ contract.unit.unit_type.project.name_en }}</small></a>
            </div>
            <div class="unit-status d-flex align-items-center">
                <span :class="statusClassObject">{{ contract.status }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <small><span class="text-muted">Requested at: <strong>{{ contract.created_at | formatDateTime }}</strong>, Signed at: <strong>{{ contract.signed_at | formatDate }}</strong></span></small>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <small><a v-bind:href="deposit_link" class="text-muted" target="_blank" v-if="contract.unit_deposit_request_id != null"><i class="far fa-eye"></i> View Deposit</a> | 
                <a v-bind:href="contract_link" class="text-muted" target="_blank" v-if="contract.contract_id != null"><i class="far fa-eye"></i> View Contract</a></small>
            </div>
        </div>
    </div>
</template>

<style scoped>   
.contract-item-card {
    background: #fff;    
    padding: 10px;
    border: 1px solid #d0d0d0;   
}
.unit-info{
    width: 100%;
}
.unit-status {
    width: 80px;
}
a.text-muted:hover{
   text-decoration: underline;
}
</style>

<script>
    export default {        
        props: [
            'contract'
        ],
        filters: {
            formatDateTime: (date) => {
                return moment(date).format("DD MMM, YYYY : HH:mm:ss");
            },
            formatDate: (date) => {
                return moment(date).format("DD MMM, YYYY");
            },
        },
        computed: {            
            self_link: function() {
                return `/admin/units/${this.contract.unit.id}/edit`;
            },
            unit_type_self_link: function() {
                return `/admin/unit_types/${this.contract.unit.unit_type.id}/edit`;
            },
            project_self_link: function() {
                return `/admin/projects/${this.contract.unit.unit_type.project.id}/edit`;
            },   
            deposit_link: function() {
                return `/admin/unit_deposit_requests/${this.contract.unit_deposit_request_id}`;
            },
            contract_link: function() {
                return `/admin/contracts/${this.contract.contract_id}/print?version=v2`;
            },
            statusClassObject: function() {
                return {
                    'badge badge-pill badge-success': this.contract.status == 'APPROVE',
                    'badge badge-pill badge-warning': this.contract.status == 'PENDING',
                    'badge badge-pill badge-danger': this.contract.status == 'OVERDUE' 
                    || this.contract.status == 'CANCELLED'
                    || this.contract.status == 'REJECTED'
                    || this.contract.status == 'VOIDED',
                    'badge badge-pill badge-primary': this.contract.status == 'RELEASE',
                    'badge badge-pill badge-secondary': this.contract.status == 'OPEN' 
                }
            },
        },
        methods: {            
        }
    };
</script>
