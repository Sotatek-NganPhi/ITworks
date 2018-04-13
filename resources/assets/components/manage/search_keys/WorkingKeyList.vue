<template>
    <div>
        <table class="table">
          <thead>
            <tr>
              <th>{{$t('search_keys.category')}}</th>
              <th>{{$t('search_keys.item_name')}}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(work, key) in working" v-if="work.length">
              <td>{{ key | changeString }}</td>
              <td>
                <table class="sub-table">
                  <tr v-for="row in work">
                    <td>{{row.name}}</td>
                    <td @click="openEditPage(row, key)" style="width: 13%">
                      <button type="button" class="btn btn-default btn-sm">
                      <span class="glyphicon glyphicon-pencil"></span> {{$t('common_action.edit')}}</button>
                    </td>
                    <td @click="deleteRow(row, key)" style="width: 13%">
                      <button type="button" class="btn btn-danger btn-sm">
                      <span class="glyphicon glyphicon-remove"></span> {{$t('common_action.delete')}}</button>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="deleteData"
                         :message="$t('message.before_delete')" :params="paramsModal">
        </confirmation-dialog>
    </div>
</template>

<script>
import Vue from 'vue';
import rf from '../../../js/lib/RequestFactory';
import Utils from '../../../js/common/Utils';
import {user} from '../../../js/app/manage/main';
import {searchKeysNavigators as subNavigators} from '../../../js/app/manage/routes';

let working = {
  working_days: [],
  working_hours: [],
  working_periods: [],
  working_shifts: [],
};

Vue.filter('changeString', function (value) {
  let name="";
  switch(value){
    case 'working_days':
    name= "勤務日数";
    break;
    case 'working_hours':
    name="勤務時間";
    break;
    case 'working_periods':
    name= "勤務期間";
    break;
    case 'working_shifts':
    name= "勤務時間帯";
    break;
  }
  return name;
})

export default {
  data() {
    return {
      user,
      subNavigators,
      working,
      isShowModal: false,
      paramsModal: null,
    }
  },
  methods: {
    getData(params) {
      let api_working_days = 'working_days';
      let api_working_hours = 'working_hours';
      let api_working_periods = 'working_periods';
      let api_working_shifts = 'working_shifts';

      rf.getRequest('MasterdataRequest').getList(api_working_days, params).then(res => {
        this.working.working_days = res;
      });
      rf.getRequest('MasterdataRequest').getList(api_working_hours, params).then(res => {
        this.working.working_hours = res;
      })
      rf.getRequest('MasterdataRequest').getList(api_working_periods, params).then(res => {
        this.working.working_periods = res;
      })
      rf.getRequest('MasterdataRequest').getList(api_working_shifts, params).then(res => {
        this.working.working_shifts =res;
      })
    },
    openEditPage(row, key) {
      this.$router.push({
        path: '/search_keys/working/edit',
        query: {
          id: row ? row.id : null,
          key: key
        }
      });
    },
    deleteRow(row, api) {
      this.isShowModal = true;
      this.paramsModal = {
        row: row,
        api: api
      };
    },

    deleteData(params) {
      this.isShowModal = false;
      rf.getRequest('MasterdataRequest').removeOne(params.api, params.row.id);
    }
  },
  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
  },

  created() {
    this.getData()
  }
}
</script>
<style type="text/css" scoped>
  tr{
    border-bottom: 1px solid #bfbfbf;
  }
  .sub-table{
    width: 100%;
  }
  .sub-table tr{
    height: 50px;
    line-height: 40px;
  }
  .sub-table tr:last-child{
    border-bottom: none;
  }
</style>