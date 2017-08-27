<?php

namespace Infonesy;

class Redmine extends \B2\App
{
	function infonesy_uuid()
	{
		return 'redmine.' . $this->path_to_uuid($this->id());
	}

	function path_to_uuid($path)
	{
		$x = parse_url($path);
		$domain = join('.', array_reverse(explode('.', $x['host'])));
		$path = trim(preg_replace('!/+!', '.', $x['path']), '.');
		return join('.', [$domain, $path]);
	}

	function issues()
	{
		// http://rm.balancer.ru/issues.json?key=...
		$url = $this->id().'/issues.json?key='.$this->api_key();
		$result = json_decode(file_get_contents($url), true);

		$issues = [];

		foreach($result['issues'] as $issue_data)
			$issues[$issue_data['id']] = Redmine\Issue::from_json($issue_data);

		return $issues;
	}

	function users()
	{
		// http://rm.balancer.ru/users.json?key=...
		$url = $this->id().'/users.json?key='.$this->api_key();

		$result = json_decode(file_get_contents($url), true);

//		dump($url, $result); exit();

		$users = [];

		foreach($result['users'] as $user_data)
			$users[$user_data['id']] = Redmine\User::from_json($user_data);

		return $users;
	}

	function _infonesy_node_def()
	{
		$node = new Redmine\Node($this->id());
		$node->b2_configure();
		return $node;
	}

	function set_infonesy_node_uuid($uuid)
	{
		return $this->infonesy_node()->set_infonesy_uuid($uuid);
	}
}
