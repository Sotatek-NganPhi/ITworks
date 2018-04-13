<template>
  <div class="form-group __vv-form-group" :class="errors.length ? 'has-error' : ''">
    <label class="col-sm-2 control-label">{{ label }}
      <span style="color: #FF3300" v-if="isRequired"><b>※</b></span>
    </label>
    <div class="col-sm-10" >
      <slot></slot>
      <p v-for="error in errors" class="text-danger">{{ error.message }}</p>
    </div>
  </div>
</template>

<script>
  function _getTargetElement(cxt, el) {
    if (el.__vue__) {
      return cxt.querySelector(`input[name="${el.__vue__.name}"]`);
    }
    return el;
  }

  export default {
    data() {
      return {
        fields: [],
        errors: [],
        validators: {},
      }
    },
    props: ['label', 'isRequired'],
    methods: {
      pushField(field) {
        const index = this.fields.indexOf(field);
        return !!~index || this.fields.push(field);
      },
      attach(el, expression) {
        const target = _getTargetElement(this.$el, el);
        if (!target) return;
        if (this.validators[target.name] === expression) return;
        this.fields.push(target.name);
        this.validators[target.name] = expression;
        this.$parent.attach(el, target, expression);
      },
      getValidationTracker() {
        const els = this.$el.querySelectorAll('[data-vv-name]');
        if (els.length) {
          for (let el of els) {
            this.pushField(el.getAttribute('data-vv-name'));
          }
        }
      },
    },

    created () {
      this.$parent.$on('FROM_ERRORS_UPDATED', () => {
        this.getValidationTracker();
        this.errors = this.$parent.errors.filter(({ field }) => {
          return ~this.fields.indexOf(field) || this.fields.some(target => field.startsWith(`${target}.`))
        });
      });
      this.$parent.$on('GET_POSITION_ELEMENT_CHILD', () => {
        const el = this.$el.querySelector('[data-vv-name]');
        if($(el).is(":visible")) {
          let params = {};
          params['field'] = el.getAttribute('data-vv-name');
          params['top'] = $(el).offset().top;
          this.$parent.positionFields.push(params);
        }
      });
    },
    destroyed () {
      this.$parent.$off('FROM_ERRORS_UPDATED');
    }
  };
</script>