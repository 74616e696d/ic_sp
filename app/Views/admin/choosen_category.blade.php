@extends('admin_master.layout')


@section('content')
	<form action="{{$base_url}}admin/manage_choosen_category/index" method="get" class='form-inline'>
		<select style='width:150px;' name="stat" id="ddl_status">
			<option @if($sel_stat==-1){{'selected'}}@endif value="-1">Select status</option>
			<option @if($sel_stat==1){{'selected'}}@endif value="1">Pending</option>
			<option @if($sel_stat==2){{'selected'}}@endif value="2">Approved</option>
		</select>
		<input class='dt' type="text" name="req" id="txt_req_date" value='{{$sel_req_date}}' placeholder='Request Date'>
		<input class='dt' type="text" name="exp" id="txt_exp_date" value='{{$sel_exp_date}}' placeholder='Expiray Date'>
		<!-- <input type="text" name="txt_email" id="txt_email" value="{{$sel_email}}" placeholder='Email'> -->
		<a name="btn_search" id='btn_search' class="btn btn-info" href="">
    <i class="fa fa-search"></i>&nbsp;GO</a>&nbsp;
    <button class='btn' type="reset"><i class="fa fa-refresh"></i></button>
	</form>
	
	<table class='table table-bordered'>
		<thead>
			<tr>
				<td>User Email</td>
				<td>User Phone</td>
				<td>Exam Category</td>
				<td>Status</td>
				<td>Request Date</td>
				<td>Expiry Date</td>
				<td>Action</td>
			</tr>
		</thead>
		<tbody>
			{{$choosen_list}}
		</tbody>
	</table>
	{{$pagi}}

<div id="edit_dlg" class="modal hide fade">
	<form method="POST" action="<?php echo base_url(); ?>admin/manage_choosen_category/update_status">
	<div class="modal-header">
   	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="myModalLabel">Change Status</h3>
  	</div>
  	<div class="modal-body">
   
 	 </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    	<button type="submit" class="btn btn-info pull-left"><i class="fa fa-save"></i>&nbsp;Save</button>
  </div>
  </form>
</div>
@stop

@section('script')
<!-- <script type="text/javascript" src="{{$base_url}}asset/js/jquery.base64.js"></script> -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#edit_dlg').on('hidden', function () {
  			$(this).removeData('modal');
		});

		 var skey1=$('#ddl_status').val(),
		 	skey2=$('#txt_req_date').val()?$('#txt_req_date').val():'na',
            skey3=$('#txt_exp_date').val()?$('#txt_exp_date').val():'na',
            skey4=$('#txt_email').val()?$('#txt_email').val():'na',
            make_url='<?php echo base_url(); ?>admin/manage_choosen_category/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;
           $('#btn_search').attr('href',make_url);

           $('#ddl_status').change(function(){
                skey1=$(this).val();
                if(skey1!=-1)
                {
                    make_url='<?php echo base_url(); ?>admin/manage_choosen_category/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/manage_choosen_category/index/'+-1+'/'+-skey2+'/'+skey3+'/'+skey4;
                }
                $('#btn_search').attr('href',make_url);
            }); //end ddl status change event

           	$('#txt_req_date').change(function(){
           		skey2=$(this).val();
               var len=skey2.length=='NaN'?0:skey2.length;
           		 if(len>0 && len!='NaN')
                {
                    make_url='<?php echo base_url(); ?>admin/manage_choosen_category/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/manage_choosen_category/index/'+skey1+'/'+'na'+'/'+skey3+'/'+skey4;
                }
                $('#btn_search').attr('href',make_url);
           	}); //end required date change event

              $('#txt_exp_date').change(function(){
                skey3=$(this).val();
                var len=skey3.length=='NaN'?0:skey3.length;
               if(len>0 && len!='NaN')
                {
                    make_url='<?php echo base_url(); ?>admin/manage_choosen_category/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/manage_choosen_category/index/'+skey1+'/'+skey2+'/'+'na'+'/'+skey4;
                }
                $('#btn_search').attr('href',make_url);
            }); //end expiry date change event

              $('#txt_email').change(function(){
                skey4=$(this).val();
               if(skey4.length>0)
                {
                  //$.base64.is_unicode = false;
                 // var skey4 = $.base64.encode($.trim(skey4)).replace(/=/g,'%');
                  //alert(skey4);
                    make_url='<?php echo base_url(); ?>admin/manage_choosen_category/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;
                }
                else
                {
                    make_url='<?php echo base_url(); ?>admin/manage_choosen_category/index/'+skey1+'/'+skey2+'/'+skey3+'/'+'na';
                }
                $('#btn_search').attr('href',make_url);
            }); //end email change event

           // $('#btn_search').click(function(e){
           // 	e.preventDeault();
           // 	var skey1=$('#ddl_status').val(),
           // 	skey2=$('#txt_req_date').val()?$('#txt_req_date').val():'na',
           // 	skey3=$('#txt_exp_date').val()?$('#txt_exp_date').val():'na',
           // 	skey4=$('#txt_email').val()?$('#txt_email').val():'na',
           // 	make_url='<?php echo base_url(); ?>admin/manage_choosen_category/index/'+skey1+'/'+skey2+'/'+skey3+'/'+skey4;
           // });

		$('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'dd-mm-yy'});
	});
</script>
@stop