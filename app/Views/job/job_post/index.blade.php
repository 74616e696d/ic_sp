@extends('job.layout.master')
@section('content')
    <div class="container">
      <form class="form-horizontal update_form" method="post" action="{{  $base_url }}job/job/insert">
        <div class="card-panel">

          <div style="text-align: center;">
              {{ $ci->session->flashdata('msg') }}
          </div>

          <!-- Job Category -->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="job_cat">Job Category</label>
            <select id="job_cat" name="job_cat">
            <option value="0">Select</option>
            @if($category)
            @foreach($category as $cat)
              <option value="<?php echo $cat->id; ?>">{{  $cat->title }}</option>
            @endforeach
            @endif
            </select>
            <span class="text-danger">{{  form_error('job_nature') }}</span>
          </div>
          <!-- Job Category -->

          <!-- Organization name -->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="organization_name">Organization Name</label>
            <input id="organization_name" name="organization_name" type="text" value="">
            <span class="text-danger">{{ form_error('organization_name') }}</span>
          </div>
          <!-- /Organization name -->

          <!--Post Name-->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="post_name">Post Name</label>
            <input id="post_name" name="post_name" type="text" value="">
          </div>
          <!--Post Name-->

          <!--Educational Requirement-->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="education">Educational Requirement</label>
            <textarea name="education" id="education" cols="30" rows="10" type="text"></textarea>
          </div>
          <!--Educational Requirement-->

          <!--Experience Year-->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="experience">Experience Year</label>
            <input id="experience" name="experience" type="text" value="">
          </div>
          <!--Experience Year-->

          <!--Number of Vacancy-->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="vacancy_no">Number of Vacancy</label>
            <input id="vacancy_no" name="vacancy_no" type="text" value="">
          </div>
          <!--Number of Vacancy-->

          <!--Job Description/Responsibility-->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="job_responsibility">Job Description/Responsibility</label>
            <textarea name="job_responsibility" id="job_responsibility" cols="30" rows="10" type="text"></textarea>
          </div>
          <!--Job Description/Responsibility-->

          <!-- Job Nature -->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="job_nature">Job Nature</label>
            <select id="job_nature" name="job_nature">
              <option value="0">Select</option>
              <option value="Full Time">Full Time</option>
              <option value="Part Time">Part Time</option>
              <option value="Contructual">Contructual</option>
            </select>
            <span class="text-danger"><?php echo form_error('job_nature'); ?></span>
          </div>
          <!-- Job Nature -->

          <!-- Experience Requirement -->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="  experience_requirement_details">Experience Requirement</label>
            <textarea name="experience_requirement_details" id="  experience_requirement_details" cols="30" rows="10" type="text"></textarea>
          </div>
          <!-- Experience Requirement -->

          <!-- Additional Job Requirement -->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="aditional_job_requirement">Additional Job Requirement</label>
            <textarea name="aditional_job_requirement" id="aditional_job_requirement" cols="30" rows="10" type="text"></textarea>
          </div>
          <!-- Additional Job Requirement -->
          
          <!-- Job Location -->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="job_location">Job Location</label>
            <select id="job_location" name="job_location">
              <option value="">Select</option>
              <option value="Dhaka">Dhaka</option>
              <option value="Chittagong">Chittagong</option>
              <option value="Rajshahi">Rajshahi</option>
              <option value="Khulna">Khulna</option>
              <option value="Barisal">Barisal</option>
              <option value="Sylhet">Sylhet</option>
              <option value="Rangpur">Rangpur</option>
              <option value="Mymensingh">Mymensingh </option>
              <option value="Any Where in Bangladesh">Any Where in Bangladesh </option>
            </select>
            <span class="text-danger"><?php echo form_error('job_nature'); ?></span>
          </div>
          <!-- Job Location -->

          <!-- Salary Range -->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="salary_range">Salary Range</label>
            <input id="salary_range" name="salary_range" type="text" value="">
          </div>
          <!-- Salary Range -->

          <!--Other Benefits -->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="other_benefits">Other Benefits</label>
            <textarea name="other_benefits" id="other_benefits" cols="30" rows="10" type="text"></textarea>
          </div>
          <!--Other Benefits -->

          <!-- Age Limit -->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="age">Age Limit</label>
            <input id="age" name="age" type="text" value="">
          </div>
          <!-- Age Limit -->

          <!--Published Date-->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="publish_date">Published Date</label>
            <input class="date" id="publish_date" name="publish_date" type="text">
          </div>
          <!--Published Date-->

          <!--Deadline-->
          <div class="">
            <i class="fa fa-keyboard-o"></i>
            <label for="deadline">Deadline</label>
            <input class="date" id="deadline" name="deadline" type="text">
          </div>
          <!--Deadline-->
          
          <button name="submit" type="submit" class="waves-effect waves-light btn-large z-depth-0 z-depth-1-hover">Submit</button>
        </div>
      </form>
    </div>
@stop