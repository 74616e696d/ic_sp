/**
 * Created with JetBrains PhpStorm.
 * User: majumder
 * Date: 7/8/13
 * Time: 10:45 PM
 * To change this template use File | Settings | File Templates.
 */
function GetCntrlType(Cntrl,ttl_ans)
{
    if(ttl_ans==1){

        $('.'+Cntrl).prop('type','radio');
        $('.'+Cntrl).attr('name','rd_ans');
        $('.'+Cntrl).attr('data-color','red');

        $('.'+Cntrl).prettyCheckable({
            color: 'red'
        });
    }
    if(ttl_ans>1)
    {
        $('.'+Cntrl).prop('type','checkbox');
        $('.'+Cntrl).prettyCheckable({
            color: 'red'
        });
    }
}