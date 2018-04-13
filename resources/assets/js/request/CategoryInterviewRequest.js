import BaseModelRequest from '../lib/BaseModelRequest';

export default class CategoryInterviewRequest extends BaseModelRequest {

  getModelName() {
    return ''
  }

  getCategories(){
    let url = '/category-interview';
    return this.get(url);
  }

}
