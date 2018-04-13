import BaseModelRequest from "../lib/BaseModelRequest";

export default class AnalysisRequest extends BaseModelRequest {

  getModelName() {
    return 'analysis'
  }

  getMonthlyAnalysis(year, month) {
    let url = `/analysis/${year}/${month}/monthly`;
    return this.get(url);
  }

  getDaylyAnalysis(year, month){
    let url = `/analysis/${year}/${month}/dayly`;
    return this.get(url);
  }

  getMonthSearchAnalysis(params){
    let url = '/analysis/search/month';
    return this.get(url, params);
  }

  getDaySearchAnalysis(params){
    let url = '/analysis/search/day';
    return this.get(url, params);
  }

  criteriaAnalysis(params){
    let url = '/analysis';
    return this.post(url, params);
  }

  analyzeOverTime(time){
    let url = '/analysis/time';
    return this.post(url, time);
  }

}
