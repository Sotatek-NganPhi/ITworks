@extends('app.layout')

@section('title')
    希望条件登録｜{{$configs["pc_site_title"]}}
@endsection

@section('vue-js')
    <script src="/js/app/home/register_condition.js"></script>
@endsection

@section('page_content')
    <div id="register_condition">
        <div id="page_content">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <a><span>検索条件登録</span></a>
                </li>
            </ul>
            @if(Auth::check())
                <div id="__component">
                    <h3>下記の内容にて、希望条件を登録します</h3>
                    <p class="text-center text">このお仕事条件を登録して、一発検索！</p>
                    <form name="form1" method="post" class="inquiry"
                          action="{{route('member_register_condition')}}">
                        <table border="0" align="center" cellpadding="0" cellspacing="0">

                            <tbody>
                            <tr>
                                <th>希望の市区町村</th>
                                <td>
                                    <template v-for="(item, index) in municipality">
                                        <template>
                                            <template v-if="index > 0" style="padding-left: 8px">L</template>
                                            @{{ _.isObject(item)? item.title+":"+item.value : item }}<br>
                                        </template>
                                    </template>
                                </td>
                            </tr>


                            <tr>
                                <th>希望の路線</th>
                                <td>
                                    <template v-for="(item, index) in routeStation">
                                        <template>
                                            <template v-if="index > 0">駅</template>
                                            @{{ _.isObject(item)? item.title+":"+item.value : item }}<br>
                                        </template>
                                    </template>
                                </td>
                            </tr>


                            <tr>
                                <th>希望の職種</th>
                                <td>
                                    <template v-for="(item, index) in category">
                                        <template>
                                            <template v-if="index > 0" style="padding-left: 8px">L</template>
                                            @{{ _.isObject(item)? item.title+":"+item.value : item }}<br>
                                        </template>
                                    </template>
                                </td>
                            </tr>

                            <tr>
                                <th>条件</th>
                                <td>
                                    <template v-for="(item, index) in conditions">
                                        <template>
                                            @{{ _.isObject(item)? item.title+":"+item.value : item }}<br>
                                        </template>
                                    </template>
                                </td>
                            </tr>
                            <tr>
                                <th>希望のメリット</th>
                                <td>
                                    <template v-for="(item, index) in meritConditions">
                                        <template>
                                            @{{ _.isObject(item)? item.title+":"+item.value : item }}<br>
                                        </template>
                                    </template>
                                </td>
                            </tr>
                            <tr>
                                <th>希望のフリーワード</th>
                                <td colspan="3">
                                    <template>@{{ freeWork }}</template>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        @if(isset($params))
                            @foreach($params as $name => $value)
                                <input hidden name="{{$name}}" value="{{$value}}">
                            @endforeach
                        @else
                            {{ csrf_field() }}
                        @endif
                        <input type="submit" name="Submit" value="この条件で保存します">
                    </form>
                </div>
            @else
                <div class="_form">
                    <div>
                        <h4>希望条件を登録します。</h4>
                        <h5>すでにご登録の方は、このお仕事条件を登録して、一発検索！</h5>
                        <div class="_form_action">
                            <form name="form_login" method="post" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                @if (session('messages'))
                                    <div class="alert alert-success">
                                        {{ session('messages') }}
                                    </div>
                                @endif
                                <label for="email" class="area">メールアドレス：
                                    <input name="email" type="email" maxlength="255"
                                           class="input-form {{ $errors->has('email') ? ' has-error' : '' }}" size="20">
                                </label>
                                <label for="password" class="area">パスワード：
                                    <input name="password" type="password"
                                           class="input-form {{ $errors->has('password') ? ' has-error' : '' }}"
                                           maxlength="255" size="20">
                                </label>
                                <input type="submit" name="Submit" class="btn_login"
                                       value="ログイン">
                                <a href="#">&gt;&gt;パスワードを忘れた方</a>
                                @if (count($errors) > 0)
                                    <div>
                                        <ul class="errors">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <h5>まだサイト登録していない方は？</h5>
                    <div class="regist_box">
                        にご登録いただくと、ご応募いただいたお仕事情報をストックしたり、あらかじめ履歴書を作成しておくことができます！<br>
                        まだ登録がお済みでない方は、是非この機会にご利用下さい！<br>
                        <p class="center __btn">
                            <a class="btn_register" href="{{ route('register') }}">新規会員登録（無料）</a>
                        </p>
                    </div>
                </div>
            @endif
            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <a><span>求人詳細</span></a>
                </li>
            </ul>
        </div>
    </div>
@endsection