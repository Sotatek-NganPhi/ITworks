<template>
  <div>
    <validation-form ref="regionForm" style="margin-bottom: 70px">
        <form-group :label="getDisplayName('name_region')" :is-required="isFieldRequired('name_region')">
          <input class="form-control" type="text" data-vv-name="name" v-model="record.name"/>
        </form-group>
        <form-group :label="getDisplayName('key_region')" :is-required="isFieldRequired('key_region')">
          <input class="form-control" type="text" data-vv-name="key" v-model="record.key"/>
        </form-group>
          <form-group :label="getDisplayName('prefectures.name')"
                    :is-required="isFieldRequired('prefectures.name')">
          <multiselect
                  v-model="selectedPrefectures"
                  :placeholder="$t('common_action.pick')"
                  label="name"
                  track-by="id"
                  :options="prefectures"
                  :multiple="true"
                  :close-on-select="false"
                  :clear-on-select="false"
                  :hide-selected="true"
          ></multiselect>
          <input type="text" hidden
                 data-vv-name="prefectures"
                 v-model="selectedPrefectures"/>
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

let defaultRegion = {
  prefectures: []
}

export default {
  components: {
    Multiselect
  },

  data() {
    return {
      subNavigators,
      oldRecord: {},
      record: {},
      prefectures: [],
      selectedPrefectures: [],
      isShowModal: false,
    };
  },

  computed: {
  },

  watch: {
  },

  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, '`regions', fieldName);
    },

    isFieldRequired(fieldName) {
      return Utils.isFieldRequired(this.masterdata, 'regions', fieldName);
    },

    showModal() {
      this.isShowModal = true;
    },

    updateChange() {
      this.isShowModal = false;
      if (this.record && this.record.id) {
        this.record.prefectures = _.map(this.selectedPrefectures, 'id');
        let api = 'regions';
        rf.getRequest('MasterdataRequest').updateOne(api, this.record.id, this.record).then(res => {
        }).catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.regionForm.$emit('REJECT_FORM', validationErrors);
          }
        });
      }
    },

    resetChange() {
      this.$router.push({
        path: '/search_keys/region/list',
      });
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const id = this.$route.query.id;
    const api = 'regions';
    const regionPromise = id
        ? rf.getRequest('MasterdataRequest').getOne(api, id)
        : Promise.resolve(defaultRegion);

      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
      Promise.all([regionPromise, masterdataPromise]).then(([region, masterdata]) => {
        this.record = region;
        this.masterdata = masterdata;
        this.prefectures = masterdata.prefectures;
        this.selectedPrefectures = _.filter(this.prefectures, pref => parseInt(pref.region_id) === parseInt(this.record.id))
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
