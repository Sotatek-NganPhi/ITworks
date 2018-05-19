import BaseModelRequest from '../lib/BaseModelRequest';

export default class ReservationRequest extends BaseModelRequest {

  getModelName() {
    return 'reservations'
  }

}
