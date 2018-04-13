<template>
    <div>
      <div><h2>検索</h2></div>
      <form class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label">取得月</label>
          <div class="col-sm-10">
            <div class="col-sm-6" style="padding: 0px 5px 0px 0px">
              <select class="form-control" v-model="searchParams.selectedYear" placeholder="pickyear">
                <option :value="currentYear">{{currentYear}}</option>
                <option :value="currentYear - 1">{{currentYear - 1}}</option>
                <option :value="currentYear - 2">{{currentYear - 2}}</option>
                <option :value="currentYear - 3">{{currentYear - 3}}</option>
                <option :value="currentYear - 4">{{currentYear - 4}}</option>
              </select>
            </div>
            <div class="col-sm-6" style="padding: 0px 5px 0px 0px">
              <select class="form-control" v-model="searchParams.selectedMonth">
                <option :value="item" v-for="item in 12">{{item}}</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">都道府県</label>
          <div class="col-sm-10">
            <select class="form-control" type="text" v-model="searchParams.prefecture_id">
              <option value="">--選択してください--</option>
              <option v-for="prefecture in masterdata.prefectures" :value="prefecture.id">{{ prefecture.name }}</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">職種</label>
          <div class="col-sm-10">
            <select v-model="searchParams.category_lv3_id" class="form-control">
              <option value="">--選択してください--</option>
              <option :value="item.id" v-for="item in masterdata.category_level3s" :key="item.id">{{item.name}}</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">掲載企業</label>
          <div class="col-sm-10">
            <select class="form-control" v-model="searchParams.company_id">
              <option value="">--選択してください--</option>
              <option :value="item.id" v-for="item in companies" :key="item.id">{{item.name}}</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="id" class="col-sm-2 control-label">仕事ID</label>
          <div class="col-sm-10">
            <input class="form-control" id="input-job_id" type="text" v-model="searchParams.job_id"/>
          </div>
        </div>

        <div class="text-center">
          <button type="button" class="btn btn-primary" @click="searchAnalysis()">{{$t('form_action.search')}}</button>
          <button type="button" class="btn btn-primary" @click="downloadCsv()">{{$t('form_action.download_csv')}}</button>
        </div>
      </form>
      <div>
        <h3 class="ui header">アクセス解析（検索結果）</h3>
        <div class="table">
          <table class="table table-bordered" style="text-align: center;">
            <thead>
              <tr>
                <th style="width: 50%;text-align:center">仕事詳細情報閲覧数</th>
                <th style="width: 50%;text-align:center">応募数</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <input class="disabled-input" v-model="monthData.views" disabled>
                </td>
                <td>
                  <input class="disabled-input" v-model="monthData.applicant" disabled>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="datatable">
          <data-table :getData="getData" ref="datatable">
            <th>日付</th>
            <th>仕事詳細情報閲覧数</th>
            <th>応募数</th>
            <template slot="body" scope="props">
              <tr>
                <td>{{ props.item.date }}</td>
                <td>{{ props.item.views }}</td>
                <td>{{ props.item.applicant }}</td>
              </tr>
            </template>
          </data-table>
        </div>
      </div>
    </div>
</template>

<script>

import {user} from '../../../js/app/manage/main';
import queryString from 'querystring';
import {analysisNavigators as subNavigators} from '../../../js/app/manage/routes';
import rf from '../../../js/lib/RequestFactory';
import async from 'async';

let masterdata = {
  prefectures: [],
  category_level3s: [],
};
export default {
  data() {
    return {
      user,
      subNavigators,
      masterdata,
      searchParams: {
        selectedYear: new Date().getFullYear(),
        selectedMonth: new Date().getMonth() + 1,
        prefecture_id: '',
        category_lv3_id: '',
        company_id: '',
        job_id: '',
      },
      monthData: {
        new_job: 0,
        views: 0,
        applicant: 0,
      },
      rows: [],
      companies: [],
    }
  },

  methods: {
    searchAnalysis() {
      rf.getRequest('AnalysisRequest').getMonthSearchAnalysis(this.searchParams).then(res => {
        this.monthData = res;
      });
      this.getData();
      this.$refs.datatable.$emit('DataTable:refresh');
    },

    getData(params, callback) {
      return rf.getRequest('AnalysisRequest').getDaySearchAnalysis(this.searchParams);
    },

    downloadCsv() {
       window.location.href = '/manage/analysis/csv?' + queryString.stringify(this.searchParams);
    },
  },

  computed: {
    currentYear: function () {
      return new Date().getFullYear();
    },
  },

  mounted() {
    let self = this;
    this.$emit('EVENT_PAGE_CHANGE', this);
    async.auto({
      masterdata: function (next) {
        rf.getRequest('MasterdataRequest').getAll(next);
      },
    }, function (err, ret) {
      if (err) return window.EventBus.$emit('EVENT_COMMON_ERROR', err);
      self.masterdata = ret.masterdata;
    });
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    const companiesPromise = rf.getRequest('CompanyRequest').getCompanies();
    Promise.all([masterdataPromise, companiesPromise]).then(([masterdata, companies]) => {
      this.masterdata = masterdata;
      this.companies = companies;
    });
    this.searchAnalysis();
  }
}
</script>

<style scoped>
  .disabled-input {
    text-align:center;
    background-color:transparent;
    border:none;
  }
  .datatable {
    text-align: center;
  }
  .table{
    text-align: center;
  }
  th{
    text-align: center;
  }
</style>