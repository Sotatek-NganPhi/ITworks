<template>
    <div>
         <h1>{{$t('sub_menu.search_key.prefecture')}}</h1>
        <data-table :getData="getData" ref="datatable">
          <th data-sort-field="name">{{getDisplayName('prefecture_name')}}</th>
          <th style="width: 10%"></th>
          <template slot="body" scope="props">
            <tr>
              <td>{{ props.item.name }}</td>
              <td @click="openEditPage(props.item)" style="width: 10%">
                <button type="button" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-pencil"></span> {{$t('common_action.edit')}}</button>
              </td>
            </tr>
          </template>
        </data-table>
    </div>
</template>

<script>

import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import {searchKeysNavigators as subNavigators} from '../../../js/app/manage/routes';

export default {
  data() {
    return {
      user,
      subNavigators,
      masterdata : {},
    }
  },

  methods: {
    getData(params) {
      let api = 'prefectures';
      if (!params) params = {};
      params.with = 'wards';
      return rf.getRequest('MasterdataRequest').getList(api, params);
    },
     getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'prefectures', fieldName);
    },
    openEditPage(row) {
      this.$router.push({
        path: '/search_keys/prefecture/edit',
        query: {
          id: row ? row.id : null
        }
      });
    }
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
     const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    Promise.all([masterdataPromise]).then(([masterdata]) => {
      this.masterdata = masterdata;
    });
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