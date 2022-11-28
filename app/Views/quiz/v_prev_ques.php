	<div id="left">
		<table>
			<thead>
				<tr>
							<th>Tag</th>
							<th>Q.No</th>
				</tr>
			</thead>
			<tbody>
				<?php for($i=1;$i<=100;$i++){ ?>
				<tr>
					<td><input class="ck_left" type="checkbox"></td>
					<td><?php echo $i; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div id="right">
        <table class="tbl_ques">
            <tr>
                <td class="qhead">Question-1:</td>
            </tr>
            <tr>
                <td class="ques">What is  national fruit of Bangladesh?</td>
            </tr>
            <tr>
                <td>
                    <table class="tbl_ans">
                        <tr>
                            <td><input class="ck" type="checkbox"/></td>
                            <td class="ans_txt"><span>Mango</span></td>
                        </tr>
                        <tr>
                            <td><input class="ck" type="checkbox"/></td>
                            <td class="ans_txt"><span>Jackfruit Jackfruit Jackfruit Jackfruit Jackfruit Jackfruit Jackfruit Jackfruit Jackfruit Jackfruit Jackfruit Jackfruit Jackfruit</span></td>
                        </tr>
                        <tr>
                            <td><input class="ck" type="checkbox"/></td>
                            <td class="ans_txt"><span>Coconut</span></td>
                        </tr>
                        <tr>
                            <td><input class="ck" type="checkbox"/></td>
                            <td class="ans_txt"><span>Guava</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
	</div>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/prev_exam.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#left table tbody tr').click(function(){
			alert('Hi');
		});

        $('.ck_left').prettyCheckable({
            color: 'red'
        });

        var ctr='ck';
        GetCntrlType(ctr,1);
	});
	</script>