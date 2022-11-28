<section class="visible-lg visible-md slider-full-width">
    <div id="carousel-full" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
   <!--      <ol class="carousel-indicators">
            <li data-target="#carousel-full" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-full" data-slide-to="1"></li>
            <li data-target="#carousel-full" data-slide-to="2"></li>
            <li data-target="#carousel-full" data-slide-to="3"></li>
        </ol> -->
        
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <img class="responsive" src="{{base_url()}}asset/frontend/img/banner 5.jpg" alt="" />
                <div class="container">
                    <div class="carousel-caption">
                        <p class="buttons animated" data-animation="fadeIn" data-animation-delay="1.6s">
                            @if(!$is_auth)
                            <!-- <a href="{{base_url()}}index/fb_request" class="btn btn-xs btn-theme btn-lightblue"><i class="fa fa-facebook"></i>Sign In With Facebook</a> -->
                           
                            {{--  <a href="{{base_url()}}" class="btn btn-xs btn-theme btn-orange">
                            <i class="fa fa-google-plus"></i>Sign In With Google</a>--}}
                             @endif
                        </p>

                        <p class="header header-tiny animated" data-animation="fadeInUp" data-animation-delay="0.2s"><strong>পরীক্ষা দিয়ে যাচাই করুন নিজেকে, ফলাফলের তুলনামূলক বিশ্লেষণে জেনে নিন নিজের অবস্থান </strong></p>
                    </div>
                </div>
            </div>


             <div class='item'>
                <img class="responsive" src="{{base_url()}}asset/frontend/img/banner2.jpg" alt="" />
                <div class="container">
                    <div class="carousel-caption">
                        <p class="buttons animated" data-animation="fadeIn" data-animation-delay="1.6s">
                            @if(!$is_auth)
                            <!-- <a href="{{base_url()}}index/fb_request" class="btn btn-xs btn-theme btn-lightblue"><i class="fa fa-facebook"></i>Sign In With Facebook</a> -->
                           
                            {{--  <a href="{{base_url()}}" class="btn btn-xs btn-theme btn-orange">
                            <i class="fa fa-google-plus"></i>Sign In With Google</a>--}}
                             @endif
                        </p>

                        <p class="header header-tiny animated" data-animation="fadeInUp" data-animation-delay="0.2s"><strong>বিষয়ভিত্তিক পড়ুন প্রতিদিন,
বিপুল প্রশ্নপত্রের সমাহারে সমৃদ্ধ করুন আপনার জ্ঞানের পরিধি</strong></p>
                    </div>
                </div>
            </div>

            <div class='item'>
                <img class="responsive" src="{{base_url()}}asset/frontend/img/banner 3.jpg" alt="" />
                <div class="container">
                    <div class="carousel-caption">
                        <p class="buttons animated" data-animation="fadeIn" data-animation-delay="1.6s">
                            @if(!$is_auth)
                            <!-- <a href="{{base_url()}}index/fb_request" class="btn btn-xs btn-theme btn-lightblue"><i class="fa fa-facebook"></i>Sign In With Facebook</a> -->
                           
                            {{--<a href="{{base_url()}}" class="btn btn-xs btn-theme btn-orange">
                            <i class="fa fa-google-plus"></i>Sign In With Google</a>--}}
                             @endif
                        </p>
                    <p class="header header-tiny animated" data-animation="fadeInUp" data-animation-delay="0.8s"><strong>ভুল উত্তর গুলো দেখে নিন এক ঝলকে, পুনরায় চর্চা করুন তা আইকনপ্রিপ্যারাশনের ‘মিস্টেক লিস্ট’ থেকে
                        </strong></p>
                    </div>
                </div>
            </div>


            <div class='item'>
                <img class="responsive" src="{{base_url()}}asset/frontend/img/banner4.jpg" alt="" />
                <div class="container">
                    <div class="carousel-caption">
                        <p class="buttons animated" data-animation="fadeIn" data-animation-delay="1.6s">
                            @if(!$is_auth)
                            <!-- <a href="{{base_url()}}index/fb_request" class="btn btn-xs btn-theme btn-lightblue"><i class="fa fa-facebook"></i>Sign In With Facebook</a> -->
                           
                            {{--  <a href="{{base_url()}}" class="btn btn-xs btn-theme btn-orange">
                            <i class="fa fa-google-plus"></i>Sign In With Google</a>--}}
                             @endif
                        </p>
                                            <p class="header header-tiny animated" data-animation="fadeInUp" data-animation-delay="0.8s"><strong>বাসে অথবা গাড়িতে, আইকনপ্রিপ্যারাশন মোবাইল অ্যাপস
                        ডাউনলোড করে পড়ুন যে কোন সময় যে কোন স্থানে</strong></p>
                
                    </div>
                </div>
            </div>

        </div>

        <!-- Controls -->
  <!--       <a class="left carousel-control" href="#carousel-full" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-full" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a> -->
    </div>
</section>