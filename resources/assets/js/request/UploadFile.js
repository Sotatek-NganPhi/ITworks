import BaseRequest from '../lib/BaseRequest';

export default class UploadFile extends  BaseRequest{

  uploadFile(url, file){
    let fd = new FormData();
    fd.append('file', file);
    return this.post(url, fd);
  }

  uploadFileTemporary(url, file){
    let fd = new FormData();
    fd.append('type', "temporary");
    fd.append('file', file);
    return this.post(url, fd);
  }
}
