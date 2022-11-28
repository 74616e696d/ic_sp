@extends('master.layout')

@section('content')
    <div class="row">
      <div class="col-sm-6 right-zero-pad">
        <div class="bx">
          <div class="bx bx-header">
          <h4 class="bx-title">Profile</h4>
          <div class="colps">
            <a title='Edit' id='btn_profile_edit' href=""><i class="fa fa-angle-up"></i></a>
          </div>
          </div>
          <div id='profile_box' class="bx bx-body">
            <form id="form1" class='form-horizontal' role='form' method="post" action='{{$base_url}}member/account_setting/save_profile' enctype="multipart/form-data">
              <a id='btn_edit_profile' href=""><i class="fa fa-edit"></i></a>
              <div class="clearfix"></div>
                <div class="form-group">
                  <label class='control-label col-sm-4'>Username</label>
                  <div class="col-sm-6">
                   <span class="input-group-btn">
                    <input disabled type="text" name="txtusername" id="username" class="form-control" value = "<?php
                    echo $info_list?$info_list->user_name:''; ?>" required />
                     <span id='user_msg'></span>
                    </span>
                  </div>
               </div>
                
                <div class='form-group'>
                  <label class='col-sm-4 control-label' form='firstname'>Fullname</label>
                  <div class="col-sm-6">
                    <input disabled type="text" name="txtfirstname" id="firstname" class="form-control" value = "<?php
                    echo $info_list?$info_list->full_name:''; ?>" required />
                  </div>
                </div>
                
                <div class='form-group'>
                  <label class='col-sm-4 control-label' for='email'>Email</label>

                  <div class="col-sm-6">
                  <span class="input-group-btn">
                    <input disabled type="email" name="txtemail" id="email" class="form-control" value = "<?php
                    echo $info_list?$info_list->email:''; ?>" required />
                    <span id="email_msg"></span>
                    </span>
                  </div>
                </div>
                
                <div class='form-group'>
                  <label class='col-sm-4 control-label'>Phone</label>
                  <div class="col-sm-6">
                    <input disabled type="text" name="txtphone" id="phone" class="form-control" value = "<?php
                    echo $info_list?$info_list->phone:''; ?>" required />
                  </div>
                </div>
                
                <div class='form-group'>
                  <label class='col-sm-4 control-label'>Location </label>
                  <div class="col-sm-6">
                    <textarea disabled cols="80" rows="3" name="location" id="location2" class="form-control"><?php
                    echo $info_list?$info_list->address:''; ?></textarea>
                  </div>
                </div>
                <div class='form-group'>
                  <label class='col-sm-4 control-label'>Image</label>
                  <?php
                  $img_lnk=base_url().'asset/img/no-image.jpg';
                  if(!empty($info_list->photo))
                  {
                  $img_lnk=base_url().'asset/images/upload/'.$info_list->photo;
                  }
                  ?>
                  <input type="hidden" name="hdnOldImg" value='{{$info_list->photo}}'>
                  <input type="hidden" name="hdnNewImg" id='hdnNewImg' value=''>
                  <div class='col-sm-4'>
                  <img src="<?php echo $img_lnk; ?>" id='userPhoto' class='thumb' alt="no-img">
                  <!-- </span>
                  <span class=field> -->
                  <input disabled type="file" name='userfile' id='userfile'>
                  </div>
                </div>
            
                <div class="form-group">
                   <div class="col-sm-offset-4 col-sm-8">
                    <!-- <button id='btn_edit_profile' class='btn btn-default'>Edit</button> -->
                    <button id="btn_pofile" class='btn btn-xs btn-default'>Update</button>
                    &nbsp;&nbsp;&nbsp;
                    <a id='btn_cancel_profile' class='btn btn-xs btn-default' href="">Cancel</a>
                  </div>
                </div>
                <br>
            </form>
          </div>
        </div>

        <div class="bx">
          <div class="bx bx-header">
            <h4 class="bx-title">Account Details</h4>
            <div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
            </div>
          </div>
          <div id='detail_box' class="bx bx-body">
            <form id="form2" class="form-horizontal" method="post" action="<?php echo base_url(); ?>member/account_setting/update_account_info">
            <div class='pull-right'>
              <a title='Edit' id='btn_edit_details' href=""><i class="fa fa-edit"></i></a>
            </div>
            <div class="clearfix"></div>
              <div class='form-group'>
                <label class='col-sm-4 control-label'>Last Study Level</label>
                <div class="col-sm-6">
                  <select disabled name="ddl_study_lebel" id="selection" class="form-control">
                    <?php $level=$info_list?$info_list->study_level:''; ?>
                      <option value="-1" <?php if($level == - 1){  echo "selected";} ?>>Choose One</option>
                      <option value="Masters" <?php if($level== 'Masters') {echo "selected";} ?>>Masters</option>
                      <option value="Honours" <?php if ($level == 'Honours') {echo "selected";} ?>>Honours</option>
                      <option value="HSC" <?php if ($level == 'HSC') {echo "selected";} ?>>HSC</option>
                      <option value="SSC" <?php if ($level == 'SSC') {echo "selected";} ?>>SSC</option>
                      <option value="Others" <?php if ($level == 'Others') {echo "selected"; } ?>>Others</option>
                  </select>
                </div>
              </div>
              <section class="university_section">
                  <div class="form-group">
                    <label id='institute' class='col-sm-4 control-label'>University Name</label>
                    <div class="col-sm-6">
                      <input disabled type="text" name="institute_name" id="institute_name" class="form-control" value = "<?php
                      echo $info_list?$info_list->institute_name:''; ?>" required />
                    </div>
                  </div>
                  <div class="form-group">
                    <label id='programme' class='col-sm-4 control-label'>Program Name</label>
                    <div class="col-sm-6">
                      <input disabled type="text" name="program_name" id="program_name" class="form-control" value = "<?php
                      echo $info_list?$info_list->dept_group:''; ?>" required />
                    </div>
                  </div>
                  <div class="form-group">
                    <label id='session' class='col-sm-4 control-label'>Session</label>
                    <div class="col-sm-6">
                      <input disabled type="text" name="session_year" id="session_year" class="form-control" value = "<?php
                      echo $info_list?$info_list->session:''; ?>" required />
                  </div>
                  </div>
              </section>
              <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                  <button class="btn btn-xs btn-default" id="user_details_update">Update</button>
                  <button id='btn_cancel_detail' class='btn btn-default btn-xs'>Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="bx">
          <div class="bx bx-header">
            <h4 class="bx-title">Change Password</h4>
            <div class="colps">
            <a href=""><i class="fa fa-angle-up"></i></a>
            </div>
          </div>
          <div id='pass_box' class="bx bx-body">
            <form class='form-horizontal' method="post" action="{{$base_url}}member/account_setting/change" role='form'>
            <a id='btn_edit_pass' href="" class='pull-right' title='Edit'><i class="fa fa-edit"></i>
            </a><span class="clearfix"></span>
                <div class="form-group">
                     <label class='control-label col-sm-4' for="txt_old_pass">Old Password:</label>
                     <div class="col-sm-6">
                         <input disabled class='form-control' type='password' name='txt_old_pass'id='txt_old_pass' required='required'/>
                     </div>
                </div>
                    
                <div class="form-group">
                    <label for="txt_password" class="control-label col-sm-4">New Password:</label>
                    <div class="col-sm-6">
                        <input disabled type='password' class='form-control' id='txt_password' name='txt_password'/>
                    </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-4">Retype New Password:</label>
                  <div class="col-sm-6">
                    <input disabled type="password" name="txt_password_again" class='form-control'>
                  </div>  
                </div>  
             
                <div style='padding-left:20px;' class="form-group">
                    <div class="col-sm-offset-4 com-sm-8">
                         <button class='btn btn-xs btn-default' id='btn_change_pass'>Update</button>
                        <a id='btn_cancel_pass' class='btn btn-default btn-xs' href="">Cancel</a>
                    </div>
                </div>
            
            </form>
          </div>
        </div>

      </div>

      <div class="col-sm-6 right-zero-pad">
        <div class="col-sm-5 no-pad">
          <div class="bx">
          {{ $latest_exam }}
           
            <div class="bx bx-body adv">
              <a target="_blank" href="http://revinr.com"><img src="{{$base_url}}asset/frontend/img/revinr.png" alt="revinr.com"></a>
            </div>
          </div>
        </div>
        <div class="col-sm-7">
          
          <!-- START RECENT -->
          <div class="bx">
            <div class="bx bx-header">
              <h4 class="bx bx-title">Recent</h4>
            </div>
            <div class="bx bx-body">
              <ul class="list-unstyled">
                <li><i class="fa fa-angle-double-right"></i>&nbsp;Peas Ahmed Completd BCS 22 &amp; Scored 87</li>
                <li><i class="fa fa-angle-double-right"></i>&nbsp;Ahmed Sharif Completd Model Test &amp; Scored 76</li>
                <li><i class="fa fa-angle-double-right"></i>&nbsp;Kabir Ahmed Completed Sonali Bank Requitement Exam &amp; Scored 60</li>
                <li><i class="fa fa-angle-double-right"></i>&nbsp;Shamim Shams Completed BCS 25 and Scored 63</li>
                <li></li>
              </ul>
            </div>
          </div>
          <!-- END RECENT -->


          <div class="bx">
            <div class="bx bx-header">
              <h4 class="bx bx-title">Current World</h4>
            </div>
            <div class="bx bx-body">
              <ul class='list-unstyled'>
                {{$current_world}}
                <a class='btn btn-default' href='{{ $base_url }}member/reading/index/315'>View All</a>
              </ul>
            </div>
          </div>

        </div>
      </div>
         
    </div>

@stop

@section('style')
<style>
  .add-on-success
  {
    border:1px solid #5AB65E;
    background-color:#fff;
    color:#5AB65E;
  }
  .form-horizontal .control-label 
  {
    text-align:left;
  }
  .add-on-error
  {
    border:1px solid #8D3330;
    background-color:#fff;
    color:#8D3330;
  }

  .btn
  {
    border-radius:6px;
    box-shadow:none;
    border:none;
    
  }
  .btn-default
  {
    color:#555555 !important;
    background:#D1D1D1;
  }

  .form-control {
      border-radius:5px !important;
      box-shadow: none;
      height:28px;
      font-size:13px;
      border: 1px solid #F0F0F0;
  }

  #btn_edit_profile
  {
    float:right;
  }

  #btn_pofile,#btn_cancel_profile,#user_details_update,#btn_cancel_detail,#btn_change_pass,#btn_cancel_pass
  {
    display:none;
  }

  .ui-autocomplete {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    float: left;
    display: none;
    min-width: 160px;
    _width: 160px;
    padding: 4px 0;
    margin: 2px 0 0 0;
    list-style: none;
    background-color: #ffffff;
    border-color: #ccc;
    border-color: rgba(0, 0, 0, 0.2);
    border-style: solid;
    border-width: 1px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -webkit-background-clip: padding-box;
    -moz-background-clip: padding;
    background-clip: padding-box;
    *border-right-width: 2px;
    *border-bottom-width: 2px;
  }

   .ui-autocomplete .ui-menu-item > a.ui-corner-all {
      display: block;
      padding: 3px 15px;
      clear: both;
      font-weight: normal;
      line-height: 18px;
      color: #555555;
      white-space: nowrap;
    }

    .ui-autocomplete .ui-state-hover, .ui-autocomplete .ui-state-active 
    {
        color: #ffffff;
        text-decoration: none;
        background-color: #0088cc;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        background-image: none;
      }
</style> 
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {

    //enable profile section to update
    $('#userfile').hide();
    $('#btn_edit_profile').click(function(e){
      e.preventDefault();
      $(this).hide();
      $('#userfile').show();
      $('#btn_pofile').show();
      $('#btn_cancel_profile').show();
      $("#profile_box :input").not('#username').removeAttr('disabled');
    });
    $('#btn_cancel_profile').click(function(e){
      e.preventDefault();
      $(this).hide();
      $('#btn_pofile').hide();
      $('#btn_edit_profile').show();
      $('#userfile').hide();
      $("#profile_box :input").not('#username').attr('disabled','disabled');
    });
    //end enable profile section to update
    

    // enable user details to edit
      $('#btn_edit_details').click(function(e){
      e.preventDefault();
      $(this).hide();
      $('#user_details_update').show();
      $('#btn_cancel_detail').show();
      $("#detail_box :input").removeAttr('disabled');
    });
    $('#btn_cancel_detail').click(function(e){
      e.preventDefault();
      $(this).hide();
      $('#user_details_update').hide();
      $('#btn_edit_details').show();
      $("#detail_box :input").attr('disabled','disabled');
    });
    //end enable user details to edit
    

    //enable password change section to edit
     $('#btn_edit_pass').click(function(e){
      e.preventDefault();
      $(this).hide();
      $('#btn_change_pass').show();
      $('#btn_cancel_pass').show();
      $("#pass_box :input").removeAttr('disabled');
    });
    $('#btn_cancel_pass').click(function(e){
      e.preventDefault();
      $(this).hide();
      $('#btn_change_pass').hide();
      $('#btn_edit_pass').show();
      $("#pass_box :input").attr('disabled','disabled');
    });
    //end enable password change section to edit

      var curr_user=$('#username').val(),
          curr_email=$('#email').val();
      //checking user exists
      $('#username').blur(function(){
        var user=$(this).val();
        $.ajax({
          url: '{{$base_url}}member/account_setting/check_user',
          type: 'GET',
          data: {username:user,curruser:curr_user},
        })
        .done(function(data) {
          $('#user_msg').html(data);
        });
        
      });
    //end checking user exists
    

    //check email exists
      $('#email').blur(function(){
        var email=$(this).val();
        $.ajax({
          url: '{{$base_url}}member/account_setting/check_email',
          type: 'GET',
          data: {email:email,curremail:curr_email},
        })
        .done(function(data) {
          $('#email_msg').html(data);
        });
        
      });
    //end check email exists


    var masters={institute:"University Name",programme:"Programme",session:"Session"},
    hsc={institute:"College",programme:"Group",session:"Session"},
    ssc={institute:"School",programme:"Group",session:"Session"};
    
    ////MYCUSTOM JS////
    $('#institute').text(masters.institute);
    $('#programme').text(masters.programme);
    $('#session').text(masters.session);
    $('#selection').change(function(){
    var leb = $('#selection').val();
    if(leb == 'Others')
    {
    $('#institute').text(masters.institute);
    $('#programme').text(masters.programme);
    $('#session').text(masters.session);
    }
    else if(leb == 'Masters' || leb == "Honours"){
    $('#institute').text(masters.institute);
    $('#programme').text(masters.programme);
    $('#session').text(masters.session);
    }
    else if(leb == 'HSC'){
    $('#institute').text(hsc.institute);
    $('#programme').text(hsc.programme);
    $('#session').text(hsc.session);
    }
    else if(leb=='SSC')
    {
    $('#institute').text(ssc.institute);
    $('#programme').text(ssc.programme);
    $('#session').text(ssc.session);
    }
    else{
    $('#institute').text(masters.institute);
    $('#programme').text(masters.programme);
    $('#session').text(masters.session);
    }


    });

    //save users profile
    $('#userfile').change(function(){
    var fl=$(this).val();
    $('#hdnNewImg').val(fl);
    });

    $('#institute_name').autocomplete({
      source:'{{$base_url}}member/account_setting/get_uni_name',
      messages: {
              noResults: '',
              results: function() {}
          }
    });

});
</script>
@stop

   