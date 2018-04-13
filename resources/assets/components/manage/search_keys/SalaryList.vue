<template>
    <div>
      <h1>{{$t('sub_menu.search_key.payroll')}}</h1>
      <data-table :getData="getData" ref="datatable">
        <th data-sort-field="description">{{$t('search_keys.search_item.payroll')}}</th>
        <th style="width: 10%"></th>
        <template slot="body" scope="props">
          <tr>
            <td>{{ props.item.description }}</td>
            <td @click="openEditPage(props.item)" style="width: 10%">
              <button type="button" class="btn btn-default btn-sm">
              <span class="glyphicon glyphicon-pencil"></span>{{$t('common_action.edit')}}</button>
            </td>
            <td @click="deleteRow(props.item)" style="width: 13%">
              <button type="button" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-remove"></span> {{$t('common_action.delete')}}</button>
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

import Utils from '../../../js/common/Utils';
import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import {searchKeysNavigators as subNavigators} from '../../../js/app/manage/routes';

export default {
  data() {
    return {
      user,
      subNavigators,
      isShowModal: false,
      paramsModal: null,
      api: 'salaries',
    }
  },

  methods: {
    getData(params) {
      return rf.getRequest('MasterdataRequest').getList(this.api, params);
    },
    openEditPage(row) {
      this.$router.push({
        path: '/search_keys/salary/edit',
        query: {
          id: row ? row.id : null
        }
      })
    },
    deleteRow(row) {
      this.isShowModal = true;
      this.paramsModal = row;
    },

    deleteData(row) {
      this.isShowModal = false;
      rf.getRequest('MasterdataRequest').removeOne(this.api, row.id).then(res => {
        this.$refs.datatable.$emit('DataTable:refresh')
      });
    }
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
  },

}
</script>

<style scoped>
  td{
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }
</style>