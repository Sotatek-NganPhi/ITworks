<template>
    <div>
        <h2>{{ $t("job_list.search_title") }}</h2>

        <validation-form style="margin-bottom: 70px">

            <form-group :label=" $t('applicant.id') ">
                <input class="form-control" type="text" v-model="searchParams.id"/>
            </form-group>

            <form-group :label=" $t('applicant.job_id') ">
                <input class="form-control" type="text" v-model="searchParams.job_id"/>
            </form-group>

            <form-group :label=" $t('applicant.first_name') ">
                <input class="form-control" type="text" v-model="searchParams.first_name"/>
            </form-group>

            <form-group :label=" $t('applicant.last_name') ">
                <input class="form-control" type="text" v-model="searchParams.last_name"/>
            </form-group>

            <form-group :label=" $t('applicant.address') ">
                <input class="form-control" type="text" v-model="searchParams.address"/>
            </form-group>

            <form-group :label=" $t('applicant.phone_number') ">
                <input class="form-control" type="text" v-model="searchParams.phone_number"/>
            </form-group>

            <form-group :label=" $t('common_field.gender') " class="inline">
                <label class="radio-inline">
                    <input type="radio" name="optradio4" value="male"
                           v-model="searchParams.gender"/>{{ $t("applicant.male") }}
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio4" value="female"
                           v-model="searchParams.gender"/>{{ $t("applicant.female") }}
                </label>
            </form-group>

            <form-group :label=" $t('applicant.mail') ">
                <input class="form-control" type="text" v-model="searchParams.email"/>
            </form-group>
        </validation-form>
        <div class="text-center">
            <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
            <button type="button" class="btn btn-primary" @click="clear()">{{ $t("form_action.clear") }}</button>
        </div>
        <h2>{{ $t("applicant.title.two") }}</h2>
        <template v-if="getListFieldDisplay()">
          <data-table :getData="getData" ref="datatable">
            <th data-sort-field="id" style="width: 7%">{{ this.getDisplayName('id') }}</th>
            <th data-sort-field="job_id" style="width: 7%">{{ this.getDisplayName('job_id') }}</th>
            <th data-sort-field="email" style="width: 16%">{{ this.getDisplayName('email') }}</th>
            <th data-sort-field="first_name" style="width: 9%">{{ this.getDisplayName('first_name') }}</th>
            <th data-sort-field="gender" style="width: 9%">{{ this.getDisplayName('gender') }}</th>
            <th data-sort-field="phone_number" style="width: 12%">{{ this.getDisplayName('phone_number') }}</th>
            <th data-sort-field="address" style="width: 20%">{{ this.getDisplayName('address') }}</th>
            <th style="width: 10%"></th>
            <th style="width: 10%"></th>
            <template slot="body" scope="props">
              <tr>
                <td style="width: 7%">{{ props.item.id }}</td>
                <td style="width: 7%">{{ props.item.job_id}}</td>
                <td style="width: 16%">{{ props.item.email }}</td>
                <td style="width: 9%">{{ props.item.first_name }}</td>
                <td style="width: 9%">{{ props.item.gender }}</td>
                <td style="width: 12%">{{ props.item.phone_number }}</td>
                <td style="width: 20%">{{ props.item.address }}</td>
                <td style="width: 10%">
                  <router-link :to="{ path: '/application/applicant', query: {id: props.item.id}}"
                           target="_blank">
                           <button type="button" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-eye-open"></span>{{$t('form_action.preview')}} </button>
                  </router-link>
                </td>
                <td @click="openMailPage(props.item)" style="width: 10%">
                    <button type="button" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-envelope"></span> {{$t("candidate.sendmail")}}
                    </button>
                </td>
              </tr>
            </template>
          </data-table>
        </template>
    </div>
</template>
<script>
  import rf from '../../../js/lib/RequestFactory'
  import { user } from '../../../js/app/manage/main'
  import queryString from 'querystring'
  import QueryBuilder from '../../../js/lib/QueryBuilder'
  import Utils from '../../../js/common/Utils'
  import Multiselect from 'vue-multiselect'

  const searchParams = {
    id: '',
    job_id: '',
    first_name: '',
    last_name: '',
    phone_number: '',
    education: '',
    language_level: '',
    language: '',
  }

  export default {
    components: {
      Multiselect
    },
    created () {
      this.$on('search', (id) => {
        this.searchFollowId(id)
      })
    },
    data () {
      return {
        ageFrom: '',
        ageTo: '',
        searchParams,
        masterdata: Utils.getMasterdataSkel(),
        user,
        isSrollBottom: false
      }
    },
    methods: {
      getDisplayName (fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'applicants', fieldName)
      },
      getData (params) {
        if (params['search'] == null) {
          if (this.$route.query.id != null) {
            params['with'] = null
            params['search'] = 'job_id\\:' + this.$route.query.id
            params['searchFields'] = null
          }
        }
        return rf.getRequest('ApplicantRequest').getList(params)
      },
      getListFieldDisplay () {
        return Utils.getListFieldDisplay(this.masterdata, 'applicants')
      },
      deleteRow (row) {
        rf.getRequest('ApplicantRequest').removeOne(row.id).then(res => {
          this.$refs.datatable.$emit('DataTable:refresh')
        })
      },
      initSearchParams () {
        this.ageFrom = ''
        this.ageTo = ''
        this.searchParams = JSON.parse(JSON.stringify(searchParams))
      },

      buildSearchQuery () {
        const searchParams = {
          'id': this.searchParams.id,
          'job_id': this.searchParams.job_id,
          'first_name': this.searchParams.first_name,
          'last_name': this.searchParams.last_name,
          'gender': this.searchParams.gender,
          'phone_number': this.searchParams.phone_number,
          'email': this.searchParams.email,
          'address': this.searchParams.address,
          'education': this.searchParams.education,
          'language': this.searchParams.language,
          'language_level': this.searchParams.language_level,
        }
        const query = new QueryBuilder(searchParams);
        if (this.ageFrom !== '') {
          this.searchParams.yearFrom = new Date().getFullYear() - this.ageFrom
          query.append('birthday', (this.searchParams.yearFrom + 1).toString().concat('-01-01 00:00:00'), '<')
        }
        if (this.ageTo !== '') {
          this.searchParams.yearTo = new Date().getYear() - this.ageTo
          query.append('birthday', (this.searchParams.yearTo).toString().concat('-01-01 00:00:00'), '>=')
        }
        return query;
      },
      search () {
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery())
      },
      clear () {
        this.initSearchParams()
        this.search()
      },
      searchFollowId (id) {
        const searchParams = {
          'job_id': id
        }
        this.isSrollBottom = true
        const query = new QueryBuilder(searchParams)
        this.$refs.datatable.$emit('DataTable:filter', query)
      },
      scrollBottom () {
        if (this.isSrollBottom) {
          document.body.scrollTop = 100000
        }
        this.isSrollBottom = false
      },
      openMailPage (row) {
        this.$router.push({
          path: '/application/applicant_sendmail',
          query: {
            applicant_id: row ? row.id : null
          }
        })
      },
    },

    mounted () {

      this.$emit('EVENT_PAGE_CHANGE', this)
      if (this.$route.query.id != null) {
        this.searchParams.id = this.$route.query.id
      }
      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll()
      Promise.all([masterdataPromise]).then(([masterdata]) => {
        this.masterdata = masterdata
        this.initSearchParams()
      })

    },
  }
</script>
<style type="text/css" scoped>
    .btn.btn-primary a {
        color: white;
        outline: none;
        text-decoration: none;
    }

    textarea {
        resize: none;
    }
</style>
