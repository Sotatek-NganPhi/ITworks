import BaseModelRequest from '../lib/BaseModelRequest';

export default class CompanyRequest extends BaseModelRequest {

  getModelName() {
    return 'applicants'
  }
}
