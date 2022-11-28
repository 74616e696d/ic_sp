<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img height="215" width="215" src="{{$user_img}}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <a href="{{$base_url}}/member/account_setting">
                <p style="font-size:14px">@if($username){{$username}}@endif</p>
                </a>
                <a href="{{$base_url}}/member/account_setting"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="active">
                <a href="{{$base_url}}/member/dashboard">
                <i class="menu-icon dashboard"></i> <span>User Panel</span>
                </a>
        </li>

      

            
            <li><a href="{{$base_url}}/member/practice_subject_list" title="Study Materials and Chapter wise all questions"><i class="menu-icon practice"></i><span>Read &amp; Practice</span></a></li>
            <li>
                <a href="{{$base_url}}/member/take_exam">
                <i class="menu-icon take-exam"></i> <span>Previous Job Test</span>
                </a>
            </li>
             <li>
                <a href="{{$base_url}}/member/model_test">
                <i class="menu-icon model"></i> <span>Model Test</span>
                </a>
            </li>
            <li>
                <a href="{{$base_url}}/member/current_world">
                <i class="menu-icon current-world"></i> <span>Current Affairs</span>
                </a>
            </li>
            <li><a href="{{$base_url}}/member/mistake_list" title="Your All Mistakes"><i class="menu-icon mistake"></i><span>Mistake List</span>  <span class='badge badge-danger'>{{$user_total_mistake}}</span></a></li>
            <li><a href="{{$base_url}}/member/review_list" title="Questions You found Difficult"><i class="menu-icon review"></i><span>Review List</span>  <span class='badge badge-info'>{{$user_total_review}}</span></a></li>

            <li class="submenu"> 
            <a href="#rpt-menu" data-toggle="collapse"><span class='menu-icon report'></span>My Statistics &nbsp;&nbsp;<i class="fa fa-angle-down fa-clps"></i></a>
            <ul id='rpt-menu' class="collapse">
                <li><a href="{{$base_url}}/member/progress_overview" title= "Your Test Statistics"><i class="menu-icon progress-view" ></i><span>Exam Report</span></a></li>
                <li><a href="{{$base_url}}/member/chapter_progress" title="Your Study Statistics"><i class="menu-icon study" ></i><span>Quiz Result</span></a></li>
                <li><a href="{{$base_url}}/member/model_quiz_progress" title="Your Study Statistics"><i class="menu-icon model-test" ></i><span>Model Test Result</span></a></li>
                <li><a href="{{$base_url}}/report/strength_report" title="Your Strong &amp; Weak Zone"><i class="menu-icon comparison" ></i><span>Strength Comparison</span></a></li>
            </ul>
            </li>
          
         <li><a href="{{$base_url}}/member/days_hints"><i class="menu-icon hints"></i><span>Important Rules</span></a></li>
         <li><a href="{{$base_url}}/member/cvtemplate"><i class="fa fa-paperclip"></i>
         <span>CV Writing Tips</span>
         <span class='badge' style='background: red'>New</span>
         </a></li>
        <li><a href="{{$base_url}}/current_news"><i class="menu-icon hints"></i><span>Current News</span></a></li>
         <li><a href="{{$base_url}}/forum/forum/posts"><i class="menu-icon hints"></i><span>Iconpreparation Forum</span></a></li>
         <li><a href="{{$base_url}}/login/sign_out"><i class="fa fa-sign-out"></i><span>Sign Out</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>