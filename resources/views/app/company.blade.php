@extends('app.layout')

@section('title')
    会社案内｜{{$configs["pc_site_title"]}}
@endsection

@section('script')
    <script type="text/javascript">
      $(document).ready(function () {
        var address = "http://maps.google.co.jp/maps?saddr=" + encodeURI($("input[name='company_address']").val()) + "&key=AIzaSyCZkw1EsXpAKgIIALEPaxbTRKMOlxAtp_8&amp;hl=ja&amp;ie=UTF8&amp;sll=34.757833,135.494589&amp;sspn=0.00662,0.013551&amp;mra=ls&amp;ttype=dep&amp;date=11%2F07%2F30&amp;time=19:38&amp;noexp=0&amp;noal=0&amp;sort=time&amp;brcurrent=3,0x6000e4fb56d3eda5:0x84e48cc4858f1017,0&amp;start=0&amp;t=m&amp;geocode=FdRcEgIdvnsTCCnBwK9K-uQAYDH4qdSRnq5Irw&amp;z=16&amp;output=embed";
        $('.__address_company').attr('src', address);
      })
    </script>
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>会社案内</span>
            </li>
        </ul>

        <div id="__component">
            <input hidden name="company_address" value="{{$configs['company_address']}}">
            <h3>会社案内</h3>
            <table>
                <tbody>
                <tr>
                    <th>会社名</th>
                    <td>
                        {!! str_replace('\n', '<br>', $configs['company_name']) !!}
                    </td>
                </tr>
                <tr>
                    <th>所在地</th>
                    <td>{!! str_replace('\n', '<br>', $configs['company_address']) !!}<br>
                        <iframe width="100%" height="auto" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                src="http://maps.google.co.jp/maps?saddr={{rawurlencode($configs['company_address'])}}&key=AIzaSyCZkw1EsXpAKgIIALEPaxbTRKMOlxAtp_8&amp;hl=ja&amp;ie=UTF8&amp;sll=34.757833,135.494589&amp;sspn=0.00662,0.013551&amp;mra=ls&amp;ttype=dep&amp;date=11%2F07%2F30&amp;time=19:38&amp;noexp=0&amp;noal=0&amp;sort=time&amp;brcurrent=3,0x6000e4fb56d3eda5:0x84e48cc4858f1017,0&amp;start=0&amp;t=m&amp;geocode=FdRcEgIdvnsTCCnBwK9K-uQAYDH4qdSRnq5Irw&amp;z=16&amp;output=embed"></iframe>
                        <br>
                        <small>
                            <a href="http://maps.google.co.jp/maps?saddr={{rawurlencode($configs['company_address'])}}&hl=ja&ie=UTF8&mra=ls&ttype=dep&source=embed"
                               style="color:#333;text-align:left">大きな地図で見る</a></small>
                    </td>
                </tr>
                <tr>
                    <th>代表者</th>
                    <td>
                        {!! str_replace('\n', '<br>', $configs['company_manager']) !!}
                    </td>
                </tr>
                <tr>
                    <th>事業内容</th>
                    <td>
                        {!! str_replace('\n', '<br>', $configs['business_contents']) !!}
                    </td>
                </tr>
                <tr>
                    <th>設立日</th>
                    <td>
                        {!! str_replace('\n', '<br>', $configs['establishment_date']) !!}
                    </td>
                </tr>
                <tr>
                    <th>資本金</th>
                    <td>
                        {!! str_replace('\n', '<br>', $configs['company_capital']) !!}
                    </td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td>
                        {!! str_replace('\n', '<br>', $configs['company_email']) !!}
                    </td>
                </tr>
                <tr>
                    <th>公式サイト</th>
                    <td>
                        {!! str_replace('\n', '<br>', $configs['company_web']) !!}
                    </td>
                </tr>
                <tr>
                    <th>取引銀行</th>
                    <td>
                        {!! str_replace('\n', '<br>', $configs['company_bank_account']) !!}
                    </td>
                </tr>
                </tbody>
            </table>

        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>会社案内</span>
            </li>
        </ul>

    </div>
@endsection


