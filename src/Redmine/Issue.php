<?php

namespace Infonesy\Redmine;

class Issue extends \B2\Obj
{
/*
   id => 419
   project => stdClass #0bf9 { ... }
   tracker => stdClass #e9a9 { ... }
   status => stdClass #6763 { ... }
   priority => stdClass #3d77 { ... }
   author => stdClass #c648 { ... }
   assigned_to => stdClass #3f24 { ... }
   subject => "Проход 13 мая 2017 года" (36)
   description => "h2. Текущая роль: Эксперт проекта ... Основная задача экспертов – голосовать в матрицах, поэтому его рабочий стол – должен быть посвящен «Матрицам и  ... " (4926)
   start_date => "2017-05-13" (10)
   done_ratio => 50
   created_on => "2017-05-13T14:33:58Z" (20)
   updated_on => "2017-05-14T04:04:46Z" (20)
*/

	static function from_json($data)
	{
		$issue = new Issue(popval($data, 'id'));
		$issue->b2_configure();

		$project = popval($data, 'project');
		$issue->set('project_id', $project['id']);
		// also name

		$tracker = popval($data, 'tracker');
		$issue->set('tracker_id', $tracker['id']);
		// also name = 'Задача'

		$status = popval($data, 'status');
		$issue->set('status_id', $status['id']);
		// also name = 'New'

		$priority = popval($data, 'priority');
		$issue->set('priority_id', $priority['id']);
		// also name = 'Normal'

		$author = popval($data, 'author');
		$issue->set('user_id', $author['id']);
		// also name = 'Balancer'

		$issue->set('user', User::load($author['id']));

		$assigned_to = popval($data, 'assigned_to');
		$issue->set('assigned_to_id', $assigned_to['id']);
		// also name = 'Balancer'

		$issue->set('title', popval($data, 'subject'));
		$issue->set('source', str_replace("\r", "", popval($data, 'description')));
		$issue->set('start_date', popval($data, 'start_date'));
		$issue->set('done_ratio', popval($data, 'done_ratio'));

		$issue->set('create_time', strtotime(popval($data, 'created_on')));
		$issue->set('modify_time', strtotime(popval($data, 'updated_on')));

		if($data)
			$issue->set('info', $data);

		return $issue;
	}

	function infonesy_uuid() { return $this->infonesy_node()->infonesy_uuid().'.issue.'.$this->id(); }

	function infonesy_container()
	{
		return Project::load($this->project_id());
	}

	function infonesy_user()
	{
		return User::load($this->user_id());
	}

	function infonesy_node() { return $this->app()->infonesy_node(); }
	function infonesy_type() { return 'Issue'; }
}
