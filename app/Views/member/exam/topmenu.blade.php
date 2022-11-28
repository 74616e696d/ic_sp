<header class="row">
    
    <div class="navbar navbar-default navbar-fixed-top" role='navigation'>
    <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        <a href="{{$base_url}}/member/dashboard" class="brand"><img src="{{$base_url}}asset/frontend/img/logo.png" alt="logo"></a></div>


        <div class="navbar-collapse collapse">
                 <ul class="nav navbar-nav navbar-right">
                   <li><i class="fa fa-user"></i>&nbsp;&nbsp;{{$username}}</li>
                   <li><a style="padding-top:0;" href="{{$base_url}}login/sign_out_frontend">Sign Out</a></li>
                 </ul>
               </div><!--/.nav-collapse -->

         </div>
    </div>
    
</header> 
