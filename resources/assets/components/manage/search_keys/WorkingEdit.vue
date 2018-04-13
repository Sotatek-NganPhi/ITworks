<template>
  <div>
    <validation-form ref="workingForm" style="margin-bottom: 70px">
      <form-group :label="displayName('name')" :is-required="fieldRequired('name')">
        <input class="form-control" type="text" data-vv-name="name" v-model="record.name"/>
      </form-group>
    </validation-form>
    <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="showModal()">
        <span class="glyphicon glyphicon-ok"></span> {{$t('common_action.ok')}}
      </button>
      <button type="button" class="btn btn-default btn-sm" @click="resetChange()">
        <span class="glyphicon glyphicon-remove"></span> {{$t('common_action.cancel')}}
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

export default {

  data() {
    return {
      subNavigators,
      record: {},
      optionStatus: Utils.getStatus(),
      api: '',
      isShowModal: false,
    };
  },

  methods: {
    displayName(displayName) {
      return Utils.getFieldDisplayName(this.masterdata, this.api, displayName);
    },
    fieldRequired(fieldRequired) {
      return Utils.isFieldRequired(this.masterdata, this.api, fieldRequired);
    },

    showModal() {
      this.isShowModal = true;
    },

    updateChange() {
      this.isShowModal = false;
      if (this.record && this.record.id) {
        rf.getRequest('MasterdataRequest').updateOne(this.api, this.record.id, this.record).then(res => {
        }).catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.workingForm.$emit('REJECT_FORM', validationErrors);
          }
        });
      }
    },
    resetChange() {
      this.$router.push({
        path: '/search_keys/working/list',
      });
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    this.api = this.$route.query.key; 
    let id = this.$route.query.id;
    const workingPromise = id ?
      rf.getRequest('MasterdataRequest').getOne(this.api, id)
      : Promise.resolve({});

    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    Promise.all([workingPromise, masterdataPromise]).then(([working, masterdata]) => {
      this.record = working;
      this.masterdata = masterdata;
    })
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