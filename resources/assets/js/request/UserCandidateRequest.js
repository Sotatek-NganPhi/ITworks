import BaseCandidateRequest from '../lib/BaseCandidateRequest.js';

export default class UserCandidateRequest extends BaseCandidateRequest {

  updateCandidate(params) {
    let url = '/member/candidate';
    return this.put(url, params);
  }

  createApplicant(params){
    let url = '/applicant';
    return this.post(url, params);
  }

  updateApplicant(params){
    let url = '/applicant';
    return this.put(url, params);
  }

  getJobReference(params){
    let url = '/job-reference';
    return this.post(url, params);
  }

  getListSearchCondition(){
    let url = '/member/conditions';
    return this.get(url);
  }

  removeCondition(id){
    let url = '/member/conditions/' + id;
    return this.del(url);
  }

}
