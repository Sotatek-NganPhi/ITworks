<template>
  <div>
    <h4>{{$t('analysis_ranking.title')}}</h4>
    <div class="col-md-12">
    <table>
      <thead>
      <tr>
        <th class="ranking">{{$t('analysis_ranking.rank')}}</th>
        <th class="task-id">{{$t('analysis_ranking.task_id')}}</th>
        <th class="access-count">{{$t('analysis_ranking.access_count')}}</th>
        <th class="description">{{$t('analysis_ranking.description')}}</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(row, index) in rows" :key="index">
        <td>{{index + 1}}</td>
        <td>{{row.id}}</td>
        <td>{{row.sum || 0}}</td>
        <td class="description"><a :href="'/job/' + row.id">{{row.description}}</a></td>
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
</template>

<script>
  import {user} from '../../../js/app/manage/main';
  import {analysisNavigators as subNavigators} from '../../../js/app/manage/routes';
  import rf from '../../../js/lib/RequestFactory';

  export default {
    data(){
      return {
        rows: [],
        user,
        subNavigators,
        criteriaTime: 'yesterday'
      }
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      rf.getRequest('AnalysisRequest').analyzeOverTime({criteria_time : this.criteriaTime}).then(res => {
        this.rows = res;
      });
    }
  }
</script>

<style scoped>
  h4{
    width: 100%;
    padding: 12px 0;
    text-indent: 25px;
    border-radius: 5px;
  }
  table {
    width: 70%;
    clear: both;
    margin-bottom: 15px;
  }

  thead {
    text-align: left;
    background: #f0f6da;
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
  .description{
    max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .ranking, .access-count{
    width: 100px;
  }
  .task-id{
    width: 60px;
  }
</style>