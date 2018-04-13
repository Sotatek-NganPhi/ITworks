<template>
  <div>
    <div class="text-center">
      <button type="button" class="btn btn-success btn-sm" @click="openEditPage()">
        <span class="glyphicon glyphicon-plus"></span> {{ $t("common_action.new") }}
      </button>
    </div>

    <h2>{{ $t("link.search_title") }}</h2>

     <validation-form ref="searchForm">
      <form-group :label="getDisplayName('id')">
        <input v-validator="'numeric|min:0'" name="ID" class="form-control" type="text" v-model="searchParams.id"/>
      </form-group>

      <form-group :label="getDisplayName('title')">
        <input class="form-control" type="text" v-model="searchParams.title"/>
      </form-group>

      <form-group :label="getDisplayName('sub_content')">
        <input class="form-control" type="text" v-model="searchParams.sub_content"/>
      </form-group>

      <form-group :label="getDisplayName('interviewer')">
        <input class="form-control" type="text" v-model="searchParams.interviewer"/>
      </form-group>

      <form-group :label="getDisplayName('post_start_date')">
        <date-picker class="col-sm-6" v-model="searchParams.post_start_date" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>

      <form-group :label="getDisplayName('post_end_date')">
        <date-picker class="col-sm-6" v-model="searchParams.post_end_date" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>

    </validation-form>

      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
        <button type="button" class="btn btn-primary" @click="clearSearchForm()">{{ $t("form_action.clear") }}</button>
      </div>

    <h2>{{ $t("link.list_title") }}</h2>

    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 10%">{{ getDisplayName('id') }}</th>
      <th data-sort-field="title" style="width: 10%">{{ getDisplayName('title') }}</th>
      <th data-sort-field="sub_content" style="width: 16%">{{ getDisplayName('sub_content') }}</th>
      <th data-sort-field="interviewer" style="width: 16%">{{ getDisplayName('interviewer') }}</th>
      <th data-sort-field="post_start_date" style="width: 13%">{{ getDisplayName('post_start_date') }}</th>
      <th data-sort-field="post_end_date" style="width: 13%">{{ getDisplayName('post_end_date') }}</th>
      <th style="width: 11%"></th>
      <th style="width: 11%"></th>
      <template slot="body" scope="props">
        <tr>

          <td style="width: 10%">{{ props.item.id }}</td>
          <td style="width: 10%">{{ props.item.title }}</td>
          <td style="width: 16%">{{ props.item.sub_content }}</td>
          <td style="width: 16%">{{ props.item.interviewer }}</td>
          <td style="width: 13%">{{ props.item.post_start_date | date }}</td>
          <td style="width: 13%">{{ props.item.post_end_date | date}}</td>
          <td @click="openEditPage(props.item)" style="width: 11%">
            <button type="button" class="btn btn-default btn-sm">
              <span class="glyphicon glyphicon-pencil"></span> {{$t("common_action.edit")}}
            </button>
          </td>
          <td @click="deleteRow(props.item)" style="width: 11%">
            <button type="button" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-remove"></span> {{$t("common_action.delete")}}
            </button>
          </td>
        </tr>
      </template>
    </data-table>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="deleteData"
                         :message="messageModal" :params="paramsModal">
    </confirmation-dialog>
  </div>
</template>

<script>

import _ from 'lodash';
import rf from '../../../js/lib/RequestFactory';
import QueryBuilder from '../../../js/lib/QueryBuilder';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
import Multiselect from 'vue-multiselect';
import FileUpload from '../../../components/common/FileUpload.vue';

let masterdata = {
  regions: [],
};

export default {
    components: {
    Multiselect,
    FileUpload
  },
  data() {
    return {
      searchParams: {
        id: '',
        title: '',
        sub_content: '',
        interviewer: '',
        post_end_date: '',
        post_start_date: ''
      },
      masterdata,
      subNavigators,
      rows: [],
      linkStatusOptions: window.Utils.getBooleans(),
      isShowModal: false,
      messageModal: "あなたは、このデータをしません削除したいです?",
      paramsModal: null,
    }
  },

  methods: {
    getDisplayName(fieldName) {
      return window.Utils.getFieldDisplayName(this.masterdata, 'interviews', fieldName);
    },

    getData(params) {
      return rf.getRequest('InterviewRequest').getList(params);
    },
    openEditPage(row) {
      this.$router.push({
        path: '/interview/edit',
        query: {
          id: row ? row.id : null
        }
      });
    },
    deleteRow(row) {
      this.isShowModal = true;
      this.paramsModal = row;
    },
    deleteData(row) {
      this.isShowModal = false;
      rf.getRequest('InterviewRequest').removeOne(row.id).then(res => {
        this.$refs.datatable.$emit('DataTable:refresh')
      });
    },
    clearSearchForm() {
      this.searchParams = {
        id: '',
        title: '',
        sub_content: '',
        interviewer: '',
        post_start_date: '',
        post_end_date: '',
      }
      this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
    },
    buildSearchQuery() {
      const searchParams = {
        'id': this.searchParams.id,
        'title': [this.searchParams.title, 'like'],
        'sub_content': [this.searchParams.sub_content, 'like'],
        'interviewer': [this.searchParams.interviewer, 'like'],
        'post_start_date': [this.searchParams.post_start_date, '>='],
        'post_end_date': [this.searchParams.post_end_date, '<='],
      };
      const query = new QueryBuilder(searchParams);
      return query;
    },
    search() {
      this.$refs.searchForm.validate().then(() => {
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      }).catch(() => {});
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    rf.getRequest('MasterdataRequest')
      .getAll()
      .then(masterdata => {
        this.masterdata = masterdata;
      });
  }
}
</script>