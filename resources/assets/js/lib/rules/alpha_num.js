import { alphanumeric } from './alpha_helper';

export default (value, [locale] = [null]) => {
  if (! locale) {
    return Object.keys(alphanumeric).some(loc => alphanumeric[loc].test(value));
  }

  return (alphanumeric[locale] || alphanumeric.en).test(value);
};
