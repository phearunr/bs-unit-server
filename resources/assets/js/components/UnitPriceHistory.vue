<style lang="scss" scoped>
    #action-list {
        width: 100%;
        height: 250px;
        overflow: auto;
        position: relative;
        .list-group-item-secondary {
            position: sticky;
            z-index: 999;
            width: 100%;
            top: 0px;
        }
    }
</style>

<template>
    <div class="row mt-4">
        <div class="col">
            <ul class="list-group" id="action-list">
                <li class="list-group-item list-group-item-secondary">Unit Price History (Recent):</li>
                <li class="list-group-item" v-for="activity in activities">
                    <small>
                        <strong>{{ activity.field_name | upText }}</strong> 
                        : <strong>$ {{ activity.old_value | toCurrencyUSD }}</strong> 
                        to <strong>$ {{ activity.new_value | toCurrencyUSD }}</strong>
                        at <strong>{{ activity.created_at }}</strong>
                        by <strong>{{ activity.user.name }}</strong>
                    </small>
                </li>
                <infinite-loading @infinite="infiniteHandlerActivity">
                    <div slot="no-more" class="list-group-item list-group-item-action text-center">No more data!</div>
                </infinite-loading>
            </ul>
        </div>  
    </div>
</template>

<script>
    export default {
        data() {
            return {
                page: 1,
                activities: [],
            };
        },
        props: [ 
            'unitId'
        ],
        methods: {
            infiniteHandlerActivity($state) {
                axios.get(`/admin/units/${this.unitId}/activities`, {
                    params: {
                        page: this.page,
                    },
                }).then(({ data }) => {
                    if (data.data.length) {
                        this.page += 1;
                        this.activities.push(...data.data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
            }
        },
    };
</script>
