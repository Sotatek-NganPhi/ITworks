@extends('app.layout')

@section('title')
    利用規約｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>利用規約</span>
            </li>
        </ul>


        <div id="__component">

            <div class="tos_content">
                <h3>利用規約について</h3>
                <p>1.弊社のサービスのご利用について
                    <span>｢はたらくご縁｣(以下｢本サイト｣といいます)とは、株式会社ご縁(以下｢弊社｣といいます)が提供する求人情報サイトおよび付随するメｰルなどの各種情報提供サｰビス、その他の求人情報サｰビスの総称です。</span>
                    <span>｢はたらくご縁会員｣(以下｢会員｣といいます)とは、個人情報及びその他の情報を登録した個人、または法人をいいます。会員は本サイトにおける求人情報サｰビスを利用できるものとします。会員は、登録の申し込みを行った時点で本利用規約及び弊社個人情報保護方針の内容を全て承諾したものとします。</span>
                </p>
                <p>2.サービス内容の保証および変更に関して
                    <span>弊社は提供するサービスの内容について、瑕疵（かし）やバグがないことは一切保証を致しておりません。
                        また弊社は、お客様にあらかじめ通知することなくサービスの内容や仕様を変更したり、提供を停止したり中止したりすることができるものとします。</span>
                </p>
                <p>3.サービスの利用制限について
                    <span>弊社は、サービスのご利用を働くご縁を含む弊社がサービスするサイトに登録された方に限定したり、一定の年齢以上の方に限定したり、弊社が定める本人確認などの手続を経て一定の要件を満たしたお客様のみに限定したりするなど、利用に際して条件を付すことができるものとします。
                        また、弊社は反社会的勢力の構成員およびその関係者の方、またコンプライアンス違反に当たる方や、サービスを悪用したり、第三者に迷惑をかけたりするようなお客様に対してはご利用をお断りしています。</span>
                </p>
                <p>4.IDの登録情報に関して
                    <span>IDを登録していただく場合、（1）入力するデータに関しては、真実かつ正確な情報を登録していただくこと、（2）登録内容や情報が最新となるようお客様ご自身で適宜修正していただくことがお客様の義務となります。また登録時点で満50歳を超えている方を対象といたします。</span>
                </p>
                <p>5.IDおよびパスワード等に関するお客様の責任について
                    <span>お客様を特定する所定の認証方法（IDとパスワードの組み合わせや携帯電話事業者から送信される携帯電話番号ごとに一意に付与される符号の、登録情報との一致確認による認証を含みますが、これらに限りません）によりログインされた場合には、弊社は、当該お客様ご自身によるご利用であるとみなします。</span>
                </p>
                <p>6.サービス利用にあたっての順守事項に関して
                    <span>弊社のサービスのご利用に際しては以下に定める行為（それらを誘発する行為や準備行為も含みます）を一切禁止いたします。ご順守お願い致します。</span>
                    <span>（1）日本国またはご利用の際にお客様が所在する国・地域の法令に違反する行為の禁止</span>
                    <span>（2）社会規範・公序良俗に反するものや、他人の権利を侵害し、または他人の迷惑となるようなものを、投稿、掲載、開示、提供または送信したりする行為の禁止</span>
                    <span>（3）他のお客様の使用するソフトウエア、ハードウエアなどの機能を破壊したり、妨害したりするようなプログラムなどの投稿などをする行為の禁止</span>
                    <span>（4）弊社のサーバーまたはネットワークの機能を破壊したり、妨害したりする行為の禁止</span>
                    <span>（5）弊社のサービス、弊社の配信する広告、または、弊社のサイト上で提供されているサービス、広告を妨害する行為の禁止</span>
                    <span>（6）他のお客様の個人情報や履歴情報および特性情報などをお客様に無断で収集したり蓄積したりする行為の禁止</span>
                    <span>（7）弊社サービスを、提供の趣旨に照らして本来のサービス提供の目的とは異なる目的で利用する行為の禁止</span>
                    <span>（8）ほかのお客様のIDを使用してサービスを利用する行為の禁止</span>
                    <span>（9）他人からIDやパスワードを入手したり、他人にIDやパスワードを開示したり提供したりする行為の禁止</span>
                    <span>（10）弊社のサービスに関連して、反社会的勢力に直接・間接に利益を提供する行為の禁止</span>
                </p>
                <p>7.弊社のサービスなどの再利用の禁止について
                    <span>お客様が、弊社のサービスやそれらを構成するデータを、当該サービスの提供目的を超えて利用した場合、弊社は、それらの行為を差し止める権利ならびにそれらの行為によってお客様が得た利益相当額を請求する権利を有します。</span>
                </p>
                <p>8.弊社に対する補償について
                    <span>お客様の行為が原因で生じたクレームなどに関連して弊社に費用が発生した場合または弊社が賠償金などの支払を行った場合、お客様は弊社が支払った費用や賠償金などを負担するものとします。</span>
                </p>
                <p>9.お客様のデータおよびコンテンツの取扱いについて
                    <span>お客様が弊社の管理するサーバーに保存しているデータについて、弊社ではIDやパスワードなどのバックアップの義務を負わないものとし、お客様ご自身においてバックアップを行っていただくものとします。十分な管理を徹底して下さい。</span>
                    <span>弊社のサービスの保守や改良などの必要が生じた場合には、弊社はお客様が弊社の管理するサーバーに保存しているデータを、サービスの保守や改良などに必要な範囲で複製等することができるものとします。</span>
                    <span>また、電子掲示板など、不特定または多数のお客様がアクセスできるサービスに対してお客様が投稿などをしたコンテンツについては、お客様または当該コンテンツの著作権者に著作権が帰属します。</span>
                    <span>当該コンテンツについて、お客様は弊社に対して、日本の国内外で無償かつ非独占的に利用（複製、上映、公衆送信、展示、頒布、譲渡、貸与、翻訳、翻案、出版を含みます）する権利を期限の定めなく許諾したものとみなします。</span>
                    <span>なお、お客様は著作者人格権を行使しないものとします。</span>
                </p>
                <p>10.広告掲載についての事項
                    <span>弊社は、提供するサービスやソフトウエアに弊社または弊社に掲載依頼をした第三者の広告（動画も含む）を掲載することができるものとします。</span>
                </p>
                <p>11.投稿などの削除、サービスの利用停止、ID削除についての事項
                    <span>弊社は、提供するサービスを適正に運営するために、以下の場合にはあらかじめ通知することなく、データやコンテンツを削除したり、サービスの全部または一部の利用をお断りしたり、お客様のIDを削除したりするといった措置を講じることができるものとします。</span>
                    <span>また、お客様が複数のIDを登録されている場合には、それらすべてのIDに対して措置がとられる場合があります。ご了承下さい</span>
                    <span>（A）お客様が本利用規約に定められている事項に違反した場合、もしくはそのおそれがあると弊社が判断した場合</span>
                    <span>（B）弊社からのお問い合わせに対して、一切お答えがない場合</span>
                    <span>（C）今後有料課金サービスが開始された場合、指定されたクレジットカードや銀行口座の利用が停止された場合</span>
                    <span>（D）今後有料課金サービスが開始された場合、お客様が破産もしくは民事再生の手続の申立てを受け、またはお客様自らがそれらの申立てを行うなど、お客様の信用不安が発生したと弊社が判断した場合</span>
                    <span>（E）サイトで取得されたIDが反社会的勢力またはその構成員や関係者によって登録または使用された場合、もしくはそのおそれがあると弊社が判断した場合</span>
                    <span>（F）お客様が一定期間にわたってIDまたは特定のサービスを使用していない場合（目安は３年間とします）</span>
                    <span>（G）お客様との信頼関係が失われた場合など、弊社とお客様との契約関係の維持が困難であると弊社が判断した場合</span>
                </p>
                <p>12.免責事項についての事項
                    <span>今後有料課金サービスが開始された場合、弊社の債務不履行責任は、弊社の故意または重過失によらない場合には免責されるものとします。</span>
                    <span>お客様との本利用規約に基づく弊社のサービスのご利用に関する契約が消費者契約法に定める消費者契約に該当する場合、上記の免責は適用されないものとし、弊社は、弊社の故意・重過失に起因する場合を除き、通常生じうる損害の範囲内で、かつ、有料サービスにおいては代金額（継続的なサービスの場合は1か月分相当額）を上限として損害賠償責任を負うものとします。</span>
                </p>
                <p>13.利用規約の変更についての事項
                    <span>弊社が必要と判断した場合には、お客様にあらかじめ通知することなくいつでも本利用規約を変更することができるものとします。</span>
                    <span>ただし、ご利用いただいているお客様に大きな影響を与える場合には、あらかじめ合理的な事前告知期間を設けるものとします。ご了承下さい。</span>
                </p>
                <p>14.通知または連絡についての事項
                    <span>お客様が弊社への連絡を希望される場合には、弊社が設けた問い合わせページまたは弊社が指定するメールアドレスあてのメールによって行っていただくものとします。</span>
                    <span>弊社は、お客様からのお問い合わせに対する回答を原則としてメールのみで行います。</span>
                </p>
                <p>15.権利義務などの譲渡の禁止についての事項
                    <span>お客様は、本利用規約に基づくすべての契約について、その契約上の地位およびこれにより生じる権利義務の全部または一部を、弊社の書面による事前の承諾なく第三者に譲渡することはできません。ご了承下さい。</span>
                </p>
                <p>16.準拠法、裁判管轄についての事項
                    <span>本利用規約の成立、効力発生、解釈にあたっては日本法を準拠法とします。</span>
                    <span>て弊社とお客様との間で生じた紛争については東京地方裁判所を第一審の専属的合意管轄裁判所とします。</span>
                </p>
                <p>17.利用規約の適用制限についてについての事項
                    <span>本利用規約の規定がお客様との本利用規約に基づく契約に適用される関連法令に反するとされる場合、当該規定は、その限りにおいて、当該お客様との契約には適用されないものとします。</span>
                    <span>ただし、この場合でも、本利用規約のほかの規定の効力には影響しないものとします。ご了承下さい。</span>
                </p>
            </div>
        </div>


        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>利用規約</span>
            </li>
        </ul>
    </div>
@endsection