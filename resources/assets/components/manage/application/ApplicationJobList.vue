<template>  
  <div>
    <h2>{{ $t("job_list.search_title") }}</h2>
    <validation-form style="margin-bottom: 70px">

      <form-group :label=" $t('applicant.company_posting') ">
        <select class="form-control" type="text" v-model="searchParams.company_id">
          <option value="">---</option>
          <option v-for="company in companies" :key="company.id" :value="company.id"> {{company.name }}</option>
        </select>
      </form-group>

      <form-group :label=" $t('applicant.start') ">
        <date-picker class="col-sm-6" v-model="searchParams.post_start_date" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>

      <form-group :label=" $t('applicant.end') ">
        <date-picker class="col-sm-6" v-model="searchParams.post_end_date" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>
    
    </validation-form>
    <div class="text-center">
      <button type="button" class="btn btn-primary" @click="search()"> {{ $t("form_action.search") }} </button>
      <button type="button" class="btn btn-primary" @click="clear()"> {{ $t("form_action.clear") }} </button>
    </div>



  <h2> {{ $t("applicant.title.one") }} </h2>

  <data-table :getData="getData" ref="datatable">
    <th data-sort-field="id" style="width: 7%">{{ getDisplayName('id') }}</th>
    <th data-sort-field="company_name" style="width: 10%">{{ getDisplayName('company_name') }}</th>
    <th data-sort-field="description" style="width: 20%">{{ getDisplayName('description') }}</th>
    <th style="width: 15%">{{ $t("applicant.posting") }}</th>
    <th data-sort-field="applicants_count" style="width: 15%">{{ $t("applicant.count") }}</th>
    <th style="width: 13%"></th>
    <template slot="body" scope="props">
      <tr>
        <td style="width: 7%">{{ props.item.id}} </td>
        <td style="width: 10%"> {{ props.item.company.name }} </td>
        <td style="width: 20%"> {{ props.item.description }} </td>
        <td style="width: 15%"> {{ props.item.post_start_date | date }} to {{ props.item.post_start_date | date}}</td>
        <td style="width: 15%"> {{ props.item.applicants_count | number }} / {{ props.item.max_applicant | number }}</td>

        <td @click="showApplicant(props.item.id)" style="width: 13%">
          <button type="button" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-pencil"></span>{{$t('applicant.title.applicant_list')}}</button>
        </td>
      </tr>
  </template>
  </data-table>
</div>
</template>

<script>
import _ from 'lodash';
import moment from 'moment';
import Utils from '../../../js/common/Utils';
import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import queryString from 'querystring';
import QueryBuilder from '../../../js/lib/QueryBuilder';

import Multiselect from 'vue-multiselect';

const searchParams = {
  company_id:'',
  company_name: '',
  post_start_date: '',
  post_end_date: '',
};

export default {
  components: {
    Multiselect
  },

  data() {
    return {
      user,
      searchParams,
      companies: [],
      items:{},
      searchJobsHaveEntriesOnly: false,
      masterdata: Utils.getMasterdataSkel(),
    };
  },

  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'jobs', fieldName);
    },
    getData(params) {
      return rf.getRequest('JobRequest').getJobApplicant(params);
    },
    showApplicant(row) {
      this.$parent.$emit('JOB_APPLICANT',row);

    },
    deleteRow(row) {
      rf.getRequest('JobRequest').removeOne(row.id).then(res => {
        this.$refs.datatable.$emit('DataTable:refresh')
      });
    },
    initSearchParams() {
      this.category_level_2 = ''
      this.searchJobsHaveEntriesOnly = false
      this.searchParams = JSON.parse(JSON.stringify(searchParams));
    },

    buildSearchQuery() {
      if(this.searchJobsHaveEntriesOnly) {
        this.searchParams['applicants.COUNT()'] = 1;
      }
      const $query = new QueryBuilder(this.searchParams);
      return new QueryBuilder(this.searchParams);
    },
    search() {
      this.$refs.datatable.$emit('DataTable:filter',this.buildSearchQuery());
    },
    clear() {
      this.initSearchParams();
      this.search();
    }
  },
  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    const companiesPromise = rf.getRequest('CompanyRequest').getCompanies();

    Promise.all([masterdataPromise, companiesPromise]).then(([masterdata, companies]) => {
      this.masterdata = masterdata;
      this.companies = companies;
      this.initSearchParams();
    });
  },
}
</script>

<style scoped>
.btn-control {
  position: fixed;
  padding: 20px;
  left: 0px;
  bottom: 0px;
  width:100%;
  height: auto;
  background:rgb(245, 248, 250);
}
</style>
