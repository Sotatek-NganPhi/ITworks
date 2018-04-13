<template>
  <div>
    <validation-form ref="companyForm" style="margin-bottom: 70px">
      <form-group :label="getDisplayName('username')" :is-required="isFieldRequired('username')">
        <input data-vv-name="username" class="form-control" type="text" v-model="record.username" />
      </form-group>
      <form-group :label="getDisplayName('password')" :is-required="isFieldRequired('password')">
        <input data-vv-name="password" class="form-control" type="text" v-model="record.password" />
      </form-group>
      <form-group :label="getDisplayName('name')" :is-required="isFieldRequired('name')">
        <input data-vv-name="name" class="form-control" type="text" v-model="record.name" />
      </form-group>
      <form-group :label="getDisplayName('name_phonetic')" :is-required="isFieldRequired('name_phonetic')">
        <input class="form-control" data-vv-name="name_phonetic" type="text" v-model="record.name_phonetic" />
      </form-group>
      <form-group :label="getDisplayName('street_address')" :is-required="isFieldRequired('street_address')">
        <input class="form-control" data-vv-name="street_address" type="text" v-model="record.street_address" />
      </form-group>
      <form-group :label="getDisplayName('contact_name')" :is-required="isFieldRequired('contact_name')">
        <input class="form-control" data-vv-name="contact_name" type="text" v-model="record.contact_name" />
      </form-group>
      <form-group :label="getDisplayName('phone_number')" :is-required="isFieldRequired('phone_number')">
        <phone-input  data-vv-name="phone_number" v-model="record.phone_number" ></phone-input>
      </form-group>
      <form-group :label="getDisplayName('short_description')" :is-required="isFieldRequired('short_description')">
        <input class="form-control" data-vv-name="short_description"  type="text" v-model="record.short_description" />
      </form-group>
      <form-group :label="getDisplayName('company_hp')" :is-required="isFieldRequired('company_hp')">
        <input class="form-control" data-vv-name="company_hp"  type="text" v-model="record.company_hp" />
      </form-group>
      <form-group :label="getDisplayName('expire_date')" :is-required="isFieldRequired('expire_date')">
        <date-picker data-vv-name="expire_date" v-model="record.expire_date" format="YYYY-MM-DD" locale="ja" required></date-picker>
      </form-group>
      <form-group :label="getDisplayName('is_active')" :is-required="isFieldRequired('is_active')">
        <radio-group inline="true" data-vv-name="is_active" v-model="record.is_active" :options="isActiveOptions"/>
      </form-group>
      <form-group :label="$t('company.manager')">
        <multiselect
                v-model="selectedManagers"
                :placeholder= "$t('common_action.pick')"
                label="name"
                track-by="id"
                :options="managers"
                :multiple="true"
                :close-on-select="false"
                :clear-on-select="false"
                :hide-selected="true"/>
      </form-group>
    </validation-form>
    <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="confirmUpdate()">
        <span class="glyphicon glyphicon-ok"></span> {{ $t("common_action.ok") }}
      </button>
      <button type="button" class="btn btn-default btn-sm" @click="cancel()">
        <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel") }}
      </button>
    </div>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="updateChange"
                         :message="messageModal">
    </confirmation-dialog>
  </div>
</template>

<script>

import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import Utils from '../../../js/common/Utils';
import {companyNavigators as subNavigators} from '../../../js/app/manage/routes';
import Multiselect from 'vue-multiselect';

const defaultRecord = {
  name: '',
  name_phonetic: '',
  street_address: '',
  contact_name: '',
  phone_number: '',
  short_description: '',
  company_hp: '',
  expire_date: '',
  is_active: 1
};

export default {
  components: {
      Multiselect
  },
  data() {
    return {
      user,
      subNavigators,
      record: {
        is_active: 1,
        oldUserName:''
      },
      oldRecord: {},
      masterdata: {},
      managers: [],
      selectedManagers: [],
      isActiveOptions: Utils.getYesNoOptions(),
      isShowModal: false,
      messageModal: "あなたはいなかった変更内容を保存しますか?",
    }
  },

  methods: {
    isFieldRequired(fieldName) {
        return Utils.isFieldRequired(this.masterdata, 'companies', fieldName);
    },
    getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'companies', fieldName);
    },
    confirmUpdate() {
        this.isShowModal = true;
    },
    updateChange() {
      const managers = this.selectedManagers;
      this.record.managers = _.map(this.selectedManagers, 'id');
      const companyPromise = (this.record && this.record.id)
        ? rf.getRequest('CompanyRequest').updateOne(this.record.id, this.record)
        : rf.getRequest('CompanyRequest').createANewOne(this.record)
      this.isShowModal = false;
      companyPromise.then(res => {
        Utils.growl('request.request_success');
        if (!this.$route.query.id) {
          this.$router.push({
            path: '/company/list'
          });
        }
        this.oldRecord = res;
        this.oldRecord.managers = managers;
        this.resetChange();
      }).catch(({ validationErrors }) => {
        if (validationErrors) {
          this.$refs.companyForm.$emit('REJECT_FORM', validationErrors);
        }
      });
    },
    resetChange() {
      this.record = JSON.parse(JSON.stringify(this.oldRecord));
      this.record.oldUserName = this.record.username;
      this.selectedManagers = this.oldRecord.managers;
      this.$refs.companyForm.$emit('FORM_ERRORS_CLEAR');
    },
    cancel() {
      this.$router.push({
        path: '/company/list'
      });
    }
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    let id = this.$route.query.id;
    const companyAdminType = 2;
    const managerPromise = rf.getRequest('AdminRequest').getManagers({
      'search': 'type:' + companyAdminType
    });
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    const companyPromise = id
      ? rf.getRequest('CompanyRequest').getOne(id, {'with': 'managers'})
      : Promise.resolve(defaultRecord);
    Promise.all([companyPromise, managerPromise, masterdataPromise]).then(([companies, managers, masterdata]) => {
      this.masterdata = masterdata;
      this.managers = managers;
      this.oldRecord = companies;
      this.resetChange();
    });
  }
}
</script>

<style>
  .multiselect {
    z-index: 3;
  }
</style>
