import BaseModelRequest from '../lib/BaseModelRequest';

export default class VideoRequest extends BaseModelRequest {
  getModelName() {
    return 'videos';
  }
}