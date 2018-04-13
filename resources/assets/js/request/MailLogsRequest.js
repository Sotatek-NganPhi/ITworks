import BaseModelRequest from '../lib/BaseModelRequest';

export default class MailLogsRequest extends BaseModelRequest {
  getModelName() {
    return 'mail_logs';
  }
   mailReview(id) {
     const url = "/candidate/mail_logs/preview/"+id ;
    return this.get(url);

  }
}
