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

      <form-group :label="getDisplayName('link_title')">
        <input class="form-control" type="text" v-model="searchParams.linkTitle"/>
      </form-group>

      <form-group :label="getDisplayName('url')">
        <input v-validator="'url'" name="URL" class="form-control" type="text" v-model="searchParams.url"/>
      </form-group>

      <form-group :label="getDisplayName('start_date')">
        <date-picker class="col-sm-6" v-model="searchParams.startDate" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>

      <form-group :label="getDisplayName('end_date')">
        <date-picker class="col-sm-6" v-model="searchParams.endDate" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>
      <form-group :label="getDisplayName('is_active')">
        <radio-group inline="true" v-model="searchParams.isActive" :options="linkStatusOptions"/>
      </form-group>
    </validation-form>
      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
        <button type="button" class="btn btn-primary" @click="clearSearchForm()">{{ $t("form_action.clear") }}</button>
      </div>

    <h2>{{ $t("link.list_title") }}</h2>

    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 5%">{{ getDisplayName('id') }}</th>
      <th style="width: 7%">{{ getDisplayName('regions') }}</th>
      <th data-sort-field="link_title" style="width: 17%">{{ getDisplayName('link_title') }}</th>
      <th data-sort-field="url" style="width: 22%">{{ getDisplayName('url') }}</th>
      <th data-sort-field="image" style="width: 19%">{{ getDisplayName('image') }}</th>
      <th data-sort-field="order_by" style="width: 6%">{{ getDisplayName('order_by') }}</th>
      <th data-sort-field="start_date" style="width: 6%">{{ getDisplayName('start_date') }}</th>
      <th data-sort-field="end_date" style="width: 6%">{{ getDisplayName('end_date') }}</th>
      <th style="width: 6%"></th>
      <th style="width: 6%"></th>
      <template slot="body" scope="props">
        <tr>

          <td style="width: 5%">{{ props.item.id }}</td>
          <td style="width: 7%">
            <span>{{ concatRegionNames(props.item.regions) }}</span>
          </td>
          <td style="width: 17%">{{ props.item.link_title }}</td>
          <td style="width: 22%">{{ props.item.url }}</td>
          <td style="width: 19%">{{ props.item.image }}</td>
          <td style="width: 6%">{{ props.item.order_by }} </td>
          <td style="width: 6%">{{ props.item.start_date }}</td>
          <td style="width: 6%">{{ props.item.end_date }}</td>
          <td @click="openEditPage(props.item)" style="width: 6%"> 
            <button type="button" class="btn btn-default btn-sm">
              <span class="glyphicon glyphicon-pencil"></span> {{$t("common_action.edit")}}
            </button>
          </td>
          <td @click="deleteRow(props.item)" style="width: 6%">
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
        areaName: '',
        linkTitle: '',
        url: '',
        image: '',
        startDate: '',
        endDate: '',
        isActive: '',
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
      return window.Utils.getFieldDisplayName(this.masterdata, 'links', fieldName);
    },

    getData(params) {
      return rf.getRequest('LinkRequest').getList(params);
    },
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'links', fieldName);
    },
    openEditPage(row) {
      this.$router.push({
        path: '/link/edit',
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
      rf.getRequest('LinkRequest').removeOne(row.id).then(res => {
        this.$refs.datatable.$emit('DataTable:refresh')
      });
    },
    clearSearchForm() {
      this.searchParams = {
        id: '',
        areaName: '',
        linkTitle: '',
        url: '',
        image: '',
        startDate: '',
        endDate: '',
        isActive: ''
      }
      this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
    },
    buildSearchQuery() {
      const searchParams = {
        'id': this.searchParams.id,
        'link_title': [this.searchParams.linkTitle, 'like'],
        'url': [this.searchParams.url, 'like'],
        'start_date': [this.searchParams.startDate, '>='],
        'end_date': [this.searchParams.endDate, '<='],
        'is_active': this.searchParams.isActive,
      };
      const query = new QueryBuilder(searchParams);
      return query;
    },
    search() {
      this.$refs.searchForm.validate().then(() => {
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      }).catch(() => {});
    },
    concatRegionNames(regions) {
      if (!regions || !regions.length) {
        return '';
      }

      return _.map(regions, 'name').join('・');
    }
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