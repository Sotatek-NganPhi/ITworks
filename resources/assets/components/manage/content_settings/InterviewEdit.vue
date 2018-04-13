<template>
  <div>
    <validation-form ref="interview" >
      <form-group :label="getDisplayName('title')" :is-required="isFieldRequired('title')">
        <input class="form-control" data-vv-name="title" type="text" v-model="record.title" />
      </form-group>

      <form-group :label="getDisplayName('sub_content')" :is-required="isFieldRequired('sub_content')">
        <input class="form-control" data-vv-name="sub_content" type="text" v-model="record.sub_content" />
      </form-group>

      <form-group :label="getDisplayName('date')" :is-required="isFieldRequired('date')">
        <date-picker data-vv-name="date" v-model="record.date" format="YYYY-MM-DD" locale="ja"/>
      </form-group>

      <form-group :label="getDisplayName('post_start_date')" :is-required="isFieldRequired('post_start_date')">
        <date-picker data-vv-name="post_start_date" v-model="record.post_start_date" format="YYYY-MM-DD" locale="ja"/>
      </form-group>

      <form-group :label="getDisplayName('post_end_date')" :is-required="isFieldRequired('post_end_date')">
        <date-picker data-vv-name="post_end_date" v-model="record.post_end_date" format="YYYY-MM-DD" locale="ja"/>
      </form-group>

      <form-group :label="getDisplayName('picture')" :is-required="isFieldRequired('picture')">
        <file-upload data-vv-name="picture" v-model="record.picture" accept="image/*"></file-upload>
      </form-group>

      <form-group :label="getDisplayName('thumbnail')" :is-required="isFieldRequired('thumbnail')">
        <file-upload data-vv-name="thumbnail" v-model="record.thumbnail" accept="image/*"></file-upload>
      </form-group>

      <form-group :label="getDisplayName('company_name')" :is-required="isFieldRequired('company_name')">
        <input class="form-control" data-vv-name="company_name" type="text" v-model="record.company_name" />
      </form-group>

      <form-group :label="getDisplayName('company_description')" :is-required="isFieldRequired('company_description')">
        <textarea class="form-control" data-vv-name="company_description" type="text" v-model="record.company_description">
        </textarea>
      </form-group>

      <form-group :label="getDisplayName('company_url')" :is-required="isFieldRequired('company_url')">
        <input class="form-control" data-vv-name="company_url" type="text" v-model="record.company_url" />
      </form-group>

      <form-group :label="getDisplayName('interviewer')" :is-required="isFieldRequired('interviewer')">
        <input class="form-control" data-vv-name="interviewer" type="text" v-model="record.interviewer" />
      </form-group>

      <form-group :label="getDisplayName('regions')" :is-required="isFieldRequired('regions')">
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

      <form-group :label="getDisplayName('category_interview_id')" :is-required="isFieldRequired('category_interview_id')">
        <select v-model="selectedCategory"
                class="form-control"
                data-vv-name="category_interview_id">
          <option v-for="option in categoryList" :value="option.id">
            {{ option.title }}
          </option>
        </select>
      </form-group>

      <form-group :label="getDisplayName('content')" :is-required="isFieldRequired('content')">
        <quill-editor v-model="record.content" data-vv-name="content"
                ref="myQuillEditor"
                :options="editorOption"
                @blur="onEditorBlur($event)"
                @focus="onEditorFocus($event)"
                @ready="onEditorReady($event)">
        </quill-editor>
      </form-group>

    </validation-form>

    <div class="col-sm-12 btn-control">
      <div class="text-center">
        <button type="button" class="btn btn-primary btn-sm" @click="showModal()">
          <span class="glyphicon glyphicon-ok"></span> {{ $t("common_action.ok") }}
        </button>
        <button type="button" class="btn btn-default btn-sm" @click="resetChange()">
          <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel") }}
        </button>
      </div>
    </div>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="updateChange"
                         :message="$t('message.before_update')">
    </confirmation-dialog>
  </div>
</template>

<script>

  import _ from 'lodash';
  import Multiselect from 'vue-multiselect';
  import {user} from '../../../js/app/manage/main';
  import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
  import rf from '../../../js/lib/RequestFactory';
  import Utils from '../../../js/common/Utils';
  import Const from '../../../js/common/Const';
  import FileUpload from '../../../components/common/FileUpload.vue';
let defaultRecord = {
    title: '',
    content: '',
    sub_content: '',
    picture: '',
    thumbnail: '',
    date: '',
    post_start_date: '',
    post_end_date: '',
    interviewer: '',
    company_name: '',
    company_description: '',
    company_url: '',
    category_interview_id: ''
};
let masterdata = {
  regions: [],
};
  export default {
    components: {
      FileUpload,
      Multiselect
    },

    data() {
      return {
        user,
        subNavigators,
        record: {
          atforms: [],
        },
        oldRecord: {},
        masterdata,
        isShowModal: false,
        categoryList: [],
        selectedCategory: '',
        selectedRegions: [],
        editorOption: {

      },
      }
    },
    methods: {

      getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'interviews', fieldName);
      },
      isFieldRequired(fieldName) {
        return Utils.isFieldRequired(this.masterdata, 'interviews', fieldName);
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
      showModal() {
        this.isShowModal = true;
      },
      updateChange() {
        this.isShowModal = false;
        this.record.category_interview_id = (this.selectedCategory) ? this.selectedCategory : '';
        this.record.regions = _.map(this.selectedRegions, 'id');
        const interviewPromise = (this.record && this.record.id)
          ? rf.getRequest('InterviewRequest').updateOne(this.record.id, this.record)
          : rf.getRequest('InterviewRequest').createANewOne(this.record);
        interviewPromise.then(res => {
          window.Utils.growl('request.request_success');
          if (!this.record.id) {
            this.$router.push({
              path: '/interview/list',
            });
          }
          this.oldRecord = res;
          this.localReset();
          this.$refs.linkForm.$emit('REJECT_FORM', null);
        }).catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.interview.$emit('REJECT_FORM', validationErrors);
          }
        });
      },
      resetChange() {
        this.$router.push({
          path: '/interview/list',
        });
      },
      localReset() {
        this.$refs.interview.$emit('FORM_ERRORS_CLEAR');
        this.record = JSON.parse(JSON.stringify(this.oldRecord));
        this.selectedCategory = this.record.category_interview_id;
        this.selectedRegions =  (this.record.regions.length) ? _.map(this.record.regions, regionId =>
            _.find(this.masterdata.regions, region => region.id === regionId)) : [];
      },
    },
    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      let id = this.$route.query.id;
      const categoryPromise = rf.getRequest('CategoryInterviewRequest').getCategories();
      const interviewPromise = id
        ? rf.getRequest('InterviewRequest').getOne(id)
        : Promise.resolve(defaultRecord);

      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

      Promise.all([interviewPromise, masterdataPromise, categoryPromise]).then(([interview, masterdata, categories]) => {
        this.masterdata = masterdata;
        this.oldRecord = interview;
        this.categoryList = categories;
        this.localReset();
      });
    }
  }
</script>

<style scoped>
  .btn-control {
    margin-bottom: 20px;
  }
  textarea {
    resize: none;
  }
</style>
<style>
  .ql-container .ql-editor {
    min-height: 30em;
    padding-bottom: 1em;
    max-height: 70em;
    background: white;
  }
</style>
