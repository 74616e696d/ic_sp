<section class="content content-light">

    <div class="container">
        
        @include('front_layout.ticker')

        <div class="content">
          @if(!$is_auth)
            @include('front_layout.reg')
          @endif
        </div>


        <div class="content">
            <div class="col-sm-12 num-stat" style='text-align:center'>
                <div class="col-sm-3 sep">
                    {{get_bn_num($total_user)}} পরীক্ষার্থী
                </div>
                <div class="col-sm-4 sep" style='text-align:center'>
                    {{get_bn_num($total_ques)}} প্রশ্ন
                </div>
                <div class="col-sm-5">
                    ব্যাংক ও বিসিএস পরীক্ষার প্রশ্ন এবং সমাধান 
                </div>
            </div>
        </div>
        
        <div class="row">
          <div class="container">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad dark-bg">
                 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                     <div id="sld">
                 <img class="img-responsive" src="{{$base_url}}asset/frontend/img/frame.png" alt="">
                <img class="img-responsive" src="{{$base_url}}asset/frontend/img/frame2.png" alt="">
                <img class="img-responsive" src="{{$base_url}}asset/frontend/img/frame3.png" alt="">
                <img class="img-responsive" src="{{$base_url}}asset/frontend/img/frame4.png" alt="">
                <img class="img-responsive" src="{{$base_url}}asset/frontend/img/frame5.png" alt="">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <h3 class='head-text'>আইকনপ্রিপ্যারাশন এ রেজিস্ট্রেশন করে আপনি পাচ্ছেন</h3>
                    <ul style='margin-left:20px;'>
                        <li>অধ্যায় ভিত্তিক আলোচনা ও কুইজ</li>
                        <li>প্রয়োজনীয় শর্টকাট</li>
                        <li>গণিত ও ইংরেজির সহজ টেকনিক</li>
                        <li>কারেন্ট অ্যাফেয়ার্স  নিয়মিত আপডেট</li>
                        <li>অসংখ্য মডেল টেস্ট</li>
                        <li>নতুন যেকোনো পরীক্ষার সমাধান</li>
                        <li>২৪/৭ ঘণ্টা সাপোর্ট</li>
                    </ul>
                </div>

            </div>
          </div>
        </div>
    </div>
</section>