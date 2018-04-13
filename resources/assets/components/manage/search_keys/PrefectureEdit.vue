<template>
  <div>
    <validation-form ref="prefectureForm" style="margin-bottom: 70px">
      <form-group :label="getDisplayName('prefecture_name')" :is-required="isFieldRequired('prefecture_name')">
          <input class="form-control" type="text" data-vv-name="name" v-model="record.name"/>
        </form-group>
      <form-group :label="getDisplayName('prefecture_ward')"
                  :is-required="isFieldRequired('prefecture_ward')">
        <multiselect
                v-model="selectedWards"
                :placeholder="$t('common_action.pick')"
                label="name"
                track-by="id"
                :options="wards"
                :multiple="true"
                :close-on-select="false"
                :clear-on-select="false"
                :hide-selected="true"
                data-vv-name="wards">
        </multiselect>
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

import _ from 'lodash';
import Utils from '../../../js/common/Utils';
import rf from '../../../js/lib/RequestFactory';
import {searchKeysNavigators as subNavigators} from '../../../js/app/manage/routes';
import Multiselect from 'vue-multiselect';

let defaultWards = {
  wards: []
}
export default {
  components: {
    Multiselect
  },

  data() {
    return {
      subNavigators,
      record: {},
      wards: [],
      selectedWards: [],
      isShowModal: false,
      api: 'prefectures',
    };
  },

  computed: {
  },

  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, this.api, fieldName);
    },

    isFieldRequired(fieldName) {
      return Utils.isFieldRequired(this.masterdata, this.api, fieldName);
    },

    showModal() {
      this.isShowModal = true;
    },

    updateChange() {
      this.isShowModal = false;
      if (this.record && this.record.id) {
        this.record.wards = _.map(this.selectedWards, 'id');
        rf.getRequest('MasterdataRequest').updateOne(this.api, this.record.id, this.record).then(res => {
        }).catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.prefectureForm.$emit('REJECT_FORM', validationErrors);
          }
        });
      }
    },

    resetChange() {
      this.$router.push({
        path: '/search_keys/prefecture/list',
      });
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const id = this.$route.query.id;
    const prefecturePromise = id ?
      rf.getRequest('MasterdataRequest').getOne(this.api, id)
      : Promise.resolve(defaultWards);

    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    Promise.all([prefecturePromise, masterdataPromise]).then(([prefecture, masterdata]) => {
      this.record = prefecture;
      this.masterdata = masterdata;
      this.wards = masterdata.wards;
      this.selectedWards = _.filter(this.wards, pref => parseInt(pref.prefecture_id) === parseInt(this.record.id));
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