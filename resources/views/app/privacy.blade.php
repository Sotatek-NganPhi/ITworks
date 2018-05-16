@extends('app.layout')

@section('title')
    Privacy｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <a href="{{route('privacy')}}"><span>Chính sách bảo vệ thông tin cá nhân</span></a>
            </li>
        </ul>

        <div id="__component">

            <h3>Chính sách bảo vệ thông tin cá nhân</h3>

            <h2><strong>Bảo mật trang web</strong></h2>
            <div class="content-privacy">
                <ul class="text-left text-justify ul-parent">
                <li>
                    ITworks tôn trọng những thông tin cá nhân của bạn.  Chúng tôi hiểu rằng bạn cần biết chúng tôi quản lý những thông tin cá nhân tập hợp được từ trang Web site ITworks như thế nào. Xin hãy đọc và tìm hiểu về những quy định bảo mật thông tin sau đây của chúng tôi.
                </li>
                <li>
                    Nếu bạn không chấp thuận bản quy định bảo mật này, xin đừng truy cập vào trang Website ITworks.
                    Việc bạn truy cập, đăng ký, sử dụng trang Web này có nghĩa rằng bạn đồng ý và chấp nhận ràng buộc bởi các điều khoản của bản quy định bảo mật của chúng tôi.
                </li>
                <li>
                    <b>Tập hợp các thông tin</b><br> 
                    ITworks tập hợp các thông tin cá nhân của bạn như: tên, email, điạ chỉ, số điện thoại, ngày sinh, và các thông tin khác, nhằm mục đích nhận biết các thông tin riêng của từng cá nhân khi bạn đăng ký hay sử dụng trang Website ITworks. Khi bạn truy cập vào trang Web của chúng tôi, chúng tôi không yêu cầu bạn cung cấp các thông tin cá nhân. Tuy nhiên để có thể truy cập những nơi cần sự đăng ký, bạn phải thực hiện việc đăng ký bằng cách cung cấp các thông tin theo yêu cầu của chúng tôi.
                    Chúng tôi chỉ tập hợp các thông tin để đáp ứng nhu cầu của người truy cập và  chỉ khi cần thiết cho mục đích thương mại của chúng tôi trên cơ sở tuân thủ quy định pháp luật. Chúng tôi cũng tập hợp các thông tin thông thường của người truy cập vào Website như: địa chỉ IP, trình duyệt Web, các kiểu của hệ thống điều hành, thời gian, ngày bạn truy cập vào Website, và những sự mô tả khác. Chúng tôi có thể kết hợp những thông tin thông thường với những thông tin cá nhân.
                </li>
                <li>
                    <b>Cách thức sử dụng thông tin</b><br>                     
                    Thông thường, chúng tôi sử dụng các thông tin bạn cung cấp chỉ để hồi đáp những câu hỏi hay thực hiện các yêu cầu của bạn.
                    Thông tin cá nhân của bạn có thể bị chia sẻ với những công ty khác, nhưng chỉ khi cần thiết để đáp ứng các yêu cầu của bạn hay cho những mục đích liên quan.
                    Chúng tôi không cung cấp các thông tin cá nhân của bạn cho bên thứ 3 để thực hiện các dịch vụ cho riêng họ khi chưa có sự đồng ý của bạn. Nhưng chúng tôi có thể chia sẻ thông tin cho các cá nhân, công ty mà chúng tôi thuê để cung cấp các dịch vụ cho chúng tôi. Chúng tôi cũng có thể cung cấp các thông tin khi thông tin đó được xác định có ảnh hưởng, tác động  tiêu cực cho bên thứ ba, chúng tôi cũng có thể cung cấp, tiết lộ những thông tin này khi được pháp luật cho phép và trong bất cứ các trường hợp khác mà chúng tôi có sự xác định hợp lý rằng điều đó cần thiết để cung cấp dịch vụ cho các cá nhân.
                    Dữ liệu khách hàng của Careerlink.vn có thể được chuyển nhượng cho người kế thừa hay người được chỉ định để quản lý công ty khi công ty bị sáp nhập, bị mua lại hoặc phá sản. 
                </li>
                <li>
                    <b>Bảo đảm an toàn đối với các thông tin thu thập được</b><br>
                    Chúng tôi chỉ tập hợp lại các thông tin cá nhân trong phạm vi phù hợp và cần thiết cho mục đích thương mại đúng đắn của chúng tôi. Và chúng tôi duy trì các biện pháp thích hợp nhằm bảo đảm tính an toàn, nguyên vẹn, độ chính xác, và tính bảo mật những thông tin mà bạn đã cung cấp. Ngoài ra, chúng tôi cũng có những biện pháp thích hợp để đảm bảo rằng bên thứ ba cũng sử dụng các biện pháp bảo đảm an toàn cho các thông tin mà chúng tôi cung cấp cho họ.
                </li>
                <li>
                    <b>Sửa đổi và xoá thông tin tài khoản</b><br> 
                    Bạn có thể sửa đổi, cập nhật thông tin tài khoản của bạn bất cứ lúc nào. Cho dù, bạn tự xoá các thông tin đó đi nhưng chúng tôi có thể phục hồi những thông tin đó từ cơ sở dữ liệu của chúng tôi để giải quyết các tranh chấp, thi hành  bản thoả thuận người sử dụng, hay vì các yêu cầu kỹ thuật, pháp lý  liên quan đến sự an toàn và những hoạt động của trang Website chúng tôi. 
                </li>
                <li>
                    <b>Điều khoản thay đổi</b><br> 
                    Chúng tôi có quyền thay đổi nội dung của các điều khoản này. Xin thường xuyên xác nhận để biết về các điều khoản thay đổi trong bản quy định bảo mật của chúng tôi. Thêm vào đó chúng tôi sẽ thông báo cho bạn bằng email khi có những thay đổi quan trọng về cách sử dụng liên quan các thông tin cá nhân của bạn. Trong trường hợp bạn từ chối các điều khoản thay đổi có trong ITworks, xin liên hệ chúng tôi theo địa chỉ E-mail contact@gmail.com. Khi bạn tiếp tục sử dụng trang Web này, có nghĩa là bạn đồng ý và chấp nhận bị ràng buộc với các thay đổi trong bản quy định bảo mật trực tuyến này.
                </li>
                </ul>
            </div>
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <a href="{{route('privacy')}}"><span>Chính sách bảo vệ thông tin cá nhân</span></a>
            </li>
        </ul>
    </div>
@endsection