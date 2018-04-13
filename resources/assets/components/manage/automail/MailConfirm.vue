<template>
    <div>
    <h2>{{$t('auto_mail.title.delivery_setting')}}</h2>
        <table class="mail">
                <tr>
                    <th>{{$t('auto_mail.interval')}}</th>
                    <td> {{ getParams.interval }}日に1回</td>
                </tr>
                <tr>
                    <th>{{$t('auto_mail.status.title')}}</th>
                    <td>{{ getParams.status }}</td>
                </tr>
                <tr>
                    <th>{{$t('auto_mail.date')}}</th>
                    <td>{{getParams.delivery_date }}</td>
                </tr>
            
        </table>
        <h2>{{$t('auto_mail.title.content_settings')}}</h2>
        <table class="mail">
            <tr>
                <th>{{$t('auto_mail.from_address.title')}}</th>
                <td> {{getParams.from_address_work}} <{{getParams.from_address_email}}></td>
            </tr>
            <tr>
                <th>{{$t('auto_mail.subject')}}</th>
                <td>{{getParams.subject}}</td>
            </tr>
            <tr>
                <th>{{$t('auto_mail.header')}}</th>
                <td>{{getParams.header}}</td>
            </tr>
            <tr>
                <th>{{$t('auto_mail.work_number')}}</th>
                <td>{{getParams.work}} 件まで </td>
            </tr>
            <tr>
                <th>{{$t('auto_mail.item.title')}}</th>
                <td>
                <div v-for="item in getParams.item1" >{{item}}</div></td>
            </tr>
             <tr>
                <th>{{$t('auto_mail.footer')}}</th>
                <td><span class="preview">{{getParams.footer}}</span></td>
            </tr>
        </table>
        <div  class="text-center">
        <button type="button" class="btn btn-primary" @click="back()">{{ $t("auto_mail.form_action.back") }}</button>
        <button type="button" class="btn btn-primary" @click="register()">{{ $t("auto_mail.form_action.register") }}</button>
       
        </div>
    </div>
</template>
<script>
import rf from '../../../js/lib/RequestFactory';
import {candidateNavigators  as subNavigators} from '../../../js/app/manage/routes';
export default {
    data() {
    return {
    subNavigators,
    getParams:{},
    }
    },
    methods: {
        back() {
    this.$router.go(-1)
    },
    register(){
     const agentPromise =rf.getRequest('AutoMailRequest').updateSetting(this.getParams);
      agentPromise.then(res => {
        window.Utils.growl('request.request_success');
        this.$router.push({
          path: '/candidate/mail_setting'
        });
      });
     
 },
        },
    mounted(){
        this.$emit('EVENT_PAGE_CHANGE', this);
        this.getParams=this.$route.query;
    },
}
</script>
<style scoped>
table.mail tr th{
    font-size: 18pt;
    color: rgb(0,37,122);
    background-color: rgb(152,198,234);
    text-align: center;
    border-style:solid solid solid solid;
    font-family: "Arial Bold";
    height: 18px;
    width:300px;
    padding-top: 20px;/*2.3653%*/
    padding-bottom: 18px;
    padding-right: 20px; /*3.5625%*/
}
table.mail tr td span.preview{
    white-space: pre-line;
}
table.mail tr td{
    padding: 18px 20px;
    width:1000px;
    border-style:solid solid solid solid;
}
</style>