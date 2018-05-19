import numeric from './numeric';

export default (value, [max]) => {
  if (value === undefined || value === null) {
    return max >= 0;
  }
  return numeric(value) ? Number(value) <= max : String(value).length <= max;
};