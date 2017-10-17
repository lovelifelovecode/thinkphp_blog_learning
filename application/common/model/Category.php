<?php
	namespace app\common\model;

	use think\Model;
	use think\Loader;
	use houdunwang\arr\Arr;
	use think\Db;

	class Category extends Model{
			protected $pk = 'cate_id';
			protected $table = 'blog_cate';

		public function store($data){
			// dump($data);

			$validate = Loader::validate('Category');

			if(!$validate->check($data)){
				return ['valid'=>0,'msg'=>$validate->getError()];
			}

			//step2
			$result = $this->validate(true)->save($data);
			if(false === $result){
		    // 验证失败 输出错误信息
		    	return ['valid'=>0,'msg'=>$validate->getError()];
			}else{
				return ['valid'=>1,'msg'=>'goodboy is save!!'];
			}
		}

		public function getAll(){
			return Arr::tree(db('cate')->order('cate_sort desc,cate_id')->select(), 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
		}

		public function getCateDate($cate_id){
			//step1 find where is sonclass
			$cate_ids = $this->getSon(db('cate')->select(),$cate_id);
			$cate_ids[] = $cate_id;
			$res = Db::table('blog_cate')->whereNotIn('cate_id',$cate_ids)->select();
			return Arr::tree($res, 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
		}

		public function getSon($data,$cate_id){
			static $temp=array();
			foreach ($data as $key => $value) {
				if($cate_id == $value['cate_pid']){
					$temp[] = $value['cate_id'];
					$this->getSon($data,$value['cate_id']);
				}
			}
			return $temp; 
		}

		public function edit($data){
			// dump($data);
			$validate = Loader::validate('Category');

			if(!$validate->check($data)){
				return ['valid'=>0,'msg'=>$validate->getError()];
			}

			//step2
			$result = $this->validate(true)->save($data,[$this->pk=>$data['cate_id']]);
			if(false === $result){
		    // 验证失败 输出错误信息
		    	return ['valid'=>0,'msg'=>$validate->getError()];
			}else{
				return ['valid'=>1,'msg'=>'goodboy is edit!!'];
			}
		}

		public function delData($cate_id){
			$cate_pid = $this->where('cate_id',$cate_id)->value('cate_pid');

			$this->where('cate_pid',$cate_id)->update(['cate_pid'=>$cate_pid]);
			if(Category::destroy($cate_id)){
				return ['valid'=>1,'msg'=>'good is delete!!!!'];
			}
		}

	}