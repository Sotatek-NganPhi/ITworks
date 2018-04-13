import numeric from './numeric';

export default (value, [min]) => {
  if (value === undefined || value === null) {
    return false;
  }
  return numeric(value) ? Number(value) >= min : String(value).length >= min;
};
