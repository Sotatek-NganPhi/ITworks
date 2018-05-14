<template>
  <div>
    <validation-form ref="candidateForm" style="margin-bottom: 70px">
      <!-- BASIC INFORMATION - START -->
      <div>
        <span class="glyphicon glyphicon-triangle-bottom"></span>
        <span>{{$t('candidate_list.basic_info')}}</span>
      </div>

      <form-group :label="$t('common_field.id')">
        <input class="form-control" id="input-id" type="text" v-model="record.id" disabled/>
      </form-group>

      <form-group :label="$t('candidate.name')" :is-required="isFieldRequired('user.name')">
        <input data-vv-name="user.name" class="form-control" type="text" v-model="record.user.name"/>
      </form-group>

      <form-group :label="$t('common_field.birthday')" :is-required="isFieldRequired('user.birthday')">
        <date-picker data-vv-name="user.birthday" v-model="record.user.birthday" format="YYYY-MM-DD" locale="ja"/>
      </form-group>

      <form-group :label="$t('common_field.address')" :is-required="isFieldRequired('user.address')">
        <input data-vv-name="user.address" class="form-control" type="text" v-model="record.user.address"/>
      </form-group>

      <form-group :label="$t('common_field.phone_number')" :is-required="isFieldRequired('user.phone_number')">
        <phone-input v-model="record.user.phone_number"></phone-input>
      </form-group>

      <form-group :label="$t('common_field.email')">
        <input data-vv-name="user.email" class="form-control" type="text" v-model="record.user.email" disabled/>
      </form-group>

      <form-group :label="$t('common_field.gender')">
        <radio-group data-vv-name="user.gender" inline="true" v-model="record.user.gender" :options="genderOptions"/>
      </form-group>

      <form-group :label="$t('candidate.registed_date')">
        <input class="form-control" type="text" v-model="record.user.created_at" locale="ja" disabled/>
      </form-group>

      <form-group :label="$t('candidate.mail_receivable')">
        <radio-group
          inline="true"
          v-model="record.user.mail_receivable"
          :options="mailReceivableOptions"/>
      </form-group>
      <!-- BASIC INFORMATION - END -->

      <!-- ADDITIONAL INFORMATION - START -->
      <div>
        <span class="glyphicon glyphicon-triangle-bottom"></span>
        <span>{{$t('candidate_list.additional_info')}}</span>
      </div>

      <form-group :label="getDisplayName('education_id')" :is-required="isFieldRequired('education_id')">
        <radio-group data-vv-name="education_id" inline="true" label="name" v-model="record.education_id" :options="masterdata.educations"/>
      </form-group>

      <form-group :label="getDisplayName('final_academic_school')" :is-required="isFieldRequired('final_academic_school')">
        <input data-vv-name="final_academic_school" class="form-control" type="text" v-model="record.final_academic_school"/>
      </form-group>

      <form-group :label="getDisplayName('graduated_at')" :is-required="isFieldRequired('graduated_at')">
        <date-picker data-vv-name="graduated_at" v-model="record.graduated_at" format="YYYY-MM-DD"></date-picker>
      </form-group>

      <!-- ADDITIONAL INFORMATION - END -->
      <!-- EXPECTATION - START -->
      <div><span class="glyphicon glyphicon-triangle-bottom"></span> <span>{{$t('candidate_list.expect')}}</span></div>

      <form-group :label="$t('candidate.salary')" :is-required="isFieldRequired('salaries')">
        <checkbox-group data-vv-name="salaries" inline="true" label="description" v-model="record.salaries" :options="masterdata.salaries"/>
      </form-group>

      <form-group :label="$t('job_edit.working_days')" :is-required="isFieldRequired('working_days')">
        <checkbox-group data-vv-name="workingDays" inline="true" label="name" v-model="record.workingDays" :options="masterdata.working_days"/>
      </form-group>

      <form-group :label="$t('job_edit.working_hours')" :is-required="isFieldRequired('working_hours')">
        <checkbox-group data-vv-name="workingHours" inline="true" label="name" v-model="record.workingHours" :options="masterdata.working_hours"/>
      </form-group>

      <form-group :label="getDisplayName('prefectures')" :is-required="isFieldRequired('prefectures')">
        <multiselect
          data-vv-name="prefectures"
          v-model="selectedPrefectures"
          :placeholder="$t('common_action.pick')"
          label="name"
          track-by="id"
          :options="masterdata.prefectures"
          :multiple="true"
          :close-on-select="false"
          :clear-on-select="false"
          :hide-selected="true"></multiselect>
      </form-group>
      <!-- EXPECTATION - END -->

      <!-- OTHERS - START -->
      <div><span class="glyphicon glyphicon-triangle-bottom"></span> <span>{{$t('candidate_list.other')}}</span></div>

      <form-group :label="getDisplayName('toeic')" :is-required="isFieldRequired('toeic')">
        <input data-vv-name="toeic" class="form-control" type="number" v-model="record.toeic"/>
      </form-group>

      <form-group :label="getDisplayName('toefl')" :is-required="isFieldRequired('toefl')">
        <input data-vv-name="toefl" class="form-control" type="number" v-model="record.toefl"/>
      </form-group>

      <form-group :label="getDisplayName('language_conversation_level_id')" :is-required="isFieldRequired('language_conversation_level_id')">
        <radio-group  data-vv-name="language_conversation_level_id" inline="true" label="description" v-model="record.language_conversation_level_id" :options="masterdata.language_conversation_levels"/>
      </form-group>

      <form-group :label="getDisplayName('language_experience_id')" :is-required="isFieldRequired('language_experience_id')">    <radio-group  data-vv-name="language_experience_id" inline="true" label="description" v-model="record.language_experience_id" :options="masterdata.language_experiences"/>    
     </form-group>

      <form-group :label="getDisplayName('certificate')" :is-required="isFieldRequired('certificate')">
        <multiselect
          data-vv-name="certificate"
          v-model="selectedCertificate"
          :placeholder="$t('common_action.pick')"
          label="name"
          track-by="id"
          :options="masterdata.certificates"
          :multiple="true"
          :close-on-select="false"
          :clear-on-select="false"
          :hide-selected="true"></multiselect>
      </form-group>
      <!-- OTHERS - END -->
    </validation-form>

    <div class="col-sm-12">
      <div class="text-center btn-control">
        <button type="button" class="btn btn-primary btn-sm" @click="showModal()">
          <span class="glyphicon glyphicon-ok"></span> {{$t("common_action.ok")}}
        </button>
        <button type="button" class="btn btn-default btn-sm" @click="resetChange()">
          <span class="glyphicon glyphicon-remove"></span> {{$t("common_action.cancel")}}
        </button>
      </div>
    </div>

    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="updateChange" :message="$t('message.before_update')">
    </confirmation-dialog>

  </div>
</template>

<script>
import _ from 'lodash';
import moment from 'moment';
import Multiselect from 'vue-multiselect';
import rf from '../../../js/lib/RequestFactory';
import Utils from '../../../js/common/Utils';
import {user} from '../../../js/app/manage/main';
import queryString from 'querystring';
import {candidateNavigators as subNavigators} from '../../../js/app/manage/routes';
import QueryBuilder from '../../../js/lib/QueryBuilder';
const masterdata = {
  prefectures: [],
  certificates: [],

};
const defaultCandidate = {
  user: {},
};
export default {
  components: {
    Multiselect
  },
  data() {
    return {
      user,
      subNavigators,
      masterdata,
      record: defaultCandidate,
      selectedPrefectures: [],
      selectedCertificate: [],
      genderOptions: Utils.getGenders(),
      mailReceivableOptions: Utils.getYesNoOptions(),
      isShowModal: false
    };
  },
  methods: {
    isFieldRequired(fieldName) {
      return Utils.isFieldRequired(this.masterdata, 'candidates', fieldName);
    },
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'candidates', fieldName);
    },
    updateChange() {
      this.isShowModal = false;
      this.record.prefectures = _.map(this.selectedPrefectures, 'id');
      this.record.certificates = _.map(this.selectedCertificate, 'id');
      rf.getRequest('CandidateRequest')
        .updateOne(this.record.id, this.record)
        .then(res => {
          this.$refs.candidateForm.$emit('FORM_ERRORS_CLEAR');
          Utils.growl('request.request_success');
          if(!this.record.id) {
            this.$router.push({
              path: '/job/list',
            });
          }
        })
        .catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.candidateForm.$emit('REJECT_FORM', validationErrors);
          }
        });
    },
    showModal() {
      this.isShowModal = true;
    },
    resetChange() {
      this.$router.push({
        path: '/candidate/list',
      });
    },
    localReset() {
      this.selectedPrefectures = _.map(this.record.prefectures, prefId =>
        _.find(this.masterdata.prefectures, pref => pref.id === prefId));
      this.selectedCertificate = _.map(this.record.certificates, prefId =>
        _.find(this.masterdata.certificates, pref => pref.id === prefId));
    },
  },
  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const id = this.$route.query.id;
    const candidatePromise = rf.getRequest('CandidateRequest').getOne(id);
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    Promise.all([candidatePromise, masterdataPromise]).then(([candidate, masterdata]) => {
      this.record = candidate;
      this.masterdata = masterdata;
      this.localReset();
    });
  }
}
</script>

<style scoped>
  .btn-control {
    position: fixed;
    padding: 20px;
    left: 0px;
    bottom: 0px;
    width:100%;
    height: auto;
    background:rgb(245, 248, 250);
    z-index: 101;
  }
  .has-error .multiselect,
  .has-error .name-file,
  .has-error .quill-editor {
    border: #a94442 1px solid !important;
    border-radius: 4px;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  }
</style>
