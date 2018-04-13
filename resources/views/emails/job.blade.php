<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
<style>
    @media only screen and (max-width: 600px) {
        .inner-body {
            width: 100% !important;
        }

        .footer {
            width: 100% !important;
        }
    }

    @media only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
        }
    }
</style>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table class="content" width="100%" cellpadding="0" cellspacing="0">

                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell">
                                    <div style="clear: both; margin: 0 auto; border: 1px solid #ccc; margin-bottom: 30px; padding-bottom: 10px; display: block;">
                                        <div style="padding: 0; margin: 0; float: left; width: 100%; position: relative; letter-spacing: 0px;">
                                            <h2 style="display: block; text-align: left; width: 100%; background: #B3B3B3; color: white; margin: 0 auto; font-size: 20px; padding: 10px 0;">
                                                <a style="color: #ffffff; width: 98%; margin: 0 auto; display: block; font-weight: bold;"
                                                   href="{{url('/job/' . $job->id)}}">{{$job->company_name}}</a></h2>
                                            <div class="detail">
                                                <a style="display: block; float: right; width: 150px; height: 30px; margin: 5px; text-decoration: none; text-align: center; padding-top: 5px; font-weight: bold; color: #fff; background: #F15A24; opacity: 0.9; border-radius: 5px; -webkit-border-radius: 5px;"
                                                   href="{{url('/job/' . $job->id)}}">詳細</a></div>
                                        </div>
                                        <div style="display: block; float: left; width: 100%; background: #f6f6f6;">
                                            <div style="display: block; padding: 1%; width: 45%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;float: left; text-align: left;">{{$job->salary}}</div>
                                            <div style="float: right;text-align: right;display: block; padding: 1%; width: 45%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div style="float: left; width: 100%;">
                                            <h3 style="color: #F2C469; width: 95%; margin: 15px auto; border-bottom: 2px solid #F2C469; clear: both; text-align: left; font-size: 18px; letter-spacing: 0px;">{{$job->description}}</h3>
                                        </div>
                                        <div style="float: left; width: 30%; margin: 2%;">
                                            <a href="javascript:void(0)"><img style="width: 100%;"
                                                                              src="{{url($job->main_image)}}"
                                                                              alt="{{url($job->main_caption ? $job->main_caption : "")}}"></a>
                                        </div>
                                        <div style="float: left; width: 65%; margin: 2% 0;">
                                            <table style="width: 95%; margin: 10px auto; border-collapse: collapse; display: inline-table; clear: both;"
                                                   border="0" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                <tr>
                                                    <th style="width: 30%; border: 1px #cccccc solid; background-color: #F4F2E8; padding: 1%;">
                                                        応募条件
                                                    </th>
                                                    <td style="width: 66%; border: 1px #cccccc solid; padding: 1%; text-align: left; white-space: pre-wrap;">{{$job->application_condition}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%; border: 1px #cccccc solid; background-color: #F4F2E8; padding: 1%;">
                                                        掲載期間
                                                    </th>
                                                    <td style="width: 66%; border: 1px #cccccc solid; padding: 1%; text-align: left; white-space: pre-wrap;">{{$job->post_start_date}}
                                                        - {{$job->post_end_date}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div style="width: 95%; margin: 0 auto;">
                                                @if(isset($job->sub_image1))
                                                    <a href="javascript:void(0)"
                                                       style="float: left; width: 31%; margin: 1% 2% 2% 0;">
                                                        <img src="{{url($job->sub_image1)}}"
                                                             alt="{{$job->sub_caption1 ? $job->sub_caption1 : ""}}"></a>
                                                @endif
                                                @if(isset($job->sub_image2))
                                                    <a href="javascript:void(0)"
                                                       style="float: left; width: 31%; margin: 1% 2% 2% 0;">
                                                        <img src="{{url($job->sub_image2)}}"
                                                             alt="{{$job->sub_caption2 ? $job->sub_caption2 : ""}}"></a>
                                                @endif
                                                @if(isset($job->sub_image3))
                                                    <a href="javascript:void(0)"
                                                       style="float: left; width: 31%; margin: 1% 2% 2% 0;">
                                                        <img src="{{url($job->sub_image3)}}"
                                                             alt="{{$job->sub_caption3 ? $job->sub_caption3 : ""}}"></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
