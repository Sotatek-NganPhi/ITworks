let mix = require('laravel-mix');
let path = require('path');
let fs = require('fs');
let Dotenv = require('dotenv-webpack');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const sourceDir = './resources/assets/js/app';

mix.sass('resources/assets/sass/app.scss', 'public/css')
  .sass('resources/assets/sass/home.scss', 'public/css')
  .sass('resources/assets/sass/lp.scss', 'public/css')
  .sass('resources/assets/sass/lp_business.scss', 'public/css')
  .js('resources/assets/js/lib/bxslider.js', 'public/js')
  .styles([
    'node_modules/vue-multiselect/dist/vue-multiselect.min.css'
  ], 'public/css/misc.css')
  .webpackConfig({
    entry: {
      'js/app/manage/admin/main': sourceDir + '/manage/admin/main.js',
      'js/app/manage/company/main': sourceDir + '/manage/company/main.js',
      'js/app/home/main': sourceDir + '/home/main.js',
      'js/app/home/search': sourceDir + '/home/search.js',
      'js/app/home/input_form': sourceDir + '/home/input_form.js',
      'js/app/home/job_detail': sourceDir + '/home/job_detail.js',
      'js/app/home/register_form': sourceDir + '/home/register_form.js',
      'js/app/home/candidate_resume': sourceDir + '/home/candidate_resume.js',
      'js/app/home/register_condition': sourceDir + '/home/register_condition.js',
      'js/app/member/list_search_condition': sourceDir + '/member/list_search_condition',
    },
    output: {
      filename: '[name].js',
      path: path.resolve('.', 'public/')
    },
    module: {
      rules: [
        {
          test: /\.scss$/,
          issuer: /\.js$/,
          use: [
            {
              loader: 'style-loader'
            },
            {
              loader: 'css-loader'
            },
            {
              loader: 'sass-loader'
            }
          ]
        }
      ]
    },
    plugins: [
      new Dotenv({
        path: './.env', // Path to .env file (this is the default)
      })
    ]
  })
;