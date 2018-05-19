<template>
  <div>
    <div>
      <h2>{{$t('analysis_search.title')}}</h2>
      <div>
        <form class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label">{{$t('analysis_search.region')}}</label>
            <div class="col-sm-6">
              <select class="form-control" type="text" v-model="analysisSearch.region">
                <option value="">--{{$t('common_action.pick')}} --</option>
                <option v-for="region in masterData.regions" :key="region.id" :value="region.id">
                  {{ region.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">{{$t('analysis_search.time')}}</label>
            <div class="col-sm-6">
            <radio-group inline="true" v-model="analysisSearch.time" :options="timeOptions"/>
            </div>
          </div>
          <div class="text-center">
            <button type="button" class="btn btn-primary" @click="search()">
              {{$t("form_action.search")}}
            </button>
            <button type="button" class="btn btn-primary" @click="clearForm()">
              {{$t("form_action.clear")}}
            </button>
          </div>
        </form>
      </div>
    </div>
    <div>
      <h2>{{$t('analysis_search.result')}}</h2>
      <div>
        <div class="col-sm-10">
          <table>
            <thead>
            <tr>
              <th>{{$t('analysis_search.rank')}}</th>
              <th>{{$t('analysis_search.region')}}</th>
              <th style="text-transform: capitalize;">{{$t(this.criteria_display)}}</th>
              <th>{{$t('analysis_search.count')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(row, index) in rows" :key="index">
              <td>{{index + 1}}</td>
              <td>{{nameRegion}}</td>
              <td>{{row.name}}</td>
              <td>{{row.sum || 0}}</td>
            </tr>
            <tr v-if="rows.length == 0">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  import rf from '../../js/lib/RequestFactory';
  import {user} from '../../js/app/manage/main';
  import {analysisNavigators as subNavigators} from '../../js/app/manage/routes';
  import Utils from '../../js/common/Utils';

  export default {
    data() {
      return {
        user,
        subNavigators,
        timeOptions: Utils.getTime(),
        masterData: {},
        analysisSearch: {
          region: '',
          time: 1,
          criteria: ''
        },
        rows: [],
        region: null,
      }
    },

    props: ["criteria", "criteriaDisplay"],

    computed: {
      nameRegion(){
        if(this.region){
          return this.region.name;
        }
        return '--';
      },
      criteria_display () {
        if(this.criteria==="merit")
          return "analysis_search.merit";
        else 
          return "analysis_search.job_type";
      },
    },

    methods: {
      search() {
        this.analysisSearch.criteria = this.criteria;
        rf.getRequest('AnalysisRequest').criteriaAnalysis({analysisSearch : this.analysisSearch}).then(res => {
          this.rows = res.results;
          this.region = res.region;
        });
      },

      clearForm(){
        this.analysisSearch = {
          region: '',
          time: 1,
          criteria: ''
        };
        this.search();
      }
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

      Promise.all([masterdataPromise]).then(([masterdata]) => {
        this.masterData = masterdata;
      });
      this.search();
    }
  }
</script>

<style type="text/css" scoped>
  table {
    width: 100%;
    clear: both;
    margin-bottom: 15px;
  }

  thead {
    text-align: left;
  }

  thead tr {
    height: 40px;
  }

  th {
    border: 1px solid #999999;
    padding: 6px 6px;
    height: 40px;
  }

  td {
    text-align: left;
    border: 1px solid #999999;
    padding: 6px 6px;
    height: 40px;
  }
</style>
