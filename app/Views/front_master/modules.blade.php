<!-- <h2 class='module-header'>MODULES</h2> -->
<?php
use App\Libraries\Slug;

$slug = new Slug();
?>
<div class='modules'>
    <div class="container">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-justified nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#bcs" aria-controls="home" role="tab" data-toggle="tab">BCS</a>
                </li>
                <li role="presentation">
                    <a href="#bank" aria-controls="tab" role="tab" data-toggle="tab">BANK</a>
                </li>
                <li role="presentation">
                    <a href="#govt" aria-controls="tab" role="tab" data-toggle="tab">GOVT. JOB</a>
                </li>
                <li role="presentation">
                    <a href="#teacher" aria-controls="tab" role="tab" data-toggle="tab">NTRCA</a>
                </li>
                <li role="presentation">
                    <a href="#mba" aria-controls="tab" role="tab" data-toggle="tab">MBA</a>
                </li>
            </ul>
        
            <!-- Tab panes -->
            <div class="tab-content">
                <!--START BCS-->
                <div role="tabpanel" class="tab-pane active" id="bcs">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 no-pad-left">
                        <div class="bar pull-left hidden-xs hidden-sm">
                            <div class="arrow-right"></div>
                        </div>
                        <div class='pull-left'>
                            <ul class='list-unstyled'>
                            <li><h3>Study Material</h3></li>
                                @if($bcs_subject)
                                @foreach($bcs_subject as $row)
                                <?php 
                                $bcs_slug=$slug->create_slug($row->name);
                                $bcs_slug = strtolower($row->name);
                                  $bcs_id='7';
                                  $lnk_bcs=base_url().'chapters/'.$row->id.'/'.$bcs_slug;
                                  
                               if($is_auth)
                                  {
                                   
                                    $lnk_bcs="{$base_url}member/practice/index/{$bcs_id}/{$row->id}/{$bcs_slug}";
                                  } 
                                ?>
                                <li><a href="{{$lnk_bcs}}">{{$row->name}}</a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <ul class='list-unstyled'>
                            <li><h3>Recent Questions</h3></li>
                            @if($bcs_exams)
                            @foreach($bcs_exams as $row)
                            <?php 
                              $bcs_exam_slug=$ci->slug->create_slug($row->name);
                              $lnk_bcs_exam=base_url().'public/user_reg';
                              if($is_auth)
                              {
                                $lnk_bcs_exam="{$base_url}member/test/index/{$row->id}";
                              } 
                            ?>
                            <li><a href="{{$lnk_bcs_exam}}">{{$row->name}}</a></li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <ul class='list-unstyled'>
                            <li><h3>Model Tests</h3></li>
                            @if($bcs_model_test)
                            @foreach($bcs_model_test as $row)
                            <?php 
                              $bcs_model_test_slug=$ci->slug->create_slug($row->name);
                              $lnk_bcs_model_test=base_url().'public/user_reg';
                              if($is_auth)
                              {
                                $lnk_bcs_model_test="{$base_url}member/model_quiz/index/{$row->id}/{$bcs_model_test_slug}";
                              } 
                            ?>
                            <li><a href="{{$lnk_bcs_model_test}}">{{$row->name}}</a></li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <ul class="list-unstyled">
                          <li><h3>Next Exam</h3></li>
                          <li>
                             @if($next_bcs_exam)
                             <img src="{{$base_url}}asset/upload/{{$next_bcs_exam->fall_back_img}}" alt="40th BCS Exam Date">
                            @endif
                          </li>
                        </ul>
                    </div>
                </div>
                 <!--END BCS-->

                  <!--START BANK-->
                <div role="tabpanel" class="tab-pane" id="bank">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 no-pad-left">
                        <div class="bar pull-left hidden-xs hidden-sm">
                            <div class="arrow-right"></div>
                        </div>
                        <div class='pull-left'>
                            <ul class='list-unstyled'>
                                <li><h3>Study Material</h3></li>
                                @if($bank_subject)
                                @foreach($bank_subject as $row)
                              <?php 
                                $bank_slug=$ci->slug->create_slug($row->name);
                                $bank_id='7';
                                $lnk_bank=base_url().'chapters/'.$row->id.'/'.$bank_slug;
                                if($is_auth)
                                {
                                  $lnk_bank="{$base_url}member/practice/index/{$bank_id}/{$row->id}/{$bank_slug}";
                                } 
                              ?>
                                <li><a href="{{$lnk_bank}}">{{$row->name}}</a></li>
                                @endforeach
                                @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <ul class='list-unstyled'>
                            <li><h3>Recent Questions</h3></li>
                            @if($bank_exams)
                            @foreach($bank_exams as $row)
                            <?php 
                              $bank_exam_slug=$ci->slug->create_slug($row->name);
                              $lnk_bank_exam=base_url().'public/user_reg';
                              if($is_auth)
                              {
                                $lnk_bank_exam="{$base_url}member/practice_test/index/{$row->id}/{$bank_exam_slug}";
                              } 
                            ?>
                            <li><a href="{{ $lnk_bank_exam }}">{{$row->name}}</a></li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <ul class='list-unstyled'>
                            <li><h3>Model Tests</h3></li>
                            @if($bank_model_test)
                                @foreach($bank_model_test as $row)
                                <?php 
                                  $bank_model_test_slug=$ci->slug->create_slug($row->name);
                                  $lnk_bank_model_test=base_url().'public/user_reg';
                                  if($is_auth)
                                  {
                                    $lnk_bank_model_test="{$base_url}member/model_quiz/index/{$row->id}/{$bank_model_test_slug}";
                                  } 
                                ?>
                                <li><a href="{{ $lnk_bank_model_test }}">{{$row->name}}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                      <ul class="list-unstyled">
                        <li><h3>Next Exam</h3></li>
                        <li>
                           @if($next_bank_exam)
                           <img src="{{$base_url}}asset/upload/{{$next_bank_exam->fall_back_img}}" alt="Bank Exam Date">
                          @endif
                        </li>
                      </ul>
                    </div>
                </div>
                <!--END BANK-->

                <!--GOVT EXAMS-->
                <div role="tabpanel" class="tab-pane" id="govt">
                 <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 no-pad-left">
                     <div class="bar pull-left hidden-xs hidden-sm">
                         <div class="arrow-right"></div>
                     </div>
                     <div class='pull-left'>
                         <ul class='list-unstyled'>
                             <li><h3>Study Material</h3></li>
                             @if($govt_subject)
                             @foreach($govt_subject as $row)
                           <?php 
                             $govt_slug=$ci->slug->create_slug($row->name);
                             $govt_id='7';
                             $lnk_govt=base_url().'chapters/'.$row->id.'/'.$govt_slug;
                             if($is_auth)
                             {
                               $lnk_govt="{$base_url}member/practice/index/{$govt_id}/{$row->id}/{$govt_slug}";
                             } 
                           ?>
                             <li><a href="{{$lnk_govt}}">{{$row->name}}</a></li>
                             @endforeach
                             @endif
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                     <ul class='list-unstyled'>
                         <li><h3>Recent Questions</h3></li>
                         @if($govt_exams)
                         @foreach($govt_exams as $row)
                         <?php 
                           $govt_exam_slug=$ci->slug->create_slug($row->name);
                           $lnk_govt_exam=base_url().'public/user_reg';
                           if($is_auth)
                           {
                             $lnk_govt_exam="{$base_url}member/practice_test/index/{$row->id}/{$govt_exam_slug}";
                           } 
                         ?>
                         <li><a href="{{ $lnk_govt_exam }}">{{$row->name}}</a></li>
                         @endforeach
                         @endif
                     </ul>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                     <ul class='list-unstyled'>
                         <li><h3>Model Tests</h3></li>
                         @if($govt_model_test)
                         @foreach($govt_model_test as $row)
                         <?php 
                           $govt_model_test_slug=$ci->slug->create_slug($row->name);
                           $lnk_govt_model_test=base_url().'public/user_reg';
                           if($is_auth)
                           {
                             $lnk_govt_model_test="{$base_url}member/model_quiz/index/{$row->id}/{$govt_model_test_slug}";
                           } 
                         ?>
                         <li><a href="{{$lnk_govt_model_test}}">{{$row->name}}</a></li>
                         @endforeach
                         @endif
                     </ul>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <ul class="list-unstyled">
                      <li><h3>Next Exam</h3></li>
                      <li>
                         @if($next_govt_exam)
                         <img src="{{$base_url}}asset/upload/{{$next_govt_exam->fall_back_img}}" alt="Ministry Exam Date">
                        @endif
                      </li>
                    </ul>
                 </div>
                </div>
                <!--END GOVT EXAMS-->
                <div role="tabpanel" class="tab-pane" id="teacher">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 no-pad-left">
                        <div class="bar pull-left hidden-xs hidden-sm">
                            <div class="arrow-right"></div>
                        </div>
                        <div class='pull-left'>
                            <ul class='list-unstyled'>
                                <li><h3>Study Material</h3></li>
                                @if($teachers_subject)
                                @foreach($teachers_subject as $row)
                               <?php 
                                 $teachers_slug=$ci->slug->create_slug($row->name);
                                 $teachers_id='7';
                                 $lnk_teachers=base_url().'chapters/'.$row->id.'/'.$teachers_slug;
                                 if($is_auth)
                                 {
                                   $lnk_teachers="{$base_url}member/practice/index/{$teachers_id}/{$row->id}/{$teachers_slug}";
                                 } 
                               ?>
                                <li><a href="{{$lnk_teachers}}">{{$row->name}}</a></li>
                                @endforeach
                                @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <ul class='list-unstyled'>
                            <li><h3>Recent Questions</h3></li>
                            @if($teachers_exams)
                            @foreach($teachers_exams as $row)
                            <?php 
                              $teachers_exam_slug=$ci->slug->create_slug($row->name);
                              $lnk_teachers_exam=base_url().'public/user_reg';
                              if($is_auth)
                              {
                                $lnk_teachers_exam="{$base_url}member/practice_test/index/{$row->id}/{$teachers_exam_slug}";
                              } 
                            ?>
                            <li><a href="{{$lnk_teachers_exam}}">{{$row->name}}</a></li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                      <ul class='list-unstyled'>
                          <li><h3>Model Tests</h3></li>
                          @if($teachers_model_test)
                          @foreach($teachers_model_test as $row)
                          <?php 
                            $teachers_model_test_slug=$ci->slug->create_slug($row->name);
                            $lnk_teachers_model_test=base_url().'public/user_reg';
                            if($is_auth)
                            {
                              $lnk_teachers_model_test="{$base_url}member/model_quiz/index/{$row->id}/{$teachers_model_test_slug}";
                            } 
                          ?>
                          <li><a href="{{$lnk_teachers_model_test}}">{{$row->name}}</a></li>
                          @endforeach
                          @endif
                      </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                      <ul class="list-unstyled">
                        <li><h3>Next Exam</h3></li>
                        <li>
                           @if($next_teachers_exam)
                           <img src="{{$base_url}}asset/upload/{{$next_teachers_exam->fall_back_img}}" alt="15th NTRCA Exam Date">
                          @endif
                        </li>
                      </ul>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="mba">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 no-pad-left">
                        <div class="bar pull-left hidden-xs hidden-sm">
                            <div class="arrow-right"></div>
                        </div>
                        <div class='pull-left'>
                            <ul class='list-unstyled'>
                                <li><h3>Study Material</h3></li>
                                @if($mba_subject)
                                @foreach($mba_subject as $row)
                                <?php 
                                  $mba_slug=$ci->slug->create_slug($row->name);
                                  $mba_id='7';
                                  $lnk_mba=base_url().'chapters/'.$row->id.'/'.$mba_slug;
                                  if($is_auth)
                                  {
                                    $lnk_mba="{$base_url}member/practice/index/{$mba_id}/{$row->id}/{$mba_slug}";
                                  } 
                                ?>
                                <li><a href="{{$lnk_mba}}">{{$row->name}}</a></li>
                                @endforeach
                                @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <ul class='list-unstyled'>
                            <li><h3>Recent Questions</h3></li>
                            @if($mba_exams)
                            @foreach($mba_exams as $row)
                            <?php 
                              $mba_exam_slug=$ci->slug->create_slug($row->name);
                              $lnk_mba_exam=base_url().'public/user_reg';
                              if($is_auth)
                              {
                                $lnk_mba_exam="{$base_url}member/practice_test/index/{$row->id}/{$mba_exam_slug}";
                              } 
                            ?>
                            <li><a href="{{$lnk_mba_exam}}">{{$row->name}}</a></li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <ul class='list-unstyled'>
                            <li><h3>Model Tests</h3></li>
                            @if($mba_model_test)
                            @foreach($mba_model_test as $row)
                            <?php 
                              $mba_model_test_slug=$ci->slug->create_slug($row->name);
                              $lnk_mba_model_test=base_url().'public/user_reg';
                              if($is_auth)
                              {
                                $lnk_mba_model_test="{$base_url}member/model_quiz/index/{$row->id}/{$mba_model_test_slug}";
                              } 
                            ?>
                            <li><a href="{{$lnk_mba_model_test}}">{{$row->name}}</a></li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                      <ul class="list-unstyled">
                        <li><h3>Next Exam</h3></li>
                        <li>
                           @if($next_mba_exam)
                           <img src="{{$base_url}}asset/upload/{{$next_mba_exam->fall_back_img}}" alt="Evening MBA Exam Date">
                          @endif
                        </li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>