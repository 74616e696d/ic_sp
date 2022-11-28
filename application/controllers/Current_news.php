<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Current_news extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Current_news_category_model','category');
		$this->load->model('Todays_heppening_model','happening');
		$this->load->model('Current_news_model','news');
		$this->load->model('Events_model');
		$this->load->model('Meta_tag_model');
		$this->load->helper('common');
		$this->load->library('Pagination');
		$config = array(
		    'table' => 'current_news',
		    'id' => 'id',
		    'field' => 'slug',
		    'title' => 'title',
		    'replacement' => 'dash' // Either dash or underscore
		);
		$this->load->library('Slug', $config);
		$this->load->helper('text');
		// $this->output->enable_profiler(true);
	}
	function index()
	{
		$data['category']=$this->category->all_by('display',1);
		$data['featured']=$this->news->get_featured_news(1);
		$data['top_news']=$this->news->get_top_news(1);
		$data['on_this_day']=$this->happening->get_on_this_day();
		$data['upcoming_events']=$this->events_model->get_published_event();
		$data['national']=$this->news->get_top_news(1,1);
		$data['international']=$this->news->get_top_news(2,1);
		$data['sports']=$this->news->get_top_news(4,1);
		$data['science']=$this->news->get_top_news(6,1);
		$data['awards']=$this->news->get_top_news(7,1);
		$data['summits']=$this->news->get_top_news(5,1);
		$data['business']=$this->news->get_top_news(3,2);
		$data['latest']=$this->news->get_latest_news(3);
		$this->db->order_by('id','desc');
		$this->db->limit(10);
		$data['important']=$this->db->get_where('current_news',array('display'=>1,'is_important'=>1))->result_array();
		$data['title']='Current News';
		$this->load->blade('current_news.index', $data);
	}

	function news_list()
	{
		$data['category']=$this->category->all_by('display',1);
		$data['featured']=$this->news->get_featured_news();
		$data['top_news']=$this->news->get_top_news();
		$data['on_this_day']=$this->happening->get_on_this_day();
		$data['upcoming_events']=$this->events_model->get_published_event();
		$data['title']='';
		$this->load->blade('current_news.list', $data);
	}

	/**
	 * show category wise news page
	 * @return void
	 */
	function categorized()
	{
		$cat=$this->uri->segment(3);
		$cat_text=$this->uri->segment(4);

		//pagination parameter
		$start=$this->uri->segment(5)?$this->uri->segment(5):0;
		$total=$this->news->total(" where category_id={$cat}");
		$url=base_url().'news/categorized/'.$cat.'/'.$cat_text;
		$num_link=5;
		$per_page=10;
		//end pagination parameter

		$data['cat_name']=current_news_category_model::get_text($cat);
		$term=" where category_id={$cat} order by id desc limit {$start},{$per_page}";
		$data['news']=$this->news->get_current_news_list($term);

		$data['page_link']=create_pagination_new($url,$total,5,$num_link,$per_page);

		$data['categories']=$this->category->get_category(" order by id asc");
		$data['title']='Current News';
		$this->load->blade('current_news.category', $data);
	}

	/**
	 * show news details page
	 * @return void
	 */
	function news_details()
	{
		$id=$this->uri->segment(4);
		$news=$this->news->find($id);
		$tags=[];
		if(!empty($news->tags)){
			$tags = explode(',',$news->tags);
		}
		
		$data['news']=$news;
		$data['category']=$this->category->all_by('display',1);
		$data['top_news']=$this->news->get_news(5);
		$data['tags_news']=$this->news->news_list_by_tags($tags);
		$data['category_news']=$this->news->get_categorized_news($news->category_id,$id,5);
		$data['title']=$news->title;
		$this->load->blade('current_news.details', $data);
	}

	function important_news()
	{
		

		//pagination parameter
		$start=$this->uri->segment(3)?$this->uri->segment(3):0;
		$total=$this->news->total(" where is_important=1");
		$url=base_url().'current_news/important_news/';
		$num_link=5;
		$per_page=10;
		//end pagination parameter

		$data['cat_name']="Important News";
		$term=" where is_important=1 order by id desc limit {$start},{$per_page}";
		$data['news']=$this->news->get_current_news_list($term);

		$data['page_link']=create_pagination_new($url,$total,5,$num_link,$per_page);

		$data['categories']=$this->category->get_category(" order by id asc");
		$data['title']='Important News';
		$this->load->blade('current_news.category', $data);
	}

}