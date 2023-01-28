<template>
    <div class="unit-hold-list">
        <unit-hold-item-card  
            v-for="(hold, index) in holds"
                :key="index"
                :hold="hold"
        ></unit-hold-item-card>      
    </div>
  
</template>

<script>
    import UnitHoldItemCard from '@/components/UnitHoldRequest/UnitHoldRequestItemCardComponent.vue';

    export default {
        components : {
            'unit-hold-item-card' : UnitHoldItemCard,            
        },
        data() {
            return {
                page: 1,
                holds: [],
                total: 0,
            };
        },
        props: [
            'userId'
        ],
        methods: {
            infiniteHandlerHolds :  function($state) {
                axios.get(`/api/users/${this.userId}/holds`, {
                    params: {
                        page: this.page
                    },
                }).then(({ data }) => {
                    if (data.data.length) {
                        this.page += 1;
                        this.holds.push(...data.data); 
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
