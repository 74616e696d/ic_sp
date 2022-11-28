<?php
namespace application\models\job;
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->table='job_list';
	}

	/**
	 * get student jobs from job lists
	 * @param  integer $limit
	 * @return object|bool        
	 */
	function student_jobs($limit=10)
	{
		$sql="select jl.*,ci.company_name,ci.logo from job_list jl inner join company_info ci on jl.com_info=ci.id where jl.job_nature='Student' and jl.is_published=1 order by jl.id desc limit {$limit}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	/**
	 * get recently published jobs
	 * @param  integer $limit
	 * @return object|bool        
	 */
	function get_recent_jobs($limit=10)
	{
		$sql="select jl.*,ci.company_name,ci.logo from job_list jl join company_info ci on jl.com_info=ci.id where jl.is_published=1 order by jl.id desc limit {$limit}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	/**
	 * get all jobs by term with page limit
	 * @param  integer $start
	 * @param  integer $limit
	 * @param  string  $term 
	 * @return object/boolean      
	 */
	function get_jobs($start=0,$limit=20,$term='')
	{
		$sql="select * from job_list {$term} limit {$start},{$limit}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	/**
	 * count records in job lists
	 * @param  string $term 
	 * @return integer      
	 */
	function count($term='')
	{
		$sql="select * from job_list {$term}";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}

	/**
	 * get job list with pagination and terms
	 * @param  string  $terms
	 * @param  integer $start
	 * @param  integer $limit
	 * @return object|false        
	 */
	function get_job_list($terms='')
	{
		$sql="select *from job_list {$terms}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	/**
	 * get total jobs
	 * @param  string $terms
	 * @return object|bool      
	 */
	function get_total($terms='')
	{
		$sql="select id from job_list {$terms}";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}

	function job_list_by_category($cat_id,$start=0,$limit=30)
	{
		$sql="select jl.* from job_list jl where jl.job_cat={$cat_id} and jl.is_published=1 and DATE(jl.deadline) > DATE(NOW()) order by jl.deadline ASC limit {$start},{$limit}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function job_search($term='',$start=0,$limit=1000)
	{
		$this->db->like('tags',$term);
		$this->db->or_like('title',$term);
		$this->db->or_like('post_name',$term);
		$this->db->where('is_published',1);
		$qry=$this->db->get('job_list');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function job_list_by_location($location,$start=0,$limit=100)
	{
		$this->db->where('location',$location);
		$this->db->where('is_published',1);
		$qry=$this->db->get('job_list');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function job_list_by_company($company,$start=0,$limit=100)
	{
		$this->db->where('com_info',$company);
		$this->db->where('is_published',1);
		$qry=$this->db->get('job_list');
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	static function company_name($id)
	{
		$ci =& get_instance();
		$ci->db->where('id',$id);
		$qry=$ci->db->get('company_info');
		if($qry->num_rows()>0)
		{
			return $qry->row()->company_name;
		}
		return '';
	}


	function job_by_category()
	{
		$sql="SELECT jc.id,jc.title,(SELECT COUNT(jl.id) FROM job_list jl WHERE jl.is_published = 1 AND jl.job_cat=jc.id) AS total FROM job_category jc";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function job_by_location()
	{
		$sql="SELECT COUNT(id) as total,location FROM job_list WHERE is_published = 1 and location IS NOT NULL  GROUP BY location";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function job_by_company()
	{
		$sql="SELECT c.id,c.company_name,(SELECT COUNT(jl.id) FROM job_list jl WHERE jl.is_published = 1 AND jl.com_info=c.id) AS total FROM company_info c ";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function job_by_deadline()
	{
		$sql="select * from job_list where is_published=1 and deadline=DATE_ADD(CURDATE(),INTERVAL 1 DAY)";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function get_featured_job()
	{
		$today= date('y-m-d');
		$sql="select jl.*,c.company_name,c.logo from job_list jl join company_info c  on jl.com_info=c.id where jl.is_featured=1 and jl.is_published=1 and DATE(jl.deadline) > DATE(NOW()) order by jl.id desc";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

	function get_student_jobs()
	{
		$sql="select jl.*,c.company_name,c.logo from job_list jl join company_info c  on jl.com_info=c.id where jl.job_nature='Student' and jl.is_published=1";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		return false;
	}

}

/* End of file job_model.php */
/* Location: ./application/models/job/job_model.php */