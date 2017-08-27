<?php

namespace Infonesy\Redmine;

class User extends \B2\Obj
{
/*
   |  3 => array (7)
   |  |  id => 91
   |  |  login => "skivan" (6)
   |  |  firstname => "Иван" (8)
   |  |  lastname => "Скляров" (14)
   |  |  mail => "skivan@aviaport.ru" (18)
   |  |  created_on => "2017-04-03T20:49:29Z" (20)
   |  |  last_login_on => "2017-08-24T16:32:47Z" (20)
*/

	static $cache = [];

	static function load($id, $app = NULL)
	{
		return self::$cache[$id];
	}

	static function from_json($data)
	{
		$user = new User(popval($data, 'id'));
		$user->b2_configure();

		$user->set('login', popval($data, 'login'));
		$user->set('first_name', popval($data, 'firstname'));
		$user->set('last_name', popval($data, 'lastname'));
		$user->set('email', popval($data, 'mail'));

		$user->set('create_time', strtotime(popval($data, 'created_on')));
		$user->set('last_login_time', strtotime(popval($data, 'last_login_on')));

		if($data)
			$user->set('info', $data);

		self::$cache[$user->id()] = $user;

		return $user;
	}

	function email_md5()
	{
		return md5($this->email());
	}

	function infonesy_uuid()
	{
		return $this->infonesy_node()->infonesy_uuid().'.user.'.$this->id();
	}

	function infonesy_node() { return $this->app()->infonesy_node(); }

	function title() { return join(' ', [$this->first_name(), $this->last_name()]); }

	function infonesy_data()
	{
//		$data = $this->data;
//		set_def($data, 'class_name', $this->class_name());
//		return $data;

		return [
			'ID' => $this->id(),
			'Title' => $this->title(),
			'FirstName' => $this->first_name(),
			'LastName' => $this->last_name(),
			'UserName' => $this->login(),
			'EmailMD5' => md5($this->email()),
			'Date' => date('r', $this->create_time()),
			'LastLogin' => date('r', $this->last_login_time()),
		];
	}
}
