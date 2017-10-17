<?php
	namespace app\admin\controller;

	use think\Controller;

	class Tag extends Controller{
		protected $db;
		protected function _initialize(){
			parent::_initialize();
			$this->db = new \app\common\model\Tag();
		}


		public function index(){
			$list = $this->db->findData();
			$page = $list->render();
			$this->assign('list',$list);
			$this->assign('page', $page);
			return $this->fetch();
		}

		public function addTag(){
			if(request()->isPost()){
				$res = $this->db->addTag(input('post.'));

				if($res['valid']){
					$this->success($res['msg'],'index');exit;
				}else{
					$this->error($res['msg']);exit;
				}
			}
			return $this->fetch();
		}

		public function editTag(){
			if(request()->isPost()){
				dump($_POST);
			}
			$tag_id = input('param.tag_id');
			$data = $this->db->findTagName($tag_id);
			if($data){
				$this->assign('data',$data);
			}
			return $this->fetch();
		}
	}