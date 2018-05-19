import moment from 'moment';

export default (value, [targetField, format], validatingField, cxt) => {
  const field = cxt.querySelector(`input[name='${targetField}']`);
  const dateValue = moment(value, format || '', true);
  const otherValue = moment(field ? field.value : targetField, format || '', true);

  if (! dateValue.isValid() || ! otherValue.isValid()) {
    return false;
  }

  return dateValue.isBefore(otherValue);
};
