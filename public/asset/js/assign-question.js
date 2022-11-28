$('.subj li button').click(function(){

	var present=$(this),
		sid=present.attr('data-val');
	$.ajax({
		url: base_url+'admin/question_assignment/get_chapter_group',
		type:'GET',
		data: {sid:sid}
	})
	.done(function(msg) {
		present.parent('li').children('div').html(msg);
	});
});


$(document).on('click','.cp_gr li button',function(){
	var present=$(this),
		cid=present.attr('data-val');
		
	$.ajax({
		url: base_url+'admin/question_assignment/get_chapters',
		type:'GET',
		data: {cid:cid}
	})
	.done(function(msg) {
		present.parent('li').children('div').html(msg);
	});
});

