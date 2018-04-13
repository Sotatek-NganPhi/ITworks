<template>
    <div>
        <div class="text-center">
            <button type="button" class="btn btn-primary" @click="close()">{{ $t("auto_mail.form_action.close") }}</button> 
        </div>
        </br>
        <table class="mail">
        <tr>
        <td>送信者: {{ getParams.sender}}
        <br>
        受取人: {{getParams.recipient }}
        <br>
        主題: {{getParams.subject}}</td>
        </tr>
        <tr>
        <td v-html="content"></td>
        </tr>
        </table>
    </div>
</template>
<script>
import {candidateNavigators  as subNavigators} from '../../../js/app/manage/routes';
  import rf from '../../../js/lib/RequestFactory';

export default {
    data() {
    return {
    getParams:{},
    content:'',
    subNavigators,
    }
    },
    methods: {
    close() {
    this.$router.go(-1);
    },
    },
    mounted(){
        this.$emit('EVENT_PAGE_CHANGE', this);
        rf.getRequest('MailLogsRequest').mailReview(this.$route.query.id).then(res => {
            this.getParams = res;
            this.content=this.getParams.content;
        });
    },
}
</script>
<style scoped>
table.mail tr th {
    padding-top: 18px;/*2.3653%*/
    padding-bottom: 18px;
    padding-right: 57px; /*3.5625%*/
    width:1000px;
    padding-left:20px;
    border-style:solid solid solid solid;
    }

table.mail tr td{
    padding-top: 18px;/*2.3653%*/
    padding-bottom: 18px;
    padding-right: 57px; /*3.5625%*/
    padding-left:20px;
    width:1000px;
    border-style:solid solid solid solid;
    }
</style>