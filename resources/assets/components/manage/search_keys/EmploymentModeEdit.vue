<template>
  <div>
    <validation-form ref="employmentForm" style="margin-bottom: 70px">

      <form-group :label="getDisplayName('employment_name')" :is-required="isFieldRequired('employment_name')">
        <input class="form-control" type="text" data-vv-name="description" v-model="record.description"/>
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
      isShowModal: false,
    };
  },

  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'employment_modes', fieldName);
    },

    isFieldRequired(fieldName) {
      return Utils.isFieldRequired(this.masterdata, 'employment_modes', fieldName);
    },

    showModal() {
      this.isShowModal = true;
    },

    updateChange() {
      this.isShowModal = false;
      if (this.record && this.record.id) {
        const api = 'employment_modes';
        rf.getRequest('MasterdataRequest').updateOne(api, this.record.id, this.record).then(res => {
        }).catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.employmentForm.$emit('REJECT_FORM', validationErrors);
          }
        });
      }
    },
    resetChange() {
      this.$router.push({
        path: '/search_keys/employment_mode/list',
      });
    },
  },
  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const id = this.$route.query.id;
    const api = 'employment_modes';
    const employmentPromise = id ?
      rf.getRequest('MasterdataRequest').getOne(api, id)
      : Promise.resolve({});

    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    Promise.all([employmentPromise, masterdataPromise]).then(([employment, masterdata]) => {
      this.record = employment;
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