import BaseRequest from '../lib/BaseRequest';

export default class HomeRequest extends BaseRequest {
  getStatisticalHomePage(){
    return this.get('/get-statistical-homepage');
  }

  getListSearchCondition(userId){
    const url = "/" + userId + "/conditions";
    return this.get(url);
  }

  removeCondition(userId, id){
    const url = "/" + userId + "/conditions/" + id;
    return this.del(url);
  }
}
