<template>
  <div>
    <validation-form ref="mailForm">
      <form-group :label="$t('candidate.first_name')">
        <input class="form-control" type="text" v-model="record.first_name" readonly/>
      </form-group>
      <form-group :label="$t('candidate.last_name')">
        <input class="form-control" type="text" v-model="record.last_name" readonly/>
      </form-group>
      <form-group :label="$t('common_field.email')">
        <input class="form-control" data-vv-name="email" type="text" v-model="record.email" readonly />
      </form-group>

      <form-group :label="$t('common_field.subject')">
        <input class="form-control" data-vv-name="subject" type="text" v-model="record.subject" />
      </form-group>

      <form-group :label="$t('campaign.content')">
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
      <button type="button" class="btn btn-default btn-sm" @click="resetChange()">
        <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel") }}
      </button>
    </div>

    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="candidateSendmail"
                         :message="$t('message.before_send')">
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
        firstName: '',
        lastName:'',
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
    candidateSendmail(){
      this.isShowModal = false;
      rf.getRequest('CandidateRequest').sendMail(this.record)
        .then(res => {
          Utils.growl('Gửi mail thành công');
          this.resetChange();
        })
        .catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.mailForm.$emit('REJECT_FORM', validationErrors);
          }
        });
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
    resetChange() {
      this.$router.push({
        path: '/candidate/candidate_mail'
      });
    },
    localReset() {
      this.record = JSON.parse(JSON.stringify(this.oldRecord.user));
    }
  },

  mounted() {
    let self = this;
    self.$emit('EVENT_PAGE_CHANGE', self);

    let id = self.$route.query.id;
    if (!id) return;
    rf.getRequest('CandidateRequest').getOne(id).then(res => {
        self.oldRecord = res;
        self.localReset();
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