<template>       
    <div class="hold-item-card">
        <div class="unit-info d-flex">
            <div class="unit-info">
                <a v-bind:href="self_link" class="unit-code"><strong>{{ deposit.unit.code }}</strong></a> 
                - <a v-bind:href="unit_type_self_link" class="unit-type text-muted"><small>{{ deposit.unit.unit_type.name }}</small></a>  
                | <a v-bind:href="project_self_link" class="project text-muted"><small>{{ deposit.unit.unit_type.project.name_en }}</small></a>
            </div>
            <div class="unit-status d-flex align-items-center">
                <span :class="statusClassObject">{{ deposit.status }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <span class="text-muted"></span><small>Customer:</small></span> 
                <span class="text-muted"><small><i :class="genderClassObject" :title="gender"></i> <strong>{{ deposit.customer_name }}</strong></small></span>
                <span class="text-muted" v-if="deposit.customer2_name != ''"><small><i :class="genderClassObject"></i> <strong>{{ deposit.customer2_name }}</strong></small></span>
                <span class="text-muted"><small> <i class="fas fa-phone-square" title="Contact Phone Number"></i> <strong>{{ deposit.customer_phone_number }}, {{ deposit.customer_phone_number2 }}</strong></small></span>
            </div>
            <div class="col-md-6">               
                <span class="text-muted"><small>Deposit:</small></span> 
                <span class="text-muted"><small><i class="far fa-calendar-alt" title="Deposit Date"></i> <strong>{{ deposit.created_at | formatDate }}</strong> 
                <i class="fas fa-file-invoice-dollar" title="Deposit Amount"></i> <strong>{{ deposit.deposit_amount | currency }}</strong> 
                <i class="fas fa-hand-holding-usd" title="Receiving Amount"></i> <strong>{{ deposit.receiving_amount | currency }}</strong> 
                <span :class="paymentStatusClassObject">{{ deposit.payment_status }} {{ overdueDuration }}</span></small></span>           
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">               
                <span class="text-muted"><small>Unit Controler <i class="fas" v-bind:class="unitControllerStatus"></i></small></span>
                <span class="text-muted" v-if="deposit.unit_controller_id != null"><small><strong>{{ deposit.unit_controller.name }}</strong> <i class="far fa-calendar-alt" title="Deposit Date"></i> <strong>{{ deposit.unit_controller_actioned_at | formatDate }}</strong></small></span>
            </div>
            <div class="col-md-6">               
                <span class="text-muted"><small>Sale Manager <i class="fas" v-bind:class="saleManagerStatus"></i></small></span>
                <span class="text-muted" v-if="deposit.sale_maanger_id != null"><small><strong>{{ deposit.sale_manager.name }}</strong> <i class="far fa-calendar-alt" title="Deposit Date"></i> <strong>{{ deposit.sale_manager | formatDate }}</strong></small></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <small><a v-bind:href="deposit_link" class="text-muted" target="_blank"><i class="far fa-eye"></i> View Deposit</a></small>
            </div>
        </div>
    </div>
</template>

<style scoped>   
.hold-item-card {
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
            'deposit'
        ],
        filters: {
            formatDate: (date) => {
                return moment(date).format("DD MMM, YYYY : HH:mm:ss");
            }
        },
        computed: {            
            self_link: function() {
                return `/admin/units/${this.deposit.unit.id}/edit`;
            },
            unit_type_self_link: function() {
                return `/admin/unit_types/${this.deposit.unit.unit_type.id}/edit`
            },
            project_self_link: function() {
                return `/admin/projects/${this.deposit.unit.unit_type.project.id}/edit`
            },
            deposit_link: function() {
                return `/admin/unit_deposit_requests/${this.deposit.id}`;
            },
            overdueDuration: function() {
                if ( this.deposit.payment_status == 'Overdue' ) {
                    return moment(this.deposit.created_at).fromNow();
                }
            },
            statusClassObject: function() {
                return {
                    'badge badge-pill badge-success': this.deposit.status == 'APPROVE',
                    'badge badge-pill badge-warning': this.deposit.status == 'PENDING',
                    'badge badge-pill badge-danger': this.deposit.status == 'OVERDUE' 
                    || this.deposit.status == 'CANCELLED'
                    || this.deposit.status == 'REJECTED'
                    || this.deposit.status == 'VOIDED',
                    'badge badge-pill badge-primary': this.deposit.status == 'RELEASE',
                    'badge badge-pill badge-secondary': this.deposit.status == 'CHANGED' 
                }
            },
            unitControllerStatus: function() {
                return {
                    'fa-check-circle text-success': this.deposit.unit_controller_status == 'APPROVED',
                    'fa-times-circle text-danger': this.deposit.unit_controller_status == 'REJECTED',
                    'fa-question-circle text-secondary': this.deposit.unit_controller_status == null,
                }
            },
            saleManagerStatus: function() {
                return {
                    'fa-check-circle text-success': this.deposit.sale_manager_status == 'APPROVED'
                    || this.deposit.sale_manager_status == 'NOT_REQUIRED',
                    'fa-times-circle text-danger': this.deposit.sale_manager_status == 'REJECTED',
                    'fa-question-circle text-secondary': this.deposit.sale_manager_status == null,
                }
            },
            gender: function(){
                return this.deposit.customer_gender == 1 ? 'Male' : 'Female';
            },
            genderClassObject: function() {
                return {
                    'fas fa-mars': this.deposit.customer_gender == 1 || this.deposit.customer2_gender == 1,
                    'fas fa-venus': this.deposit.customer_gender == 2 || this.deposit.customer2_gender == 2,
                }
            },
            paymentStatusClassObject: function() {
                return {
                    'badge badge-pill badge-success': this.deposit.payment_status == 'Full',
                    'badge badge-pill badge-warning': this.deposit.payment_status == 'Unpaid',
                    'badge badge-pill badge-danger': this.deposit.payment_status == 'Overdue',
                    'badge badge-pill badge-primary': this.deposit.payment_status == 'Partial',
                }
            }


        },
        methods: {            
        }
    };
</script>
