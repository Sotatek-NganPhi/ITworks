<template>
  <div>
    <validation-form ref="applicantSendMail">
      <form class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label">{{ $t("job.company_name") }}</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" v-model="job.company_name" readonly />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">{{ $t("candidate.first_name") }}</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" v-model="applicant.first_name" readonly />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">{{ $t("common_field.email") }}</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" v-model="applicant.email" readonly />
          </div>
        </div>

        <form-group :label="$t('common_field.title')">
          <input v-validator="'required'" class="form-control"
                 type="text" :name="$t('common_field.title')" v-model="record.title"/>
        </form-group>

        <form-group :label="$t('campaign.content')">
          <quill-editor v-model="record.content"
                        ref="myQuillEditor"
                        :options="editorOption"
                        @blur="onEditorBlur($event)"
                        @focus="onEditorFocus($event)"
                        @ready="onEditorReady($event)">
          </quill-editor>
          <input v-validator="'required'" class="form-control"
                 type="hidden" :name="$t('campaign.content')"
                 v-model="record.content"/>
        </form-group>
      </form>
    </validation-form>
    <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="showModal()">
        <span class="glyphicon glyphicon-envelope"></span> {{ $t("candidate.sendmail") }}
      </button>
      <button type="button" class="btn btn-default btn-sm" @click="back()">
        <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel") }}
      </button>
    </div>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="sendmail" :message="$t('message.before_update')">
    </confirmation-dialog>
  </div>
</template>

<script>

import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import {candidateNavigators as subNavigators} from '../../../js/app/manage/routes';


export default {
  data() {
    return {
      user,
      subNavigators,
      editorOption: {

      },
      applicant: {
        first_name: '',
        email:'',
      },
      job: {
        company_name: '',
      },
      record: {
        title: '',
        content: ''
      },
      isShowModal: false
    }
  },

  methods: {
    showModal() {
      this.isShowModal = true;
    },

    sendmail(){
      this.isShowModal = false;
      this.$refs.applicantSendMail.validate().then(() => {
        const sendMailPromise = rf.getRequest('MessageRequest').createANewOne(this.record);
        Promise.all([sendMailPromise]).then(([sendMail]) => {
            window.Utils.growl('Message sent successfully');
            this.$router.push({
                path: '/candidate/application_list'
            });
        });
      }).catch(() => {});
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
    back() {
      this.$router.push({
          path: '/application/application_list'
      });
    }
  },

  mounted() {
    let self = this;
    self.$emit('EVENT_PAGE_CHANGE', self);

    let applicantId = self.$route.query.applicant_id;
    if (!applicantId) return;
    rf.getRequest('ApplicantRequest').getOne(applicantId).then(res => {
        self.applicant = res;
        self.record = {
          applicant_id: res.id,
          user_id: res.user_id,
          from: 'manager',
          title: '',
          content: '',
        }
        rf.getRequest('JobRequest').getOne(res.job_id).then(res => {
          self.job = res;
        });
    });
  }
}
</script>
<style type="text/css">
  .ql-container .ql-editor {
    min-height: 30em;
    padding-bottom: 1em;
    max-height: 70em;
    background: white;
  }
</style>