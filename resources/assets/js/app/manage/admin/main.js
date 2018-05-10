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
import AgencyList from '../../../../components/manage/agencies/AgencyList.vue';
import AgencyEdit from '../../../../components/manage/agencies/AgencyEdit.vue';
import AdminList from '../../../../components/manage/admin/AdminList.vue';
import AdminEdit from '../../../../components/manage/admin/AdminEdit.vue';
import AutoMail from '../../../../components/manage/automail/MailSetting.vue';
import MailPreview from '../../../../components/manage/automail/MailPreview.vue';
import MailConfirm from '../../../../components/manage/automail/MailConfirm.vue';
import CandidateList from '../../../../components/manage/candidate/CandidateList.vue';
import CandidateEdit from '../../../../components/manage/candidate/CandidateEdit.vue';
import CandidateMail from '../../../../components/manage/candidate/CandidateMail.vue';
import MailCompany from '../../../../components/manage/candidate/MailCompany.vue';
import SendMailCompany from '../../../../components/manage/candidate/SendMailCompany.vue';
import CandidateSendmail from '../../../../components/manage/candidate/CandidateSendmail.vue';
import MailLogs from '../../../../components/manage/automail/MailLogs.vue';
import Mail from '../../../../components/manage/automail/Mail.vue';
import ApplicantSendmail from '../../../../components/manage/application/ApplicantSendmail.vue';
import ApplicationList from '../../../../components/manage/application/ApplicationList.vue';
import ApplicantDetail from '../../../../components/manage/application/ApplicantDetail.vue';
import JobDetail from '../../../../components/manage/application/JobDetail.vue';
import Inbox from '../../../../components/manage/application/Inbox.vue';
import Conversation from '../../../../components/manage/application/Conversation.vue';
import SpecialList from '../../../../components/manage/content_settings/SpecialList.vue';
import LinkList from '../../../../components/manage/content_settings/LinkList.vue';
import UrgentList from '../../../../components/manage/content_settings/UrgentList.vue';
import PickupList from '../../../../components/manage/content_settings/PickupList.vue';
import ExpoList from '../../../../components/manage/content_settings/ExpoList.vue';
import CampaignList from '../../../../components/manage/content_settings/CampaignList.vue';
import AnnouncementList from '../../../../components/manage/content_settings/AnnouncementList.vue';
import ReservationList from '../../../../components/manage/content_settings/ReservationList.vue';
import SpecialEdit from '../../../../components/manage/content_settings/SpecialEdit.vue';
import LinkEdit from '../../../../components/manage/content_settings/LinkEdit.vue';
import UrgentEdit from '../../../../components/manage/content_settings/UrgentEdit.vue';
import PickupEdit from '../../../../components/manage/content_settings/PickupEdit.vue';
import ExpoEdit from '../../../../components/manage/content_settings/ExpoEdit.vue';
import CampaignEdit from '../../../../components/manage/content_settings/CampaignEdit.vue';
import AnnouncementEdit from '../../../../components/manage/content_settings/AnnouncementEdit.vue';
import AnalysisList from '../../../../components/manage/analysis/AnalysisList.vue';
import AnalysisSearch from '../../../../components/manage/analysis/AnalysisSearch.vue';
import FieldList from '../../../../components/manage/field_settings/FieldList.vue';
import FieldEdit from '../../../../components/manage/field_settings/FieldEdit.vue';
import SearchKeyList from '../../../../components/manage/search_keys/SearchKeyList.vue';
import PrefectureList from '../../../../components/manage/search_keys/PrefectureList.vue';
import PrefectureEdit from '../../../../components/manage/search_keys/PrefectureEdit.vue';
import JobKeyList from '../../../../components/manage/search_keys/JobKeyList.vue';
import JobCategoryEdit from '../../../../components/manage/search_keys/JobCategoryEdit.vue';
import WorkingKeyList from '../../../../components/manage/search_keys/WorkingKeyList.vue';
import WorkingEdit from '../../../../components/manage/search_keys/WorkingEdit.vue';
import CurrentStatusList from '../../../../components/manage/search_keys/CurrentStatusList.vue';
import CurrentStatusEdit from '../../../../components/manage/search_keys/CurrentStatusEdit.vue';
import EmploymentModeList from '../../../../components/manage/search_keys/EmploymentModeList.vue';
import EmploymentModeEdit from '../../../../components/manage/search_keys/EmploymentModeEdit.vue';
import SalaryList from '../../../../components/manage/search_keys/SalaryList.vue';
import SalaryEdit from '../../../../components/manage/search_keys/SalaryEdit.vue';
import RegionEdit from '../../../../components/manage/search_keys/RegionEdit.vue';
import MetadataList from '../../../../components/manage/metadata/MetadataList.vue';
import AnalysisAccessRanking from '../../../../components/manage/analysis/AnalysisAccessRanking.vue';
import AnalysisJobType from '../../../../components/manage/analysis/AnalysisJobType.vue';
import AnalysisMerit from '../../../../components/manage/analysis/AnalysisMerit.vue';
import CompanySendEmail from '../../../../components/manage/company/CompanySendEmail.vue';
import CertificateList from '../../../../components/manage/search_keys/CertificateList.vue';
import CertificateEdit from '../../../../components/manage/search_keys/CertificateEdit.vue';
import VideoList from '../../../../components/manage/content_settings/VideoList.vue';
import VideoEdit from '../../../../components/manage/content_settings/VideoEdit.vue';
import InterviewList from '../../../../components/manage/content_settings/InterviewList.vue';
import InterviewEdit from '../../../../components/manage/content_settings/InterviewEdit.vue';
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
    { path: '/agency/list', component: AgencyList },
    { path: '/agency/edit', component: AgencyEdit },
    { path: '/admin/list', component: AdminList },
    { path: '/admin/edit', component: AdminEdit },
    { path: '/candidate/list', component: CandidateList },
    { path: '/candidate/edit', component: CandidateEdit },
    { path: '/candidate/candidate_mail', component: CandidateMail },
    { path: '/candidate/candidate_sendmail', component: CandidateSendmail },
    { path: '/candidate/mail_company', component: MailCompany },
    { path: '/candidate/send_mail_to_company', component: SendMailCompany },
    { path: '/candidate/mail_logs',component: MailLogs },
    { path: '/candidate/mail_logs/preview',component: Mail },
    { path: '/candidate/mail_setting' , component: AutoMail },
    { path: '/candidate/mail_preview' , component: MailPreview },
    { path: '/candidate/mail_confirm' , component: MailConfirm },
    { path: '/candidate/application_list', component: ApplicationList },
    { path: '/candidate/application_list/job', component: ApplicationList , props: (route) => ({ id: route.query.id })},
    { path: '/application/applicant_sendmail', component: ApplicantSendmail },
    { path: '/application/applicant', component: ApplicantDetail },
    { path: '/application/job', component: JobDetail },
    { path: '/candidate/inbox', component: Inbox },
    { path: '/application/inbox/conversations', component: Conversation , props: (route) => ({ id: route.query.id }) },
    { path: '/special/list', component: SpecialList },
    { path: '/special/edit', component: SpecialEdit },
    { path: '/link/list', component: LinkList },
    { path: '/link/edit', component: LinkEdit },
    { path: '/urgent/list', component: UrgentList },
    { path: '/urgent/edit', component: UrgentEdit },
    { path: '/pickup/list', component: PickupList },
    { path: '/pickup/edit', component: PickupEdit },
    { path: '/expo/list', component: ExpoList },
    { path: '/expo/reservations', component: ReservationList },
    { path: '/campaign/list', component: CampaignList },
    { path: '/expo/edit', component: ExpoEdit },
    { path: '/campaign/edit', component: CampaignEdit },
    { path: '/announcement/list', component: AnnouncementList },
    { path: '/announcement/edit', component: AnnouncementEdit },
    { path: '/analysis/list', component: AnalysisList },
    { path: '/analysis/search', component: AnalysisSearch },
    { path: '/analysis/merit', component: AnalysisMerit },
    { path: '/analysis/job-type', component: AnalysisJobType },
    { path: '/analysis/access-ranking', component: AnalysisAccessRanking },
    { path: '/field_settings/list', component: FieldList , props: (route) => ({ table: route.query.table }) },
    { path: '/field_settings/edit', component: FieldEdit },
    { path: '/search_keys/region/list', component: SearchKeyList },
    { path: '/search_keys/region/edit', component: RegionEdit },
    { path: '/search_keys/prefecture/list', component: PrefectureList },
    { path: '/search_keys/prefecture/edit', component: PrefectureEdit },
    { path: '/search_keys/job/list', component: JobKeyList },
    { path: '/search_keys/category_level3/edit', component: JobCategoryEdit },
    { path: '/search_keys/working/list', component: WorkingKeyList },
    { path: '/search_keys/working/edit', component: WorkingEdit },
    { path: '/search_keys/current_status/list', component: CurrentStatusList },
    { path: '/search_keys/current_status/edit', component: CurrentStatusEdit },
    { path: '/search_keys/employment_mode/list', component: EmploymentModeList },
    { path: '/search_keys/employment_mode/edit', component: EmploymentModeEdit },
    { path: '/search_keys/salary/list', component: SalaryList },
    { path: '/search_keys/salary/edit', component: SalaryEdit },
    { path: '/metadata/list', component: MetadataList },
    { path: '/company/company_send_email', component: CompanySendEmail },
    { path: '/search_keys/certificate/list', component: CertificateList },
    { path: '/search_keys/certificate/edit', component: CertificateEdit },
    { path: '/video/list', component: VideoList },
    { path: '/video/edit', component: VideoEdit },
    { path: '/interview/list', component: InterviewList },
    { path: '/interview/edit', component: InterviewEdit },
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
