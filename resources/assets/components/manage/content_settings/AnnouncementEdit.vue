<template>
  <div>
    <validation-form ref="candidateForm" style="margin-bottom: 70px">
      <div><span class="glyphicon glyphicon-triangle-bottom"></span> <span>{{$t('common_field.basic_info')}}</span></div>

      <form-group :label="getDisplayName('id')" :is-required="isFieldRequired('id')">
        <input class="form-control" id="input-id" type="text" v-model="record.id" disabled/>
      </form-group>

      <form-group :label="getDisplayName('content')" :is-required="isFieldRequired('content')">
        <input data-vv-name="content" class="form-control" type="text" v-model="record.content" />
      </form-group>

      <form-group :label="getDisplayName('start_date')" :is-required="isFieldRequired('start_date')">
        <date-picker v-model="record.start_date" format="YYYY-MM-DD" data-vv-name="start_date" locale="ja"></date-picker>
      </form-group>

      <form-group :label="getDisplayName('end_date')" :is-required="isFieldRequired('end_date')">
        <date-picker v-model="record.end_date" format="YYYY-MM-DD" locale="ja" data-vv-name="end_date"></date-picker>
      </form-group>

      <form-group :label="getDisplayName('regions')"
            :is-required="isFieldRequired('regions')">
        <multiselect
          v-model="selectedRegions"
          :placeholder="$t('common_action.pick')"
          label="name"
          track-by="id"
          :options="masterdata.regions"
          :multiple="true"
          :close-on-select="false"
          :clear-on-select="false"
          :hide-selected="true"
        ></multiselect>
        <input type="text" hidden
                 :name="getDisplayName('regions')"
                 data-vv-name="regions"
                 v-model="selectedRegions"/>
      </form-group>
      <form-group :label="getDisplayName('is_active')"
                    :is-required="isFieldRequired('is_active')">
          <radio-group inline="true" v-model="record.is_active" :options="statusOptions"/>
      </form-group>
    </validation-form>

    <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="updateChange()">
        <span class="glyphicon glyphicon-ok"></span> {{ $t("common_action.ok") }}
      </button>
      <button type="button" class="btn btn-default btn-sm" @click="cancel()">
        <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel") }}
      </button>
    </div>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="updateData" :message="messageModal">
    </confirmation-dialog>
  </div>
</template>

<script>

import rf from '../../../js/lib/RequestFactory';
import _ from 'lodash';
import {user} from '../../../js/app/manage/main';
import Utils from '../../../js/common/Utils';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
import Multiselect from 'vue-multiselect';

let defaultAnnouncement = {
  content: '',
  start_date: '',
  end_date: '',
  regions: [],
  is_active: 1
};
export default {
  components: {
    Multiselect,
  },
  data() {
    return {
      user,
      subNavigators,
      startAt: '',
      endAt: '',
      record: {
        is_active: 1
      },
      oldRecord: {},
      selectedRegions: [],
      masterdata: Utils.getMasterdataSkel(),
      messageModal: "あなたはいなかった変更内容を保存しますか?",
      isShowModal: false,
      statusOptions: window.Utils.getYesNoOptions(),
    }
  },

  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'announcements', fieldName);
    },
    isFieldRequired(fieldName) {
      return Utils.isFieldRequired(this.masterdata, 'announcements', fieldName);
    },
    updateChange() {
       this.$refs.candidateForm.validate().then(() => {
        this.isShowModal = true
      }).catch(() => {
      });
    },
    updateData() {
      this.record.regions = _.map(this.selectedRegions, (region) => { return parseInt(region.id) });

      const announcementPromise = (this.record && this.record.id)
        ? rf.getRequest('AnnouncementRequest').updateOne(this.record.id, this.record)
        : rf.getRequest('AnnouncementRequest').createANewOne(this.record)

      announcementPromise.then(res => {
        Utils.growl('request.request_success');
        if(!this.record.id){
          this.$router.push({
            path: '/announcement/list',
          });
        }
        this.isShowModal = false
        this.oldRecord = res;
        this.oldRecord.regions = this.selectedRegions
      }).catch(({ validationErrors }) => {
        if (validationErrors) {
          this.isShowModal = false
          this.$refs.candidateForm.$emit('REJECT_FORM', validationErrors);
        }
      });
    },
    localReset() {
      this.$refs.candidateForm.$emit('FORM_ERRORS_CLEAR');
      this.selectedRegions = this.oldRecord.regions
      this.record = JSON.parse(JSON.stringify(this.oldRecord));
      this.record.is_active = (this.record.is_active) ? 1 : 0
    },
    cancel() {
      this.$router.push({
        path: '/announcement/list',
      })
    }
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);

    let id = this.$route.query.id;
    const announcementPromise = id
      ? rf.getRequest('AnnouncementRequest').getOne(id, { with:'regions' })
      : Promise.resolve(defaultAnnouncement)
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

    Promise.all([masterdataPromise, announcementPromise]).then(([masterdata, announcement]) => {
      this.oldRecord = announcement;
      this.masterdata = masterdata;
      this.selectedRegions = announcement.regions;
      this.localReset();
    });
  }
}
</script>

<style scoped>
  .ql-container .ql-editor {
    min-height: 30em;
    padding-bottom: 1em;
    max-height: 70em;
    background: white;
  }
</style>