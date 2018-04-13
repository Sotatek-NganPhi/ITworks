@extends('app.layout')

@section('title')
    お問い合わせ｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>お問い合わせ</span>
            </li>
        </ul>
        <div id="__component">
            @if(!isset($submitted) && !isset($success))
                <h3>お問い合わせフォーム</h3>
            @else
                <h3>お問い合わせ</h3>
            @endif
            @if(!isset($submitted) && !isset($success))
                <h5>はたらくご縁についてご質問などございましたら、下記お問い合わせフォームよりお問い合わせください。</h5>
            @endif
            @if (count($errors) > 0)
                <div>
                    <ul class="errors">
                        @foreach ($errors as $error)
                            @foreach($error as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (isset($submitted) && isset($inputs) && isset($errors) && $inputs['privacy_policy'] && count($errors) == 0)
                <p class="message-success">下記の内容でよろしいでしょうか？</p>
            @endif
            @if(isset($submitted) || isset($success))
                <form method="post" action="/contact" class="inquiry">
                    {{ csrf_field() }}
                    @if(isset($inputs))
                        <input hidden name="name"
                               value="{{ isset($inputs['name']) ? $inputs['name'] : '' }}">
                        <input hidden name="mail_address"
                               value="{{ isset($inputs['mail_address']) ? $inputs['mail_address'] : ''}}">
                        <input hidden name="content_inquiry"
                               value="{{ isset($inputs['content_inquiry']) ? $inputs['content_inquiry'] : ''}}">
                        <input hidden name="privacy_policy"
                               value="{{ isset($inputs['privacy_policy']) ? $inputs['privacy_policy'] : ''}}">
                    @endif
                    @if(isset($submitted) && $submitted)
                        <input hidden name="confirm" value="true">
                        <div>
                            <table>
                                <tbody>
                                <tr>
                                    <th class="required">お名前</th>
                                    <td>{{ $inputs['name'] }}</td>
                                </tr>
                                <tr>
                                    <th class="required">メールアドレス</th>
                                    <td>{{ $inputs['mail_address'] }}</td>
                                </tr>
                                <tr>
                                    <th class="required">お問い合わせ内容</th>
                                    <td>{{ $inputs['content_inquiry'] }}</td>
                                </tr>
                                </tbody>
                            </table>
                            @if(count($errors) == 0 && $inputs['privacy_policy'])
                                <input type="submit" class="confirm" value="　送信する　">
                            @endif
                            <input type="button" class="cancel" value="　戻る　" onclick="history.back()">
                        </div>
                    @endif
                    @if(isset($success) && $success)
                        <h5>送信が完了しました。</h5>
                        <p class="text">こちらから、折り返し連絡させていただきます。<br>
                            今しばらくお待ちくださいませ。<br><br>
                            ありがとうございました。
                        </p>
                        <div id="contact">
                            <p><a href="/">TOPページに戻る</a></p>
                        </div>
                    @endif
                </form>
            @endif
            @if(!isset($submitted) && !isset($success))
                <form class="inquiry" method="post" action="/contact">
                    {{ csrf_field() }}
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <th class="required">お名前</th>
                            <td>
                                <input name="name"  value="{{ old('name') }}">　(全角)
                            </td>
                        </tr>
                        <tr>
                            <th class="required">メールアドレス</th>
                            <td>
                                <input name="mail_address"  value="{{ old('mail_address') }}">　(半角)
                            </td>
                        </tr>
                        <tr>
                            <th class="required">お問い合わせ内容</th>
                            <td>
                                <textarea name="content_inquiry" rows="3"
                                          cols="40">{{ old('content_inquiry') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th class="required">個人情報保護方針</th>
                            <td>
                                <textarea cols="40" rows="7" readonly>
1. 個人情報の定義
個人情報とは、個人情報の保護に関する法律に規定される生存する個人に関する情報(氏名、生年月日、住所等特定の個人を識別することが可能な情報)、ならびに特定の個人と結びついて使用されるメールアドレス、パスワード、クレジットカード等の情報、および個人に関する属性情報と考えます。

2. 個人情報の取得
当社は、適法かつ公正に個人情報を取得し、不正の手段により取得することはありません。なお、当社では、当社のサービスの会員（加盟店）、閲覧ユーザー、その他のお客様から、以下のような方法で個人情報を取得することがあります。 （取得方法の例）
・当社のウェブサイトにてご入力いただくことによる取得
・当社に電話または電子メールにてお問い合わせをいただく際の通話・通信内容の記録または録音

3. 個人情報の利用目的
当社は、個人情報を以下の利用目的で利用します。また、当社では、予め本人の同意を得ずに、利用目的の範囲を超えて個人情報を取り扱うことはありません。
（当サイトのユーザー会員の個人情報）
会員管理
当社のサービス運営上必要な事項の通知・保存
各種問い合わせ対応およびアフターサービスの実施
契約や法律に基づく権利の行使または義務の履行
キャンペーン、懸賞企画、アンケートの実施
メールマガジンの配信
統計資料の作成、マーケティングデータの調査・分析、新サービスの開発

（当サイトに掲載を希望するもの）
当社の提供するサービスの提案、資料の提供、販売
説明会、セミナー等の開催
加盟店管理
加盟店審査
当社のサービス運営上必要な事項の通知
各種問い合わせ対応およびアフターサービスの実施
契約や法律に基づく権利の行使または義務の履行
キャンペーン、アンケートの実施
統計資料の作成、マーケティングデータの調査・分析、新サービスの開発
加盟店に関連する商品、サービス等のご提案

個人情報の安全管理
当社は、個人情報の漏洩、紛失、毀損および改竄の防止、その他の個人情報の安全管理が図られるよう、適切な情報セキュリティ対策ならびに従業員に対する必要かつ適切な監督を行います。

5. 個人情報の委託
当社は、当社が保有する個人情報の全部または一部を、利用目的遂行のために第三者に委託する場合は、委託先の選定に配慮するとともに、個人情報保護に関する契約を締結した上行います。

6. 個人情報の第三者提供
当社は、以下の場合に限り、個人情報を第三者に提供いたします。

（当社のサービスのユーザー会員の個人情報）
本人の同意がある場合
法令に基づく場合または法令により提供が認められる場合
人の生命、身体または財産の保護のために必要がある場合であって、本人の同意を得ることが困難である場合
公衆衛生の向上または児童の健全な育成の推進のために特に必要がある場合であって、本人の同意を得ることが困難である場合
国の機関もしくは地方公共団体またはその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって、本人の同意を得ることによって当該事務の遂行に支障を及ぼすおそれがある場合

（加盟店の個人情報）
本人の同意がある場合
法令に基づく場合または法令により提供が認められる場合
人の生命、身体または財産の保護のために必要がある場合であって、本人の同意を得ることが困難である場合
公衆衛生の向上または児童の健全な育成の推進のために特に必要がある場合であって、本人の同意を得ることが困難である場合
国の機関もしくは地方公共団体またはその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって、本人の同意を得ることによって当該事務の遂行に支障を及ぼすおそれがある場合
会員が参加加盟店に対して各種問い合わせ（アフターサービスに関する問い合わせを含みます。）をするために必要な範囲で、個人情報を提供する場合

7. 統計データの作成・利用
当社は、取得した個人情報をもとに、個人を特定できないよう加工した統計データを作成することがあります。個人を特定できない統計データについては、当社は、何ら制限なく利用することができるものとします。

8. クッキー(cookie)等の使用
当社は、当社のサービスの会員、参加加盟店その他のお客様が、当社のウェブサイトにアクセスされたことを契機として、以下のような個人を特定しない情報を取得することがあります。
閲覧に利用されたコンピュータ機器の基本情報（IPアドレス、携帯端末の機体識別情報、ブラウザの種類・バージョン、OSの種類、プラットフォームなど）、閲覧履歴(URL、アクセス日時、表示された商品など）
上記のほか、クッキー(cookie)やウェブビーコン(web beacon)の技術により自動的に取得される情報

9. 個人情報の開示・訂正・利用停止・削除
当社は、本人または代理人から個人情報の開示・訂正・利用停止・削除等を求められた時は、速やかに手続をします。ただし、手続にあたって、本人確認書類（免許証・住民票の写し等、当社が指定するもの）をご提出いただきます。

10. 継続的改善
当社は、個人情報保護体制を適切に維持する為、コンプライアンス・プログラムを定期的に見直し、その改善に努めます。

11. プライバシーポリシーに関するお問い合わせ
当社のプライバシーポリシーに関するお問い合わせは、以下までお願い致します。
住所：〒103-0025　東京都中央区茅場町1丁目9－2　第一稲村ビル3階
名前：株式会社ご縁 市川健三
                                </textarea><br>
                                上記、個人情報保護方針に<br>
                                <input type="radio" name="privacy_policy" value="1" id="p1">
                                <label for="p1">同意する</label>
                                <input type="radio" name="privacy_policy" value="0" id="p2" checked>
                                <label for="p2">同意しない</label>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <input type="submit" value="確認" name="submit">
                </form>
            @endif
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>お問い合わせ</span>
            </li>
        </ul>

    </div>
@endsection