<template>
  <div>
    <form class="form-horizontal" style="margin-bottom: 70px">
      <validation-form ref="fieldSetting">
      <div><span class="glyphicon glyphicon-triangle-bottom"></span> <span>{{$t('field_settings.edit_title')}}</span></div>

      <form-group :label="$t('common_field.id')">
        <input class="form-control"  type="text" v-model="record.id" disabled/>
      </form-group>

      <form-group :label="getDisplayName('table_name')">
        <input class="form-control" type="text" v-model="record.table_name" disabled/>
      </form-group>

      <form-group :label="getDisplayName('field_name')">
        <input class="form-control" type="text" v-model="record.field_name" disabled/>
      </form-group>

      <form-group :label="getDisplayName('display_name')">
        <input data-vv-name="display_name" class="form-control" type="text"
               v-model="record.display_name"/>
      </form-group>

      <form-group :label="getDisplayName('description')">
        <input data-vv-name="description" class="form-control" type="text"
               v-model="record.description"/>
      </form-group>

      <form-group :label="getDisplayName('is_required')" :is-required="true">
        <radio-group inline="true" v-validator="'required'"
                     v-model="record.is_required"
                     :options="getReferenceValues('is_required')">
        </radio-group>
      </form-group>

      <form-group :label="getDisplayName('is_list_display')" :is-required="true">
        <radio-group inline="true" v-validator="'required'"
                     v-model="record.is_list_display"
                     :options="getReferenceValues('is_list_display')">
        </radio-group>
      </form-group>

      <form-group :label="getDisplayName('is_active')" :is-required="true">
        <radio-group inline="true" v-validator="'required'"
                     v-model="record.is_active"
                     :options="getReferenceValues('is_active')">
        </radio-group>
      </form-group>
      </validation-form>
    </form>
    <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="updateChange()">
        <span class="glyphicon glyphicon-ok"></span> OK
      </button>
      <button type="button" class="btn btn-default btn-sm" @click="cancel()">
        <span class="glyphicon glyphicon-remove"></span> Cancel
      </button>
    </div>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="updateData" :message="$t('message.before_update')">
    </confirmation-dialog>
  </div>
</template>

<script>

import Utils from '../../../js/common/Utils';
import rf from '../../../js/lib/RequestFactory';
import {fieldSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';

export default {
  data() {
    return {
      subNavigators,
      oldRecord: {},
      masterdata: {},
      record: {},
      isShowModal: false
    };
  },

  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'field_settings', fieldName);
    },
    updateChange() {
      this.$refs.fieldSetting.validate().then(() => {
        this.isShowModal = true;
      }).catch(() => {
      });
    },

    cancel() {
      this.$router.push({
        path: '/field_settings/list?table=' + this.record.table_name,
      });
    },

    updateData(){
      this.isShowModal = false;
      if (this.record && this.record.id) {
        rf.getRequest('MasterdataRequest')
            .updateOne('field_settings', this.record.id, this.record)
            .then(res => {
              Utils.growl('Requested successfully.');
              this.oldRecord = res;
              this.localReset();
            });
      }
    },

    resetChange() {
      if (!this.oldRecord.id) {
        this.localReset();
        return;
      }

      rf.getRequest('MasterdataRequest')
        .getOne('field_settings', this.oldRecord.id)
        .then(res => {
          this.oldRecord = res;
          this.localReset();
        });
      rf.getRequest('MasterdataRequest').getAll().then(res => {
        this.masterdata = res;
      });
    },

    localReset() {
      this.record = JSON.parse(JSON.stringify(this.oldRecord));
    },

    getReferenceValues(fieldName) {
      // TODO: make search fields configurable and remove these hack
      if (fieldName === 'is_required' ||
          fieldName === 'is_list_display' ||
          fieldName === 'is_active') {
        return Utils.getYesNoOptions();
      }

      return {};
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);

    let id = this.$route.query.id;
    rf.getRequest('MasterdataRequest')
      .getOne('field_settings', id)
      .then(field => {
        this.oldRecord = field;
        this.resetChange();
      });
  }
}
</script>

<style scoped>
  .div-inline{
    display:inline-block;
  }

  .row {
    padding-bottom: 5px;
  }
</style>

<style lang="sass">
  @import "../../../sass/_merit.scss"
</style>