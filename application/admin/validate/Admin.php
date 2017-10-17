<?php
	namespace app\admin\validate;
	use think\Validate;

	class Admin extends Validate{
		protected $rule = [
			'admin_username'=>'require',
			'admin_password'=>'require',
			'code'=>'require|captcha'
		];

		protected $message = [
			'admin_username.require' => 'Please entry username.',
			'admin_password.require' => 'Please entry password.',
			'code.require' => 'Please entry code.',
			'code.captcha' => 'The code is error,please entry again.'
		];
	}