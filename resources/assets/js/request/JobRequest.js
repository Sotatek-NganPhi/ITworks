import BaseModelRequest from "../lib/BaseModelRequest";
;
export default class JobRequest extends BaseModelRequest {

  getModelName() {
    return 'jobs'
  }

  getJobApplicant(params) {
    let url = '/counters';

    return this.get(url, params);
  }

  getJobsQualified(params) {
    let url = '/job_qualified';
    return this.get(url, params);
  }

  getJobsWithIds(params) {
    let url = '/job_getById' ;
    return this.get(url, params);
  }

  getUrgentJobs(regionId) {
    let url = '/job_urgents' ;
    let params = { regionId };
    return this.get(url, params);
  }

  updateUrgentJobs(params) {
    return this.put('/job_urgents', params);
  }

  importCsv(file, images){
    let url = `/job/csv/import`;
    let fd = new FormData();
    fd.append('file', file);
    fd.append('images', images);
    return this.post(url, fd);
  }

  loadRules(){
    let url = '/job/load-rules';
    return this.get(url);
  }
}
