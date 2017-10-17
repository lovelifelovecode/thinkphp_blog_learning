<?php
	namespace app\admin\controller;

	use think\Controller;
	use think\Db;

	class Category extends Controller{
		protected $db;
		protected function _initialize(){
			parent::_initialize();
			$this->db = new \app\common\model\Category();
		}


		public function index(){
			// $list = Db::name('cate')->select();
			$list = $this->db->getAll();
			// dump($list);
			$this->assign('list',$list);
			return $this->fetch();
		}

		public function store(){
			if(request()->isPost()){
				$res = $this->db->store(input('post.'));

				if($res['valid']){
					$this->success($res['msg'],'index');
				}else{
					$this->error($res['msg']);exit;
				}
			}
			return $this->fetch();
		}

		public function addSon(){
			if(request()->isPost()){
				$res = $this->db->store(input('post.'));

				if($res['valid']){
					$this->success($res['msg'],'index');
				}else{
					$this->error($res['msg']);exit;
				}
			}
			$cate_id = input('param.cate_id');
			$data = $this->db->where('cate_id',$cate_id)->find();
			$this->assign('data',$data);
			return $this->fetch();
		}

		public function edit(){
			if(request()->isPost()){
				$res = $this->db->edit(input('post.'));

				if($res['valid']){
					$this->success($res['msg'],'index');exit;
				}else{
					$this->error($res['msg']);exit;
				}
			}

			$cate_id = input('param.cate_id');
			// dump($cate_id);
			$oldData = $this->db->where('cate_id',$cate_id)->find();
			$this->assign('oldData',$oldData);

			$data = $this->db->getCateDate($cate_id);
			$this->assign('data',$data);
			return $this->fetch();
		}

		public function delData(){
			$cate_id = input('get.cate_id');

			$res = $this->db->delData($cate_id);

			if($res['valid']){
				$this->success($res['msg'],'index');exit;
			}else{
				$this->error($res['msg']);exit;
			}

		}

	}