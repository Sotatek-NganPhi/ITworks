<template>
  <div>
    <div class="msg-a-t">
      <strong>{{ title }}</strong>
    </div>

    <div class="conversation">
      <template v-for="message in messages">
        <div class="message">
          <div class="msg-header">
            <div class="msg-author">
              <div class="name">
                <template v-if="message.from === 'user'">
                  {{ message.user_name }}
                </template>
                <template v-else>
                  {{ message.company_name }}
                </template>
              </div>
              <div class="time">
                <span>{{ formatDate(message.created_at) }}</span>
              </div>
            </div>
          </div>
          <div class="clear"></div>
          <div class="msg-content">
            <div v-html="message.content"></div>
          </div>
        </div>
      </template>
    </div>
    <div class="reply">
        <div class="form-group">
          <label for="content">{{$t('job.message')}}</label>
          <textarea class="form-control" name="content" id="content" rows="5" v-model="message"></textarea>
        </div>
        <div class="form-group gr-btn text-center">
          <button type="submit" class="btn" @click="sendMessage">{{$t('form_action.reply')}}</button>
        </div>
    </div>
  </div>
</template>

<script>
  import {candidateNavigators  as subNavigators} from '../../../js/app/manage/routes';
  import rf from '../../../js/lib/RequestFactory';
  import queryString from 'querystring';
  import Utils from '../../../js/common/Utils';
  import QueryBuilder from '../../../js/lib/QueryBuilder';
  import moment from 'moment'

  export default {
    data() {
      return {
        subNavigators,
        messages: [],
        title: '',
        message: '',
        applicantId: '',
      }
    },

    methods: {
      getConversation(applicantId) {
        rf.getRequest('MessageRequest').getConversation(applicantId).then(res => {
          this.messages = res;
          this.title = _.head(this.messages).title;
        });
      },

      formatDate(date) {
        return moment(date).calendar(null, {
          sameDay: '[今日] HH:mm:ss',
          lastDay: '[昨日] HH:mm:ss',
          lastWeek: '[前] dddd',
          sameElse: 'YYYY-MM-DD'
        });
      },

      sendMessage() {
        if(!this.message) {
          return;
        }

        rf.getRequest('MessageRequest').sendMessage(this.applicantId, { message: this.message}).then(res => {
          this.messages = res;
          this.message = "";
          this.scrollConversation('fast');
        })
      },

      scrollConversation(speed) {
        $(".conversation").animate({ scrollTop: Math.pow(10, 6) }, speed);
      }
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      this.applicantId = this.$route.query.applicant_id;
      this.getConversation(this.applicantId);
      this.scrollConversation('slow');
    }
  }
</script>

<style scoped>
  .msg-a-t {
    padding: 5px 0;
    width: 100%;
    float: left;
    background: #e6e6e6;
    clear: both
  }

  .message {
    font-size: 1.2rem;
    margin: 10px 0;
  }

  .msg-author {
    padding: 5px;
    color: #000;
    width: 100%;
    float: left;
    border-bottom: 1px solid grey;
  }

  .msg-author .name {
    width: 50%;
    float: left;
    text-align: left;
    font-weight: bold;
  }

  .time {
    width: 50%;
    font-size: 1.1rem;
    text-align: right;
    float: left;
  }

  .clear {
    clear: both;
  }

  .msg-content {
    white-space: pre-line;
    padding: 10px;
  }

  .conversation{
    overflow-y: auto;
    height: 400px;
    clear: both;
  }

  .reply{
    clear: both;
    margin-top: 40px;
  }
</style>