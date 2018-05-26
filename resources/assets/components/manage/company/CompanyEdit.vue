<template>
  <div>
    <validation-form ref="companyForm" style="margin-bottom: 70px">
      <form-group :label="getDisplayName('id')"
                      :is-required="isFieldRequired('id')">
            <input class="form-control" type="text" data-vv-name="id"
                   v-model="record.id" disabled/>
          </form-group>
      <form-group :label="getDisplayName('email')" :is-required="isFieldRequired('email')">
        <input data-vv-name="email" class="form-control" type="text" v-model="record.email" />
      </form-group>
      </form-group>
      <form-group :label="getDisplayName('name')" :is-required="isFieldRequired('name')">
        <input data-vv-name="name" class="form-control" type="text" v-model="record.name" />
      </form-group>
      <form-group :label="getDisplayName('street_address')" :is-required="isFieldRequired('street_address')">
        <input class="form-control" data-vv-name="street_address" type="text" v-model="record.street_address" />
      </form-group>
      <form-group :label="getDisplayName('contact_name')" :is-required="isFieldRequired('contact_name')">
        <input class="form-control" data-vv-name="contact_name" type="text" v-model="record.contact_name" />
      </form-group>
      <form-group :label="getDisplayName('phone_number')" :is-required="isFieldRequired('phone_number')">
        <input class="form-control" data-vv-name="phone_number" v-model="record.phone_number" ></input>
      </form-group>
      <form-group :label="getDisplayName('short_description')" :is-required="isFieldRequired('short_description')">
        <input class="form-control" data-vv-name="short_description"  type="text" v-model="record.short_description" />
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
  email:'',
  name: '',
  street_address: '',
  contact_name: '',
  phone_number: '',
  short_description: '',
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
        oldUserName:''
      },
      oldRecord: {},
      masterdata: {},
      selectedManagers: [],
      isActiveOptions: Utils.getYesNoOptions(),
      isShowModal: false,
      messageModal: "Bạn có muốn lưu thay đổi không?",
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
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    const companyPromise = id
      ? rf.getRequest('CompanyRequest').getOne(id)
      : Promise.resolve(defaultRecord);
    Promise.all([companyPromise, masterdataPromise]).then(([companies, masterdata]) => {
      this.masterdata = masterdata;
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
