<input type="hidden" name="hdn_uid" value="{{$uid}}">

<div class="form-horizontal">
    <div class="control-group">
        <label class="control-label">Current Membership</label>
        <div class="controls">
           <span class="badge">{{$current_membership}}</span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="ddl_day">Membership Type</label>
        <div class="controls">
            <select name="ddl_day" id="ddl_day">
                <option value="-1">Select Membership</option>
                <option value="30">One Month</option>
                <option value="60">Two Month</option>
                <option value="90">Three Month</option>
                <option value="180">Six Month</option>
                <option value="360">Twelve Month</option>
                <option value="10">Custom</option>
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="start_date">Start Date</label>
        <div class="controls">
            <input type="text" id="start_date" name='start_date' class='dt' placeholder="Start Date" required>
        </div>
    </div>
    <div id='div_end_date' class="control-group hide">
        <label class="control-label" for="end_date">End Date</label>
        <div class="controls">
            <input type="text" id="end_date" name='end_date' class='dt' placeholder="End Date">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="ref_no">Payament Ref No</label>
        <div class="controls">
            <input type="text" id="ref_no" name='ref_no' placeholder="Payament Ref No(BKash/DBBL Mob No)" required>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('.dt').datepicker({changeMonth:true,changeYear:true,dateFormat:'dd-mm-yy'});
    $('#ddl_day').change(function(){
        var m=$(this).val();
        if(m==10)
        {
            $('#div_end_date').removeClass('hide');
        }
        else{
            $('#div_end_date').addClass('hide');
        }
    });
});
</script>