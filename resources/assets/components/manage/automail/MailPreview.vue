<template>
    <div>
        <div class="text-center">
            <button type="button" class="btn btn-primary" @click="close()">{{ $t("auto_mail.form_action.close") }}</button> 
        </div>
        </br>
        <table class="mail">
        <tr>
        <td>送信者: {{ getParams.from_address_work}} <{{ getParams.from_address_email   }}>
        <br>
        主題: {{getParams.subject}}</td>
        </tr>
        <tr>
        <td>{{getParams.header}}</td>
        </tr>
        <tr>
                <td>
        <div v-for="item in getParams.item1">■{{item}}: <br></div>
        </td>
        </tr>
        <tr>
        <th>
        >>続きを見る
        <br>
http://demo.job-maker.jp/kyujin/83515/
<br>
↓スマホ版はこちら
<br>
http://demo.job-maker.jp/kyujin/83515/
<br>
=================================================================□
<br >
</th>
        </tr>
        <tr>
        <td>
            <span class="preview">{{getParams.footer}}</span>
        </td >
        </tr>
        </table>
    </div>
</template>
<script>
import {candidateNavigators  as subNavigators} from '../../../js/app/manage/routes';
export default {
    data() {
    return {
    subNavigators,
    getParams:{},
    }
    },
    methods: {
    close() {
    window.close();
    },
    },
    mounted(){
        this.$emit('EVENT_PAGE_CHANGE', this);
        this.getParams=this.$route.query;
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

    table.mail tr td span.preview{
        white-space: pre-line;
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