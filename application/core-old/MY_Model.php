<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
	var $table="";
	function __construct()
	{
		$this->load->library('paginator');
	}

	function create($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}

	/**
	 * Get single row by primary key named id
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function find($id,$fields=array())
	{
		$this->db->where('id',$id);
		if(count($fields)>0)
		{
			$this->db->select($fields);
		}
		$qry=$this->db->get($this->table);
		if($qry->num_rows())
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	/**
	 * Get single row by custom field name and its name
	 * @param  [type] $field_name  [description]
	 * @param  [type] $field_value [description]
	 * @return [type]              [description]
	 */
	function find_by($field_name,$field_value)
	{
		$this->db->where($field_name,$field_value);
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		else
		{
			return false;
		}
	}

	function exist($field_name,$field_value)
	{
		$this->db->where($field_name,$field_value);
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function all($fields=array())
	{
		if(count($fields)>0)
		{
			$this->db->select($fields);
		}
		$this->db->order_by('id','desc');
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}



	function all_by($key,$value,$fields=array())
	{
		$this->db->where($key,$value);
		if(count($fields)>0)
		{
			$this->db->select($fields);
		}
		$this->db->order_by('id','desc');
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function max($field='id')
	{
		$this->db->select_max($field);
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->row()->$field;
		}
		else
		{
			return 0;
		}
	}

	function max_by($key,$value,$field='id')
	{
		$this->db->where($key,$value);
		$this->db->select_max($field);
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->row()->$field;
		}
		else
		{
			return 0;
		}
	}

	function where($fields=array())
	{
		if(count($fields)>0)
		{
			foreach ($fields as $key => $value) 
			{
				$operator=explode('|',$key);
				if(count($operator))
				{
					if(!empty($value) && $value!=-1 && $value!=0)
					{
						if($operator[1]=='='){$this->db->where($operator[0],$value);}
						elseif(trim($operator[1])=='!='){$this->db->where("{$operator[0]} {$operator[1]}",$value);}
						elseif(trim($operator[1])=='<'){$this->db->where("{$operator[0]} {$operator[1]}",$value);}
						elseif(trim($operator[1])=='>'){$this->db->where("{$operator[0]} {$operator[1]}",$value);}
						elseif(trim($operator[1])=='in'){$this->db->where_in("{$operator[0]}",$value);}
						elseif(trim($operator[1])=='not_in'){$this->db->where_not_in("{$operator[0]}",$value);}
						elseif(trim($operator[1])=='like'){$this->db->like("{$operator[0]}",$value);}
					}
				}
			}
			
		}
		return $this;

	}

	function order_by($key,$order='asc')
	{
		$this->db->oder_by($key,$order);
	}

	function limit($end,$start=0)
	{
		if($start==0){$this->db->limit($end);}
		else{$this->db->limit($start,$end);}
		return $this;
	}
    
    function join_get($fields=array(),$join_table=array())
    {
    	if(count($fields)>0)
		{
			$this->db->select($fields);
		}
    	$this->db->from($this->table);
    	if(count($join_table))
    	{
    		foreach ($join_table as $key => $value) 
    		{
    			$term=explode('|',$value);
    			if(count($term>0))
    			{
    				if(count($term)>2)
    				{
    					$this->db->join($key,"{$term[0]} {$term[1]} {$term[2]}");
    				}
    				else 
    				{
    					$this->db->join($key,"{$term[0]} = {$term[1]}");
    				}
    			}
    		}
    	}
    	$this->db->order_by('id','desc');
    	$qry=$this->db->get();
    	if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
    }

    /**
     * count total rows in a table
     * 
     * @param  string $term
     * @return integer     
     */
    function count($term="")
    {
    	$sql="select count(id) as total from {$this->table} $term";
    	$qry=$this->db->query($sql);
    	return $qry->row()->total;
    }

	function get($fields=array())
	{
		if(count($fields)>0)
		{
			$this->db->select($fields);
		}
		$this->db->order_by('id','desc');
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function row($fields=array())
	{
		if(count($fields)>0)
		{
			$this->db->select($fields);
		}
		$qry=$this->db->get($this->table);
		if($qry->num_rows()>0)
		{
			return $qry->row();
		}
		return false;
	}


	/**
	 * Single Table Pagination
	 * @param  integer $per_page   [description]
	 * @param  integer $segment_id [description]
	 * @param  array   $fields     [description]
	 * @return [type]              [description]
	 */
	function paginate($per_page=25,$segment_id=3,$fields=array())
	{
		if(count($fields)>0)
		{
			$this->db->select($fields);
		}
		$qry=$this->db->get($this->table);
		$item_count=$qry->num_rows();
		Paginator::init($item_count,$per_page,$segment_id);
		$links=Paginator::page_links();
		return $links;
	}


	/**
	 * Signle Table Pagination Item For Current Page
	 * @return [type] [description]
	 */
	function make()
	{
		$qry=$this->db->limit(Paginator::$perpage,Paginator::offset)->get($items);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function total($term='')
	{
		$sql="select id from {$this->table} {$term}";
		$qry=$this->db->query($sql);
		return $qry->num_rows();
	}
	
	function all_by_query($start,$limit,$term)
	{
		$sql="select *from {$this->table} {$term} limit {$start},{$limit}";
		$qry=$this->db->query($sql);
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		else
		{
			return false;
		}
	}

	function update($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
	}

	function update_by($key,$value,$data)
	{
		$this->db->where($key,$value);
		$this->db->update($this->table,$data);
	}

	function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}

	function delete_by($key,$value)
	{
		$this->db->where($key,$value);
		$this->db->delete($this->table);
	}


}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */