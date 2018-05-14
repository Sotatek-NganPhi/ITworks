export default {

}

export const jobNavigators = [
  { link: '/job/list', text: 'sub_menu.job.job_list', sub: 'job' },
];

export const companyNavigators = [
  { link: '/company/list', text: 'sub_menu.company.company', sub: 'company' },
  { link: '/admin/list', text: 'sub_menu.company.admin', sub: 'company' },
];

export const candidateNavigators = [
  { link: '/candidate/list', text: 'sub_menu.candidate.candidate', sub: 'candidate' },
  { link: '/candidate/candidate_mail', text: 'sub_menu.candidate.candidate_mail', sub: 'candidate' },
  { link: '/candidate/application_list', text: 'sub_menu.candidate.applicant', sub: 'candidate' },
  // { link: '/candidate/mail_setting', text: 'sub_menu.candidate.mail_setting',sub: 'candidate' },
  { link: '/candidate/mail_company', text: 'sub_menu.candidate.company_mail',  sub: 'candidate' },
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
