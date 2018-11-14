
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('fhk-drop', require('./components/DropDownComponent.vue'));
Vue.component('fhk-radio', require('./components/RadioComponent.vue'));
Vue.component('fhk-check', require('./components/CheckBoxComponent.vue'));
Vue.component('fhk-input', require('./components/InputComponent.vue'));
Vue.component('fhk-button', require('./components/ButtonComponent.vue'));
Vue.component('fhk-modal', require('./components/ModalComponent.vue'));
Vue.component('fhk-crud-list', require('./components/CrudListComponent.vue'));
Vue.component('fhk-total-list', require('./components/BasicTotalComponent.vue'));

//app related input
Vue.component('app-user', require('./components/app/UserComponent.vue'));
Vue.component('app-party', require('./components/app/PartyComponent.vue'));
Vue.component('app-payment', require('./components/app/PaymentComponent.vue'));
Vue.component('app-product', require('./components/app/ProductComponent.vue'));
Vue.component('app-outreceipt', require('./components/app/OutReceiptComponent.vue'));
Vue.component('app-outreceiptentry', require('./components/app/OutReceiptEntryComponent.vue'));
Vue.component('app-inreceipt', require('./components/app/InReceiptComponent.vue'));
Vue.component('app-inreceiptentry', require('./components/app/InReceiptEntryComponent.vue'));
Vue.component('app-expensetype', require('./components/app/ExpenseTypeComponent.vue'));
Vue.component('app-passiveprofit', require('./components/app/PassiveProfitComponent.vue'));

//output
//Vue.component('app-creditlist', require('./components/app/query/CreditListComponent.vue'));
//Vue.component('app-salesheet', require('./components/app/query/SaleSheetComponent.vue'));


//mixin
Vue.mixin({
	methods: {
		clone: function(obj) {
	        if (null == obj || "object" != typeof obj) return obj;
	        var copy = obj.constructor();
	        for (var attr in obj) {
	            if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
	        }
	        return copy;
	    },
	    updateHelper: function(controller, helperData, callBack){
	        axios.get('/'+ controller).then((response)=>{
	            callBack(helperData, response.data); //
	        }).catch((error)=>{console.log(error.response.data)});
	    },
	    test: function(){
	    	alert("Test works!");
		},  
		token: function(){
            axios.get('/token').then((response)=>{
                console.log(response.data)
            }).catch((error)=>{console.log(error.response.data)});
        },
	},
});

const app = new Vue({
    el: '#app',
});
