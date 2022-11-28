<h2 class="forum-title"><img src="{{$base_url}}asset/frontend/new/img/forum.png" alt="Forum">FORUM</h2>
<div class="container forum">
@if($forum)
@foreach($forum as $row)
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
     <?php
   $dtls=strip_tags($row->details,'<img>');
   $dtls=word_limiter($dtls,50,'...');
   $ttl=!empty($row->title)?$row->title:$dtls;
   ?>
   <h3>{{ $ttl }}</h3>
   <h5 class='date'>{{$row->post_date}}</h5>
   <p>
   </p>

   <a href="{{$base_url}}forum/forum/replies/{{$row->id}}" class="btn btn-primary" title="">READ MORE</a>
</div>
 @endforeach
 <div class="clearfix"></div>
 @endif
</div>
