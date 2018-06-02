<template>
  <div>
    <validation-form ref="mailForm">
      <form-group :label=" $t('job.company_name') ">
        <input class="form-control" type="text" v-model="record.name" readonly/>
      </form-group>
      <form-group :label=" $t('common_field.email') ">
        <input class="form-control" data-vv-name="email" type="text" v-model="record.email" readonly />
      </form-group>

      <form-group :label="$t('common_field.subject')">
        <input class="form-control"
               data-vv-name="subject" type="text" v-model="record.subject" />
      </form-group>

      <form-group :label=" $t('campaign.content') ">
        <quill-editor data-vv-name="content"
                      v-model="record.content"
                      ref="myQuillEditor"
                      :options="editorOption"
                      @blur="onEditorBlur($event)"
                      @focus="onEditorFocus($event)"
                      @ready="onEditorReady($event)">
        </quill-editor>
      </form-group>
    </validation-form>
    <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="confirmSendMail()">
        <span class="glyphicon glyphicon-envelope"></span> {{ $t("candidate.sendmail") }}
      </button>
      <button type="button" class="btn btn-default btn-sm" @click="cancelSendMail()">
        <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel") }}
      </button>
    </div>

    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="companySendmail"
                         :message="$t('message.before_update')">
    </confirmation-dialog>
  </div>
</template>

<script>

import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import {candidateNavigators as subNavigators} from '../../../js/app/manage/routes';
import Utils from '../../../js/common/Utils';


export default {
  data() {
    return {
      user,
      subNavigators,
      editorOption: {},
      record: {
        name: '',
        email:'',
        content: '',
        subject: '',
      },
      oldRecord: {},
      isShowModal: false,
    }
  },

  methods: {
    confirmSendMail() {
      this.isShowModal = true;
    },
    companySendmail(){
      this.isShowModal = false;
      rf.getRequest('CandidateRequest').sendMailToCompany(this.record)
        .then(res => {
          Utils.growl('Gửi mail thành công');
          this.cancelSendMail();
        })
        .catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.mailForm.$emit('REJECT_FORM', validationErrors);
          }
        });
    },
    onEditorBlur(editor) {

    },
    onEditorFocus(editor) {

    },
    onEditorReady(editor) {

    },
    resetChange() {
      this.record.name = this.oldRecord.name;
      this.record.email = this.oldRecord.email;
    },
    cancelSendMail() {
      this.$router.push({
        path: '/candidate/mail_company'
      });
    },
  },

  mounted() {
    let self = this;
    self.$emit('EVENT_PAGE_CHANGE', self);
    let id = self.$route.query.id;
    if (!id) return;
    rf.getRequest('CompanyRequest').getOne(id).then(res => {
        self.oldRecord = res;
        self.resetChange();
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