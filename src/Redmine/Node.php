<?php

namespace Infonesy\Redmine;

class Node extends \B2\Obj
{
	function _infonesy_uuid_def()
	{
		$x = parse_url($this->id());

		$host = join('.', array_reverse(explode('.', $x['host'])));
		$path = join('.', explode('/', trim(@$x['path'], '/')));

		return 'redmine.'.join('.', array_filter([ $host, $path ]));
	}
}
