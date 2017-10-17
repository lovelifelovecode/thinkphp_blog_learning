<?php
	namespace app\common\model;

	use think\Model;
	use think\Loader;

	class Tag extends Model{
		protected $tag_id;
		protected $name = 'tag';

		public function addTag($data){
			$validate = Loader::validate('Tag');

			if(!$validate->check($data)){
				return ['valid'=>0,'msg'=>$validate->getError()];
			}

			//step2
			$res = $this->data([
					'tag_name'=>$data['tag_name']
				]);
			$res = $res->save();
			if($res){
				return ['valid'=>1,'msg'=>'good tag is added!'];
			}else{
				return ['valid'=>0,'msg'=>'No tag is not add error!'];
			}
		}

		public function findData(){
			$res = $this->whereNotNull('tag_id')->paginate(10);
			return $res;
		}

		public function findTagName($tag_id){
			$data = $this->where('tag_id',$tag_id)->find();
			if($data){
				return $data;
			}
		}
	}