import request from 'superagent';

export default class BaseRequest {

  constructor(router, user) {
    this._router = router;
    this._user = user;

  }

  get(url, query = {}) {
    return new Promise((resolve, reject) => {
      request
          .get(url)
          .query(query)
          .set({
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          })
          .end((err, res) => {
            this._responseHandler(resolve, reject, err, res);
          });
    });
  }

  put(url, params = {}) {
    return new Promise((resolve, reject) => {
      request
          .put(url)
          .send(params)
          .set({
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          })
          .end((err, res) => {
            this._responseHandler(resolve, reject, err, res);
          });
    });
  }

  post(url, params = {}) {
    return new Promise((resolve, reject) => {
      request
          .post(url)
          .send(params)
          .set({
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          })
          .end((err, res) => {
            this._responseHandler(resolve, reject, err, res);
          });
    });
  }

  del(url, params = {}) {
    return new Promise((resolve, reject) => {
      request
          .delete(url)
          .send(params)
          .set({
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          })
          .end((err, res) => {
            this._responseHandler(resolve, reject, err, res);
          });
    });
  }

  _responseHandler(resolve, reject, err, res) {
    if (res.statusCode === 400) {
      return this._invalidParamsHandler(reject, res.body.message);
    }

    if (err) {
      return this._errorHandler(reject, this._getErrorMsg(err));
    }

    if (!res.body) {
      return this._errorHandler(reject, res.text);
    }

    if (!res.body.data) {
      return resolve(res.body);
    }

    if (typeof(Storage) !== 'undefined') {
      let data = res.body;
      let localDataVersion = localStorage.getItem('masterdata_version')
      if (localDataVersion && localDataVersion !== data.dataVersion) {
        localStorage.removeItem('masterdata_version');
        localStorage.removeItem('masterdata');
        location.reload();
      }
    }

    return resolve(res.body.data);
  }

  _invalidParamsHandler(reject, message) {
    return reject({ validationErrors: message });
  }

  _errorHandler(reject, err) {
    window.EventBus.$emit('EVENT_COMMON_ERROR', err);
    return reject(err);
  }

  _getErrorMsg(err) {
    try {
      return err.response.body.message;
    } catch (e) {
      return err.toString();
    }
  }

}
