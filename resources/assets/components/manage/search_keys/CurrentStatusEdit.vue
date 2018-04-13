<template>
  <div>
    <validation-form ref="currentForm" style="margin-bottom: 70px">

      <form-group :label="getDisplayName('current_name')" :is-required="isFieldRequired('current_name')">
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
      optionStatus: Utils.getStatus(),
      record: {},
      isShowModal: false,
      api: 'current_situations',
    };
  },

  computed: {
  },
  
  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'current_situations', fieldName);
    },

    isFieldRequired(fieldName) {
      return Utils.isFieldRequired(this.masterdata, 'current_situations', fieldName);
    },
    
    showModal() {
      this.isShowModal = true;
    },

    updateChange() {
      this.isShowModal = false;
      if (this.record && this.record.id) {
        const api = 'current_situations';
        rf.getRequest('MasterdataRequest').updateOne(api, this.record.id, this.record).then(res => {
        }).catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.currentForm.$emit('REJECT_FORM', validationErrors);
          }
        });
      }
    },
    resetChange() {
      this.$router.push({
        path: '/search_keys/current_status/list',
      });
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const id = this.$route.query.id;
    const api = 'current_situations';
    const currentPromise = id ?
      rf.getRequest('MasterdataRequest').getOne(api, id)
      : Promise.resolve({});

    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    Promise.all([currentPromise, masterdataPromise]).then(([current, masterdata]) => {
      this.record = current;
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