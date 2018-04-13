<template>
  <div>
    <nav class="navbar navbar-default navbar-fixed-top" :class="{'is-ja': isJa}">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#/">{{ $t("app_name") }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav main-menu">
            <slot name="main_menu"></slot>
            <li>
              <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ $t("menu.logout") }}</a>
              <form id="logout-form" action="/manage/logout" method="POST" style="display: none;">
                <input type="hidden" name="_token" :value="csrf_token" />
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <ul class="nav navbar-nav sub-menu" v-if="subNavigators.length > 0">
        <li v-for="navi in subNavigators" :key="navi.link" :click="highlight(navi.sub)">
          <router-link :to="navi.link" exact-active-class="navActive" @click.native="activeItem">{{ $t(navi.text) }}</router-link>
        </li>
      </ul>
    </div>

    <div class="container">
      <div id="alert-error" class="alert alert-danger" role="alert" v-if="!!error">
        <strong>{{ error }}</strong>
      </div>
      <div class="alert alert-success" role="alert" v-if="!!msg">
        <strong>{{ msg }}</strong>
      </div>
    </div>

    <div class="container">
      <router-view v-on:EVENT_PAGE_CHANGE="onPageChange"></router-view>
    </div>

    <div id="circularG">
      <div id="circularG_1" class="circularG"></div>
      <div id="circularG_2" class="circularG"></div>
      <div id="circularG_3" class="circularG"></div>
      <div id="circularG_4" class="circularG"></div>
      <div id="circularG_5" class="circularG"></div>
      <div id="circularG_6" class="circularG"></div>
      <div id="circularG_7" class="circularG"></div>
      <div id="circularG_8" class="circularG"></div>
    </div>
  </div>
</template>

<script>
  import $ from 'jquery';
  export default {
    data() {
      return {
        user: null,
        subNavigators: [],
        error: null,
        msg: null,
        csrf_token: '',
        isJa: true
      }
    },
    watch: {
      "$route": function(newRoute, oldRoute) {
        this.checkHighlight(newRoute, oldRoute);
      }
    },
    methods: {
      activeItem(event) {
        $('.sub-menu').find('li').removeClass('navActive');
        $(event.target.parentElement).addClass('navActive');
      },
      highlight(id) {
        $('.main-menu').find('li').removeClass('navActive');
        $('#'+id).addClass('navActive');
      },
      onPageChange(context) {
        this.error = null;
        this.subNavigators = context.subNavigators;
        this.$nextTick(() => this.checkHighlight(this.$route, ''));
        this.$parent.$emit('EVENT_CHANGE_SUB_NAVIGATOR');
      },
      checkHighlight(newRoute, oldRoute) {
        let href = (newRoute.path.indexOf('/edit') === -1)
                  ? newRoute.path
                  : newRoute.path.substr(0, newRoute.path.indexOf('/edit')) + '/list';
        let sub_menu = $('ul.sub-menu').find('li a');
        _.forEach(sub_menu, function(value, key) {
          let a_url = value.hash.replace('#', '');
          if(a_url === href) {
            $(value).removeClass('navActive').addClass('navActive')
            $(value).parent().removeClass('navActive').addClass('navActive')
          }
        })
      }
    },
    mounted() {
      let self = this;
      if(window.Utils.qs('lang') === 'en') {
        this.isJa = false;
      }
      this.csrf_token = window.Laravel.csrfToken;
      window.EventBus.$on('EVENT_COMMON_ERROR', function(err) {
        window.Utils.growlError(err.toString());
      });
      window.EventBus.$on('EVENT_COMMON_MSG', function(msg) {
        self.msg = msg.toString();
      });
    }
  }
</script>
<style>
  body {
    padding-top:52px !important;
    position: relative;
  }
  .multiselect.multiselect--above {
    z-index: 99;
  }
</style>
<style scoped>
  .container {
    padding-left: 15px;
    padding-right: 15px;
  }

  .navbar-brand {
    font-weight: bolder;
  }
  .navbar-default ul.navbar-nav >li {
    display: table;
    height: 100%;
    border-left: 1px solid #d3e0e9;
  }
  .navbar-default ul.navbar-nav {
    max-width: 900px;
    height: 50px;
  }
  .is-ja.navbar-default .navbar-nav > li {
    width: 100px;
    padding: 0;
  }
  .is-ja.navbar-default .navbar-nav > li > a {
    white-space: pre;
    font-size: 11px;
    padding: 5px;
    text-align: center;
    line-height: 13px;
  }
  .navbar-default .navbar-nav > li > a {
    display: table-cell;
    text-align: left;
    vertical-align: middle;
  }
  .navbar-default .navbar-nav > li > a:focus, .navbar-default .navbar-nav > li > a:hover, .navActive {
    background-color: #F0F0F0;
  }
  /*loading*/
  #circularG{
    position: absolute;
    width: 68px;
    height: 68px;
    margin: auto;
    top: 40%;
    left: 0;
    right: 0;
    display: none;
  }

  .circularG{
    position:absolute;
    background-color:rgb(0,0,0);
    width:16px;
    height:16px;
    border-radius:10px;
    -o-border-radius:10px;
    -ms-border-radius:10px;
    -webkit-border-radius:10px;
    -moz-border-radius:10px;
    animation-name:bounce_circularG;
    -o-animation-name:bounce_circularG;
    -ms-animation-name:bounce_circularG;
    -webkit-animation-name:bounce_circularG;
    -moz-animation-name:bounce_circularG;
    animation-duration:0.818s;
    -o-animation-duration:0.818s;
    -ms-animation-duration:0.818s;
    -webkit-animation-duration:0.818s;
    -moz-animation-duration:0.818s;
    animation-iteration-count:infinite;
    -o-animation-iteration-count:infinite;
    -ms-animation-iteration-count:infinite;
    -webkit-animation-iteration-count:infinite;
    -moz-animation-iteration-count:infinite;
    animation-direction:normal;
    -o-animation-direction:normal;
    -ms-animation-direction:normal;
    -webkit-animation-direction:normal;
    -moz-animation-direction:normal;
  }

  #circularG_1{
    left:0;
    top:27px;
    animation-delay:0.308s;
    -o-animation-delay:0.308s;
    -ms-animation-delay:0.308s;
    -webkit-animation-delay:0.308s;
    -moz-animation-delay:0.308s;
  }

  #circularG_2{
    left:7px;
    top:7px;
    animation-delay:0.404s;
    -o-animation-delay:0.404s;
    -ms-animation-delay:0.404s;
    -webkit-animation-delay:0.404s;
    -moz-animation-delay:0.404s;
  }

  #circularG_3{
    top:0;
    left:27px;
    animation-delay:0.51s;
    -o-animation-delay:0.51s;
    -ms-animation-delay:0.51s;
    -webkit-animation-delay:0.51s;
    -moz-animation-delay:0.51s;
  }

  #circularG_4{
    right:7px;
    top:7px;
    animation-delay:0.616s;
    -o-animation-delay:0.616s;
    -ms-animation-delay:0.616s;
    -webkit-animation-delay:0.616s;
    -moz-animation-delay:0.616s;
  }

  #circularG_5{
    right:0;
    top:27px;
    animation-delay:0.712s;
    -o-animation-delay:0.712s;
    -ms-animation-delay:0.712s;
    -webkit-animation-delay:0.712s;
    -moz-animation-delay:0.712s;
  }

  #circularG_6{
    right:7px;
    bottom:7px;
    animation-delay:0.818s;
    -o-animation-delay:0.818s;
    -ms-animation-delay:0.818s;
    -webkit-animation-delay:0.818s;
    -moz-animation-delay:0.818s;
  }

  #circularG_7{
    left:27px;
    bottom:0;
    animation-delay:0.914s;
    -o-animation-delay:0.914s;
    -ms-animation-delay:0.914s;
    -webkit-animation-delay:0.914s;
    -moz-animation-delay:0.914s;
  }

  #circularG_8{
    left:7px;
    bottom:7px;
    animation-delay:1.02s;
    -o-animation-delay:1.02s;
    -ms-animation-delay:1.02s;
    -webkit-animation-delay:1.02s;
    -moz-animation-delay:1.02s;
  }



  @keyframes bounce_circularG{
    0%{
      transform:scale(1);
    }

    100%{
      transform:scale(.3);
    }
  }

  @-o-keyframes bounce_circularG{
    0%{
      -o-transform:scale(1);
    }

    100%{
      -o-transform:scale(.3);
    }
  }

  @-ms-keyframes bounce_circularG{
    0%{
      -ms-transform:scale(1);
    }

    100%{
      -ms-transform:scale(.3);
    }
  }

  @-webkit-keyframes bounce_circularG{
    0%{
      -webkit-transform:scale(1);
    }

    100%{
      -webkit-transform:scale(.3);
    }
  }

  @-moz-keyframes bounce_circularG{
    0%{
      -moz-transform:scale(1);
    }

    100%{
      -moz-transform:scale(.3);
    }
  }
</style>