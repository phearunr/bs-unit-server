<template>
    <div class="paging-container my-2" v-if="isApiPagination(paginationData)">
        <div class="paging-label">
            <span>Showing <strong>{{ paginationData.from | nullableString }}</strong> to <strong>{{ paginationData.to | nullableString }}</strong> of <strong>{{ paginationData.total | nullableString }}</strong> entries</span>
        </div>
        <div class="paging-action-containter">            
            <div class="btn-group">           
                <span class="paging-action-label">Page</span>
                <input type="text" class="page-input" :value="paginationData.current_page" v-on:keyup.enter="goToPage($event.target.value)"/>
                <span class="paging-action-label">of {{ paginationData.last_page | nullableString }}</span>                
                <button type="button" class="btn btn-sm btn-primary btn-flat" :class="previousButtonShouldDisable" @click="goToPage(paginationData.current_page - 1)" alt="Previous Page"><i class="fa fa-arrow-left"></i></button>
                <button type="button" class="btn btn-sm btn-primary btn-flat" :class="nextButtonShouldDisable" @click="goToPage(paginationData.current_page + 1)" alt="Next Page"><i class="fa fa-arrow-right" ></i></button>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .paging-container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
    .paging-container .paging-action-containter input.page-input {        
        width: 30px;
        float: left;
    }
    .paging-container .paging-action-containter input.page-input {
        text-align: center;
    }
    .paging-container .paging-action-containter input.page-input,
    .paging-container .paging-action-containter .paging-action-label  {
        position: relative;
        float: left;
        font-size: 12px;
        line-height: 1.5;
        padding: 5px;
        border:1px solid #ddd;
    }
    .paging-container .paging-action-containter .paging-action-label {       
        background-color: #f4f4f4;
    }
</style>
<script>
    export default {        
        filters: {
            nullableString : (value) => {
                return value == null ? "N/A" : value;
            },
            
        },
        props: {
            paginationData: {},
        },
        computed: {            
            previousButtonShouldDisable: function() {
                return { 
                   'disabled': this.paginationData.current_page == 1,  
                }
            },
            nextButtonShouldDisable: function() {
                return {               
                    'disabled': this.paginationData.current_page == this.paginationData.last_page,                   
                }
            }
        },
        methods: {
            isApiPagination: function(response_data) {
                if ( response_data == undefined ) return false;
                return response_data.hasOwnProperty('current_page') &&
                       response_data.hasOwnProperty('from') &&
                       response_data.hasOwnProperty('last_page') &&
                       response_data.hasOwnProperty('path') &&
                       response_data.hasOwnProperty('per_page') &&
                       response_data.hasOwnProperty('to') &&
                       response_data.hasOwnProperty('total');
            },
            goToPage: function(page) {
                if  (page < 1 || page > this.paginationData.last_page) {
                    return false;
                }
                this.$emit('on-pagination-changed', page);
            }
        }
    }
</script>
