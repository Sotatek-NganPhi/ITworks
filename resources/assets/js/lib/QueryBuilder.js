import _ from 'lodash';

export default class QueryBuilder {
  constructor (params) {
    this.with = '';
    this.search = '';
    this.searchFields ='';
    if (params) {
      this.parse(params);
    }
  }

  append (fieldName, value, operator) {
    if (value === undefined || value === null) return this;

    if (fieldName === 'user.gender') {
      console.log([fieldName, value, operator])
    }
    value = ('' + value).trim();
    if (value !== '') {
      this.search += this.search ? '\\;' : '';
      this.search += `${fieldName}\\:${value}`;
    }

    if (value !== '' && operator) {
      this.searchFields += this.searchFields ? '\\;' : '';
      this.searchFields += `${fieldName}:${operator}`;
    }
    return this;
  }

  parse (params) {
    if (params instanceof Object) {
      for (let key in params) {
        if (params.hasOwnProperty(key) && (params[key] === 0 || params[key])) {
          let value = params[key];
          let operator = '';

          if (Array.isArray(params[key])) {
            value = params[key].length > 0 ? params[key][0] : params[key];
            operator = params[key].length > 1 ? params[key][1] : '';
          }

          this.append(key, value, operator);
        }
      }
    }
    return this;
  }

  setOperator (name, operator) {
    if (this[name]) {
      this[name] = this[name].length > 0 ? [this[name][0], operator] : [this[name], operator];
    }
    return this;
  }

  with (relations) {
    if (_.isString(relations)) {
      this.with = relations;
    } else if (_.isArray(relations)) {
      this.with = relations.join('\\;');
    }
    return this;
  }

  appendWith (relation) {
    const originalWith = this.with.split('\\;');
    if (_.isString(relations)) {
      this.with = _.union([originalWith, [relations]]).join('\\;');
    } else if (_.isArray(relations)) {
      this.with = _.union([originalWith, relations]).join('\\;');
    }
    return this;
  }

}
