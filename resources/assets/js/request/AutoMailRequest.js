import BaseModelRequest from '../lib/BaseModelRequest';

export default class AutoMailRequest extends BaseModelRequest {

  getModelName() {
    return 'mail_setting'
  }

  updateSetting(params) {
     const url = "/update" ;
    return this.post(url,params);

  }
}
