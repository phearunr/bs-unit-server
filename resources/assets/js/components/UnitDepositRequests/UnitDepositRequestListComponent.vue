<template>
    <div class="deposit-item-container">     
        <unit-deposit-request-item-card
            v-for="(deposit, index) in laravelData.data"
            :key="deposit.id"
            :deposit="deposit"       
        ></unit-deposit-request-item-card>       
        <pagination 
            :paginationData="laravelData.meta"
            v-on:on-pagination-changed="paginate"
        ></pagination>
    </div>
</template>

<style scoped>

</style>

<script>

import UnitDepositRequestItemCard from './UnitDepositRequestItemCardComponent.vue';
import PaginationComponent from '../utils/PaginationComponent';

export default {
    components : {
        'unit-deposit-request-item-card' : UnitDepositRequestItemCard,       
        'pagination': PaginationComponent,    
    },
    data : () => {
        return {
            laravelData: {},
            isLoading: true,
            isError:false,
            searchTerm: ''
        }
    },
    props: {
        filter: {},
        userId: null,
    },    
    methods: {
        getData: function(page = 1, search = '', filter = '') {
            this.laravelData = {};
            this.isLoading = true;
            let queryString = `page=${page}&per_page=10&embed=unit,unitController,saleManager`;  
            if ( search != '' ) {
                queryString += `search=${search}`;
            }
            axios.get(`/api/users/${this.userId}/unitDepositRequests?${queryString}`)
            .then( response => {
                this.laravelData = response.data;          
            })
            .catch( error => {        
                this.laravelData = {};
            })
            .finally( () => {
                this.isLoading = false;
            });
        },
        search: function(criteria) {
            // this.searchTerm = criteria.term;
            // this.getData(1, this.searchTerm, '');
        },
        paginate: function (page) {
            this.getData(page, this.searchTerm);
        },
    },
    mounted() {
        this.getData();
    }
}
</script>
