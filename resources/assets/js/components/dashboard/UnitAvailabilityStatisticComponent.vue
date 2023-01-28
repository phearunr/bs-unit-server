<template>
	<div class="chart-container">
		<div class="row mb-2" style="height: 52px;">
			<div class="col-md">
				<h5 class="mb-0">Units Availability</h5>	
				<span class="text-secondary font-weight-light font-italic">All units which were encoded into system.</span>	
			</div>		
		</div>
	   	<doughnut-chart :chart-data="datacollection" :options="chartOption" :height="height"></doughnut-chart>
	</div>
</template>


<script>
import DoughnutChart from '../chartjs/DoughnutChart.vue';
import ChartDataLabels from 'chartjs-plugin-datalabels';

export default {
	components: { DoughnutChart },
	props: ['height', 'width'],
  	data() {
  		return {
	        datacollection: null,
	        chartOption: null,	    
      	}
  	},
  	methods: {
  		fillData () {
			axios.get(`/api/units/report/availabilityStatistic`)
      		.then( response => {
      			const data = response.data.data;      			
      			this.datacollection = {
          			labels: data.map(item => item.action),
          			datasets: [{
          				label: 'Unit Status',
          				data: data.map(item => item.count),
          				backgroundColor: [
			                'rgba(0, 123, 255, 0.7)',
			                'rgba(40, 167, 69, 0.7)',
			                'rgba(23, 162, 184, 0.7)',
			                'rgba(255, 193, 7, 0.7)',
			                'rgba(220, 53, 69, 0.7)'
			            ],
			            borderColor: [
			                'rgba(0, 123, 255, 1)',
			                'rgba(40, 167, 69, 1)',
			                'rgba(23, 162, 184, 1)',
			                'rgba(255, 193, 7, 1)',
			                'rgba(220, 53, 69, 1)'
			            ],
			            borderWidth: 1
          			}]
	        	}; 
	        	this.chartOption = {
			    	legend: {
			    		display: true,
			    		position: 'bottom',
			    		onClick: null,
			    		labels: {
				          	generateLabels: function(chart) {		          		
				          		return Chart.helpers.isArray(chart.data.labels) ? chart.data.labels.map(function(item, i) {
				          			return {
					                	text: item + " (" + chart.data.datasets[0].data[i] + ")",
					                	fillStyle: chart.data.datasets[0].backgroundColor[i],
					                	strokeStyle: chart.data.datasets[0].borderColor[i],
					                	lineWidth: 1,
					                	datasetIndex: i
					              	};
				          		}, this) : [];
					        },
				        },
			    	},
			    	cutoutPercentage: 60,
			    	maintainAspectRatio: false,	    
			        plugins: {
			            datalabels: {
			            	color: '#FFF',		            
			                formatter: function(value, context) {	 
			                	let sum = 0;
		                		let dataArr = context.chart.data.datasets[0].data;
				                dataArr.map(data => {
				                    sum += data;
				                });
			                    return (value*100/sum).toFixed(2) + '%';
			         		},
			            }
			        }
			    }
      		})
      		.catch( error => {
      			console.log(error);
      		});
      	},
  	},
	mounted () {	
		this.fillData();			
	}
}
</script>

<style>
</style>