<div class="card">
    <div class="header">
        <h4 class="title pull-left">Edit Profile</h4>

        <button type="button" title='Edit' id='btnExpertDetailsEdit' onclick="enable_edit('.expert_details_content')" class="btn btn-xs btn-default btn-enable-edit pull-right"><i class="fa fa-edit"></i></button>
        <div class="clearfix"></div>
    </div>
    <div class="content">
        <form class='expert_details_content'>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for='title'>Title</label>
                        <input type="text" class="form-control border-input" name="title" placeholder="Title" value="{{ $user_details->title }}">
                    </div>
                </div>
                <div class="col-md-7">
                   <div class="form-group">
                       <label>Full Name</label>
                       <input type="text" name="full_name" id="full_name" class="form-control border-input" placeholder="Full Name" value="{{ $user_details->full_name }}">
                   </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for='address'>Address</label>
                        <input type="text" name='address' id='address' class="form-control border-input" placeholder="Address" value="{{ $user_details->present_address }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for='summery'>About Me</label>
                        <textarea rows="3" name="summery" id="summery" class="form-control border-input" placeholder="About Me">{{ $user_details->expert_summery }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for='fb_url'>Facebook Url</label>
                        <input type="text" name='fb_url' id='fb_url' class="form-control border-input" placeholder="Facebook Url" value="{{ $user_details->facebook_url }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for='twitter_url'>Twitter Url</label>
                        <input type="text" name='twitter_url' id='twitter_url' class="form-control border-input" placeholder="Twitter Url" value="{{ $user_details->twitter_url }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for='youtube_url'>Youtube Url</label>
                        <input type="text" name='youtube_url' id='youtube_url' class="form-control border-input" placeholder="Youtube Url" value="{{ $user_details->youtube_url }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for='linkedin_url'>Linkedin Url</label>
                        <input type="text" name='linkedin_url' id='linkedin_url' class="form-control border-input" placeholder="Linkedin Url" value="{{ $user_details->linkedin_url }}">
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-info btn-fill btn-sm btn-action hide">Update Profile</button>
                <button type="button" id='btnCancelExpertDetailsEdit' onclick="cancel_edit('.expert_details_content')" class="btn btn-fill btn-sm btn-action hide">Cancel</button>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>