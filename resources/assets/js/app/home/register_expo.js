import Vue from 'vue';
Vue.component('phone-input', require('../../../components/common/PhoneInput.vue'));
Vue.component('validation-form', require('../../../components/common/ValidationForm.vue'));
Vue.component('form-group', require('../../../components/common/FormGroup.vue'));
var app = new Vue({
  el: '#register-expo'
});

export default app;

