<template>
  <div>
      <h2> {{$t('auto_mail.title.delivery_setting')}} </h2>
      <validation-form>
        <form-group :label=" $t('auto_mail.interval') ">
        <select class= "form-control" id="input-interval" type="text" v-model="saveParams.interval">
          <option value="">---</option>
          <option  v-for = " interval in 30" :key="interval" :value="interval">{{ interval }}</option>
        </select>
        </form-group>
        <form-group :label=" $t('auto_mail.date') " >
          <datetime-picker v-model="saveParams.delivery_date" locale="ja"></datetime-picker>
        </form-group>

        <form-group :label= " $t('auto_mail.status.title')"  >
          <label class="radio-inline">
          <input type="radio" name="optradio4" value="有効" v-model="saveParams.status" />{{ $t('auto_mail.status.choice_1') }}
          </label>
          <label class="radio-inline">
          <input type="radio" name="optradio4" value="無効" v-model="saveParams.status" />{{ $t('auto_mail.status.choice_2') }}
          </label>
        </form-group>


      <h2 > {{$t('auto_mail.title.content_settings')}}</h2>
        <form-group :label=" $t('auto_mail.from_address.title') ">

        {{ $t('auto_mail.from_address.work') }}
        <input class="form-control" type="text" v-model="saveParams.from_address_work" />
        </form-group>

         <form-group :label=" $t('auto_mail.subject') ">
          <input class="form-control" type="text" v-model="saveParams.subject" />
         </form-group>

        <form-group :label=" $t('auto_mail.header') ">
          <input class="form-control" type="text" v-model="saveParams.header" />
        </form-group>
        <form-group :label=" $t('auto_mail.work_number') ">
        <select class= "form-control" id="input-work" type="text" v-model="saveParams.work">
          <option value="">---</option>
          <option  v-for = "work in 30" :key="work" :value="work">{{ work }}</option>
        </select>
           </br>
        </form-group>
        <form-group :label=" $t('auto_mail.item.title')" >
          <label style="font-weight: normal;" class="checkbox" v-for="item in items" :key="item.name">
            <input type="checkbox" v-model="saveParams.items" :value="item.value"/>{{ item.name }}
          </label>
        </form-group>

        <form-group :label=" $t('auto_mail.footer') ">
          <textarea rows="5" class="form-control" v-model="saveParams.footer"></textarea>
        </form-group>
         <div class="text-center">
        <button type="button" class="btn btn-primary" @click="clear()">{{ $t("auto_mail.form_action.clear") }}</button>
        <button type="button" class="btn btn-primary"><router-link :to="{ path: '/candidate/mail_preview',
        query: this.saveParams,}" target="_blank">{{ $t("auto_mail.form_action.preview") }}</router-link></button>
        <button type="button" class="btn btn-primary" @click="next">{{ $t("auto_mail.form_action.next") }}</button>
        </div>
      </validation-form>
  </div>
</template>

<script>
  import rf from '../../../js/lib/RequestFactory';
  import { candidateNavigators as subNavigators } from '../../../js/app/manage/routes';

  export default {
    data() {
      return {
        saveParams: {
          status: '',
          delivery_date: '',
          interval: '',
          from_address_work: '',
          footer: '',
          items: [],
          subject: '',
          header: '',
          footer: '',
          work: '',
        },
        subNavigators,
        selected: [],
        items: [
          {
            name: 'メインキャッチ',
            value: 'work_main',
          },
          {
            name:' 企業名',
            value: 'company_name',
          },
          {
            name: '給与',
            value: 'salary',
          },
          {
            name: '勤務時間',
            value: 'working_hours',
          },
          {
            name: '応募条件',
            value: 'application_condition',
          },
          {
            name: 'メッセージ',
            value: 'message',
          },
          {
            name: '休日休暇',
            value: 'holiday_vacation',
          },
          {
            name: '受付担当者',
            value:'receptionist',
          },
          {
            name:' 先輩の出身校',
            value: 'seniors_hometown',
          },
          {
            name: '面接地',
            value: 'interview_place',
          },
          {
            name: 'Work No',
            value: 'id',
          }
        ],
      }
    },
    methods: {
      clear() {
        const settingPromise = rf.getRequest('AutoMailRequest').getList();
        Promise.all([settingPromise]).then(([mails]) => {
          this.saveParams =  mails;
        });
      },
      next() {
        this.$router.push({
          path: '/candidate/mail_confirm',
          query: this.saveParams,
        });
      },
    },
    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      this.clear();
    },
  }
</script>

<style type="text/css" scoped>
  .btn.btn-primary a {
    color: white;
    outline: none;
    text-decoration: none;
  }
  textarea {
    resize: none;
  }
  .checkbox {
    margin-left: 20px;
  }
</style>
