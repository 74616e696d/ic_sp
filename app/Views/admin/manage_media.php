<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\Finder\Finder;

class Manage_media extends Member_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('path');
	}
	public function index()
	{
		// $files=get_filenames('asset/media/');
		$files=$this->get_media_files();
		$data['files']=$files;
		$data['title']='Manage Media';
		$this->load->blade('admin.manage_media', $data);
	}


	function reload_files()
	{
		$term=$this->input->post('term');
		echo $this->get_media_files($term);
	}

	function get_media_files($term='')
	{
		$finder=new Finder();
		if(!empty($term))
		{
			switch ($term) {
				case '1':
					$finder->date('since 1 week ago');
					break;
				case '2':
					$finder->date('since 1 month ago');
					break;
				case '3':
					$finder->date('< 1month');
					break;

				case '4':
					$finder->size('<=500K');
					break;
				case '5':
					$finder->size('>=500K')->size('<=1024K');
					break;
				case '6':
					$finder->size('>1024K');
					break;
				default:
					break;
			}
		}
		else{
		$finder->date('since yesterday');
		}
		$files=$finder->files()->in('asset/media/');
		$ignored=['.','.htaccess','.git','.quarantine','.tmb'];
		//$files=$this->sort_file_file_last_modi('asset/media/');
		$str='';
		if(count($files)>0)
		{
			$str.="<div class='row-fluid'>";
			$str.='<div id="photos">';
			//$str.='<ul class="thumbnails">';
			$indx=0;
			foreach ($files as $file) 
			{
			   $fl=$file->getRelativePathname();
			   if(file_exists('asset/media/'.$fl)){
			   //$str.="<li class='span3'>";
			   $copy_link=base_url().'asset/media/'.$fl;
			   $str.="<article class='ripplelink' data-clipboard-text='{$copy_link}' data-img='{$copy_link}'>";
			   $src=base_url().'asset/media/'.$fl;
			   $str.="<img height='120px' src='{$src}' alt='Not Found'>";
			   $str.="</article>";
			   //$str.="</li>";
			   }
			}
			//$str.='</ul>';
			$str.='</div>';
			$str.='</div>';
		}
		else
		{
			$str.="<p style='text-align:center;font-size:18px;'>No File Found !</p>";
		}
		return $str;
	}

	function send()
	{
		$filename='file';
		$allowed=array('jpg','jpeg','png','gif');
		if ($_FILES[$filename]["error"] > 0) 
		{
			$error=$_FILES[$filename]['error'];
			return $error;
		}
		else
		{
			$path = $_FILES[$filename]['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			if(in_array($ext, $allowed))
			{
				// $img_name=uniqid('study_press').'.'.$ext;
				$img_name=$path;
				$img=Image::make($_FILES[$filename]['tmp_name']);
				$img->save("asset/media/{$img_name}");
				echo "ok";
			}
			else
			{
				echo "unable to upload";
			}
		}
	}

	function remove()
	{
		$name=$this->uri->segment(4);
		if(file_exists("./asset/media/".$name))
		{
			unlink("./asset/media/".$name);
			$this->session->set_flashdata('success', 'Successfully deleted!!');
			redirect(base_url()."admin/manage_media");
		}
		else
		{
			$this->session->set_flashdata('error', 'Something wrong when deleting files!!');
			redirect(base_url()."admin/manage_media");
		}
	}

	/**
	 * sort files of directory according to last modified date
	 * @param  string $dir        
	 * @param  string $sort_type  
	 * @param  string $date_format
	 * @return array            
	 */
	function sort_file_file_last_modi($dir, $sort_type = 'descending', $date_format = "F d Y H:i:s.")
	{
		$files = scandir($dir);
		$array = array();
		foreach($files as $file)
		{
		    if($file != '.' && $file != '..')
		    {
		        $now = time();
		        $last_modified = filemtime($dir.$file);
		        $time_passed_array = array();
		        $diff = $now - $last_modified;
		        $days = floor($diff / (3600 * 24));
		        if($days)
		        {
		        	$time_passed_array['days'] = $days;
		        }

		        $diff = $diff - ($days * 3600 * 24);
		        $hours = floor($diff / 3600);

		        if($hours)
		        {
		        	$time_passed_array['hours'] = $hours;
		        }
		 
		        $diff = $diff - (3600 * $hours);
		        $minutes = floor($diff / 60);
		 
		        if($minutes)
		        {
		        	$time_passed_array['minutes'] = $minutes;
		        }
		 
		        $seconds = $diff - ($minutes * 60);
		        $time_passed_array['seconds'] = $seconds;
		    	$array[] = array('file'     => $file,
		                     'timestamp'    => $last_modified,
		                     'date'         => date ($date_format, $last_modified),
		                     'time_passed'  => $time_passed_array);
		    }
		}
	 
		usort($array, create_function('$a, $b', 'return strcmp($a["timestamp"], $b["timestamp"]);'));
		 
		if($sort_type == 'descending')
		{
			krsort($array);
		}
		return array_values($array);
	}
}

/* End of file manage_media.php */
/* Location: ./application/controllers/admin/manage_media.php */