<template>
  <div>
    <div class="content">
      <div class="col-lg-12">
        <div class="col-lg-6">
          <div>
            <div class="title">
              <h4>現在の状況</h4>
            </div>
            <h5>現在の登録原稿数: {{totalJob}} 件</h5>
            <div>
              <table class="border">
                <tbody>
                <tr>
                  <th width="300">掲載原稿数</th>
                  <td>
                    {{totalJob - (totalJobInvalid + totalJobExpired)}} 件
                  </td>
                </tr>

                <tr>
                  <th width="300">無効（保留）原稿数</th>
                  <td>
                    {{totalJobInvalid}} 件
                  </td>
                </tr>
                <tr>
                  <th width="300">掲載期間外原稿数</th>
                  <td>
                    {{totalJobExpired}} 件
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div>
            <div class="title">
              <h4>昨日のアクセス数ランキング</h4>
            </div>
            <div class="text-center">
              <router-link to="/analysis/access-ranking">アクセス数ランキングページへ</router-link>
            </div>
          </div>
          <div>
            <div class="title">
              <h4>昨日のアクセス数</h4>
            </div>
            <div class="row">
              <table class="border">
                <tbody>
                <tr>
                  <th>日付</th>
                  <th>仕事詳細情報閲覧数</th>
                  <th>応募数</th>
                </tr>
                <tr>
                  <td align="center">{{yesterday}}</td>
                  <td align="right">{{totalAccessJob}}</td>
                  <td align="right">{{totalAccessApplicant}}</td>
                </tr>
                </tbody>
              </table>
            </div>
            <div class="text-center">
              <router-link to="/analysis/search">月間アクセス数ページへ</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import rf from '../../js/lib/RequestFactory';
  import {user} from '../../js/app/manage/main';
  export default {
    data(){
      return {
        user: null,
        subNavigators: [],
        totalJob: 0,
        totalJobExpired: 0,
        totalJobInvalid: 0,
        totalAccessJob: 0,
        totalAccessApplicant: 0,
        yesterday: null,
      }
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      rf.getRequest('HomeRequest').getStatisticalHomePage().then(res => {
        const statisticalJob = res.statisticalJob;
        const statisticalAccess = res.statisticalAccess;
        this.totalJob = statisticalJob.total || 0;
        this.totalJobExpired = statisticalJob.totalExpired || 0;
        this.totalJobInvalid = statisticalJob.totalInvalid || 0;
        this.totalAccessJob = statisticalAccess.job.totalViews || 0;
        this.totalAccessApplicant = statisticalAccess.applicant || 0;
        this.yesterday = statisticalAccess.yesterday;
      });
    }
  }
</script>
<style>
  table.border {
    border-collapse: collapse;
    border: 1px solid #999999;
    margin: 10px auto;
    width: 100%;
  }

  .border th {
    border: 1px solid #999999;
    text-align: left;
    min-height: 40px;
    height: 40px;
    padding: 6px 3px;
  }

  .border td {
    border: 1px solid #999999;
    height: 40px;
    min-height: 40px;
    text-align: left;
    padding: 6px 3px;
  }
</style>