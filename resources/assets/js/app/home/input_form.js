import Vue from 'vue';
import validator from '../../../directives/validator';
Vue.directive('validator', validator);

Vue.component('form-group', require('../../../components/common/FormGroup.vue'));
Vue.component('validation-form', require('../../../components/common/ValidationForm.vue'));
Vue.component('phone-input', require('../../../components/common/PhoneInput.vue'));

var app = new Vue({
  el: '#input_form'
}); 

export default app;
