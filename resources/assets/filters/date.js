import moment from 'moment';

export default (value) => {
  return moment(value).format('YYYY-MM-DD');
}