<template>
    <div class="unit-price-history-component d-inline">               
        <button class="btn btn-sm btn-secondary" @click="showModal" data-toggle="tooltip" data-placement="top" title="View Price History">
            <i class="fas fa-history"></i>
        </button>
        <v-modal v-if="isModalVisible" size="v-modal-sm" @close="closeModal">
            <template v-slot:header>
               <h4>Unit Price History</h4>               
               <button type="button" class="btn btn-sm btn-danger" @click="closeModal" aria-label="Close modal">x</button>
            </template>
            <template v-slot:body>
                <p v-for="item in items" class="log-record-item"> 
                    <strong>{{ item.field_name | upText }}</strong> 
                    : <strong>$ {{ item.old_value | toCurrencyUSD }}</strong> 
                    to <strong>$ {{ item.new_value | toCurrencyUSD }}</strong>
                    at <strong>{{ item.created_at }}</strong>
                    by <strong>{{ item.user.name }}</strong>
                </p>             
                <load-more-pagination 
                    :paginationData="paginateMeta"
                    v-on:on-load-more-button-clicked="paginate"
                ></load-more-pagination>  
            </template>
        </v-modal>

    </div>
</template>
<style lang="scss" scoped>
    .log-record-item {
        padding-bottom: 0.5rem;
        margin-bottom: 0.25rem;
        border-bottom: 1px solid #ccc;
    }
</style>

<script>

import LoadMorePagination from '../utils/LoadMoreComponent';

export default {   
    components: {
        'load-more-pagination': LoadMorePagination,    
    },
    props: [ 
        'unitId'
    ],
    data() {
        return {       
            items:[],
            paginateMeta: {},
            isLoading: true,
            isError:false,
            isModalVisible : false,
        };
    },
    methods: {
        getData: function(page = 1, search = '', filter = '') {         
            this.isLoading = true;
            let queryString = `page=${page}&per_page=10&embed=createdBy`;  
            if ( search != '' ) {
                queryString += `search=${search}`;
            }
            axios.get(`/admin/units/${this.unitId}/activities?${queryString}`)
            .then( response => {
                response.data.data.forEach( obj => {
                    this.items.push(obj);
                });                
                this.paginateMeta = response.data;
            })
            .catch( error => {        
               console.log(error);
            })
            .finally( () => {
                this.isLoading = false;
            });
        },
        paginate: function (page) {           
            this.getData(page, this.searchTerm);
        },
        showModal () {
            this.isModalVisible = true;
        },
        closeModal () {
            this.isModalVisible = false;
        }
    },
    mounted() {   
        this.getData();      
    }  
}
</script>

