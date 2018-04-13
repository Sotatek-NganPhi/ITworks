export default (value, options) => {
  if (Array.isArray(value)) {
    return value.every(sigleValue => {
      return !!options.filter(option => option == sigleValue).length;
    });
  }
  return !!options.filter(option => option == value).length;
}
