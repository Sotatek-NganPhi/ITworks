<template>
<div>

  <div class="text-center">
    <button type="button" class="btn btn-success btn-sm" @click="openEditPage()">
      <span class="glyphicon glyphicon-plus"></span> {{ $t("common_action.new") }}
    </button>
  </div>
   <h1>{{$t('announcement_list.search_title')}}</h1>

  <validation-form ref="searchForm">
    <form-group :label="getDisplayName('id')">
      <input v-validator="'numeric|min:0'" class="form-control" type="text" v-model="searchParams.id" />
    </form-group>

    <form-group :label="getDisplayName('content')">
      <input class="form-control" type="text" v-model="searchParams.content" />
    </form-group>

    <form-group :label="getDisplayName('start_date')">
      <date-picker v-model="searchParams.start_date" format="YYYY-MM-DD" locale="ja" required></date-picker>
    </form-group>

    <form-group :label="getDisplayName('end_date')">
      <date-picker v-model="searchParams.end_date" format="YYYY-MM-DD" locale="ja"></date-picker>
    </form-group>

    <form-group :label="getDisplayName('is_active')">
      <radio-group inline="true" v-model="searchParams.is_active" :options="statusOptions" />
    </form-group>

    <div class="text-center">
      <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
      <button type="button" class="btn btn-primary" @click="initSearchParams()">{{ $t("form_action.clear") }}</button>
      <button type="button" class="btn btn-primary" @click="downloadCsv()">{{ $t("form_action.download_csv") }}
      </button>
    </div>

  </validation-form>

  <h1>{{$t('announcement_list.list_title')}}</h1>

  <data-table :getData="getData" ref="datatable">
    <th data-sort-field="id" style="width: 7%">{{this.getDisplayName('id')}}</th>
    <th data-sort-field="content" style="width: 63%">{{this.getDisplayName('content')}}</th>
    <th data-sort-field="start_date" style="width: 8%">{{this.getDisplayName('start_date')}}</th>
    <th data-sort-field="end_date" style="width: 8%">{{this.getDisplayName('end_date')}}</th>
    <th style="width: 7%"></th>
    <th style="width: 7%"></th>
    <template slot="body" scope="props">
      <tr>
        <td style="width: 7%">{{ props.item.id }}</td>
        <td style="width: 63%">{{ props.item.content }}</td>
        <td style="width: 8%">{{ props.item.start_date }}</td>
        <td style="width: 8%">{{ props.item.end_date }}</td>
        <td @click="openEditPage(props.item)" style="width: 7%">
          <button type="button" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-pencil"></span> {{$t("common_action.edit")}}
          </button>
        </td>
        <td @click="deleteRow(props.item)" style="width: 7%">
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
import rf from '../../../js/lib/RequestFactory';
import QueryBuilder from '../../../js/lib/QueryBuilder';
import Utils from '../../../js/common/Utils';
import {user} from '../../../js/app/manage/main';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
import queryString from 'querystring';

const searchParams = {
  id: '',
  content: '',
  start_date: '',
  end_date: '',
  is_active: '',
};

export default {
  data() {
    return {
      user,
      subNavigators,
      searchParams,
      masterdata: Utils.getMasterdataSkel(),
      isShowModal: false,
      messageModal: "あなたは、このデータをしません削除したいです?",
      paramsModal: null,
      statusOptions: Utils.getBooleans()
    }
  },
  methods: {
    getData(params) {
      return rf.getRequest('AnnouncementRequest').getList(params);
    },
    openEditPage(row) {
      this.$router.push({
        path: '/announcement/edit',
        query: {
          id: row ? row.id : null
        }
      });
    },
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'announcements', fieldName);
    },
    getReferenceValues(fieldName) {
      // TODO: make search fields configurable and remove these hack
      if (fieldName === 'is_active') {
        let result = {};
        result[this.$t('common_field.active')] = 1;
        result[this.$t('common_field.in_active')] = 0;
        result[this.$t('common_field.not_specified')] = '';
        return result;
      }

      return Utils.getReferenceValues(this.masterdata, 'jobs', fieldName);
    },
    deleteRow(row) {
      this.isShowModal = true
      this.paramsModal = row
    },
    deleteData(row) {
      this.isShowModal = false
      rf.getRequest('AnnouncementRequest').removeOne(row.id).then(res => {
        this.$refs.datatable.$emit('DataTable:refresh')
      });
    },
    initSearchParams() {
      this.searchParams = JSON.parse(JSON.stringify(searchParams));
      this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
    },
    buildSearchQuery() {
      const query = new QueryBuilder(this.searchParams);

      if (this.searchParams.post_start_date) {
        query.append('post_start_date', this.searchParams.post_start_date, '>=');
      }

      if (this.searchParams.post_end_date) {
        query.append('post_end_date', this.searchParams.post_end_date, '<=');
      }
      return query;
    },
    search() {
      this.$refs.searchForm.validate().then(() => {
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      }).catch(() => {});
    },
    downloadCsv() {
      const query = this.buildSearchQuery();
      window.location.href = '/manage/announcement/csv?' + queryString.stringify(query);
    }
  },
  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    Promise.all([masterdataPromise]).then(([masterdata]) => {
      this.masterdata = masterdata;
      this.initSearchParams();
    });
  },
}
</script>
<style>
  .text-center {
      margin-top: 20px;
      margin-bottom: 20px;
  }
</style>