@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title"></h4>
			</div>
			<div class="bx-body">
				<div>
					<?php $dt=date_create($expire);$dtf=date_format($expire,'d F,Y'); ?>
				</div>
				<div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12 table-responsive">
					<table class="table table-bordered">
						<tr>
							<th>Current Package:</th>
							<td><span class="badge">{{$current_membership_text}}</span></td>
						</tr>
						<tr>
							<th>Requested Package:</th>
							<td><span class="badge">{{$requested_for}}</span></td>
						</tr>
						@if($discount > 0)
						<tr>
							<th>Total amount:</th>
							<td><span class="badge">Tk. {{$total}}</span></td>
						</tr>
						<tr>
							<th>Discount amount:</th>
							<td><span class="badge">Tk. {{$discount}}</span></td>
						</tr>
						@endif
						<tr>
							<th>Payment amount:</th>
							<td><span class="badge">Tk. {{$amount}}</span></td>
						</tr>
						<tr>
							<th>Expire Date:</th>
							<td><span class="badge">{{$dtf}}</span></td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
			
				<p>
				<p class="lead">You can pay in two ways:</p>
				<ul class="list-group">
					<li class="list-group-item" style='padding-top:25px;padding-bottom:25px;'>
					<p class="lead" style='margin-bottom:65px;font-weight:bold;' >1.) Online: Your membership will be updated <span style='color:#0177BF;'>instantly</span>. You can pay via-</p>
					<img class='img-responsive' src="{{$base_url}}asset/frontend/img/payment.png" alt="">

					<form action="https://www.sslcommerz.com.bd/process/index.php" method="post" name="form1">
						<input type="hidden" name="store_id" value="studypresslive001"> 
						<input type="hidden" name="total_amount" value="{{$amount}}">
						<input type="hidden" name="tran_id" value="{{$trans_id}}">
						<input type="hidden" name="success_url" value="{{$base_url}}public/conf_payment/success/{{$amount}}/{{$day}}/studypresslive001">
						<input type="hidden" name="fail_url" value = "{{$base_url}}public/conf_payment/fail_payment">
						<input type="hidden" name="cancel_url" value = "{{$base_url}}member/dashboard"><br>
						<input type="submit" class='btn btn-danger btn-sm' value="Continue to payment" name="pay">
					</form>

					</li>
					<li class="list-group-item"><strong>OR</strong></li>
					<li class='list-group-item' style='padding-top:20px;padding-bottom:20px;'><p class='lead' style='font-weight:bold;'>2.) Manual: You can send via bKash Personal Number <strong>01994336000</strong>  and call the same number for activation.</p></li>
				</ul>
				</p>
				
			</div>
		</div>
	</div>
</div>
@stop


@section('style')
<style>
	ul li
	{
		line-height:20px;
		font-size:16px;
	}
	.btn-danger
	{
		background:red !important;
		color:#fff;
	}
</style>
@stop

@section('script')
@stop