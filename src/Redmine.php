<?php

namespace Infonesy;

class Redmine extends \B2\Obj
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
}
