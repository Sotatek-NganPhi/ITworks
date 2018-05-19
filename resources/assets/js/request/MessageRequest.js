import BaseModelRequest from '../lib/BaseModelRequest';

export default class MessageRequest extends BaseModelRequest {

  getModelName() {
    return 'messages'
  }

  getConversations(params) {
    const url = '/get-conversations';
    return this.get(url, params);
  }

  getConversation(id) {
    const url = '/get-conversation/' + id;
    return this.get(url);
  }

  sendMessage(applicantId, message) {
    const url = '/send-message/' + applicantId;
    return this.post(url, message);
  }
}
