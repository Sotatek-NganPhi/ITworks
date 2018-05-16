<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
        <p>Cảm ơn bạn rất nhiều vì đã đăng ký thành viên.</p>

        <p>Thông tin tài khoản bạn đã đăng ký ở bên dưới.</p>

        <p>
        Email: <b>{{ $user->email }}</b><br />
        Mật khẩu ：******
        </p>

        <p>
        Để xác nhận, hãy click vào link dưới đây trong vòng 24h <br />
        Vui lòng hoàn tất đăng ký tài khoản.<br />
        <a href="{{ URL::to('register/verify/' . $user->confirmation_code) }}">{{ URL::to('register/verify/' . $user->confirmation_code) }}</a>.
        </p>

        <p>
        ※ Nếu bạn vượt quá 24 giờ sau khi gửi email này, nó sẽ hết hạn vì lý do bảo mật.<br />
        Trong trường hợp đó, vui lòng bắt đầu lại từ đầu.
        </p>
        </div>

    </body>
</html>