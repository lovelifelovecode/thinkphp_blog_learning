<?php
namespace app\common\model;

use think\Loader;
use think\Model;
use think\Validate;

class Admin extends Model{
	protected $pk = 'admin_id';
	protected $table = 'blog_admin';

	public function login($data){
		$validate = Loader::validate('Admin');

		if(!$validate->check($data)){
			return ['valid'=>0,'msg'=>$validate->getError()];
		}


		//step2
		$userInfo = $this->where('admin_username',$data['admin_username'])->where('admin_password',md5(md5($data['admin_password']).'skyuse'))->find();
		if(!$userInfo){
			return ['valid'=>0,'msg'=>'The user or password is error!'];
		}

		//step3
		session('admin.admin_id',$userInfo['admin_id']);
		session('admin.admin_username',$userInfo['admin_username']);
		return ['valid'=>1,'msg'=>'success!!!'];
	}

	public function pass($data){
		//step1
		$validate = new Validate([
		    'admin_password'  => 'require',
		    'new_password' => 'require',
		    'confirm_password' => 'require|confirm:new_password'
		],[
			'admin_password.require'=>'Please enter the old password.',
			'new_password.require'=>'Please enter the new_password.',
			'confirm_password.require'=>'Please enter the confirm_password.',
			'confirm_password.confirm'=>'Please enter the confirm_password===new_password.',

		]);
		if (!$validate->check($data)) {
		    return ['valid'=>0,'msg'=>$validate->getError()];
		}

		//step2
		$userInfo = $this->where('admin_id',session('admin.admin_id'))->where('admin_password',md5(md5($data['admin_password']).'skyuse'))->find();
		if(!$userInfo){
			return ['valid'=>0,'msg'=>'The old password is error!'];
		}

		//step3
		$res = $this->save([
			'admin_password'=>md5(md5($data['new_password']).'skyuse')
			],['admin_id'=>session('admin.admin_id')]);
		if($res){
			return ['valid'=>1,'msg'=>'The password is edit'];
		}
	}
}