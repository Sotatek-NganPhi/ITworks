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

import App from '../../../../components/manage/AppAdmin.vue';
import Index from '../../../../components/manage/Index.vue';
import JobList from '../../../../components/manage/job/JobList.vue';
import JobEdit from '../../../../components/manage/job/JobEdit.vue';
import CompanyList from '../../../../components/manage/company/CompanyList.vue';
import CompanyEdit from '../../../../components/manage/company/CompanyEdit.vue';
import AdminList from '../../../../components/manage/admin/AdminList.vue';
import AdminEdit from '../../../../components/manage/admin/AdminEdit.vue';
import CandidateList from '../../../../components/manage/candidate/CandidateList.vue';
import CandidateEdit from '../../../../components/manage/candidate/CandidateEdit.vue';
import CandidateMail from '../../../../components/manage/candidate/CandidateMail.vue';
import MailCompany from '../../../../components/manage/candidate/MailCompany.vue';
import SendMailCompany from '../../../../components/manage/candidate/SendMailCompany.vue';
import CandidateSendmail from '../../../../components/manage/candidate/CandidateSendmail.vue';
import ApplicantSendmail from '../../../../components/manage/application/ApplicantSendmail.vue';
import ApplicationList from '../../../../components/manage/application/ApplicationList.vue';
import ApplicantDetail from '../../../../components/manage/application/ApplicantDetail.vue';
import JobDetail from '../../../../components/manage/application/JobDetail.vue';
import AnalysisList from '../../../../components/manage/analysis/AnalysisList.vue';
import AnalysisSearch from '../../../../components/manage/analysis/AnalysisSearch.vue';
import FieldList from '../../../../components/manage/field_settings/FieldList.vue';
import FieldEdit from '../../../../components/manage/field_settings/FieldEdit.vue';
import AnalysisAccessRanking from '../../../../components/manage/analysis/AnalysisAccessRanking.vue';
import AnalysisJobType from '../../../../components/manage/analysis/AnalysisJobType.vue';
import AnalysisMerit from '../../../../components/manage/analysis/AnalysisMerit.vue';
import CompanySendEmail from '../../../../components/manage/company/CompanySendEmail.vue';
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
Vue.component('postal-code', require('../../../../components/common/PostalCode.vue'));
require('../../../lib/growl');


Vue.use(VueRouter);
Vue.use(VueI18n);
Vue.use(VueQuillEditor);
Vue.component(Multiselect);

const locale = Utils.qs('lang');
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
    { path: '/', component: Index },
    { path: '/job/list', component: JobList },
    { path: '/job/edit', component: JobEdit },
    { path: '/company/list', component: CompanyList },
    { path: '/company/edit', component: CompanyEdit },
    { path: '/admin/list', component: AdminList },
    { path: '/admin/edit', component: AdminEdit },
    { path: '/candidate/list', component: CandidateList },
    { path: '/candidate/edit', component: CandidateEdit },
    { path: '/candidate/candidate_mail', component: CandidateMail },
    { path: '/candidate/candidate_sendmail', component: CandidateSendmail },
    { path: '/candidate/mail_company', component: MailCompany },
    { path: '/candidate/send_mail_to_company', component: SendMailCompany },
    { path: '/candidate/application_list', component: ApplicationList },
    { path: '/candidate/application_list/job', component: ApplicationList , props: (route) => ({ id: route.query.id })},
    { path: '/application/applicant_sendmail', component: ApplicantSendmail },
    { path: '/application/applicant', component: ApplicantDetail },
    { path: '/application/job', component: JobDetail },
    { path: '/field_settings/list', component: FieldList , props: (route) => ({ table: route.query.table }) },
    { path: '/field_settings/edit', component: FieldEdit },
    { path: '/company/company_send_email', component: CompanySendEmail },
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
