<?php

class Spadmin extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title']='Iconpreparation Sql Editor';
		$this->load->blade('admin.spadmin.index', $data);
	}

	function get_result()
	{
		$sql=$this->input->get('term');
		if (strpos(strtolower($sql),'select') === FALSE) {
		   echo "You can only execute select statement";
		   return;
		}
		$qry=$this->db->query($sql);
		$result='';
		if($qry->num_rows()>0)
		{
			$columns=$qry->num_fields();
			foreach ($qry->result_array() as $value) {
				$result.='<table class="table table-hover" style="width:auto;float:left;">';
				$result.="<tr>";
				$result.="<td>";
				$result.="<table>";
				$keys=array_keys($value);
				for($i=0;$i<$columns;$i++)
				{
					$result.="<tr>";
					$column_name=$keys[$i];
					$column_val=$value[$column_name];
					$result.="<th>{$column_name}</th><td>$column_val</td>";
					$result.="</tr>";
				}
				$result.="</table>";
				$result.="</td>";
				$result.="</tr>";
				$result.="</table>";
			}

		}
		
		echo $result;

	}

}

/* End of file spadmin.php */
/* Location: ./application/controllers/admin/spadmin.php */