<template>
  <div>
    <validation-form ref="searchForm">
      <div class="text-center">
        <button type="button" class="btn btn-success btn-sm" @click="openEditPage()">
          <span class="glyphicon glyphicon-plus"></span> {{ $t("common_action.new") }}
        </button>
      </div>

      <h2>{{ $t("special_promotion.search_title") }}</h2>

      <form-group :label="$t('common_field.id')">
        <input class="form-control" v-validator="'numeric|min:0'" type="text" v-model="searchParams.id"/>
      </form-group>

      <form-group :label="$t('special_promotion.name')">
        <input class="form-control" type="text" v-model="searchParams.name"/>
      </form-group>

      <form-group :label="$t('special_promotion.start')">
        <date-picker v-model="searchParams.start_date" ref="special_start_date" format="YYYY-MM-DD" locale="ja"  required></date-picker>
      </form-group>

      <form-group :label="$t('special_promotion.end')">
        <date-picker v-model="searchParams.end_date" ref="special_end_date" format="YYYY-MM-DD" locale="ja" required></date-picker>
      </form-group>

      <form-group :label="$t('common_field.is_active')">
        <radio-group inline="true" v-model="searchParams.is_active" :options="specialStatusOptions"/>
      </form-group>

    </validation-form>
      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
        <button type="button" class="btn btn-primary" @click="clearSearchForm()">{{ $t("form_action.clear") }}</button>
        <button type="button" class="btn btn-primary" @click="downloadCsv()">{{ $t("form_action.download_csv") }}</button>
      </div>


    <h2 class="section-space">{{ $t("special_promotion.list_title") }}</h2>

    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 9%">{{this.getDisplayName('id')}}</th>
      <th data-sort-field="name" style="width: 46%">{{this.getDisplayName('name')}}</th>
      <th data-sort-field="is_active" style="width: 9%">{{this.getDisplayName('is_active')}}</th>
      <th data-sort-field="start_date" style="width: 11%">{{this.getDisplayName('start_date')}}</th>
      <th data-sort-field="end_date" style="width: 11%">{{this.getDisplayName('end_date')}}</th>
      <th style="width: 7%"></th>
      <th style="width: 7%"></th>
      <template slot="body" scope="props">
        <tr>
          <td style="width: 9%">{{ props.item.id }}</td>
          <td style="width: 46%">{{ props.item.name }}</td>
          <td style="width: 9%">{{ props.item.is_active | boolean }}</td>
          <td style="width: 11%">{{ props.item.start_date }}</td>
          <td style="width: 11%">{{ props.item.end_date }}</td>
          <td @click="openEditPage(props.item)" style="width: 7%"> 
            <button type="button" class="btn btn-default btn-sm">
              <span class="glyphicon glyphicon-pencil"></span> {{ $t("common_action.edit") }}
            </button>
          </td>
          <td @click="deleteRow(props.item)" style="width: 7%">
            <button type="button" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.delete") }}
            </button>
          </td>
        </tr>
      </template>
    </data-table>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="deleteData"
                         :message="$t('message.before_delete')" :params="paramsModal">
    </confirmation-dialog>
  </div>
</template>

<script>

import _ from 'lodash';
import QueryBuilder from '../../../js/lib/QueryBuilder';
import rf from '../../../js/lib/RequestFactory';
import queryString from 'querystring';
import {user} from '../../../js/app/manage/main';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';

const searchParams = {
  id: '',
  name: '',
  start_date: '',
  end_date: '',
  is_active: '',
};

export default {
    data() {
      return {
        user,
        subNavigators,
        rows: [],
        searchParams,
        masterdata: Utils.getMasterdataSkel(),
        specialStatusOptions: Utils.getBooleans(),
        isShowModal: false,
        paramsModal: null
      }
    },

    methods: {
      getData(params) {
        return rf.getRequest('SpecialPromotionRequest').getList(params);
      },
      getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'special_promotions', fieldName);
    },
      buildSearchQuery() {
        return new QueryBuilder(this.searchParams);
      },
      search() {
        this.$refs.searchForm.validate().then(() => {
          this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
        }).catch(() => {});
      },
      clearSearchForm() {
        this.initSearchParams();
        this.$refs.special_start_date.$emit('DatePicker:clear');
        this.$refs.special_end_date.$emit('DatePicker:clear');
        this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      },
      downloadCsv() {
        var query = this.buildSearchQuery();
        window.location.href = "/manage/special/csv?" + queryString.stringify(query);
      },
      openEditPage(row) {
        this.$router.push({
          path: '/special/edit',
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
        rf.getRequest('SpecialPromotionRequest').removeOne(row.id).then(res => {
          this.$refs.datatable.$emit('DataTable:refresh')
        });
      },
      initSearchParams() {
        this.searchParams = {
          id: '',
          name: '',
          start_date: '',
          end_date: '',
          is_active: '',
        }
      }
    },

    mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

    Promise.all([masterdataPromise]).then(([masterdata]) => {
      this.masterdata = masterdata;
    });
    this.clearSearchForm();
  }
}
</script>


<style scoped>
    .section-space {
        padding-top: 50px;
    }
</style>
