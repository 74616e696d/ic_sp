<?php
namespace App\Models;
use CodeIgniter\Model;

class Current_news_model extends Model
{
    
    function __construct() {
        parent::__construct();
        $this->table = 'current_news';
    }

    /**
     * get news by terms
     * @param  string $terms
     * @return object       
     */
    function get_current_news_list($terms='')
    {
        $sql="select cn.*,cnc.name from current_news cn join current_news_category cnc on cn.category_id=cnc.id {$terms}";
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

    function get_categorized_news($cat,$exclude,$limit=10)
    {
        $sql="select *from current_news where category_id={$cat} and id!={$exclude}  order by id desc limit {$limit}";
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

    /**
     * select current news having same tags
     * @param  array   $tags 
     * @param  integer $limit 
     * @return object
     */
    function news_list_by_tags($tags=[],$limit=5){
        $last='';
        $terms='';
        if(count($tags)>0){
            $terms.="where ";
            foreach($tags as $tag){
                $terms.="FIND_IN_SET('{$tag}',tags) or ";
            }
            if($terms!=' where')
            {
                $terms=substr($terms,0,strlen($terms)-4);
            }
        }
        $sql="select *from current_news {$terms} order by id desc limit {$limit}";

        

        $qry=$this->db->query($sql);
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }

    function count_all($terms='')
    {
        $sql="select cn.id from current_news cn join current_news_category cnc on cn.category_id=cnc.id {$terms}";
        $qry=$this->db->query($sql);
        return $qry->num_rows();
    }

    function get_news($limit = 2) {
        $this->db->table('current_news')->where('display', 1)
        ->limit($limit)
        ->orderBy('id', 'desc')
        ->get()->getResultArray();
      /*  if ($qry->num_rows() > 0) {
            return $qry->result();
        } 
        else {
            return false;
        }*/
    }

    function get_featured_news($limit = 2) {
        $this->db->where('is_featured', 1);
        $this->db->where('display', 1);
        $this->db->limit($limit);
        $this->db->order_by('id', 'desc');
        $qry = $this->db->get('current_news');
        if ($qry->num_rows() > 0) {
            return $qry->result();
        } 
        else {
            return false;
        }
    }
    
    function get_top_news($cat, $limit = 10) {
        $this->db->where('category_id', $cat);
        $this->db->where_not_in('is_featured',1);
        $this->db->where('display', 1);
        $this->db->order_by('post_date', 'desc');
        $this->db->limit($limit);
        $qry = $this->db->get('current_news');
        if ($qry->num_rows() > 0) {
            return $qry->result();
        } 
        else {
            return false;
        }
    }

    function get_latest_news($limit = 10) {
        $this->db->where_not_in('is_featured',1);
        $this->db->where('display', 1);
        $this->db->order_by('post_date', 'desc');
        $this->db->limit($limit);
        $qry = $this->db->get('current_news');
        if ($qry->num_rows() > 0) {
            return $qry->result();
        } 
        else {
            return false;
        }
    }
}

/* End of file current_news_model.php */

/* Location: ./application/models/current_news_model.php */
