//making edittable template
function makeTemplate(itemTemp,editItemTemp,removeIcon)
{
	if(itemTemp.text().length!=0)
	{
		editItemTemp.css('display','none');
		removeIcon.css('display','none');

		itemTemp.dblclick(function(){
			$(this).css('display','none');
			removeIcon.show();
			editItemTemp.show();

		});
		removeIcon.live('click',function(){
			removeIcon.hide();
			editItemTemp.hide();
			itemTemp.show();
		});
	}
	else
	{
		removeIcon.css('display','none');
	}

}


//Raw control

function bindEditDropdownOnChange(ddlChange,ddlToBind,hdnField,actionName)
{	
	 ddlChange.change(function(){

        	var changeVal=ddlChange.children(":selected").val();
        	
        	 if(changeVal>0){
                
                $.ajax({
                    url:actionName,
                    type:'POST',
                    data:{eid:changeVal},
                    success:function(msg){
                       ddlToBind.html(msg);
                    }

                });
            }
        });
        
        ddlToBind.change(function(){
            var currVal=$(this).children(':selected').val();
            hdnField.val(currVal);
        });
}

function bindDropdownOnChange(ddlChange,ddlToBind,actionName)
{	
	 ddlChange.change(function(){

        	var changeVal=ddlChange.children(":selected").val();
        	 if(changeVal>0){
                $.ajax({
                    url:actionName,
                    type:'POST',
                    data:{eid:changeVal},
                    success:function(msg){
                       ddlToBind.html(msg);
                    }

                });
            }
        });
}


// Generating checkboxes depending on parent value
function generate_checkbox_list(ddlChange,ckToBind,actionName)
{
   ddlChange.change(function(){
    //alert('Hi');
    var changeVal=ddlChange.children(':selected').val();
    if(changeVal>0){
        $.ajax({
            url:actionName,
            type:'GET',
            data:{eid:changeVal},
            success:function(msg){
                ckToBind.html(msg);
            }
        });
    }else{
        ckToBind.html(msg);
    }

   });
    
}


function exam_meta_on_ck_change(ckChange,ckToBind,action)
{
    //ckChange.removeAttr('checked');
    ckChange.click(function()
    {
        var vl=$(this).attr('value'),
         track_vl=$('#spn_exm_name_'+vl);
        if($(this).is(':checked'))
        {
                $.ajax({
                    url:action,
                    type:'GET',
                    data:{eid:vl},
                    success:function(msg){
                        ckToBind.append(msg);
                    }
                });  
        }
        else
        {
            ckToBind.find(track_vl).remove();
        }
        

    });
}


function exam_meta_on_ck_edit_change(ckChange,ckToBind,action)
{
    //ckChange.removeAttr('checked');
    ckChange.click(function()
    {
        var vl=$(this).attr('value'),
         track_vl=$('#spn_exm_name_'+vl),
         editId=$('#hdn_edit_id').val();
        if($(this).is(':checked'))
        {
                $.ajax({
                    url:action,
                    type:'GET',
                    data:{eid:vl,edit_id:editId},
                    success:function(msg){
                        ckToBind.append(msg);
                    }
                });  
        }
        else
        {
            ckToBind.find(track_vl).remove();
        }
        

    });
}


function exam_meta_on_load(ckChange,ckToBind,action)
{
        $.each(ckChange,function(){
             var vl=$(this).val(),
                    track_vl=$('#spn_exm_name_'+vl),
                    editId=$('#hdn_edit_id').val();
            if($(this).is(':checked'))
            {
                    $.ajax({
                        url:action,
                        type:'GET',
                        data:{eid:vl,edit_id:editId},
                        success:function(msg){
                            ckToBind.append(msg);
                        }
                    });  
            }
            else
            {
                ckToBind.find(track_vl).remove();
            }

        });   
}





