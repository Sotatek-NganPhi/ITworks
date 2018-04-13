<template>
  <div>
    <validation-form ref="linkForm">
      <form-group :label="getDisplayName('regions')"
                    :is-required="isFieldRequired('regions')">
          <multiselect
                  v-model="selectedRegions"
                  placeholder="Pick some"
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

      <form-group :label="getDisplayName('link_title')"
                    :is-required="isFieldRequired('link_title')">
        <input class="form-control" type="text" data-vv-name="link_title" v-model="record.link_title"/>
      </form-group>

      <form-group :label="getDisplayName('url')"
                    :is-required="isFieldRequired('url')">
        <input class="form-control" :name="getDisplayName('url')" data-vv-name="url" type="text" v-model="record.url"/>
      </form-group>

      <form-group :label="getDisplayName('image')"
                    :is-required="isFieldRequired('image')">
        <file-upload v-model="record.image" accept="image/*" data-vv-name="image"></file-upload>
      </form-group>

      <form-group :label="getDisplayName('order_by')"
                    :is-required="isFieldRequired('order_by')">
        <input class="form-control" type="number" min="1" data-vv-name="order_by" v-model="record.order_by"/>
      </form-group>

      <form-group :label="getDisplayName('start_date')" :is-required="isFieldRequired('start_date')">
        <date-picker v-model="record.start_date" data-vv-name="start_date" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>

      <form-group :label="getDisplayName('end_date')" :is-required="isFieldRequired('end_date')">
        <date-picker v-model="record.end_date" data-vv-name="end_date" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>

      <form-group :label="getDisplayName('is_active')"
                    :is-required="isFieldRequired('is_active')">
          <radio-group inline="true" v-model="record.is_active" :options="linkStatusOptions"/>
      </form-group>
    </validation-form>
    <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="updateChange()">
        <span class="glyphicon glyphicon-ok"></span> {{ $t("common_action.save") }}
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
import _ from 'lodash';
import rf from '../../../js/lib/RequestFactory';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
import Multiselect from 'vue-multiselect';
import FileUpload from '../../../components/common/FileUpload.vue';

let masterdata = {
  regions: [],
};
let defaultLink = {
  link_title: '',
  url: '',
  order_by: '',
  regions: [],
  image: '',
  start_date: '',
  end_date: '',
  is_active: 1
};
export default {
  components: {
    Multiselect,
    FileUpload
  },
  data() {
    return {
      subNavigators,
      record: {
        link_title: '',
        url: '',
        image: '',
        order_by: '',
        start_date: '',
        end_date: '',
        is_active: '',
        regions: []
      },
      oldRecord: {},
      masterdata,
      selectedRegions: [],
      linkStatusOptions: window.Utils.getYesNoOptions(),
      messageModal: "あなたはいなかった変更内容を保存しますか?",
      isShowModal: false
    }
  },

  methods: {
    getDisplayName(fieldName) {
      return window.Utils.getFieldDisplayName(this.masterdata, 'links', fieldName);
    },

    isFieldRequired(fieldName) {
      return window.Utils.isFieldRequired(this.masterdata, 'links', fieldName);
    },

    updateChange() {
      this.$refs.linkForm.validate().then(() => {
        this.isShowModal = true
      }).catch(() => {
      });
    },

    updateData() {
      this.record.regions = _.map(this.selectedRegions, 'id');
      const LinkPromise = (this.record && this.record.id)
          ? rf.getRequest('LinkRequest').updateOne(this.record.id, this.record)
          : rf.getRequest('LinkRequest').createANewOne(this.record);

        LinkPromise.then(res => {
          this.isShowModal = false
          window.Utils.growl('request.request_success');
          if(!this.record.id){
            this.$router.push({
              path: '/link/list',
            });
          }
          this.oldRecord = res;
          this.resetChange();
          this.$refs.linkForm.$emit('REJECT_FORM', null);
        }).catch(({ validationErrors }) => {
        if (validationErrors) {
          this.isShowModal = false
          this.$refs.linkForm.$emit('REJECT_FORM', validationErrors);
        }
      });
    },
    resetChange() {
      let self = this;
      if (!self.oldRecord.id) {
        self.localReset();
        this.$refs.linkForm.$emit('FORM_ERRORS_CLEAR');
        return;
      }
      self.localReset();
      this.record = JSON.parse(JSON.stringify(this.oldRecord));
      this.$refs.linkForm.$emit('FORM_ERRORS_CLEAR');
    },

    localReset() {
      this.record = JSON.parse(JSON.stringify(this.oldRecord));
      this.selectedRegions =  _.map(this.record.regions, regionId =>
            _.find(this.masterdata.regions, region => region.id === regionId));
    },
    cancel() {
      this.$router.push({
        path: '/link/list',
      })
    }
  },

  mounted() {

    this.$emit('EVENT_PAGE_CHANGE', this);

    let id = this.$route.query.id;
    const linkPromise = id
      ? rf.getRequest('LinkRequest').getOne(id)
      : Promise.resolve(defaultLink)

    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

    Promise.all([linkPromise, masterdataPromise]).then(([link, masterdata]) => {
        this.oldRecord = link;
        this.masterdata = masterdata;
        this.resetChange();
    });
  }
}
</script>
