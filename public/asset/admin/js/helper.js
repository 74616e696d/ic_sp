

function ajax_post(name,msg_name){

name.on('submit',function(){
	var that=$(this),
	 url=that.attr('action'),
	 method=that.attr('method'),
	 data={};
	 that.find('[name]').each(function(index,value){
	 		var that=$(this),
	 			name=that.attr('name'),
	 			value=that.val();

	 			data[name]=value;
	 });

	 $.ajax({
	 	url:url,
	 	type:method,
	 	data:data,
	 	success:function(msg){
	 		msg_name.html(msg);
	 	}
	 });
	return false;
});

}
function bind_ddl(url,child,key,value)
{
	var dt='{'+key+':'+value+'}';
	alert(dt);
		$.ajax({
			url:url,
			type:'POST',
			data:dt,
			success:function(msg){
				child.html(msg);
			}
		});
}