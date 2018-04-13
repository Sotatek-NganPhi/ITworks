<template>
  <div>
    <validation-form ref="editForm">
      <form-group :label="getDisplayName('date')" :is-required="isFieldRequired('date')">
        <date-picker v-model="record.date" data-vv-name="date" format="YYYY-MM-DD" locale="ja" required></date-picker>
      </form-group>
      <form-group :label="getDisplayName('regions')"
                    :is-required="isFieldRequired('regions')">
        <label class="checkbox-inline" v-for="region in masterdata.regions"
               :key="region.id">
          <input type="checkbox" v-model="regions"
                 :value="region.id"/>{{ region.name }}
        </label>
        <input hidden
               :name="getDisplayName('regions')"
                data-vv-name="regions" 
               v-model="regions"/>
      </form-group>

      <form-group :label="getDisplayName('organizer_name')"
                    :is-required="isFieldRequired('organizer_name')">
        <input class="form-control" data-vv-name="organizer_name" type="text" v-model="record.organizer_name"/>
      </form-group>

      <form-group :label="getDisplayName('time')" :is-required="isFieldRequired('time')">
        <input class="form-control" v-model="record.time" data-vv-name="time" type="text"/>
      </form-group>

      <form-group :label="getDisplayName('start_date')" :is-required="isFieldRequired('start_date')">
        <date-picker v-model="record.start_date" data-vv-name="start_date" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>

      <form-group :label="getDisplayName('end_date')" :is-required="isFieldRequired('end_date')">
        <date-picker v-model="record.end_date" data-vv-name="end_date" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>

      <form-group :label="getDisplayName('presentation_name')"
                    :is-required="isFieldRequired('presentation_name')">
        <input class="form-control" data-vv-name="presentation_name" type="text" v-model="record.presentation_name"/>
      </form-group>

      <form-group :label="getDisplayName('address')"
                    :is-required="isFieldRequired('address')">
        <input class="form-control" data-vv-name="address" type="text" v-model="record.address"/>
      </form-group>

      <form-group :label="getDisplayName('content')"
                    :is-required="isFieldRequired('content')">
        <input class="form-control" data-vv-name="content" type="text" v-model="record.content"/>
      </form-group>

      <form-group :label="getDisplayName('pr')"
                    :is-required="isFieldRequired('pr')">
        <input class="form-control" data-vv-name="pr" type="text" v-model="record.pr"/>
      </form-group>

      <form-group :label="getDisplayName('map_url')"
                    :is-required="isFieldRequired('map_url')">
        <input class="form-control" data-vv-name="map_url" type="text" v-model="record.map_url"/>
      </form-group>

      <form-group :label="getDisplayName('cs_email')"
                    :is-required="isFieldRequired('cs_email')">
        <input class="form-control" data-vv-name="cs_email" type="text" v-model="record.cs_email"/>
      </form-group>

      <form-group :label="getDisplayName('cs_phone')"
                    :is-required="isFieldRequired('cs_phone')">
        <input class="form-control" data-vv-name="cs_phone" type="text" v-model="record.cs_phone"/>
      </form-group>
      <form-group :label="getDisplayName('is_active')"
                    :is-required="isFieldRequired('is_active')">
           <radio-group inline="true" data-vv-name="is_active" v-model="record.is_active" :options="isActiveOptions"/>
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
import {user} from '../../../js/app/manage/main';
import Utils from '../../../js/common/Utils';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';

let masterdata = {
  regions: []
};

let defaultExpo = {
  date: '',
  organizer_name: '',
  regions: [],
  time: '',
  start_date: '',
  end_date: '',
  presentation_nameL: '',
  address: '',
  content: '',
  pr: '',
  map_url: '',
  cs_email: '',
  cs_phone: '',
  is_active: 1
};
export default {
  data() {
    return {
      masterdata,
      user,
      subNavigators,
      regions: [],
      record: {},
      oldRecord: {},
      isActiveOptions : Utils.getYesNoOptions(),
      messageModal: "あなたはいなかった変更内容を保存しますか?",
      isShowModal: false
    }
  },

  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'expos', fieldName);
    },

    isFieldRequired(fieldName) {
      return Utils.isFieldRequired(this.masterdata, 'expos', fieldName);
    },

    updateChange() {
      this.$refs.editForm.validate().then(() => {
        this.isShowModal = true
      }).catch(() => {
      });
    },

    updateData() {
      this.record.regions = this.regions;

      const expoPromise = (this.record && this.record.id)
        ? rf.getRequest('ExpoRequest').updateOne(this.record.id, this.record)
        : rf.getRequest('ExpoRequest').createANewOne(this.record)
      expoPromise.then(res => {
        this.isShowModal = false
        Utils.growl('request.request_success');
        if(!this.record.id){
          this.$router.push({
            path: '/expo/list',
          });
        }
        this.oldRecord = res;
        this.resetChange();
      }).catch(({ validationErrors }) => {
        if (validationErrors) {
          this.isShowModal = false
          this.$refs.editForm.$emit('REJECT_FORM', validationErrors);
        }
      });
    },
    resetChange() {
      this.$refs.editForm.$emit('FORM_ERRORS_CLEAR');
      this.record = JSON.parse(JSON.stringify(this.oldRecord));

      if (this.record.regions) {
        this.regions = this.record.regions;
      }
    },
    cancel() {
      this.$router.push({
        path: '/expo/list',
      })
    }
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);

    let id = this.$route.query.id;

    const expoPromise = id
      ? rf.getRequest('ExpoRequest').getOne(id)
      : Promise.resolve(defaultExpo)

    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

    Promise.all([expoPromise, masterdataPromise]).then(([expo, masterdata]) => {
      this.oldRecord = expo;
      this.masterdata = masterdata;

      this.resetChange();
    });
  }
}
</script>
