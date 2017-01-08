<?php


require_once('../config/config.php');


function git_commit()
{
	if (($short_hash = shell_exec('git log -n 1 --format="%h"')) == NULL)
	{
		/* TODO : error reporting syslog */
	}

	return $short_hash;
}


function submit_thread($board)
{
	return;
}


function submit_post($board, $thread)
{
	return;
}


function view_board($board, $page)
{
	return;
}


function view_thread($board, $thread)
{
	return;
}
