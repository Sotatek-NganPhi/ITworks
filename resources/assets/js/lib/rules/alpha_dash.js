import { alphaDash } from './alpha_helper';

export default (value, [locale] = [null]) => {
  if (! locale) {
    return Object.keys(alphaDash).some(loc => alphaDash[loc].test(value));
  }

  return (alphaDash[locale] || alphaDash.en).test(value);
};
