<div id="header">
    <div class="headerContent">
        <div class="areaHeaderContent">
            <div class="logo"><a href="/"><img src="/images/img_top.jpg" width="260" height="80"></a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <p class="btn_xxx">
                    <a href="#" id="btn_nav">
                        <span></span>
                        <span class="nth2"></span>
                        <span></span>
                    </a>
                </p>
                <div class="menu-mobile" id="menu-mobile">
                    <ul class="list">
                        @foreach($regions as $region)
                            <li class="icon"><a href="{{ URL::route('home', $region->key) }}">{{$region->name}}</a></li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
      $("#btn_nav").click(function () {
        if($("#btn_nav").hasClass("active")){
          $("#btn_nav").removeClass("active");
          $("#menu-mobile").removeClass("active");
        }else {
          $("#btn_nav").addClass("active");
          $("#menu-mobile").addClass("active");
        }
        if($("#menu-mobile").hasClass("active")){
          $("#menu-mobile").show();
        }else {
          $("#menu-mobile").hide();
        }
      })
    });
</script>