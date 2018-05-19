function getClosestFromGroup(context, el, className='__vv-form-group') {
  do {
    if (el.nodeName === 'BODY') break;
    if (!!~el.className.indexOf(className) && el.__vue__) {
      return el.__vue__;
    }
  } while (el = el.parentNode);
  return null;
}

export default {
  inserted (el, { value }, { context }) {
    const formGroup = getClosestFromGroup(context, el);
    formGroup.attach(el, value);
  },
  update (el, { value }, { context }) {
    const formGroup = getClosestFromGroup(context, el);
    formGroup.attach(el, value);
  },
};
