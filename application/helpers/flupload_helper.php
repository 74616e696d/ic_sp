<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
/*###################################################################################*/
    function multiple_upload($name = 'userfile', $upload_dir = 'sources/images/', $allowed_types = 'gif|jpg|jpeg|jpe|png', $size)
/*###################################################################################*/
    {
        $CI =& get_instance();
     
        $config['upload_path']   = realpath($upload_dir);
        $config['allowed_types'] = $allowed_types;
        $config['max_size']      = $size;
        $config['overwrite']     = FALSE;
        $config['encrypt_name']  = TRUE;
             
 
            $CI->upload->initialize($config);
            $errors = FALSE;
                      
            if(!$CI->upload->do_upload($name)):
                $errors = TRUE;
            else:
                // Build a file array from all uploaded files
                $files = $CI->upload->data();
            endif;
 
             
            // There was errors, we have to delete the uploaded files
            if($errors):                   
                @unlink($files['full_path']);
                return false;
            else:
                return $files;
            endif;
             
    }//end of multiple_upload()
 
 
 
 
/*#################################################*/
    //modified version of jeffrey way's zip extract tutorial
function upload_batch_images($name = 'userfile', $upload_dir = 'sources/images/', $allowed_types = 'gif|jpg|jpeg|jpe|png', $size) 
/*#################################################*/
{
    $CI =& get_instance();
        $realpath = $upload_dir."images-".rand(1111111111,9999999999); //let's make it unique
        $config['upload_path']   = $realpath;
        $config['allowed_types'] = $allowed_types;
        $config['max_size']      = $size;
        $config['overwrite']     = FALSE;
        $config['encrypt_name']  = TRUE;
         
    $CI->upload->initialize($config);
     
    if(mkdir($realpath)):
        if($CI->upload->do_upload($name)):
            $files = $CI->upload->data(); 
            if(openZip($realpath."/".$files['file_name'], $realpath)):
                @unlink($files['full_path']);
                return $realpath;
            else:
                @unlink($files['full_path']);
                return false;
            endif;
        endif;
    else:
        return false;
    endif;
 
}
 
 
/*#################################################*/
function openZip($file_to_open, $zip_target) 
/*#################################################*/
{
    $zip = new ZipArchive();
    $x = $zip->open($file_to_open);
    if ($x === true):
        $zip->extractTo($zip_target);
        $zip->close();
        return true;
    else:
        return false;
    endif;
}