<?php
	namespace app\admin\validate;

	use think\Validate;

	class Tag extends Validate{
	    protected $rule = [
	        'tag_name'  =>  'require',
	    ];

		protected $msg = [
		    'tag_name.require' => 'tag_name must is input.',
		];
	}