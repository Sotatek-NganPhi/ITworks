import BaseModelRequest from '../lib/BaseModelRequest';

export default class PickupRequest extends BaseModelRequest {
  getModelName() {
    return 'pickups';
  }
}
