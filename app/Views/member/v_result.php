<style>
	#result
	{
		margin-top:50px;
	}
	.table
	{
		border:2px solid #f9f9f9;
	}
	.table th
	{
		width:35%;
		text-align:left;
	}
	.table td
	{
		text-align:left;
	}
	.table tr:hover
	{
		background:#f5f5f5;
	}
	h3
	{
		padding-left:35%;
		background:#66A54C;
		color:#fff;
		box-shadow:2px 2px 2px #f5f5f5;
	}
	.container
	{
		width:750px;
	}
</style>

<div id='result'>
	<div class='container'>
		<h3>Result</h3>
		<table class="table table stripped">
			<tr>
				<th>Name:</th>
				<td><?php echo $user->full_name; ?></td>
			</tr>
			<tr>
				<th>Test Name:</th>
				<td><?php echo $exam->test_name;  ?></td>
			</tr>
		</table>
		<table class='table table-stripped'>
				<tr>
					<th>Total Question</th>
					<td><?php echo $exam->total_ques; ?></td>
				</tr>
				<tr>
					<th>Total Marks</th>
					<td><?php echo $exam->total_marks; ?></td>
				</tr>
				<tr>
					<th>Correct Answer</th>
					<td><?php echo $correct; ?></td>
				</tr>
				<tr>
					<th>Wrong Answer</th>
					<td><?php echo $wrong; ?></td>
				</tr>
				<tr>

					<th>Not Answered</th>
					<td><?php echo $notanswered; ?></td>
				</tr>
				<tr>
					<th>Gained Marks</th>
					<td><?php echo $gained; ?></td>
				</tr>
		</table>
		<div>

		</div>
	</div>
</div>