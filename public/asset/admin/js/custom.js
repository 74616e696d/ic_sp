$(document).ready(function(){
    $('.ttp').tooltip();
    });



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
                resetForm();
            }
        });
        return false;
    });

}
function get_selected_data(url,id,msg_ietm)
{
    $.ajax({
        url:url,
        type:'POST',
        data:{id:id},
        success:function(data){
            msg_ietm.empty().html(data);
        }
    });
   return false;
}
function resetForm() {
   $(':text').val('');
    $('textarea').val('');
    $(':checkbox').removeAttr('checked');
}