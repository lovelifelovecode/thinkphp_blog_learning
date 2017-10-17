<?php
	namespace app\admin\validate;

	use think\Validate;

	class Category extends Validate{
	    protected $rule = [
	        'cate_name'  =>  'require',
	        'cate_pid' =>  'require',
	        'cate_sort' =>  'require|number'
	    ];

		protected $msg = [
		    'cate_name.require' => 'cate_sort must is input.',
		    'cate_pid.require'     => 'cate_sort must is input.',
		    'cate_sort.require'   => 'cate_sort must is input.',
		    'cate_sort.number'   => 'cate_sort must is number.',
		];
	}