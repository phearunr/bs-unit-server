<template>	
	<div class="user-activity-container">
		<nav class="nav nav-tabs">
			<li class="nav-item" v-for="tab in tabs" >
				<a class="nav-link" :class="{ active : active_tab == tab.slug }" href="#"  v-on:click="activate(tab)">{{ tab.name }}</a>
			</li>			
		</nav>		
		<div class="bg-white tab-content" id="myTabContent">
			<keep-alive>
				<component v-bind:is="component" v-bind:unit-id="unitId"></component>
			</keep-alive>
		</div>
	</div>
</template>

<script>
	import UnitTransactionTable from '../Units/UnitTransactionTableComponent.vue';
	// import UnitCommentList from '../Units/UnitCommentTabComponent.vue';
	import UnitConstructionProgressTab from '../Units/UnitConstructionProgressTabComponent.vue';

    export default {
    	components: {
    		'unit-transaction-tab': UnitTransactionTable,
    		'unit-construction-progress': UnitConstructionProgressTab,
    	},

        props: [ 
            'unitId'	
        ],

    	data() {
		    return {
		    	tabs: [
		    		{
		    			'name': 'Transactions',
		    			'slug': 'unit-transaction-tab',
		    		},
		    		{
		    			'name': 'Construction Progress',
		    			'slug': 'unit-construction-progress',
		    		}		    		
		    	],
		    	component: 'unit-transaction-tab',
		    	isActive: true,
		    	active_tab: 'unit-transaction-tab'
		    }
		},
		methods:{
		    activate:function(tab){
		    	this.component = tab.slug;
		    	this.active_tab = tab.slug;
		    }
		}
    };
</script>
