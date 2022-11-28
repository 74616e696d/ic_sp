<?php
/**
 * @name        Custom Validation Library
 * @author      Md. Shamsudddoha Majumder(Shamim)
 * 
 *DESCRIPTION:This is a generic form validation library for codeigniter.
 *       Idea taken from Laravel framework. This library is not dependent
 *        CI validation library
 **/


 if (!defined("BASEPATH")) exit("No direct script access allowed");

class My_Validation {

	public $errors=array();
	
    /**
     * display validation message
     * @return [string] [description]
     */
	public function display_message()
	{
		$ci =& get_instance();
		$str_message='';
		if($ci->session->flashdata('msg'))
		{
			$msgs=$ci->session->flashdata('msg');
			if(count($msgs)>0)
			{
                //$str_message.="<h3>The following error occures</h3>";
				for($i=0;$i<count($msgs);$i++)
				{
					$str_message.='<div class="alert alert-error">';
	    			$str_message.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
	    			$str_message.='<strong>'.$msgs[$i].'</strong>';
	    			$str_message.='</div>';
				}
			}
		}
		echo $str_message;
	}

    /**
     * validation function
     * @param  [type] $data  [description]
     * @param  [type] $rules [description]
     * @return [bool]        [description]
     */
    public function validate($data,$rules)
    {
        $valid=TRUE;
        foreach ($rules as $fieldname => $rule) {
        	$callbacks=explode('|',$rule);
        	foreach ($callbacks as $callback) 
        	{
                $fld=explode('|',$fieldname);
        		$value=isset($data[$fld[0]])?$data[$fld[0]]:NULL;
                $fld_name=explode('|',$fieldname);

                $callbacks2=explode(':',$callback);
                
                if(count($callbacks2)==1)
                {
            		if($this->$callback($value,$fld_name)==FALSE)
            		{
            			$valid=FALSE;
            		}
                }
                if(count($callbacks2)==2)
                {
                    $cb=explode(',',$callbacks2[1]);
                    if(count($cb)==1)
                    {
                        if($this->$callbacks2[0]($value,$callbacks2[1],$fld_name)==FALSE)
                        {
                            $valid=FALSE;
                        }
                    }
                   if(array_key_exists(1,$cb))
                    {
                        if($this->$callbacks2[0]($value,$cb[0],$cb[1],$fld_name)==FALSE)
                        {
                            $valid=FALSE;
                        }
                    }
                }

        	}
        }
        return $valid;
    }

    /**
     * function for validating email address
     * @param  [type] $value     [description]
     * @param  array  $fieldname [description]
     * @return [bool]            [description]
     */
    public function email($value,$fieldname=array())
    {
    	$valid=filter_var($value,FILTER_VALIDATE_EMAIL);
    	if($valid==FALSE) 
    	{
            $fld_display=array_key_exists(1,$fieldname)?$fieldname[1]:$fieldname[0];
    		$this->errors[]="The {$fld_display} needs to be a valid email!";
    	}
    	return $valid;
    }

    /**
     * required determine where a field is required or not
     * @param  [type] $value     [description]
     * @param  array  $fieldname [description]
     * @return [bool]            [description]
     */
    public function required($value,$fieldname=array())
    {
    	$valid=!empty($value);
    	if($valid==FALSE) 
    	{
            $fld_display=array_key_exists(1,$fieldname)?$fieldname[1]:$fieldname[0];
    		$this->errors[]="The {$fld_display} is required!";
    	}
    	return $valid;
    }

    /**
     * number function validate whether a field is numberic
     * @param  [type] $value     [description]
     * @param  array  $fieldname [description]
     * @return [type]            [description]
     */
    public function number($value,$fieldname=array())
    {
        $valid=is_numeric($value)?TRUE:FALSE;
        if($valid==FALSE) 
        {
            $fld_display=array_key_exists(1,$fieldname)?$fieldname[1]:$fieldname[0];
            $this->errors[]="The {$fld_display} must be a munber!";
        }
        return $valid;
    }

    /**
     * min validate the minimun numeric value .
     * @param  [type] $value         [description]
     * @param  [type] $compare_value [description]
     * @param  array  $fieldname     [description]
     * @return [type]                [description]
     */
    public function min($value,$compare_value,$fieldname=array())
    {
        $valid=$value>$compare_value?TRUE:FALSE;
        if($valid==FALSE)
        {
            $fld_display=array_key_exists(1,$fieldname)?$fieldname[1]:$fieldname[0];
            $this->errors[]="The size of {$fld_display} must be grater than $compare_value";
        }
        return $valid;
    }

    /**
     * max validate the maximum numeric value
     * @param  [type] $value         [description]
     * @param  [type] $compare_value [description]
     * @param  array  $fieldname     [description]
     * @return [type]                [description]
     */
    public function max($value,$compare_value,$fieldname=array())
    {
        $valid=$value<$compare_value?TRUE:FALSE;
        if($valid==FALSE)
        {
            $fld_display=array_key_exists(1,$fieldname)?$fieldname[1]:$fieldname[0];
            $this->errors[]="The size of {$fld_display} must be less than $compare_value";
        }
        return $valid;
    }

    /**
     * min length of string
     * @param  [type] $value         [description]
     * @param  [type] $compare_value [description]
     * @param  array  $fieldname     [description]
     * @return [type]                [description]
     */
    public function min_length($value,$compare_value,$fieldname=array())
    {
        $valid=strlen($value)<$compare_value?TRUE:FALSE;
        if($valid==FALSE)
        {
            print_r($fieldname);
            $fld_display=array_key_exists(1,$fieldname)?$fieldname[1]:$fieldname[0];
            $this->errors[]="The size of {$fld_display} must be greater than $compare_value";
        }
        return $valid;
    }

    /**
     * max lenght of string
     * @param  [type] $value         [description]
     * @param  [type] $compare_value [description]
     * @param  array  $fieldname     [description]
     * @return [type]                [description]
     */
    public function max_length($value,$compare_value,$fieldname=array())
    {
        $valid=strlen($value)>$compare_value?TRUE:FALSE;
        if($valid==FALSE)
        {
            $fld_display=array_key_exists(1,$fieldname)?$fieldname[1]:$fieldname[0];
            $this->errors[]="The size of {$fld_display} must be less than $compare_value";
        }
        return $valid;
    }

    /**
     * validate range variable
     * @param  [type] $value     [description]
     * @param  [type] $min       [description]
     * @param  [type] $max       [description]
     * @param  [type] $fieldname [description]
     * @return [bool]            [description]
     */
    public function range($value,$min,$max,$fieldname)
    {
        $valid=$value>=$min && $value<=$max?TRUE:FALSE;
        if($valid==FALSE)
        {
            $fld_display=array_key_exists(1,$fieldname)?$fieldname[1]:$fieldname[0];
            $this->errors[]="The size of {$fld_display} must be between {$min} and {$max}";
        }
        return $valid;
    }

    public function match($fieldname1,$fieldname2)
    {
        $fld1=$_POST[$fieldname1];
        $fld2=$_POST[$fieldname2];

        $valid=$fld1==$fld2?TRUE:FALSE;
        if($valid==FALSE)
        {
           $this->errors[]="The password and confirm password does not match";
        }
        return $valid;
    }

}