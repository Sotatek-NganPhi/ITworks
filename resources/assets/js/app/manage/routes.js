export default {

}

export const jobNavigators = [
  { link: '/job/list', text: 'sub_menu.job.job_list', sub: 'job' },
  { link: '/job/job_import', text: 'sub_menu.job.import', sub: 'job' },
];

export const companyNavigators = [
  { link: '/company/list', text: 'sub_menu.company.company', sub: 'company' },
  { link: '/agency/list', text: 'sub_menu.company.agency',  sub: 'company' },
  { link: '/admin/list', text: 'sub_menu.company.admin', sub: 'company' },
];

export const candidateNavigators = [
  { link: '/candidate/list', text: 'sub_menu.candidate.candidate', sub: 'candidate' },
  { link: '/candidate/candidate_mail', text: 'sub_menu.candidate.candidate_mail', sub: 'candidate' },
  { link: '/candidate/application_list', text: 'sub_menu.candidate.applicant', sub: 'candidate' },
  { link: '/candidate/mail_setting', text: 'sub_menu.candidate.mail_setting',sub: 'candidate' },
  { link: '/candidate/mail_company', text: 'sub_menu.candidate.company_mail',  sub: 'candidate' },
  { link: '/candidate/mail_logs', text: 'sub_menu.candidate.mail_logs',  sub: 'candidate' },
  { link: '/candidate/inbox', text: 'sub_menu.candidate.inbox', sub: 'candidate' },
];

export const contentSettingsNavigators = [
  { link: '/special/list', text: 'sub_menu.content.special', sub: 'content_settings' },
  { link: '/link/list', text: 'sub_menu.content.link', sub: 'content_settings' },
  { link: '/urgent/list', text: 'sub_menu.content.urgen', sub: 'content_settings' },
  { link: '/pickup/list', text: 'sub_menu.content.pickup', sub: 'content_settings' },
  { link: '/expo/list', text: 'sub_menu.content.expo', sub: 'content_settings' },
  { link: '/campaign/list', text: 'sub_menu.content.campaign', sub: 'content_settings' },
  { link: '/announcement/list', text: 'sub_menu.content.announcement', sub: 'content_settings' },
  { link: '/video/list', text: 'sub_menu.content.video', sub: 'content_settings' },
  { link: '/interview/list', text: 'sub_menu.content.interview', sub: 'content_settings' },
];

export const analysisNavigators = [
  { link: '/analysis/list', text: 'sub_menu.analysis.overal', sub: 'analysis' },
  { link: '/analysis/search', text: 'sub_menu.analysis.search', sub: 'analysis' },
  { link: '/analysis/merit', text: 'sub_menu.analysis.merit', sub: 'analysis' },
  { link: '/analysis/job-type', text: 'sub_menu.analysis.type', sub: 'analysis' },
  { link: '/analysis/access-ranking', text: 'sub_menu.analysis.rank', sub: 'analysis' },
];

export const fieldSettingsNavigators = [
  { link: '/field_settings/list?table=jobs', text: 'sub_menu.field_settings.job', sub: 'field_settings' },
  { link: '/field_settings/list?table=companies', text: 'sub_menu.field_settings.company', sub: 'field_settings' },
  { link: '/field_settings/list?table=applicants', text: 'sub_menu.field_settings.applicant', sub: 'field_settings' },
  { link: '/field_settings/list?table=managers', text: 'sub_menu.field_settings.managers', sub: 'field_settings' },
];

export const searchKeysNavigators = [
  { link: '/search_keys/region/list', text: 'sub_menu.search_key.region', sub: 'search_keys' },
  { link: '/search_keys/prefecture/list', text: 'sub_menu.search_key.prefecture', sub: 'search_keys' },
  { link: '/search_keys/job/list', text: 'sub_menu.search_key.job', sub: 'search_keys' },
  { link: '/search_keys/employment_mode/list', text: 'sub_menu.search_key.employment_mode', sub: 'search_keys' },
  { link: '/search_keys/working/list', text: 'sub_menu.search_key.working', sub: 'search_keys' },
  { link: '/search_keys/current_status/list', text: 'sub_menu.search_key.current_status', sub: 'search_keys' },
  { link: '/search_keys/salary/list', text: 'sub_menu.search_key.payroll', sub: 'search_keys' },
  { link: '/search_keys/certificate/list', text: 'sub_menu.search_key.certificate', sub: 'search_keys' },
  { link: '/search_keys/agency/list', text: 'sub_menu.search_key.agency', sub: 'search_keys' },
];

export const metadataNavigators = [
  { link: '/metadata/list', text: '運営者情報', sub: 'metadata' },
];
