export default (value, [format]) => moment(value, format, true).isValid();
