<template>
    <button v-if="!isLastPage" class="btn btn-sm btn-primary mx-auto d-block my-4" @click="goToPage(paginationData.current_page + 1)">Load More..</button>
    <p v-else class="text-center text-muted">No more data to display</p>
</template>

<style lang="scss" scoped>
   
</style>
<script>
    export default {
        computed : {
            isLastPage: function() {
                return this.paginationData.current_page == this.paginationData.last_page; 
            },
        },
        props: {
            paginationData: {},
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
                this.$emit('on-load-more-button-clicked', page);
            }
        }
    }
</script>
