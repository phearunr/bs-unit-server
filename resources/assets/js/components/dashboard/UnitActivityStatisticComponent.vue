<template>
	<div class="chart-container">
		<div class="row mb-2" style="height: 52px;">
			<div class="col-md">
				<h5 class="mb-0">Unit Requests</h5>	
				<span class="text-secondary font-weight-light font-italic">All units which were encoded into system.</span>	
			</div>
			<div class="col-md">
				<div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
				 	<button type="button" class="btn btn-primary" v-bind:class="{ active: obj.active }" v-for="obj in dateRange" v-on:click="dateButtonSelectionChanged(obj)">{{ obj.text }}</button>
				</div>
				<span class="text-secondary font-weight-light font-italic d-block float-right"><small>{{ dateLabel }}</small></span>
			</div>	
		</div>
	   	<line-chart :chart-data="datacollection" :options="chartOption" :height="height"></line-chart>
	</div>
</template>

<script>
import LineChart from '../chartjs/LineChart.vue';
import ChartDataLabels from 'chartjs-plugin-datalabels';

export default {
  	components: { LineChart },
  	props: ['height', 'width'],
  	data () {
      	return {
	        datacollection: null,
	        chartOption: null,
	    	dateRange: [],
	    	selectedDateRange: null,
	    	dateLabel: "",
      	}
    },
	methods: {
		fillData (obj) {
			axios.get(`/api/unit_requests/statistic`, {
      			params: {
      				from: this.selectedDateRange.start.format('YYYY-MM-DD'),
      				to: this.selectedDateRange.end.format('YYYY-MM-DD'),
      				group_by: this.selectedDateRange.group_by
      			},
      		})
      		.then( response => {
      			const data = response.data.data;
      			this.datacollection = {
          			labels: data.UnitHoldRequest.map(record => record.date),
          			datasets: [
	            		{
	              			label: 'Hold',
			              	borderColor: 'rgb(255, 193, 7)',
			            	fill: false,
			            	borderWidth: 1,
	        		     	data: data.UnitHoldRequest.map(record => record.count)
	            		}, {
	              			label: 'Deposit',
	              			borderColor: 'rgb(23, 162, 184)',
			            	fill: false,
			            	borderWidth: 1,
	              			data: data.UnitDepositRequest.map(record => record.count)
	            		}, {
	              			label: 'Contract',
	              			borderColor: 'rgb(40, 167, 69)',
			            	fill: false,
			            	borderWidth: 1,
	              			data: data.UnitContractRequest.map(record => record.count)
	            		}
	          		]
	        	}; 
	        	this.chartOption = {
			    	legend: {
			    		display: true,
			    		position: 'bottom',
			    	},	
			    	scales: {
				        yAxes: [{
				            ticks: {
				                beginAtZero: true
				            }
				        }]
				    },
		        	maintainAspectRatio: false,		        	
			    }
      		})
      		.catch( error => {
      			console.log(error);
      		});
      	},
		calDateLabel: function(obj) {
			this.dateLabel = `${obj.start.format('ll')} - ${obj.end.format('ll')}`;
		},
		dateButtonSelectionChanged: function (obj) {
			this.dateRange.map(function (ele, i) { ele.active = false; });
			obj.active = true;
			this.selectedDateRange = obj;			
			this.calDateLabel(obj);	
			this.fillData(obj);
		}
	},
	mounted () {
		this.dateRange.push({ start: moment().startOf('Week'), end: moment().endOf('Week'), text: 'This Week', active: true, group_by: "DAY"});
		this.dateRange.push({ start: moment().startOf('Month'), end: moment().endOf('Month'), text: 'This Month', active: false, group_by: "DAY"});
		this.dateRange.push({ start: moment().subtract(2, 'Months').startOf('Month'), end:  moment().endOf('Month'), text: '3M', active: false, group_by: 'MONTH'});
		this.dateRange.push({ start: moment().subtract(5, 'Months').startOf('Month'), end: moment().endOf('Month'), text: '6M', active: false, group_by: "MONTH"});
		this.dateRange.push({ start: moment().subtract(11, 'Months').startOf('Month'), end: moment().endOf('Month'), text: '1Y', active: false, group_by: "MONTH"});
		this.dateRange.push({ start: moment('2019-01-01'), end: moment().endOf('Month'), text: 'All', active: false, group_by: "YEAR"});
		this.dateButtonSelectionChanged(this.dateRange[0]);
		
	},
	created () {
		
	}
}
</script>

<style>
</style>