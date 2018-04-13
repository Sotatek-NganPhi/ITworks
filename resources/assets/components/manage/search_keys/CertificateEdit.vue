<template>
  <div>
    <validation-form ref="certificateForm" style="margin-bottom: 70px">
      <form-group :label="getDisplayName('certificate_id')" :is-required="isFieldRequired('certificate_id')">
        <input class="form-control" type="text" :name="getDisplayName('certificate_id')"
               v-validator="(isFieldRequired('certificate_id') ? 'required' : '')"
               v-model="record.id" disabled/>
      </form-group>
      <form-group :label="getDisplayName('certificates.group_name')" :is-required="isFieldRequired('certificates.group_name')">
        <input class="form-control" type="text" v-model="record.groupName" disabled>
      </form-group>
      <form-group :label="getDisplayName('name')" :is-required="isFieldRequired('name')">
        <input class="form-control" type="text" v-model="record.name">
      </form-group>
    </validation-form>
    <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="showModal()">
        <span class="glyphicon glyphicon-ok"></span>  {{$t('common_action.ok')}}
      </button>
      <button type="button" class="btn btn-default btn-sm" @click="cancel()">
        <span class="glyphicon glyphicon-remove"></span>  {{$t('common_action.cancel')}}
      </button>
    </div>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="updateChange" :message="$t('message.before_update')">
    </confirmation-dialog>
  </div>
</template>

<script>

import Utils from '../../../js/common/Utils';
import rf from '../../../js/lib/RequestFactory';
import {searchKeysNavigators as subNavigators} from '../../../js/app/manage/routes';

const defaultCertificate = {
  id: '',
  groupName: '',
  name: '',
};
export default {

  data() {
    return {
      subNavigators,
      record: {},
      api: '',
      isShowModal: false,
    };
  },
  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'certificates', fieldName);
    },

    isFieldRequired(fieldName) {
      return Utils.isFieldRequired(this.masterdata, 'certificates', fieldName);
    },

    showModal() {
      this.isShowModal = true;
    },

    updateChange() {
      this.isShowModal = false;
      rf.getRequest('CertificateRequest').updateOne(this.record.id, this.record).then(res => {
      }).catch(({ validationErrors }) => {
        if (validationErrors) {
          this.$refs.certificateForm.$emit('REJECT_FORM', validationErrors);
        }
      });
    },
    cancel() {
      this.$router.push({
        path: '/search_keys/certificate/list',
      });
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const id = this.$route.query.id;
    const certificatePromise = id
      ? rf.getRequest('MasterdataRequest').getOne('certificates', id)
      : Promise.resolve(defaultCertificate);
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    Promise.all([certificatePromise, masterdataPromise]).then(([certificate, masterdata]) => {
      this.masterdata = masterdata;
      this.record = certificate;
      const certificateGroup = _.find(this.masterdata.certificate_groups, ['id', this.record.certificate_group_id]);
      this.record.groupName = certificateGroup.name;
    });
  }
}
</script>

<style scoped>
  .div-inline{
    display:inline-block;
  }

  .row {
    padding-bottom: 5px;
  }
</style>