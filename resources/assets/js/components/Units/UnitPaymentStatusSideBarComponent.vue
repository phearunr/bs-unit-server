<template> 
    <div class="row" v-if="unit != null">
        <div class="col-md-12">
            <h5 class="pt-4 px-4 text-center">Handover Information:</h5>
            <table class="table table-sm table-bordered">
                <tbody>
                    <tr>
                        <th scope="row" class="bg-light" width="180px">Unit Code</th>
                        <td class="text-right">{{ unit.code }}</td>
                    </tr>
                    <!-- 
                    <tr>
                        <th scope="row" class="bg-light" width="180px">Customer Name</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ unit.unit_handover.customer_name  }}</td>
                        <td class="text-right" v-else>N/A</td>
                    </tr>
                    
                    <tr>
                        <th scope="row" class="bg-light">Net Selling</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ unit.unit_handover.net_selling_price | toCurrencyUSD  }}</td>
                        <td class="text-right" v-else>N/A</td>                          
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Total Payment</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ unit.unit_handover.total_payment | toCurrencyUSD  }}</td>
                        <td class="text-right" v-else>N/A</td>                          
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Ending Balance</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ unit.unit_handover.ending_balance | toCurrencyUSD }}</td>
                        <td class="text-right" v-else>N/A</td>                          
                    </tr> 
                    -->
                    
                    <tr>
                        <th scope="row" class="bg-light">Last Posting Date</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ unit.unit_handover.last_posting_date | formatDate }}</td>
                        <td class="text-right" v-else>N/A</td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Last Payment Date</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ unit.unit_handover.last_payment_date | formatDate }}</td>
                        <td class="text-right" v-else>N/A</td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Late Payment Month</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ latePaymentMonthWord  }}</td>
                        <td class="text-right" v-else>N/A</td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Contract Signed Date</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ unit.unit_handover.contract_signed_date | formatDate }}</td>
                        <td class="text-right" v-else>N/A</td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Contract Deadline Date</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ unit.unit_handover.contract_deadline_date | formatDate }}</td>
                        <td class="text-right" v-else>N/A</td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Late Deadline Month</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ lateDeadlineMonthWord  }}</td>
                        <td class="text-right" v-else>N/A</td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Date Updated on</th>
                        <td class="text-right" v-if="unit.unit_handover">{{ unit.unit_handover.unit_handover_batch.data_updated_on  | formatDate}}</td>
                        <td class="text-right" v-else>N/A</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- 
        <div class="col-12 bg-light p-4">
            <h5 class="text-center">Construction Progress:</h5>
            <unit-construction-progress :unit-id="unit.id" :key="unit.id"></unit-construction-progress>
        </div> 
        <div class="col-12 pt-4">
            <h5 class="text-center d-block">Comment:</h5>
            <unit-comment-list :unit-id="unit.id" :key="unit.id"></unit-comment-list>
        </div> 
        -->
    </div>
    <div class="row h-100" v-else>
        <div class="col-12 d-flex flex-column justify-content-center">
            <h4 class="text-center mt-4">No unit was selected.</h4>
            <p class="text-center text-muted">Please select any unit in the masterplan on the left side to display the unit information.</p>
        </div>
    </div>    
</template>

<style scoped>
</style>

<script>
    export default {    
        props: {
            unit_code: null,
        },
        data () {
            return {
                unit: null,
            }
        },
        mounted() {       
            if ( this.unit_code != null ) {
               this.getUnit();
            }
        },
        methods: {
            getUnit: function () {
                axios.get(`/admin/units/${this.unit_code}/code?embed=action,unitHandover,unitHandover.unitHandoverBatch`)
                .then( response => { this.unit = response.data; })
                .catch( error => {
                    this.error = error.response;
                });
            }          
        },
        computed: {     
            lateDeadlineMonthWord: function () {
                if ( this.unit.unit_handover.late_deadline_month < 0 ) {
                    return `late ${this.unit.unit_handover.late_deadline_month * -1} months`;
                } else {
                    return `remain ${this.unit.unit_handover.late_deadline_month} months`;
                }
            },
            latePaymentMonthWord: function () {
                if ( this.unit.unit_handover.late_payment_month > 0 ) {
                    return `late ${this.unit.unit_handover.late_payment_month} months`;
                } else if(this.unit.unit_handover.late_payment_month == 0) {
                     return `pay on time`;
                } else {
                    return `prepaid ${this.unit.unit_handover.late_payment_month * -1} months`;
                }
            }

        }
    };
</script>