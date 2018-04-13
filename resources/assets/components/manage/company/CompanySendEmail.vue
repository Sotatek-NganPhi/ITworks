<template>
    <div>
        <form class="form-horizontal">

            <div class="form-group">
                <label for="id" class="col-sm-2 control-label">{{ $t("company.name") }}</label>
                <div class="col-sm-10">
                    <input class="form-control" id="input-company_name" type="text" v-model="record.name" />
                </div>
            </div>

            <div class="form-group">
                <label for="id" class="col-sm-2 control-label">{{ $t("company.name_phonetic") }}</label>
                <div class="col-sm-10">
                    <input class="form-control" id="input-name_phonetic" type="name_phonetic"
                           v-model="record.name_phonetic" />
                </div>
            </div>

            <div class="form-group">
                <label for="id" class="col-sm-2 control-label">{{ $t("common_field.phone_number") }}</label>
                <div class="col-sm-10">
                    <input class="form-control" id="input-phone_number" type="phone_number"
                           v-model="record.phone_number" />
                </div>
            </div>

            <div class="form-group">
                <label for="id" class="col-sm-2 control-label">{{ $t("company.expire_date") }}</label>
                <div class="col-sm-10">
                    <input class="form-control" id="input-expire_date" type="text" v-model="record.expire_date" />
                </div>
            </div>

            <div class="form-group">
                <label for="id" class="col-sm-2 control-label">{{ $t("common_field.email") }}</label>
                <div class="col-sm-10">
                    <input class="form-control" id="input-email" type="text" v-model="record.email" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{ $t("campaign.content") }}</label>
                <div class="col-sm-10">
                    <quill-editor v-model="record.content"
                                  ref="myQuillEditor"
                                  :options="editorOption"
                                  @blur="onEditorBlur($event)"
                                  @focus="onEditorFocus($event)"
                                  @ready="onEditorReady($event)">
                    </quill-editor>
                </div>
            </div>
        </form>
        <div class="text-center">
            <button type="button" class="btn btn-primary btn-sm" @click="companySendEmail()">
                <span class="glyphicon glyphicon-envelope"></span> {{$t("common_action.send_email") }}
            </button>
            <button type="button" class="btn btn-default btn-sm" @click="resetChange()">
                <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel") }}
            </button>
        </div>
    </div>
</template>

<script>

    import rf from '../../../js/lib/RequestFactory';
    import {user} from '../../../js/app/manage/main';
    import {companyNavigators as subNavigators} from '../../../js/app/manage/routes';
    export default {
        data() {
            return {
                user,
                subNavigators,
                editorOption: {
                },
                record: {
                    name:'',
                    name_phonetic:'',
                    phone_number:'',
                    expire_date:'',
                    email:'',
                    content: '',
                },
                oldRecord: {
                },
            }
        },

        methods: {
            companySendEmail(){
                const sendMailPromise = rf.getRequest('CompanyRequest').sendMail(this.record);
                Promise.all([sendMailPromise]).then(([sendMail]) => {
                    window.Utils.growl('Company send mail successfully.');
                    this.$router.push({
                        path: '/company/list'
                    });
                });
            },
            onEditorBlur(editor) {
                // console.log('editor blur!', editor)
            },
            onEditorFocus(editor) {
                // console.log('editor focus!', editor)
            },
            onEditorReady(editor) {
                // console.log('editor ready!', editor)
            },
            resetChange() {
                this.record = JSON.parse(JSON.stringify(this.oldRecord));
            }
        },

        mounted() {
            let self = this;
            self.$emit('EVENT_PAGE_CHANGE', self);
            let id = self.$route.query.id;
            if (!id) return;
            rf.getRequest('CompanyRequest').getOne(id).then(res => {
                self.oldRecord = res;
                self.resetChange();
            });
        }
    }
</script>
<style type="text/css">
    .ql-container .ql-editor {
        min-height: 30em;
        padding-bottom: 1em;
        max-height: 70em;
        background: white;
    }
</style>