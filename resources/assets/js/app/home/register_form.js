import Vue from 'vue';
import validator from '../../../directives/validator';

Vue.directive('validator', validator);

Vue.component('date-picker', require('../../../components/common/DatetimePicker/DatePicker.vue'));
Vue.component('datetime-picker', require('../../../components/common/DatetimePicker/DatetimePicker.vue'));

Vue.component('form-group', require('../../../components/common/FormGroup.vue'));
Vue.component('validation-form', require('../../../components/common/ValidationForm.vue'));

var app = new Vue({
  el: '#register_from',
  mounted(){
    $(".certificate-group").click(function () {
      var parent = $(this).parent();
      var certificateChild = $(parent).find(".certificate-child");
      if ($(certificateChild).is(":visible")) {
        $(certificateChild).hide();
      } else {
        $(certificateChild).show();
      }
    });
  }
});

export default app;
