@extends('master.layout')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="bx">
			<div class="bx bx-header">
				<h4 class="bx-title">Confirm your upgrade request</h4>
			</div>
			<div class="bx bx-body">
				<h5>Thank You for sending <span style='color:#FF7F2A;'>{{ $mtext }} membership upgrade</span> request.</h5>
				<p id='welcome'>Please pay <span style='color:green;'><strong>Tk.{{ $amount }}</strong></span> by <span class='bkash_1'>b</span><span class='bkash_2'>Kash</span> to the given number below and insert <span class='bkash_1'>b</span><span class='bkash_2'>Kash</span> code in the following textbox.</p>
				<p id='phn'><span class='bkash_1'>b</span><span class='bkash_2'>Kash</span> Number:&nbsp;&nbsp;  01917777021</p>
				<form class='form-horizontal' role='form' action="{{$base_url }}public/upgrade_confirmation/send" method="post">
					<input type="hidden" name="hdn_id" value="{{ $mid }}">
					<div class="form-group">
						 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<input type="text" name="txt_upgrade_code" id="txt_upgrade_code" class='form-control' required='required' placeholder='Bikash Code'>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						 <button type='submit' class='btn btn-info'>Send</button>
						 </div>
					</div>
					
				</form>
				
			</div>
		</div>
	</div>
</div>
@stop

@section('style')
<style>
h5
{
	font-size:16px;
}
#welcome
{
	line-height:25px;
	font-size:15px;
}
#phn
{
line-height:25px;
color:#0177BF;
font-size:18px;
}
</style>
@stop

@section('script')

@stop