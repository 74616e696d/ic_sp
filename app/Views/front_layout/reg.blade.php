<div class="col-sm-12 reg-content">

	<div class="col-sm-6">
		<img style='margin-top:20px;' class="img-responsive" src="{{$base_url}}asset/frontend/img/look.png" alt="">

		<h2 style="color:#0177BF;font-size:37px !important;">অনলাইনে বিসিএস ও ব্যাংক জব প্রস্তুতি</h2>
	</div>

	<div class="col-sm-6">
		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
		<h3 style='padding-left:0;text-align:left;'>
		লগ ইন  <a style='background:#f5f5f5 !important;font-size:19px;color:#444;text-decoration:none;' class="sm-size" href="{{$base_url}}index/fb_request">
		&nbsp;&nbsp;অথবা <img src="{{$base_url}}asset/frontend/img/fb.png" alt=""> লগ ইন </a>
		</h3>
		
		<form role="form" action="{{$base_url}}login/sign_in" method='post'>
		    <div class="form-group">
		      <!-- <label for="login">ইমেইল:</label> -->
		        <input type="email" name="login" id="login" placeholder='ইমেইল' class='form-control' required="required"/>
		    </div>
		    <div class="form-group">
		      <!-- <label for='pass'>পাসওয়ার্ড: </label> -->
		        <input type="password" name="pass" id="pass" placeholder='পাসওয়ার্ড' class='form-control' required="required"/>
		    </div>
		    <div class="form-group">
		        <button class="btn btn-primary btn-md" type="submit">
		              <i class="fa fa-check"></i>লগ ইন
		        </button>
		         <a style="margin-top:5px;" class='forget-pass' href="{{$base_url}}login/forget_password_view">পাসওয়ার্ড ভুলে গেছেন<i class="fa fa-question"></i></a>
		    </div>
		  </form>

		<hr>
		

		<h3 style='font-size:16px;color:#444444;'>রেজিস্ট্রেশন করে নতুন সদস্য হতে <a class='btn-reg' href="{{$base_url}}public/user_reg">এখানে ক্লিক করুন</a> <br><br>
		<a style='background:#f5f5f5;font-size:14px;color:#444;text-decoration:none;' href="{{$base_url}}index/fb_request">
			অথবা  <img src="{{$base_url}}asset/frontend/img/fb.png" alt=""> দিয়ে রেজিস্ট্রেশন করুন </a>
		</h3>
		</div>

	</div>

	<div class="clearfix"></div>

</div>