import request from 'superagent';
import _ from 'lodash';
import zlib from 'browserify-zlib';
import buffer from 'buffer';
import BaseRequest from '../lib/BaseRequest';
import Utils from '../../js/common/Utils';

let cacheMasterdata = null;

export default class MasterdataRequest extends BaseRequest {

  getAll() {
    if (typeof(Storage) === 'undefined') {
      return this.requestMasterdataFromServer();
    }

    const dataVersion = localStorage.getItem('masterdata_version');
    if (dataVersion === null ||
        $("meta[name='masterdata-version']").attr('content') !== dataVersion) {
      return this.requestMasterdataFromServer();
    }
    if(cacheMasterdata) {
      return Promise.resolve(cacheMasterdata);
    }
    try {
      const zipData = localStorage.getItem('masterdata');
      const buf = buffer.Buffer.from(zipData, 'base64');
      const unzipData = zlib.unzipSync(buf).toString();
      cacheMasterdata = JSON.parse(unzipData);
      return Promise.resolve(cacheMasterdata);
    }
    catch(err) {
      console.error(err);
      return this.requestMasterdataFromServer();
    }
  }

  getOne(table, id) {
    return new Promise((resolve, reject) => {
      this.getAll()
          .then(data => {
            let record = data[table].find(row => parseInt(row.id) === parseInt(id));
            return resolve(record);
          })
    });
  }

  getList(api, params) {
    let url = `/masterdata`;
    if (!params) params = {};
    params._table = api;
    return this.get(url, params);
  }

  updateOne(api, id, params) {
    let url = `/masterdata/${id}`;
    if (!params) params = {};
    params._table = api;
    return this.put(url, params).then(res => {
      this.getAll();
      return res;
    });
  }

  updateBulk(api, params) {
    let url = `/bulk_update/${api}`;
    return this.put(url, params).then(res => {
      this.getAll();
      return res;
    });
  }

  removeOne(api, id) {
    let url = `/masterdata/${id}`;
    let params = { _table: api };
    return this.del(url, params).then(res => {
      this.getAll();
      return res;
    });
  }

  requestMasterdataFromServer() {
    let url = '/masterdata';
    return new Promise((resolve, reject) => {
      request
          .get(Utils.getAppEndpoint() + url)
          .end((err, res) => {
            if (err) {
              return this._errorHandler(reject, this._getErrorMsg(err));
            }

            if (!res.body) {
              return this._errorHandler(reject, res.text);
            }

            const dataVersion = res.body.dataVersion;
            let masterdata = this.buildMasterdata(res.body.data);
            try {
              masterdata.prefecture_railway = this.getPrefectureRailway(masterdata);

              let zipData = zlib.gzipSync(JSON.stringify(masterdata)).toString('base64');

              localStorage.setItem('masterdata_version', dataVersion);
              localStorage.setItem('masterdata', zipData);
            } catch(err) {
              window.EventBus.$emit('EVENT_COMMON_ERROR', err);
            }

            return resolve(masterdata);
          });
    });
  }

  buildMasterdata(data) {
    let result = JSON.parse(JSON.stringify(data));

    result.__lookup = {};
    _.forOwn(result, (data, table) => {
      if (table === '__lookup') {
        return;
      }

      result.__lookup[table] = _.keyBy(data, 'id');
    });

    result.__lookup.configs = _.keyBy(data.configs, 'key');
    result.__lookup.references = _.keyBy(data.references, 'key');
    result.__lookup.fieldSettings = {};
    _.forEach(data.field_settings, record => {
      let tableName = record.table_name;
      let fieldName = record.field_name;
      if (!result.__lookup.fieldSettings[tableName]) {
        result.__lookup.fieldSettings[tableName] = {};
      }

      result.__lookup.fieldSettings[tableName][fieldName] = record;
    });

    return result;
  }

  getPrefectureRailway(masterdata) {
    let prefectureRailway = [];

    _.forEach(masterdata.prefectures, function (prefecture) {

      let stations = _.filter(masterdata.stations, function(station){
        return parseInt(station.prefecture_id) === parseInt(prefecture.id);
      });

      _.forEach(stations, function (station) {
        let lineStations = _.filter(masterdata.line_stations, function (lineStation) {
          return parseInt(lineStation.station_id) === parseInt(station.id);
        });

        _.forEach(lineStations, function (lineStation) {
          _.forEach(masterdata.railway_lines, function (railwayLine) {
            if(parseInt(railwayLine.id) === parseInt(lineStation.line_id)) {
              let row = {};
              row.prefecture_id = prefecture.id;
              row.station_id = station.id;
              row.line_id = railwayLine.id;
              prefectureRailway.push(row);
            }
          });
        })
      })
    });

    return prefectureRailway;
  }

}
