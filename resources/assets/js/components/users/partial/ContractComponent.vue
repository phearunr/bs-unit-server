<template>
    <!-- Post -->
    <table class="table table-hover table-action mb-0">
        <thead>
            <tr>
                <th scope="col">Unit Code</th>
                <th scope="col">Customer Info.</th>
                <th scope="col">Payment Info.</th>                               
                <th scope="col">Status</th>                  
            </tr>
        </thead>
        <tbody>
            <tr v-for="contract in contracts">
                <td class="action-td">
                    <a href="#" class="title">{{ contract.unit.code }}</a> 
                    <span class="d-block text-muted">{{ contract.unit.unit_type.name }}</span>
                    <span class="d-block text-muted">{{ contract.unit.unit_type.project.name_en }}</span>
                </td> 
                <td>
                   <span class="d-block">{{ contract.unit_deposit_request.customer_name}}</span>
                    <span class="d-block text-muted">
                        {{ contract.unit_deposit_request.customer_phone_number }}
                    </span>
                    <span class="d-block text-muted" v-if="contract.unit_deposit_request.customer_phone_number2">
                        {{ contract.unit_deposit_request.customer_phone_number2 }}
                    </span>
                </td>
                <td>
                    <ul class="mb-0">
                        <li>Unit Sold Price : <b>{{ contract.unit_deposit_request.unit_sale_price | currency }}</b></li>
                        <li>Deposit Amount: <b>{{ contract.unit_deposit_request.deposit_amount | currency }}</b></li>
                        <li>
                            Payment Option : 
                            <a v-if="contract.unit_deposit_request.payment_option_id !== null" :href="'admin/unit_types/'+contract.unit_deposit_request.payment_option_id+'edit'">
                                <b>{{ contract.unit_deposit_request.payment_option.name }}</b>
                            </a>
                            <b v-else>Other</b>
                        </li>
                    </ul>
                </td>
                <td>
                    <span class="badge badge-pill badge-primary">{{ contract.status }}</span>
                </td>
            </tr>
            <infinite-loading @infinite="infiniteHandlerContracts" class="infinite-loading-container-custom">
                <div slot="spinner">Loading...</div>
                <div slot="no-more">No more data</div>
                <div slot="no-results">No results data</div>
            </infinite-loading>
        </tbody>
    </table>
    <!-- /.post -->
</template>

<script>
    export default {
        data() {
            return {
                page: 1,
                contracts: [],
                total: 0,
            };
        },
        props: [
            'userId'
        ],
        methods: {
            infiniteHandlerContracts :  function($state) {
                axios.get(`/api/users/${this.userId}/contracts`, {
                    params: {
                        page: this.page
                    },
                }).then(({ data }) => {
                    if (data.data.length) {
                        this.page += 1;
                        this.contracts.push(...data.data); 
                        this.total = data.meta.total;
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
            },
        }
    };
</script>
