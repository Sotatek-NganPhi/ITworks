<template>
  <form class="form-horizontal">
    <slot></slot>
  </form>
</template>

<script>
  import Rules from '../../js/lib/rules';
  import Utils from '../../js/common/Utils';

  function _pareValidator (rules) {
    const validations = {};
    rules.split('|').forEach(rule => {
      const parsedRule = _parseRule(rule);
      if (! parsedRule.name) {
        return;
      }

      validations[parsedRule.name] = parsedRule.params;
    });

    return validations;
  }

  function _parseRule (rule) {
    let params = [];
    const name = rule.split(':')[0];

    if (~rule.indexOf(':')) {
      params = rule.split(':').slice(1).join(':').split(',');
    }

    return { name, params };
  }

  function _checkboxValueGetter(cxt, el) {
    const containers = cxt.querySelectorAll(`input[name="${el.name}"]:checked`);
    if (!containers || !containers.length) {
      return null;
    }
    return Array.from(containers).map(checkbox => checkbox.value);
  }

  function _radioValueGetter(cxt, el) {
    const container = cxt.querySelector(`input[name="${el.name}"]:checked`);
    return container && container.value;
  }

  function _fileValueGetter(el) {
    return Array.from(el.files);
  }

  function _defaultValueGetter(el) {
    return el.value;
  }

  function _resolveValueGetter (cxt, el) {
    switch (el.type) {
      case 'checkbox':
        return _checkboxValueGetter.bind(this, cxt, el);
      case 'radio':
        return _radioValueGetter.bind(this, cxt, el);
      case 'file':
        return _fileValueGetter.bind(this, el);
      default:
        return _defaultValueGetter.bind(this, el);
    }
  }

  export default {
    data() {
      return {
        fields: [],
        positionFields: [],
        totalFields: 0,
        errors: [],
        _errors: [],
      }
    },
    watch: {
      errors(errors) {
      	this.$emit('FROM_ERRORS_UPDATED');
      },

      positionFields() {
        if(parseInt(this.positionFields.length) === parseInt(this.totalFields)) {
          const error = _.head(this.errors);
          const el =  _.head(_.filter(this.positionFields, (el) => { return el.field === error.field}));
          window.scrollTo(0, (parseInt(el.top) + 51))
        }
      }
    },
    methods: {
      attach(el, target, expression) {
        const validators = _pareValidator(expression);
        const getter = _resolveValueGetter(this.$el, target);
        this.fields.push({
          name: target.name,
          component: el.__vue__ || null,
          element: target,
          alias: el.getAttribute(`data-vv-as`),
          getter,
          validators
        });
      },
      _validateField(field) {
        if ((field.component && field.component.disabled) || field.element.disabled) {
          return true;
        }

        const value = field.getter();

        if (!('required' in field.validators) && (value === undefined || value === null || value === '')) {
          return true;
        }

        const results = Object.keys(field.validators).map(rule => {
          const validator = Rules[rule];

          if (typeof validator !== 'function') {
            return true;
          }

          const params = field.validators[rule];
          const isValidate = validator(value, params, field.name, this.$el);

          if (!isValidate) {
            this._errors.push({ field: field.name, alias: field.alias, rule, params });
          }

          return isValidate;
        });

        return results.every(result => result);
      },
      errorsHandler(reject) {
        this.errors = this._errors.map(({field, alias, rule, params}) => {
          const message = this.$t(`errors.${rule}`, { field: alias || field, arg_1st: params[0], arg_2nd: params[1] });
          return { field, message };
        });
        reject(this.errors);
      },
      validate() {
        this.errors = [];
        this._errors = [];

        return new Promise((resolve, reject) => {
          const results = this.fields.map(field => this._validateField(field));
          const isValidate = results.every(result => result);
          return isValidate ? resolve(true) : this.errorsHandler(reject);
        });
      },
      parseAsynRejectedErrors(errors) {
        const result = [];
        for (let field in errors) {
          for (let message of errors[field]) {
            result.push({ field, message});
          }
        }
        return result;
      },
    },
    created () {
      this.$on('REJECT_FORM', (errors) => {
        this.errors = this.parseAsynRejectedErrors(errors);
        this.$emit('GET_POSITION_ELEMENT_CHILD');
      });
      this.$on('FORM_ERRORS_CLEAR', () => this.errors = []);
    },
    mounted() {
      this.$nextTick(() => {
        const els = this.$el.querySelectorAll('[data-vv-name]');
        _.forEach(els, el => {
            if($(el).is(":visible")){
              this.totalFields ++;
            }
        })
      });

    },
    destroyed () {
      this.$off('REJECT_FORM');
      this.$off('FORM_ERRORS_CLEAR');
    }
  };
</script>
