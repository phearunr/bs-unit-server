<template>
    <div class="transaction-table-container">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th scope="col" width="120px">Type</th>
                    <th scope="col" width="130px">Status</th>
                    <th scope="col" width="150px">By</th>
                    <th scope="col">Remark</th>
                    <th scope="col" width="50px"></th>
                </tr>
            </thead>
            <tbody>             
                <tr v-for="action in items" :key="action.id">
                    <th v-html="action.status_html"></th>
                    <td v-html="action.status_action_html"></td>
                    <td>{{ action.created_by.name }} <span class="d-block text-secondary"><small>{{ action.created_at }}</small></span></td>
                    <td>{{ action.description }}</td> 
                    <td>
                        <a v-if="actionableLink(action) != null" :href="actionableLink(action)"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <load-more-pagination 
            :paginationData="paginateMeta"
            v-on:on-load-more-button-clicked="paginate"
        ></load-more-pagination>            
    </div>
</template>

<style scoped>

</style>

<script>
import LoadMorePagination from '../utils/LoadMoreComponent';

export default {    
    components : {       
        'load-more-pagination': LoadMorePagination,    
    },
    data : () => {
        return {
            items:[],
            paginateMeta: {},
            isLoading: true,
            isError:false,
            searchTerm: ''
        }
    },
    props: {
        filter: {},
        unitId: null,
    },    
    methods: {
        getData: function(page = 1, search = '', filter = '') {         
            this.isLoading = true;
            let queryString = `page=${page}&per_page=15&embed=createdBy`;  
            if ( search != '' ) {
                queryString += `search=${search}`;
            }
            axios.get(`/api/units/${this.unitId}/actions?${queryString}`)
            .then( response => {
                response.data.data.forEach( obj => {
                    this.items.push(obj);
                });
                this.paginateMeta = response.data.meta;              
            })
            .catch( error => {        
               console.log(error);
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
        actionableLink: function ( action ) {
            switch (action.actionable_type) {
                case 'App\\UnitHoldRequest':
                    return `/admin/unit_hold_requests/${action.actionable_id}`;
                    break;
                case 'App\\UnitDepositRequest':
                    return `/admin/unit_deposit_requests/${action.actionable_id}`;
                    break;
                case 'App\\UnitContractRequest':
                    return `/admin/unit_contract_requests/${action.actionable_id}`;
                    break;
                case 'App\\Contract':
                    return `/admin/contract/${action.actionable_id}`;
                    break
                default:
                    return null;
            }       
        },
    },    
    mounted() {
        this.getData();
    }
}
</script>
