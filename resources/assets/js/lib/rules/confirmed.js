export default (value, [confirmedField], validatingField, cxt) => {
  let field = confirmedField
    ? cxt.querySelector(`input[name='${confirmedField}']`)
    : cxt.querySelector(`input[name='${validatingField}_confirmation']`);
  return !! (field && String(value) === field.value);
};
