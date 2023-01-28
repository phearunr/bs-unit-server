<template>	
	<div class="user-activity-container">
		<nav class="nav nav-tabs">
			<li class="nav-item" v-for="tab in tabs" >
				<a class="nav-link" :class="{ active : active_tab == tab.slug }" href="#"  v-on:click="activate(tab)">{{ tab.name }}</a>
			</li>			
		</nav>		
		<keep-alive>
			<component v-bind:is="component" v-bind:user-id="userId"></component>
		</keep-alive>
	</div>
</template>

<script>
	import HoldComponent from '../UnitHoldRequests/UnitHoldRequestListComponent.vue';
	import DepositComponent from '../UnitDepositRequests/UnitDepositRequestListComponent.vue';
	import ContractComponent from '../UnitContractRequests/UnitContractRequestListComponent.vue';

    export default {
    	components: {
    		'hold-request': HoldComponent,
    		'deposit-request': DepositComponent,
    		'contract-request': ContractComponent
    	},

        props: [ 
            'userId'
        ],

    	data() {
		    return {
		    	tabs: [
		    		{
		    			'name': 'Hold',
		    			'slug': 'hold-request',
		    		},
		    		{
		    			'name': 'Deposit',
		    			'slug': 'deposit-request',
		    		},
		    		{
		    			'name': 'Contract',
		    			'slug': 'contract-request',
		    		},
		    	],
		    	component: 'hold-request',
		    	isActive: true,
		    	active_tab: 'hold-request'
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
