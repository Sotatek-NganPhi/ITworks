import BaseModelRequest from '../lib/BaseModelRequest';

export default class CertificateRequest extends BaseModelRequest {

  getModelName() {
    return 'certificates'
  }
  getCertificate(params) {
    let url = '/certificate/search';
    return this.post(url, params);
  }

}
