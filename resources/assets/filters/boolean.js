const MESSAGES = {
  YES: 'Yes',
  NO: 'No',
  NOT_SPECIFIED: 'No Specified'
}

export default (value) => {
  if (value === true || value === 1 || value === 'true' || value === '1') {
    return MESSAGES.YES;
  }
  if (value === false || value === 0 || value === 'false' || value === '0') {
    return MESSAGES.NO;
  }
  return MESSAGES.NOT_SPECIFIED;
}