<?php

namespace App\Controllers;
use Illuminate\View\Factory as View;
use App\Models\Membership_model;
use App\Models\User_model;
use App\Models\Exam\ChoosenCategoryModel;
use App\Models\Ref_text_model;
use App\Models\Dashboard_model;
use App\Models\member\Result_model;
use App\Models\Exam_model;
use App\Models\Model_quiz_summery_model;
use App\Models\member\Upgrade_model;
use App\Models\Days_vocabulary_model;
use App\Models\Vocabulary_model;
use App\Models\Model_test_model;
use App\Models\Activity_log_model;
use App\Models\Events_model;
use App\Models\member\User_choice_model;


use Carbon\Carbon;

//use App\Libraries\Recaptcha;

class MemberController extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        
        $this->creationDate = $this->session->get('creation_date');
        $this->username = $this->session->get('username');
        $this->userid = $this->session->get('userid');
        if(is_null($this->userid))
        {
			header('Location: '.base_url());
			exit(); 
        }
       
        $this->utype = $this->session->get('utype');
        
        $this->ChoosenCategoryModel = new ChoosenCategoryModel();
        $this->refTextModel = new Ref_text_model();
        $this->dashboard_model = new Dashboard_model();
        $this->userModel = new User_model();
        $this->membershipModel = new Membership_model();
        $this->resultModel = new Result_model();
        $this->examModel = new Exam_model();
        $this->modelQuizSummaryModel = new Model_quiz_summery_model();
        $this->upgradeModel = new Upgrade_model();
        $this->days_vocabulary_model = new Days_vocabulary_model();
        $this->vocabulary_model = new Vocabulary_model();
        $this->model_test_model = new Model_test_model();
        $this->activity_log_model = new Activity_log_model();
        $this->events_model = new Events_model();
        $this->choice = new User_choice_model();
    }
    
    public function dashboard()
    {
        $data['choosen']=$this->get_sel_choosen();
        $data['profile_comp']=$this->dashboard_model->get_profile_completed($this->userid);
        $data['mem_info']=$this->get_mem_info();
        $data['mistake_list']=$this->mistake_list();
        $data['review_list']=$this->review_list();
        $data['progress']=$this->progress_list();
        //$data['current_world']=$this->current_world_list();
        $data['latest_exams']=$this->latest_exam_list();
        $data['bcs_subject']=$this->refTextModel->get_exam_wise_subject(7);
        $data['bank_subject']=$this->refTextModel->get_exam_wise_subject(318);
        $data['bcs_written']=$this->refTextModel->get_exam_wise_subject(642);
        $data['mba']=$this->refTextModel->get_exam_wise_subject(680);
        $data['nibondhon']=$this->refTextModel->get_exam_wise_subject(713);
        $data['reviews']=$this->expert_review();
        $latest=$this->dashboard_model->find_latest_eid($this->userid);
        $exam='';
        $user_latest_exam=false;
        $avg_mark='';
        $my_score='';
        $top_score='';
        $rank='';
        if($latest)
        {
         $exam = $this->examModel->get_text($latest->exam_id);
         $user_latest_exam=$this->lastes_user_exam();
         $avg_mark=$this->dashboard_model->get_average($this->userid,$latest->exam_id);
         $my_score=($latest->total_correct/$latest->total_question)*100;
         $top_score=$this->dashboard_model->get_top_score($latest->exam_id);
         $rank=$this->dashboard_model->get_rank($latest->exam_id,$latest->total_correct);
        }


        $upgrade = $this->upgradeModel->find_by_user($this->userid);
        $member_type=$upgrade?$this->membershipModel->get_text($upgrade->mem_type):'N/A';
         $member_type_message='';
        $date_remains=$this->membershipModel->remaining_days($this->userid);

         $data['member_type']=$member_type_message;


        //add choosen category in page load(this may change in future)
        $this->add_choosen_exam();
        //end add category in page load

        // message to display upgrade status
         $mtype=$upgrade?$upgrade->mem_type:0;
         $stts=2;
         $message_for_member='';
         if($this->utype!='101' && $this->utype!='102')
         {
             if($this->utype=='2')
             {
                 $total_free_chapter=get_bn_num($this->dashboard_model->total_free_chapter());
                 $message_for_member="Basic Member হিসেবে আপনি {$total_free_chapter} টি
                 অধ্যায় এবং ৮ টি Previous Test পড়তে ও পরীক্ষা দিতে পারবেন।
                 সব অধ্যায় পড়তে ও পরীক্ষা দিতে Membership Upgrade করুন ";
             }
             else
             {
                 $message_for_member=$this->member_message($this->utype,$stts,$date_remains);
             }

         }
         else
         {
               $message_for_member=$this->member_message($this->utype,$stts,$date_remains);
         }

        $data['message_for_member']=$message_for_member;
        //end message to display upgrade status

        //days vocabulary
        $vocabulary=$this->get_vocabulary();
        //end days vocabulary
        $data['exam_name']=$exam;
        // $data['model_test']=$this->model_test_model->model_test(3);
        $data['model_test']=$this->model_test_model->model_test_bank(5);
        $data['live_test'] =$this->model_test_model->get_live_model_test_dash();
        $data['latest']=$latest;
        $data['user_latest_exam']=$user_latest_exam;
        $data['avg_mark']=$avg_mark;
        $data['my_score']=$my_score;
        $data['top_score']=$top_score;
        $data['vocabulary']=$vocabulary;
        $data['rank']=$rank;
        $data['mtype']=$this->utype;
        $data['activity_logs']=$this->activity_list();
        $data['user']=$this->userid;
        $data['events']=$this->upcoming_events();
        $data['ongoing_events']=$this->ongoing_events();

        $cats_arr=['7','318','713','680','833'];
        $cats=$this->refTextModel->ref_text_group_in($cats_arr);
        $data['exam_cat']=$cats;
        $data['choice_list']=$this->choice_list();
        $data['title']='User panel';
        
        $data['refereal_url'] = get_referral_url($this->session);
        $data['refTextModel'] = $this->refTextModel;
        $data['creationdate'] = $this->creationDate;
        $data['username'] = $this->username;
        return $this->render('member.v_dashboard', $data);
        //$this->load->blade('member.v_dashboard', $data);
    }
    
    
    function get_sel_choosen()
    {
        $choosen = $this->ChoosenCategoryModel->get_choosen($this->userid);
        $str='';
        if($choosen)
        {
            foreach ($choosen as $ch)
            {
                $status='';
                $cat_text = $this->refTextModel->get_text($ch->exam_cat);
                if($ch->status==1)
                {
                    $status="<span style='color:#FFD581'>Pending</span>";
                }
                else
                {
                    $status="<span style='color:#369000'>Approved</span>";
                }

                $str.="<li><i class='fa fa-check' style='color:#70AD40;'></i>&nbsp;&nbsp;{$cat_text}  {$status}</li>";
            }
        }
        else
        {
            $str.="You have not selected any category yet";
        }
        return $str;

    }
    
    
    function choice_list()
    {
        $choices=$this->choice->get_todays_choice($this->userid);
        // var_dump($choices);
        $str='';
        if($choices)
        {
            $str.="<table class='table table-bordered table-striped frm-choice'>";
            $str.="<caption>My Today's Study Plan</caption>";
            $str.="<thead>";
            $str.="<tr>";
            $str.="<th>Chapter Name</th>";
            $str.="<th>Status</th>";
            $str.="</tr>";
            $str.="</thead>";
            $str.="<tbody>";
            foreach ($choices as $choice) {
               $str.="<tr>";
               $name=Ref_text_model::get_text($choice->chapter_id);
               $str.="<td>{$name}</td>";
               $read_stat=$choice->has_read?'checked':'';
               $read_text=$choice->has_read?'Done':'Not Done';
               $str.="<td><label><input data-choice='{$choice->id}' type='checkbox' class='ck_read' value='1' {$read_stat}/><span id='spn_choice_{$choice->id}'>{$read_text}</span></label> ";
               // $str.="<a class=''>Practice</a></td>";
               $str.="</tr>";

            }
            $str.="</tbody>";
            $str.="</table>";
            $plan_url=base_url()."member/dashboard/plans";
            $str.="<a class='btn btn-default' href='{$plan_url}'>Total Plan</a>";
        }
        return $str;

    }

    function plans()
    {
        $data['plans']=$this->choice->get_my_plans($this->userid);
        $data['title']='My Plans';
        $this->load->blade('member.plan.list', $data);
    }

    function update_plan()
    {
        $id=$this->input->post('id');
        $status=$this->input->post('status');
        $this->choice->update($id,['has_read'=>$status]);
        echo 'ok';
    }

    /**
     * get subject by category
     * @return void
     */
    function subject_list()
    {
        $cat_id=$this->input->get('cat_id');
        $subjects=$this->ref_text_model->get_subject_of_exam_cat($cat_id);
        $str="";
        if($subjects)
        {
            foreach ($subjects as $subj) {
            $str.="<option value='{$subj->id}'>{$subj->name}</option>";
            }
        }
        else
        {
            $str='';
        }
        echo  $str;
    }

    /**
     * get chapters by subject
     * @return void
     */
    function get_chapters()
    {
        $subj_id=$this->input->get('subj_id');
        $chapters=$this->ref_text_model->get_chapter_by_subject($subj_id);
        $str="";
        if($chapters)
        {
            foreach ($chapters as $chap) {
            $str.="<option value='{$chap->id}'>{$chap->name}</option>";
            }
        }
        else
        {
            $str='';
        }
        echo  $str;
    }

    function plan()
    {
        $data['title']='Study Plan';
        $this->load->blade('member.plan.plan', $data);
    }

    function update_read_status()
    {
        $choice=$this->input->get('choice');
        $stat=$this->input->get('stat');
        $data=array('has_read'=>$stat);
        $this->choice->update($choice,$data);
        echo 1;
    }


    /**
     * displaing upcoming events
     * @return void
     */
    function ongoing_events()
    {
        $events=$this->events_model->get_ongoing_event();
        $str="";
        if($events)
        {
            foreach ($events as $event) {
                $url=base_url()."member/event_post/index/{$event->id}";

                $str.="<h3 class='sub-header'><a href='{$url}'>{$event->name}</a></h3>";

                $dt=date_create($event->expitre_time);
                $dtf=date_format($dt,"d M Y");
                $time=date_format($dt,'H:i A');
                $str.="<h4>End Date: {$dtf}</h4>";
                $str.="<h4>End Time: {$time}</h4>";

                $check_in_count=$this->check_in_model->count($event->id);
                $checked=$this->check_in_model->checked_in($this->userid,$event->id);
                $stat=$checked?0:1;
                $btn_class=$checked?'btn-info':'btn-default';
                $str.="<h4><button data-status='{$stat}' data-event='{$event->id}' class='btn {$btn_class} btn-sm check_in'>";
                $str.="<i class='fa fa-check'></i>Check In</button> <span clas='check_in_count'><span class='badge badge-info'>{$check_in_count}</span></span> Guests Joined";

                $str.="<a href='{$url}' class='btn btn-info pull-right'>Go Now</a></h4>";


                $str.="<hr/>";
            }
        }
        return $str;
    }


    function expert_review()
    {
        $reviews=$this->modelQuizSummaryModel->expert_review_summery($this->userid);
        $str="";
        if($reviews)
        {
            foreach ($reviews as $review) {
                if(!empty($review->expert_review)){
                $str.="<li class='list-group-item'><i class='fa fa-pencil-square-o'></i>  {$review->expert_review} ";
                $lnk=base_url().'member/model_quiz_progress/show/'.$review->quiz_id;
                $str.="<a class='btn btn-xs' target='_blank' href='{$lnk}'><i class='fa fa-link'></i></a></li>";
                }
            }
        }
        return $str;
    }

    /**
     * Ongoing events
     * @return string
     */
    function upcoming_events()
    {
        $events=$this->events_model->get_published_event(5);
        $str="";
        if($events)
        {
            foreach ($events as $event)
            {
                $url=base_url()."member/event_post/index/{$event->id}";
                $str.="<h3 class='sub-header'>{$event->name}</h3>";
                $dt=date_create($event->event_time);
                $dtf=date_format($dt,"d M Y");
                $time=date_format($dt,"H:i A");
                $str.="<h4>Date: {$dtf}</h4>";
                $str.="<h4>Time: {$time}</h4>";
                $check_in_count=$this->check_in_model->count($event->id);
                $checked=$this->check_in_model->checked_in($this->userid,$event->id);
                $stat=$checked?0:1;
                $btn_class=$checked?'btn-info':'btn-default';
                $str.="<h4><button data-status='{$stat}' data-event='{$event->id}' class='btn {$btn_class} btn-sm check_in'>";
                $str.="<i class='fa fa-check'></i>Check In</button> <span clas='check_in_count'><span class='badge badge-info'>{$check_in_count}</span></span> Guests Joined</h4>";
                if(!empty($event->attachment))
                {
                    $str.="<a class='btn btn-default btn-xs' href='{$event->attachment}'>Download</a>";
                }
                $str.="<hr/>";
            }
        }
        return $str;
    }

    function update_check_in()
    {
        $event_id=$this->input->get('eid');
        $user_id=$this->userid;
        $status=$this->input->get('status');
        if($status=='1')
        {
            $data=['user_id'=>$user_id,'event_id'=>$event_id];
            $this->check_in_model->create($data);
            $status=0;
        }
        else
        {
            $this->check_in_model->remove_check_in($user_id,$event_id);
            $status=1;
        }

        echo $status;
    }


    function activity_list()
    {
        $logs=$this->activity_log_model->get_top_activity(5);
        $str='';
        foreach ($logs as $log) {
            $dt=date_create($log->activity_date);
            $dtf=date_format($dt,'d M, Y');
            $str.="<li>{$log->details}<br/><span><i class='fa fa-clock-o'></i> {$dtf}</span><hr></li>";
        }
        return $str;
    }

    function get_vocabulary()
    {
        // $this->output->enable_profiler(true);
        $today=date('Y-m-d H:i:s');

        //set todays vocabulary
        if($this->days_vocabulary_model->check_date($this->userid)==false)
        {
            $user_max=$this->days_vocabulary_model->user_max($this->userid);
           	$user_max=$user_max==null?0:$user_max;

            //$max=$this->vocabulary_model->max();
                $max=$this->vocabulary_model->table('vocabulary')->selectMax('id')->get()->getRow();
                $max = $max->id;
            $start=$user_max==$max?0:$user_max;
            $this->days_vocabulary_model->clean_data($this->userid);
            $result=$this->vocabulary_model->todays_word($start,10);
            if($result)
            {
                foreach ($result as $row)
                {
                    $data=['user_id'=>$this->userid,
                    'vocabulary_id'=>$row->id,
                    'display_date'=>$today
                    ];
                    $this->days_vocabulary_model->add($data);
                }
            }
        } //end set todays vocabulary


        $vocabulary=$this->days_vocabulary_model->get_todays_word($this->userid);

        return $vocabulary;

    }

    function member_message($mem_type,$status,$date_remains)
    {

        $roles=array('101','102','105');
        $str='';
        if(!in_array($mem_type,$roles))
        {
            // $member_type=membership_model::get_text($mem_type);
            // $amount=$this->permission_model->get_amount($mem_type);
            if($mem_type==2)
            {
                if($status==2)
                {
                    if($date_remains<=0)
                    {
                        $str.="<li style='color:#DA3838;font-size:18px ;'>Your membership has been expired !</li>";
                        $str.="<li>Please upgrade to continue</li>";
                    }
                    else
                    {
                        $str.="<li style='font-size:18px;'>Your are enjoying  premium membership!</li>";
                        $str.="<li>Your membership will expire in {$date_remains} days</li>";
                    }
                }
                else
                {

                }

            }
            else
            {
                if($status==2)
                {
                    if($date_remains<=0)
                    {
                        $str.="<li style='color:#DA3838;'>Your premium has been expired !</li>";
                        $str.="<li>Please upgrade to continue</li>";
                    }
                    else
                    {
                        $str.="<li>Your are enjoying  premium membership!</li>";
                        $str.="<li>Your membership will expire in {$date_remains} days</li>";
                    }
                }
                elseif($status==1)
                {
                    $str.="<li style='color:#DA3838;'>Your premium membership request is under process!</li>";
                    $str.="<li>Please send Tk.{$amount} to bkash number  01917777021 to activate your membership</li>";
                }
                else
                {
                    $str.="<li style='color:#DA3838;'>Your premium has been expired !</li>";
                    $str.="<li>Please upgrade to continue</li>";
                }
            }

        }
        else
        {
            $str.="<li>Admin does not need any membership plan</li>";
        }
        return $str;
    }

    /**
     * added choosen category in page load(this may change in future)
     */
    function add_choosen_exam()
    {
        //$category=$this->refTextModel->all_by('group_id',2);
       // if($category)
        //{
        
        $category = $this->refTextModel->where('group_id', 2)->get()->getResultObject();
		
            foreach ($category as $c) {
                $has=$this->ChoosenCategoryModel->exists($this->userid,$c->id);
                if(!$has)
                {
                    $expiry=date_create('2025-07-21 05:49:37');
                    $expiry_date=date_format($expiry,'Y-m-d H:i:s');
                    $data=array('user_id'=>$this->userid,
                        'exam_cat'=>$c->id,
                        'status'=>2,
                        'request_date'=>date('Y-m-d H:i:s'),
                        'expiry_date'=>$expiry_date
                        );
                    $this->ChoosenCategoryModel->insert($data);
                }
            }
        //}
    }

    

    function get_mem_info()
    {
        $user = $this->userModel->table('user')->where('id',$this->userid)->get()->getRow();
        $str='';
        if($user)
        {
            $date=new Carbon($user->update_date);
            $exp=$date->addDays(90);
            $now=Carbon::now();
            $exp_diff=$exp->diffInDays($now);
            $exptext=0;
            if($exp->isFuture())
            {
                $exptext=$exp_diff;
            }
            $mtext = $this->membershipModel->get_text($user->mem_type);
            $murl=base_url()."membership_feature";
            $str.="<li>I am currently using {$mtext} Membership (<a target='_blank' href='{$murl}'>View Membership Comparison</a>)</li>";
            $str.="<li>Your membership is about  <span style='color:#3C8DBC;'>{$exptext} days</span> to expire</li>";
        }
        return $str;
    }

    function mistake_list()
    {
        $mistakes=$this->dashboard_model->get_latest_mistakes($this->userid,3);
        $str='';
        if($mistakes)
        {
            $i=1;
            foreach ($mistakes as $m) {
                $dt=date_create($m->last_attempt_date);
                $date_attempt=date_format($dt,'d F, Y');
                $question=$this->question_bank_model->question_by_id($m->qid);
                $qtext=strip_tags($question?$question->question:'','<img>');
                $ans=strip_tags($question?$question->options:'');
                $ans_arry=explode('///',$ans);
                $correct='';
                if(count($ans_arry))
                {
                    foreach ($ans_arry as $a)
                    {
                        if(substr(trim(strip_tags($a,'<img>')),0,2)=="@@")
                        {

                            $correct=str_replace("@@",'',trim(strip_tags($a,'<img>')));
                        }
                    }
                }

               $str.="<li style='padding-bottom:7px;'><span style='font-size:15px;'>{$i}. {$qtext}</span><br/><span style='font-size:12px;'>Ans:&nbsp;&nbsp;{$correct}</span></li>";
               $i++;
            }
        }

        return $str;
    }

    function latest_exam_list()
    {
        $str='';
        $exams=$this->examModel->get_latest_exam(5);
        if($exams)
        {
            foreach ($exams as $exam)
            {
                $url=base_url()."member/take_exam/confirm_take_exam/{$exam->id}";
                $exam_name=empty($exam->test_name)?$exam->name:$exam->test_name;
                $str.="<div class='bx bx-body adv'>";
                $str.="<h4>{$exam_name}</h4>";
                $str.="<p>Question added</p>";
                $str.="<a class='btn btn-default' href='{$url}'>Start Now</a>";
                //$str.="<li style='line-height:40px;'><span style='display:block;width:60%;float:left;text-align:left;'>{$exam_name}</span>&nbsp;&nbsp;<span style='display:block;width:20%;float:right;text-align:right;'><a class='btn btn-default' href='{$url}'>Start Now</a></span></li>";
                $str.="</div>";
            }
        }
        return $str;
    }

    function lastes_user_exam()
    {
        $str='';
        $exams=$this->dashboard_model->get_users_latest_exam($this->userid);
        if($exams)
        {
            $str.="<table class='table table-bordered'>";
            $str.="<thead>";
            $str.="<tr>";
            $str.="<th>Exam Name</th>";
            $str.="<th>Date</th>";
            $str.="<th>Time Taken</th>";
            $str.="<th>Total Correct</th>";
            $str.="<th>Total Wrong</th>";
            $str.="</tr>";
            $str.="</thead>";
            $str.="<tbody>";
            foreach ($exams as $exm)
            {
                $examname=exam_model::get_text($exm->exam_id);
                $time=gmdate('H:i:s',$exm->time_taken);
                $dt=date_create($exm->exam_date);
                $dtf=date_format($dt,'d F, Y');
                $str.="<tr>";
                $str.="<td>{$examname}</td>";
                $str.="<td>{$dtf}</td>";
                $str.="<td>{$time}</td>";
                $str.="<td>{$exm->total_correct}</td>";
                $str.="<td>{$exm->total_wrong}</td>";
                $str.="</tr>";
            }
            $str.="</tbody>";
            $str.="</table>";
        }
        return $str;
    }

    function review_list()
    {
        $reviews=$this->dashboard_model->get_latest_reviews($this->userid,3);
        $str='';
        if($reviews)
        {
            $i=1;
            foreach ($reviews as $r) {
                $question=$this->question_bank_model->question_by_id($r->qid);
                $qtext=$question?strip_tags($question->question,'<img>'):'';
                $ans=$question?strip_tags($question->options):'';
                if(!empty($ans))
                {
                    $ans_arry=explode('///',$ans);
                    $correct='';

                    foreach ($ans_arry as $a)
                    {
                        if(substr(trim(strip_tags($a,'<img>')),0,2)=="@@")
                        {

                            $correct=str_replace("@@",'',trim(strip_tags($a,'<img>')));
                        }
                    }

               $str.="<li><span style='font-size:15px;'>{$i}. {$qtext}</span><br/><span style='font-size:13px;'>Ans:&nbsp;&nbsp;{$correct}</span></li>";
               }
               $i++;
            }
        }

        return $str;
    }

    function progress_list()
    {
        $result = $this->resultModel->get_user_progress_latest($this->userid);
        $str="";
        if($result)
        {
            foreach ($result as $r) {

                $dt=date_create($r->exam_date);
                $dtf=date_format($dt,'d F, Y');
                $testname=exam_model::get_text($r->exam_id);
                $str.="<tr>";
                $str.="<td>{$testname}</td>";
                $str.="<td>{$dtf}</td>";
                $str.="<td>{$r->total_correct}</td>";
                $str.="<td>{$r->total_wrong}</td>";
                $str.="</tr>";
            }
        }
        return $str;
    }

    function current_world_list()
    {
        $result=$this->dashboard_model->get_current_world_info(10);
        $str='';
        if($result)
        {
            foreach ($result as $r) {
                $qtext=strip_tags($r->question,'<img>');
                $ans=strip_tags($r->options);
                $ans_arry=explode('///',$ans);
                $correct='';
                foreach ($ans_arry as $a)
                {
                    if(substr(trim(strip_tags($a,'<img>')),0,2)=="@@")
                    {

                        $correct=str_replace("@@",'',trim(strip_tags($a,'<img>')));
                    }
                }
               $str.="<li><span style='font-size:15px;'><i class='fa fa-hand-o-right'></i>&nbsp;{$qtext}<br/><span><span style='font-size:13px;'>Ans:&nbsp;&nbsp;{$correct}</span></li>";
            }
        }
        return $str;
    }
}