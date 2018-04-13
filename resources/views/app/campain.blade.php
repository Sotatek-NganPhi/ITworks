@extends('app.layout')

@section('title', "キャンペーンページ｜{$configs['site_name']}")

@section('page_content')
    <div id="campaign">
        @if($campaign)
            <ul class="breadcrumb">
                <li>
                    <a href="/" title="{{$configs['pc_site_title']}}">
                        <span>{{$configs['site_name']}}</span>
                    </a>
                    　≫　
                </li>
                <li>
                    <span itemprop="title">{{ $campaign->title }}</span>
                </li>
            </ul>
            <div class="campaign-content">
                {!! $campaign->content !!}
            </div>
        @endif
    </div>

@endsection
