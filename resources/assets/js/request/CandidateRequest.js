import BaseModelRequest from '../lib/BaseModelRequest';

export default class CandidateRequest extends BaseModelRequest {

  getModelName() {
    return 'candidates'
  }

  sendMail(params, callback) {
    let url = '/candidates/send-mail';
    return this.post(url, params, callback);
  }

  sendMailToCompany(params, callback) {
    let url = '/candidates/send-mail-to-company';
    return this.post(url, params, callback);
  }

  removeReferralCode(id) {
    let url = '/candidate/' + id + '/remove-code';
    return this.del(url, {});
  }
}
