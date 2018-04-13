<template>
  <div>
    <validation-form ref="editForm">
      <form-group :label="getDisplayName('title')"
                    :is-required="isFieldRequired('title')">
        <input class="form-control" type="text" data-vv-name="title" v-model="record.title"/>
      </form-group>

      <form-group :label="getDisplayName('start_at')"
                    :is-required="isFieldRequired('start_at')">
        <datetime-picker data-vv-name="start_at" v-model="record.start_at" format="YYYY-MM-DD HH:mm:ss" locale="ja"/>
      </form-group>

      <form-group :label="getDisplayName('end_at')"
                    :is-required="isFieldRequired('end_at')">
        <datetime-picker data-vv-name="end_at" v-model="record.end_at" format="YYYY-MM-DD HH:mm:ss" locale="ja"/>
      </form-group>

      <form-group :label="getDisplayName('banner_path')"
                    :is-required="isFieldRequired('banner_path')">
          <file-upload v-model="record.banner_path" accept="image/*" data-vv-name="banner_path"></file-upload>
      </form-group>

      <form-group :label="getDisplayName('content')"
                    :is-required="isFieldRequired('content')">
          <quill-editor v-model="record.content" data-vv-name="content"
                ref="myQuillEditor"
                :options="editorOption"
                @blur="onEditorBlur($event)"
                @focus="onEditorFocus($event)"
                @ready="onEditorReady($event)">
          </quill-editor>
      </form-group>

      <form-group :label="getDisplayName('is_active')"
                    :is-required="isFieldRequired('is_active')">
        <radio-group inline="true" v-model="record.is_active" data-vv-name="is_active" :options="isActiveOptions"/>
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
import FileUpload from '../../common/FileUpload.vue';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';

let defaultCampaign = {
  title: '',
  start_at: '',
  end_at: '',
  banner_path: '',
  content: '',
  is_active: 1
};

export default {
  components: {
    FileUpload,
  },
  data() {
    return {
      user,
      subNavigators,
      start_at: '',
      end_at: '',
      editorOption: {

      },
      record: {
        is_active: 1
      },
      oldRecord: {},
      isActiveOptions : window.Utils.getYesNoOptions(),
      masterdata: [],
      messageModal: "あなたはいなかった変更内容を保存しますか?",
      isShowModal: false
    }
  },

  methods: {
     getDisplayName(fieldName) {
      return window.Utils.getFieldDisplayName(this.masterdata, 'campaigns', fieldName);
    },

    isFieldRequired(fieldName) {
      return window.Utils.isFieldRequired(this.masterdata, 'campaigns', fieldName);
    },
    onEditorBlur(editor) {
      // console.log('editor blur!', editor)
    },
    onEditorFocus(editor) {
      // console.log('editor focus!', editor)
    },
    onEditorReady(editor) {
      // console.log('editor ready!', editor)
    },
    updateChange() {
      this.$refs.editForm.validate().then(() => {
        this.isShowModal = true
      }).catch(() => {
      });
    },
    updateData() {
      const campaignPromise = (this.record && this.record.id)
        ? rf.getRequest('CampaignRequest').updateOne(this.record.id, this.record)
        : rf.getRequest('CampaignRequest').createANewOne(this.record)

      campaignPromise.then(res => {
        this.isShowModal = false
        Utils.growl('request.request_success');
        if(!this.record.id) {
          this.$router.push({
            path: '/campaign/list',
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
    },
    cancel() {
      this.$router.push({
        path: '/campaign/list',
      })
    }
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);

    let id = this.$route.query.id;
    const campaignPromise = id
      ? rf.getRequest('CampaignRequest').getOne(id)
      : Promise.resolve(defaultCampaign)
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

    Promise.all([campaignPromise, masterdataPromise]).then(([campaign, masterdata]) => {
      this.oldRecord = campaign
      this.masterdata = masterdata
      this.resetChange()
    })
  }
}
</script>

<style>
  .ql-container .ql-editor {
    min-height: 30em;
    padding-bottom: 1em;
    max-height: 70em;
    background: white;
  }
</style>