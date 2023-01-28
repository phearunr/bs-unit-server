
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.moment = require('moment');

import Vue2Filters from 'vue2-filters';
Vue.use(Vue2Filters);

import Photoswipe from 'vue-pswipe';
Vue.use(Photoswipe);

import 'vue2-datepicker/index.css';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('infinite-loading', require('vue-infinite-loading').default);
Vue.component('unit-action-history', require('./components/ActionHistory.vue').default);
Vue.component('unit-price-history', require('./components/UnitPriceHistory.vue').default);
Vue.component('unit-price-history-button', require('./components/Units/UnitPriceHistoryButtonComponent.vue').default);
Vue.component('user-member-component', require('./components/Users/UserMemberComponent.vue').default);
Vue.component('user-activities-component', require('./components/Users/UserActivitiesComponent.vue').default);
Vue.component('unit-availability-statistic', require('./components/dashboard/UnitAvailabilityStatisticComponent').default);
Vue.component('unit-activity-statistic', require('./components/dashboard/UnitActivityStatisticComponent').default);
Vue.component('unit-transaction-table', require('./components/Units/UnitTransactionTableComponent').default);
Vue.component('unit-comment-list', require('./components/Units/UnitCommentListComponent').default);
Vue.component('unit-construction-progress', require('./components/Units/UnitConstructionProgressComponent').default);
Vue.component('unit-construction-procedure', require('./components/UnitConstructionProcedures/UnitConstructionProcedureList').default);

Vue.component('purchase-request-comment-list', require('./components/PurchaseRequests/PurchaseRequestCommentListComponent').default);
Vue.component('unit-handover-request-comment-list', require('./components/UnitHandoverRequests/UnitHandoverRequestCommentListComponent').default);

Vue.component('user-summary-card', require('./components/Users/UserSummaryItemCardComponent').default);
Vue.component('unit-tabs', require('./components/Units/UnitTabsComponent').default);
Vue.component('project-master-plan', require('./components/Projects/MasterPlanComponent').default);
Vue.component('project-master-plan-sale', require('./components/Projects/MasterPlanForSaleComponent').default);
Vue.component('availability-masterplan', require('./components/Projects/AvailabilityMasterPlanComponent').default);
Vue.component('construction-masterplan', require('./components/Projects/ConstructionMasterPlanComponent').default);
Vue.component('audit-log-list', require('./components/utils/AuditLogListComponent').default);
Vue.component('datepicker', require('vue2-datepicker').default);
Vue.component('v-modal', require('./components/utils/ModalComponent').default);

Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('diffForHuman', function (date) {
	return moment(date).fromNow();
});

Vue.filter('formatDate', function (date) {
	return moment(date).format("DD MMM, YYYY");
})

Vue.filter('toCurrencyUSD', function(value) {
	let val = (value/1).toFixed(2).replace(',', '.')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
});

const app = new Vue({
    el: '#app'
});
