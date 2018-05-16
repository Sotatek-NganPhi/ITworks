@extends('app.layout')

@section('title')
    Điều khoản｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>Điều khoản</span>
            </li>
        </ul>


        <div id="__component">

            <div class="tos_content">
                <h3>Dịch Vụ Đặt Mua Và Thanh Toán</h3>
                <p>Bạn có thể mua một hoặc nhiều dịch vụ có sẵn trong Danh sách Dịch vụ của ITworks thông qua Đơn đặt hàng và/hoặc Hợp đồng Dịch vụ.</p>
                <h4>Nếu dịch vụ Khách hàng mua là Dịch vụ Đăng tuyển:</h4>
                <p>Vị trí đăng tuyển sẽ được đăng trên Website ITworks trong 30 (ba mươi) ngày kể từ ngày kích hoạt. Tiêu đề công việc không được thay đổi sau khi vị trí đăng tuyển đã được kích hoạt đăng trên Webiste ITworks.</p>
                <p>Mỗi vị trí đăng tuyển chỉ được bao gồm 01 (một) tiêu đề đăng tuyển cùng 01 (một) mô tả công việc và yêu cầu công việc.</p>
                <p>Dịch vụ của ITworks là dịch vụ trả trước hoặc trả sau bằng tiền mặt, chuyển khoản hoặc thẻ tín dụng. Danh sách các loại thẻ tín dụng được chấp thuận sẽ được công bố trên Website ITworks. Phí Dịch vụ phải được thanh toán chậm nhất vào Ngày thanh toán quy định trên Đơn đặt hàng. Các Dịch vụ đặt mua sẽ được kích hoạt trong vòng 3 ngày làm việc kể từ ngày Khách hàng thanh toán Phí Dịch vụ.</p>
                <p>Nếu quá Ngày thanh toán mà Khách hàng vẫn chưa thực hiện thanh toán Phí Dịch vụ, thì Công ty có quyền tạm ngưng cung cấp dịch vụ cho đến khi việc thanh toán được thực hiện đầy đủ.</p>
                <p>Công ty sẽ xuất Hóa đơn Thuế GTGT theo quy định của pháp luật Việt Nam hiện hành ngay khi Khách hàng yêu cầu. Khách hàng chịu trách nhiệm về tính chính xác của thông tin xuất Hóa đơn Thuế GTGT.</p>
                <h3>Điều Khoản Về Sử Dụng Dịch Vụ</h3>
                <p>Sau khi bạn đã thanh toán Phí Dịch vụ và/hoặc kích hoạt các Dịch vụ đã đặt mua, chúng tôi sẽ không chấp nhận bất kỳ yêu cầu tạm ngưng hoặc hủy bỏ các Dịch vụ đã đặt mua, hoặc hoàn Phí Dịch vụ, hoặc thay đổi dịch vụ.</p>
                <p>Bạn sẽ tự tạo một tài khoản với mật khẩu để sử dụng dịch vụ trên Website ITworks.</p>
                <p>Bạn được quyền đăng tải nội dung thông tin đăng tuyển của mình và/hoặc đường dẫn trên Website ITworks đến nội dung thông tin tuyển dụng tại trang web của mình và hoàn toàn chịu trách nhiệm về tính chính xác và hợp pháp của các nội dung này.</p>
                <p>Bạn phải kích hoạt Dịch vụ đã mua trong thời hạn sử dụng. Khi hết thời hạn sử dụng, bất kỳ Dịch vụ đã mua nhưng chưa được kích hoạt sẽ không còn giá trị sử dụng.</p>
                <p>Trường hợp do lỗi cố ý của chúng tôi mà sau 7 (bảy) ngày làm việc kể từ ngày bạn có thông báo nhắc nhở bằng văn bản về vi phạm mà chúng tôi vẫn chưa tiến hành khắc phục sai phạm này, chúng tôi sẽ hoàn trả cho bạn Phí Dịch vụ tương ứng với Dịch vụ chưa sử dụng theo Đơn đặt hàng/Hợp đồng Dịch vụ mà chúng tôi không cung cấp theo đúng thỏa thuận giữa hai bên.</p>
                <h3>Quyền Và Trách Nhiệm Của Người Sử Dụng</h3>
                <p>Truy cập Website ITworks.com. Bạn có trách nhiệm tự cung cấp tất cả phần cứng, phần mềm, số điện thoại hoặc các thiết bị liên lạc khác và/hoặc dịch vụ kết nối tới Internet và truy cập Website ITworks.com, đồng thời có trách nhiệm trả mọi khoản phí truy cập Internet, phí điện thoại hoặc các khoản phí khác phát sinh trong quá trình kết nối Internet và truy cập Website ITworks.</p>
                <p>Đạo đức người sử dụng. Khi sử dụng Dịch vụ của ITworks và truy cập vào Website ITworks, bạn nhận thức đầy đủ các điều cấm sau:</p>
                <ul>
                <li>Chống Nhà nước Cộng hoà xã hội chủ nghĩa Việt Nam, phá hoại khối đoàn kết toàn dân, tuyên truyền, xuyên tạc, kích động hoặc cung cấp thông chống phá Nhà nước Việt Nam;</li>
                <li>Kích động bạo lực, tuyên truyền chiến tranh xâm lược, gây hận thù giữa các dân tộc và nhân dân các nước, kích động dâm ô, đồi trụy, tội ác, tệ nạn xã hội, mê tín dị đoan, phá hoại thuần phong mỹ tục của dân tộc;</li>
                <li>Tiết lộ bí mật nhà nước, bí mật quân sự, an ninh, kinh tế, đối ngoại và những bí mật khác đã được pháp luật quy định;</li>
                <li>Xuyên tạc, vu khống, xúc phạm uy tín của tổ chức, danh dự, nhân phẩm, uy tín của công dân;</li>
                <li>Quảng cáo, tuyên truyền hàng hoá, dịch vụ thuộc danh mục cấm đã được pháp luật quy định;</li>
                <li>Đề cập đến các vấn đề chính trị và tôn giáo;</li>
                <li>Sử dụng các từ ngữ vô văn hóa vi phạm truyền thống đạo đức của Việt Nam;</li>
                <li>Hạn chế hoặc ngăn cản người sử dụng khác sử dụng và hưởng các tính năng tương tác;</li>
                <li>Gửi hoặc chuyển các thông tin bất hợp pháp, đe doạ, lạm dụng, bôi nhọ, nói xấu, khiêu dâm, phi thẩm mỹ, xúc phạm hoặc bất kỳ loại thông tin không đứng đắn nào, bao gồm nhưng không hạn chế việc truyền bá tin tức góp phần hay khuyến khích hành vi phạm tội, gây ra trách nhiệm pháp lý dân sự hoặc vi phạm pháp luật đia phương, liêng bang, quốc gia hoặc quốc tế;</li>
                <li>Gửi hay chuyển các thông tin, phần mềm, hoặc các tài liệu khác bất kỳ, vi phạm hoặc xâm phạm các quyền của những người khác, trong đó bao gồm cả tài liệu xâm phạm đến quyền riêng tư hoặc công khai, hoặc tài liệu được bảo vệ bản quyền, tên thương mại hoặc quyền sở hữu khác, hoặc các sản phẩm phái sinh mà không được sự cho phép của người chủ sở hữu hoặc người có quyền hợp pháp;</li>
                <li>Gửi hoặc chuyển thông tin, phần mềm hoặc tài liệu bất kỳ có chứa virus hoặc một thành phần gây hại khác;</li>
                <li>Thay đổi, làm hư hại hoặc xóa nội dung bất kỳ hoặc các phương tiện khác mà không phải là nội dung thuộc sở hữu của bạn, hoặc gây trợ ngại cho những người khác truy cập đến Website ITworks;</li>
                <li>Phá vỡ luồng thông tin bình thường trong một vùng tương tác;</li>
                <li>Tuyên bố có liên hệ với hay phát ngôn cho một doanh nghiệp, hiệp hội, thể chế hay tổ chức nào khác mà bạn không được uỷ quyền tuyên bố mối liên hệ đó;</li>
                <li>Sử dụng Website ITworks cho những mục đích phi pháp, bao gồm nhưng không giới hạn hành vi vi phạm một quy tắc, chính sách hay hướng dẫn sử dụng nào của nhà cung cấp dịch vụ Internet cho bạn hay các dịch vụ trực tuyến.</li>
                </ul>
            </div>
        </div>


        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>Điều khoản</span>
            </li>
        </ul>
    </div>
@endsection