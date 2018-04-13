<template>
    <div>
        <br>
        <br>
        <label class="col-sm-2 control-label">取得月</label>
        <div class="col-sm-10">
          <div class="col-sm-5" style="padding: 0px 5px 0px 0px">
            <select class="form-control" v-model="selectedYear">
              <option :value="currentYear">{{currentYear}}</option>
              <option :value="currentYear - 1">{{currentYear - 1}}</option>
              <option :value="currentYear - 2">{{currentYear - 2}}</option>
              <option :value="currentYear - 3">{{currentYear - 3}}</option>
              <option :value="currentYear - 4">{{currentYear - 4}}</option>
            </select>
          </div>
          <div class="col-sm-5" style="padding: 0px 5px 0px 0px">
            <select class="form-control" v-model="selectedMonth">
              <option :value="item" v-for="item in 12">{{item}}</option>
            </select>
          </div>
        </div>
        <br>
        <br>
        <br>
         <div class="text-center">
          <button type="button" class="btn btn-primary" @click="seeMonthAnalysis()">{{$t('common_action.ok')}}</button>
          <button type="button" class="btn btn-primary" @click="downloadCsv()">{{$t('form_action.download_csv')}}</button>
        </div>
        <br>
        <br>
        <div>
          <h3 class="ui header">アクセス解析（検索結果）</h3>
          <div class="table">
            <table class="table table-bordered" style="text-align: center;">
              <thead>
                <tr>
                  <th style="width: 8%;">当月</th>
                  <th style="width: 23%;">新規原稿数</th>
                  <th style="width: 23%;">仕事詳細情報閲覧数</th>
                  <th style="width: 23%;">応募数</th>
                  <th style="width: 23%;">サイト登録者数</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td>
                    <input v-model="monthData.new_job" disabled>
                  </td>
                    <td>
                        <input v-model="monthData.views" disabled>
                    </td>
                  <td>
                    <input v-model="monthData.applicant" disabled>
                  </td>
                  <td>
                    <input v-model="monthData.registrant" disabled>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        <br>
        <div class="datatable">
          <data-table :getData="getData" ref="datatable">
            <th>日付</th>
            <th>閲覧可能原稿</th>
            <th>仕事詳細情報閲覧数</th>
            <th>応募数</th>
            <th>サイト登録者数</th>
            <th></th>
            <th></th>
            <template slot="body" scope="props">
              <tr>
                <td>{{ props.item.date }}</td>
                <td>{{ props.item.available_job }}</td>
                <td>{{ props.item.views }}</td>
                <td>{{ props.item.applicant }}</td>
                <td>{{ props.item.registrant }}</td>
              </tr>
            </template>
          </data-table>
        </div>
        </div>
    </div>
</template>

<script>
import {user} from '../../../js/app/manage/main';
import {analysisNavigators as subNavigators} from '../../../js/app/manage/routes';
import QueryBuilder from '../../../js/lib/QueryBuilder';
import rf from '../../../js/lib/RequestFactory';
import queryString from 'querystring';

export default {
  data() {
    return {
      user,
      subNavigators,
      monthData: {
        new_job: 0,
        views: 0,
        applicant: 0,
        registrant: 0,
      },
      rows: [],
      selectedYear: new Date().getFullYear(),
      selectedMonth: new Date().getMonth() + 1,
    }
  },
  methods: {
    seeMonthAnalysis(){
      rf.getRequest('AnalysisRequest').getMonthlyAnalysis(this.selectedYear, this.selectedMonth).then(res => {
        this.monthData = res;
      });
      this.$refs.datatable.$emit('DataTable:refresh');
    },

    getData(params, callback) {
      return rf.getRequest('AnalysisRequest').getDaylyAnalysis(this.selectedYear, this.selectedMonth);
    },

    downloadCsv() {
      var params = {selectedYear: this.selectedYear, selectedMonth: this.selectedMonth};
      const query = queryString.stringify(params);
      window.location.href = `/manage/analysis/csv?${query}`;
    },
  },

  computed: {
    currentYear: function () {
      return new Date().getFullYear();
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    this.seeMonthAnalysis();
  }
}
</script>

<style scoped>
  input {
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
</style>