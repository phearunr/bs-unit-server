<template> 
    <div class="card">
        <div class="card-header">Action History (Recent):</div>
        <div class="card-body p-0">
            <ul class="list-group" id="action-list">
                <li class="list-group-item" v-for="action in actions">
                    <small>
                        <strong>{{ action.action }} ({{ action.status_action }})</strong> 
                        at <strong>{{ action.created_at }}</strong> 
                        by <strong>{{ action.created_by.name }}</strong>
                        <br>
                        <span v-show="action.description">Remark: {{ action.description }}</span>
                    </small>
                </li>
                <infinite-loading @infinite="infiniteHandler">
                    <div slot="no-more" class="list-group-item list-group-item-action text-center">No more data!</div>
                </infinite-loading>
            </ul>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    #action-list {
        width: 100%;
        height: 400px;
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

<script>
    export default {
        data() {
            return {
                page: 1,
                actions: [],
            };
        },
        props: [ 
            'unitId'
        ],
        methods: {
            infiniteHandler :  function($state) {           
                axios.get(`/admin/units/${this.unitId}/actions`, {
                    params: {
                        page: this.page,
                    },
                }).then(({ data }) => {
                    if (data.data.length) {
                        this.page += 1;
                        this.actions.push(...data.data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
            },
        },
    };
</script>