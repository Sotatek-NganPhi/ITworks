import Vue from 'vue';
import _ from 'lodash';
import jQuery from 'jquery';
import Const from './Const';
import messages from '../app/manage/messages';


const PLATFORMS = {
  PC: 0,
  MOBILE: 1,
}

export default {
  qs: function (key) {
    key = key.replace(/[*+?^$.[]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " ")) || 'ja';
  },

  getKey: function (field_name) {
    const locale=this.qs('lang') || 'ja';
    var res= field_name.split(".");
    var message= messages[locale];
    res.forEach(function(re) {
     message=message[re];
   });
  
    return message;
  },

  growl: function(text, options) {
    var true_text=this.getKey(text);
    if(true_text!=null)
    jQuery.bootstrapGrowl(true_text, options);
  else 
    jQuery.bootstrapGrowl(text, options);
  },

  growlError: function(err) {
    jQuery.bootstrapGrowl(err, { type: 'danger'});
  },

  getAppEndpoint: function () {
    return `${location.protocol}//${location.hostname}:${location.port}/api`;
  },

  getPlatforms: function () {
    return { [this.getKey('utils_choice.platforms.PC')]: 0, [this.getKey('utils_choice.platforms.mobile')]: 1 }
  },

  getGenders: function () {
    return { [this.getKey('utils_choice.gender.male')]: 'male', [this.getKey('utils_choice.gender.female')]: 'female' }
  },

  getMaritals: function () {
    return { [this.getKey('utils_choice.maritals.married')]: 1, [this.getKey('utils_choice.maritals.unmarried')]: 0 }
  },

  getTypeManagers: function () {
    return { [this.getKey('utils_choice.manager.system')]: 1, [this.getKey('utils_choice.manager.company')]: 2 }
  },

  getBooleans: function () {
    return { [ this.getKey('utils_choice.booleans.yes')]: 1, [this.getKey('utils_choice.booleans.no')]: 0, [this.getKey('utils_choice.booleans.not_specified')]: '' }
  },

  getStatus: function () {
    return { [this.getKey('utils_choice.status.effectiveness')]: 1, [this.getKey('utils_choice.status.invalid')]: 0 }
  },

  getYesNoOptions: function() {
    return { [this.getKey('utils_choice.yes_no_option.yes')]: 1, [this.getKey('utils_choice.yes_no_option.no')]: 0 }
  },

  getTime: function () {
    return { [this.getKey('utils_choice.time.all')]: 3, [this.getKey('utils_choice.time.this_month')]: 1, [this.getKey('utils_choice.time.last_month')]: 2}
  },

  getItemToUseOptions: function () {
    return { [this.getKey('utils_choice.item_to_use.not_specified')]: 0, [this.getKey('utils_choice.item_to_use.merit')]: 1, [this.getKey('utils_choice.item_to_use.job_category')]: 2}
  },
  getMail_time: function () {
    return { [this.getKey('utils_choice.mail_time.2_months_ago')]: '2_months_ago', [this.getKey('utils_choice.mail_time.last_month')]: 'last_month',[this.getKey('utils_choice.mail_time.this_month')]: 'this_month' }
  },
     getMail_type: function () {
    return { [this.getKey('utils_choice.mail_type.automatic')]: 'automatic', [this.getKey('utils_choice.mail_type.condition')]: 'condition',[this.getKey('utils_choice.mail_type.company')]: 'company' }
  },

  resolvePlatformFlag: function (platforms) {
    return _.sumBy(platforms, function (platform) {
      return Math.pow(2, platform);
    });
  },

  isLoaded: function (masterdata) {
    return masterdata && masterdata.__lookup;
  },

  turnOnLoading: function () {
    $('#circularG').show();
  },

  turnOffLoading: function () {
    $('#circularG').hide();
  },

  resolvePlatforms: function (input) {
    const platforms = [];
    const platformFlag = Number(input);

    if (Number.isInteger(platformFlag)) {
      if ((Math.pow(2, PLATFORMS.PC) & platformFlag) > 0) {
        platforms.push(PLATFORMS.PC)
      }
      if ((Math.pow(2, PLATFORMS.MOBILE) & platformFlag) > 0) {
        platforms.push(PLATFORMS.MOBILE)
      }
    }
    return platforms;
  },

  getOneFieldSettings: function(masterdata, tableName, fieldName) {
    if (masterdata && masterdata.__lookup) {
      var fieldSettings = masterdata.__lookup.fieldSettings[tableName];
      if (fieldSettings && fieldSettings[fieldName]) {
        return fieldSettings[fieldName];
      }
    }
    return null;
  },

  getFieldDisplayName: function(masterdata, tableName, fieldName) {
    var settings = this.getOneFieldSettings(masterdata, tableName, fieldName);
    return settings ? settings.display_name : fieldName;
  },

  isFieldRequired: function(masterdata, tableName, fieldName) {
    var field = this.getOneFieldSettings(masterdata, tableName, fieldName);
    if(!field){
      return false;
    }
    return parseInt(field.is_required) === 1 ? true : false;
  },

  getListFieldDisplay: function(masterdata, tableName){
    if (masterdata && masterdata.__lookup) {
      var fieldSettings = masterdata.__lookup.fieldSettings[tableName];
      return _.filter(fieldSettings, function (fieldSetting) {
        return parseInt(fieldSetting.is_list_display) === 1;
      });
    }
    return null;
  },

  getReferenceValues: function(masterdata, tableName, fieldName) {
    var settings = this.getOneFieldSettings(masterdata, tableName, fieldName);
    if (!settings || !settings.reference) {
      return null;
    }

    let reference = masterdata.__lookup.references[settings.reference];
    if (reference.type === Const.REF_TYPE_ENUM) {
      let refEnumId = reference.ref_id;
      let refEnum = masterdata.__lookup.ref_enums[refEnumId];
      let refEnumValues = _.filter(masterdata.ref_enum_values, record => {
        if (refEnum.data_type === 'integer') {
          record.value = parseInt(record.value);
        } else if (refEnum.data_type === 'float') {
          record.value = parseFloat(record.value);
        }

        return record.ref_enum_id === refEnumId;
      });

      return _.keyBy(refEnumValues, 'display_name');
    } else if (reference.type === Const.REF_TYPE_TABLE) {
      // TODO
      return null;
    }

    return null;
  },

  getMasterdataSkel: function() {
    return {
      'regions': [],
      'prefectures': [],
      'wards': [],
      'stations': [],
      'railway_lines': [],
      'line_stations': [],
      'salaries': [],
      'employment_modes': [],
      'working_shifts': [],
      'working_days': [],
      'working_hours': [],
      'working_periods': [],
      'companies': [],
      'current_situations': [],
      'merits': [],
      'merit_groups': [],
      'category_level1s': [],
      'category_level2s': [],
      'category_level3s': [],
      'jumping_conditions': [],
      'jumping_dates': [],
      'educations': [],
      'industries': [],
      'company_sizes': [],
      'positions': [],
      'language_experiences': [],
      'language_conversation_levels': [],
      'driver_licenses': [],
      'configs': [],
      'field_settings': [],
      'certificate_groups' : [],
      'certificates' : [],
      'referral_agencies' : [],
    };
  },
};
