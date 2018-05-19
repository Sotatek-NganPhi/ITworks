import BaseModelRequest from '../lib/BaseModelRequest';

export default class CompanyRequest extends BaseModelRequest {

  getModelName() {
    return 'companies'
  }

  sendMail(params, callback) {
    let url = '/company/send_email';
    this.post(url, params, callback);
  }

  getCompanies(params){
    let url = '/get-companies';
    return this.get(url, params);
  }

}
