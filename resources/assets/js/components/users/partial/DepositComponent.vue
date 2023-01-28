<template>
    <!-- Post -->
    <table class="table table-hover table-action mb-0">
        <thead>
            <tr>
                <th scope="col">Unit Code</th>
                <th scope="col">Customer Info</th>
                <th scope="col">Deposit Date</th>
                <th scope="col">Payment Info</th>
                <th scope="col">Payment Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="deposit in deposits">
                <td class="action-td">
                    <a :href="'/admin/units/'+deposit.unit.id+'/edit'">
                        <strong>{{ deposit.unit.code }}</strong>
                    </a>
                    <span class="d-block text-muted">
                        {{ deposit.unit.unit_type.name }}
                    </span>
                    <span class="d-block text-muted">
                        {{ deposit.unit.unit_type.project.name_en }} 
                    </span>
                </td>
                <td>
                    <span class="d-block">{{ deposit.customer_name}}</span>
                    <span class="d-block" v-if="deposit.customer2_name">{{ deposit.customer2_name }}</span>
                    <span class="d-block text-muted">
                        <span>{{ deposit.customer_phone_number }}</span>
                        <span v-if="deposit.customer_phone_number2"> | {{ deposit.customer_phone_number2 }}</span>
                    </span>
                </td>
                <td>
                    <span>{{ deposit.deposited_at }}</span>
                </td>
                <td>
                    <ul class="mb-0">                    
                        <li>Deposit Amount: <b>{{ deposit.deposit_amount | currency }}</b></li>
                        <li>Receiving Amount: <b>{{ deposit.receiving_amount | currency }}</b></li>
                        <!-- <li>Due Amount: <b>{{ deposit.getDueAmount() }}</b></li> -->
                    </ul>
                </td>
                <td>
                    <span class="badge badge-pill badge-primary">{{ deposit.status }}</span>
                </td>
            </tr>
            <infinite-loading @infinite="infiniteHandlerDeposits" class="infinite-loading-container-custom">
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
                deposits: [],
                total: 0,
            };
        },
        props: [
            'userId'
        ],
        methods: {
            infiniteHandlerDeposits :  function($state) {
                axios.get(`/api/users/${this.userId}/deposits`, {
                    params: {
                        page: this.page
                    },
                }).then(({ data }) => {
                    if (data.data.length) {
                        this.page += 1;
                        this.deposits.push(...data.data); 
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
