@extends('master.layout')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="bx">
            <div class="bx bx-header">
                <h4 class="bx-title">Progress Overview</h4>
            </div>
            <div class="bx bx-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Test Name</th>
                            <th>Date</th>
                            <th>Total Correct</th>
                            <th>Total Wrong</th>
                            <th>View All</th>
                            <th>Time Taken</th>
                            
                            <!-- <th>Subject Wise Answer</th>
                            <th>Subejct Wise Rsult</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($result)
                            {
                                foreach ($result as $r) {
                                    $test_name=exam_model::get_text($r->exam_id);

                                    $date=date_create($r->exam_date);
                                    $dt=date_format($date,'dS M yy  H:i a');
                                    $dt_sec=strtotime($r->exam_date);
                                   
                                    $tm=gmdate('H:i:s',$r->time_taken);
                                    $rpt_link=base_url()."report/subject_wise_answer/index/{$r->exam_id}/{$r->user_id}/{$dt_sec}";
                                    $rpt_link1=base_url()."report/subject_wise_result/index/{$r->exam_id}/{$r->user_id}/{$dt_sec}";
                                    $wrong_lst=base_url()."member/answer_review/index/{$r->exam_id}/{$r->user_id}/{$r->track_id}";
                                    $all_lst=base_url()."member/all_review/index/{$r->exam_id}/{$r->user_id}/{$r->track_id}";
                                    echo "<tr>";
                                    echo "<td>{$test_name}</td>";
                                    echo "<td>{$dt}</td>";
                                    echo "<td>{$r->total_correct}</td>";
                                    echo "<td><a class='btn btn-danger' href='{$wrong_lst}'><i class='fa fa-list'></i>&nbsp;&nbsp;{$r->total_wrong}</a></td>";
                                     echo "<td><a class='btn btn-info' href='{$all_lst}'><i class='fa fa-list'></i>&nbsp;&nbsp;{$r->total_question}</a></td>";
                                    echo "<td>{$tm}</td>";
                                    // echo "<td><a class='btn btn-default' href='{$rpt_link}'> <i class='fa fa-search'></i>&nbsp;</a></td>";
                                    // echo "<td><a class='btn btn-default' href='{$rpt_link1}'><i class='fa fa-search'></i>&nbsp;GO</a></td>";
                                    echo "</tr>";
                                }
                            } 
                        ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('style')
    <style>
        .wlst:hover
        {
            color:#fff;
            font-weight:bold;
            height:20px;
            width:50px;
            display:block;
            background:#FB9337;
        }
    </style>
@stop

@section('script')
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/highcharts.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/exporting.js"></script>
@stop