import BaseModelRequest from '../lib/BaseModelRequest';

export default class AdminRequest extends BaseModelRequest {

  getModelName() {
    return 'admins'
  }

  getManagers(params){
    let url = '/get-managers';
    return this.get(url, params);
  }
}
