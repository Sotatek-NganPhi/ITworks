import Vue from 'vue';
import VueRouter from 'vue-router';
import VueI18n from 'vue-i18n';
import Multiselect from 'vue-multiselect';
import VueQuillEditor from 'vue-quill-editor';
import Utils from '../../../common/Utils';
import messages from '../messages';
import jQuery from 'jquery';

import validator from '../../../../directives/validator';

import booleanlize from '../../../../filters/boolean';
import gender from '../../../../filters/gender';
import marry from '../../../../filters/marry';
import originalState from '../../../../filters/originalState';
import platformlize from '../../../../filters/platformlize';
import number from '../../../../filters/number';
import date from '../../../../filters/date';

import App from '../../../../components/manage/AppCompany.vue';
import ApplicantSendmail from '../../../../components/manage/application/ApplicantSendmail.vue';
import ApplicantDetail from '../../../../components/manage/application/ApplicantDetail.vue';
import JobDetail from '../../../../components/manage/application/JobDetail.vue';
import Inbox from '../../../../components/manage/application/Inbox.vue';
import Conversation from '../../../../components/manage/application/Conversation.vue';
import ApplicationList from '../../../../components/manage/application/ApplicationList.vue';
import RequestFactory from '../../../lib/RequestFactory';
Vue.component('form-group', require('../../../../components/common/FormGroup.vue'));
Vue.component('radio-group', require('../../../../components/common/RadioGroup.vue'));
Vue.component('checkbox-group', require('../../../../components/common/CheckboxGroup.vue'));
Vue.component('validation-form', require('../../../../components/common/ValidationForm.vue'));
Vue.component('data-table', require('../../../../components/common/DataTable/DataTable.vue'));
Vue.component('dt-item-chekbox', require('../../../../components/common/DataTable/ItemCheckbox.vue'));
Vue.component('dt-list-items-chekbox', require('../../../../components/common/DataTable/ListItemsCheckbox.vue'));
Vue.component('date-picker', require('../../../../components/common/DatetimePicker/DatePicker.vue'));
Vue.component('datetime-picker', require('../../../../components/common/DatetimePicker/DatetimePicker.vue'));
Vue.component('ConfirmationDialog', require('../../../../components/common/ConfirmationDialog.vue'));
Vue.component('phone-input', require('../../../../components/common/PhoneInput.vue'));
require('../../../lib/growl');


Vue.use(VueRouter);
Vue.use(VueI18n);
Vue.use(VueQuillEditor);
Vue.component(Multiselect);

const locale = Utils.qs('lang') || 'en';
const i18n = new VueI18n({
  locale,
  messages,
});

Vue.directive('validator', validator);

Vue.filter('platformlize', platformlize);
Vue.filter('number', number);
Vue.filter('boolean', booleanlize);
Vue.filter('gender', gender);
Vue.filter('marry',marry);
Vue.filter('state', originalState);
Vue.filter('date', date);

window.jQuery = jQuery;
window.i18n = i18n;
window.Utils = Utils;

if ((~window.navigator.userAgent.indexOf('MSIE')) ||
  (~window.navigator.userAgent.indexOf('Trident/')) ||
  (~window.navigator.userAgent.indexOf('Edge/'))) {
  window.Promise = require('es6-promise').Promise;
  require('es6-object-assign').polyfill();
}

export var router = new VueRouter({
  routes: [
    { path: '/', redirect: '/candidate/application_list' },
    { path: '/candidate/application_list/job', component: ApplicationList , props: (route) => ({ id: route.query.id })},
    { path: '/application/applicant_sendmail', component: ApplicantSendmail },
    { path: '/application/applicant', component: ApplicantDetail },
    { path: '/application/job', component: JobDetail },
    { path: '/candidate/inbox', component: Inbox },
    { path: '/application/inbox/conversations', component: Conversation , props: (route) => ({ id: route.query.id }) }
  ]
});

// TODO: correct the credentials
RequestFactory.setCredentials(null, null);

export var user = null;
export const EventBus = new Vue();
window.EventBus = EventBus;

window.app = new Vue({
  i18n,
  router,
  render: (h) => h(App)
}).$mount('#app');
