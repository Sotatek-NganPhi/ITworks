<template>
    <form class="form-horizontal">
      <table class="border">
        <tbody>
          <tr v-for="config in configs">
            <th v-if="config.isFirstInGroup" :rowspan="config.groupLength">{{ config.group }}</th>
            <td v-if="config.groupLength > 1" class="name">{{ config.display_name }}</td>
            <td :colspan="(config.groupLength > 1) ? 1 : 2" class="input">
              <input
                type="text"
                name="site_name"
                v-model="config.value"
                :value="config.value" />
              <span v-if="config.description">
                <br/><font color="#FF3300">{{config.description}}</font>
              </span>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="col-sm-12">
        <div class="text-center btn-control">
          <button type="button" class="btn btn-primary btn-sm" @click="showModal">
            <span class="glyphicon glyphicon-ok"></span> 次へ
          </button>
          <button type="button" class="btn btn-default btn-sm" @click="refresh">
            <span class="glyphicon glyphicon-remove"></span> キャンセル
          </button>
        </div>
      </div>
      <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                           @ConfirmationDialog:OK="updateChange" :message="$t('message.before_update')">
      </confirmation-dialog>
    </form>
</template>
<script>

import _ from 'lodash';
import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import {metadataNavigators as subNavigators} from '../../../js/app/manage/routes';

export default {
  data() {
    return {
      user,
      subNavigators,
      configs: [],
      isShowModal: false
    }
  },

  methods: {
    showModal() {
      this.isShowModal = true;
    },

    updateChange: function() {
      this.isShowModal = false;
      let changes = [];
      _.forEach(this.configs, (config, i) => {
        let originalConfig = this._originalConfigs[i];
        if (config.value !== originalConfig.value) {
          let change = JSON.parse(JSON.stringify(originalConfig));
          change.value = config.value;
          changes.push(change);
        }
      });

      if (!changes.length) {
        window.Utils.growl('request.request_success');
        return;
      }

      rf.getRequest('MasterdataRequest')
        .updateBulk('configs', changes)
        .then(res => {
          window.Utils.growl('request.request_success');
        })
        .catch(err => {
          window.EventBus.$emit('EVENT_COMMON_ERROR', err);
        });
    },
    getConfigByKey (key) {
      return _.find(this.configs, record => {
        return record.key === key;
      });
    },
    updateGroup (groupLeaderIndex, groupLength) {
      let groupLeader = this.configs[groupLeaderIndex];
      if (!groupLeader) return;
      groupLeader.groupLength = groupLength;
      for (let memberIndex = 1; memberIndex < groupLength; memberIndex++) {
        this.configs[groupLeaderIndex + memberIndex].groupLength = groupLength;
      }
    },
    refresh() {
      rf.getRequest('MasterdataRequest').getList('configs').then(res => {
        this._originalConfigs = res;
        this.configs = JSON.parse(JSON.stringify(res));
        let currentGroupName = '';
        let currentGroupIndex = 0;
        _.forEach(this.configs, (config, i) => {
          if (!config.group) {
            config.group = config.display_name;
            config.isFirstInGroup = true;
            config.groupLength = 1;
          }

          if (currentGroupName !== config.group) {
            if (currentGroupIndex > 0) {
              let prevGroupLeaderIndex = i - currentGroupIndex;
              let prevGroupLength = currentGroupIndex;
              this.updateGroup(prevGroupLeaderIndex, prevGroupLength);
            }

            config.isFirstInGroup = true;
            currentGroupName = config.group;
            currentGroupIndex = 1;
            return;
          }

          config.isFirstInGroup = false;
          currentGroupIndex++;

          if (i === this.configs.length - 1) {
            let prevGroupLeaderIndex = i - currentGroupIndex + 1;
            let prevGroupLength = currentGroupIndex;
            this.updateGroup(prevGroupLeaderIndex, prevGroupLength);
          }
        });
      });
    }
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    this.refresh();
  },
}
</script>
<style scoped>
table.border{
  width: 100%;
  border-collapse: collapse;
  border: 1px solid #999999;
  margin: 10px auto 60px;
  font-size: 100%;
}
tbody{
  display: table-row-group;
  vertical-align: middle;
  border-color: inherit;
}
tr{
  display: table-row;
  vertical-align: inherit;
  border-color: inherit;
}
.border th{
  width: 30%;
  text-align: left;
  border: 1px solid #999999;
  padding: 6px 3px;
  line-height: 150%;
  vertical-align: top;
}
.border td{
  border: 1px solid #999999;
  padding: 6px 3px;
  line-height: 150%;
  vertical-align: top;
  text-align: left;
}
.group .name{
  width: 30%;
}
.group .input{
  width: 70%;
}
input{
  width: 300px;
}
input.btn100{
  border-radius: 5px;
  box-shadow: 0 1px 0 0 #FFFFFF inset;
  font-weight: bold;
  padding: 5px 20px;
  text-align: center;
  text-decoration: none;
  cursor: pointer;
  border: #999 1px solid;
  width: auto;
}
.btn100.confirm{
  background: #3097D1;
}
input:hover{
  opacity: 0.7;
}
.btn-control{
  text-align: center;
  position: fixed;
  padding: 10px;
  left: 0px;
  bottom: 0px;
  width: 100%;
  height: auto;
  background: rgb(245, 248, 250);
}
span{
  margin: 0px;
}
</style>
