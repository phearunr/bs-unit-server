<template>
   <div class="filter-container">
        <div class="input-group input-group-flat search-control">
            <input type="text" class="form-control" placeholder="Enter some text to begin search..."
                v-model="criteria.term"
                v-on:keyup.enter="submit"
            >
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-flat"><i class="fa fa-search" aria-hidden="true"
                    @click="submit"
                ></i> <span class="hidden-xs">Find</span></button>            
            </span>
        </div>
       
    </div>
</template>

<script>
    export default {
        data: () => {
            return {
                criteria : {
                    term: '',
                    fitler: {},
                },
            };
        },       
        methods : { 
            submit : function () {
                this.$emit('on-search-term-changed', this.criteria);
            },
        }
    }
</script
