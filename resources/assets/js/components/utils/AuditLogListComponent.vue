<template>
    <div class="audit-log-list" v-if="items.length > 0">
        <div v-for="(audit, index) in items"
            :key="audit.id">
            <span>On <strong>{{ audit.created_at }}</strong>, User: <strong>{{ audit.user.name }}</strong>, Updated data as the following:</span>
            <ul>
                <li v-for="(val, index) in audit.new_values">
                    <strong>{{ index }}</strong> : from  <strong>{{ audit.old_values[index] ? audit.old_values[index] : 'N/A' }}</strong> to <strong>{{ val }}</strong> 
                </li>
            </ul>
            <hr />
        </div>
        <load-more-pagination 
            :paginationData="paginateMeta"
            v-on:on-load-more-button-clicked="paginate"
        ></load-more-pagination> 
    </div>
    <div v-else>No data available</div>
</template>

<style lang="scss" scoped>
   
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
                isLoading: true,
                isError:false,
                paginateMeta: {},
            }
        },
        props : {
            type : String,
            id : null,
        },
        methods : {
            getData: function(page = 1) {
                this.laravelData = {};
                this.isLoading = true;
                let queryString = `type=${this.type}&id=${this.id}&page=${page}&per_page=2`;  
                axios.get(`/api/audits?${queryString}`)
                .then( response => {
                    response.data.data.forEach( (obj) => {                   
                        this.items.push(obj);
                    });
                    this.paginateMeta = response.data.meta;   
                })
                .catch( error => {        
                    this.laravelData = {};
                })
                .finally( () => {
                    this.isLoading = false;
                });
            },
            paginate: function (page) {           
                this.getData(page, this.searchTerm);
            },
        },
        mounted() {
            if ( this.id ) {
                this.getData();
            }
        }
    }
</script>
