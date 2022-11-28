<style>
	#content{
		padding-left:10px;
		padding-top:10px;
	}
</style>
<script>

      window.fbAsyncInit = function() {
        FB.init({
          appId      : "1390651954534358",
          status     : true,
          xfbml      : true
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/all.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));

      function newInvite(){
     FB.ui({ method: 'apprequests',
     	title:'Pinnacle Test',
          message: 'You are requested to join Pinnacle Test http://pinnacletest.com'});
    }
</script>
<div id="content">
<a class="btn btn-info btn-mini btn-block" href="#" onclick="newInvite(); return false;">Invite Fiends To Join</a>
</div>
<div id="fb-root"></div>