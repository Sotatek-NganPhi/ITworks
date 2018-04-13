export default (value) => {
  if (typeof value !== 'number' && typeof value !== 'string') {
  	return false
  }
  return /^[0-9]+$/.test(String(value));
};
