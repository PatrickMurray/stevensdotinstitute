<?php


require_once '../config/config.php';


function view_homepage()
{
	global $DATABASE;

	$sql  = 'SELECT abbreviation, title ';
	$sql .= 'FROM Boards ';
	$sql .= 'WHERE published_status = 1';

	if (($query = $DATABASE->prepare($sql)) === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to prepare statement: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	if ($query->execute() === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to execute statement: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	$boards = [];

	while (($result = $query->fetch()) !== FALSE)
	{
		array_push($boards, $result);
	}

	require_once('../views/homepage.php');

	return;
}


function view_admin()
{
	global $DATABASE;
	
	require_once('../views/admin.php');

	return;
}


function view_board($board_abbreviation)
{
	global $DATABASE;

	$sql  = 'SELECT id, creation_timestamp, name, comment, file_id ';
	$sql .= 'FROM Posts ';
	$sql .= 'WHERE parent_id IS NULL AND board_id = (';
	$sql .= '  SELECT id ';
	$sql .= '  FROM Boards ';
	$sql .= '  WHERE abbreviation = :board_abbreviation';
	$sql .= ')';

	if (($query = $DATABASE->prepare($sql)) === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to prepare statement: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	$values = [
		':board_abbreviation' => $board_abbreviation
	];

	if ($query->execute($values) === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to execute statement: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	/* 
	 * threads = [
	 *         [
	 *                 'thread' => (object),
	 *                 'posts'  => [
	 *                         (object),
	 *                         ...
	 *         ],
	 *         ...
	 * ]
	 */

	$threads = [];

	while (($result = $query->fetch()) !== FALSE)
	{
		array_push(
			$threads,
			[
				'thread' => $result,
				'posts'  => NULL
			]
		);
	}

	if ($result === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to fetch query: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	foreach ($threads as $thread)
	{
		$sql  = 'SELECT id, creation_timestamp, name, comment, file_id ';
		$sql .= 'FROM Posts ';
		$sql .= 'WHERE parent_id = :parent_id AND board_id = (';
		$sql .= '  SELECT id ';
		$sql .= '  FROM Boards ';
		$sql .= '  WHERE abbreviation = :board_abbreviation';
		$sql .= ') ';
		$sql .= 'ORDER BY creation_timestamp ASC ';
		$sql .= 'LIMIT :post_limit';

		if (($query = $DATABASE->prepare($sql)) === FALSE)
		{
			$error   = $query->errorInfo();
			$message = $error[2];
			log_error(
				__FILE__,
				__LINE__,
				'failed to prepare statement: ' . $message
			);
			error_internal_error();
			exit(-1);
		}

		$board_id = $thread['thread'].board_id;
		$op_id    = $thread['thread'].id;

		$values = [
			':parent_id'  => $op_id,
			':board_id'   => $board_id,
			':post_limit' => 3
		];

		if ($query->execute($values) === FALSE)
		{
			$error   = $query->errorInfo();
			$message = $error[2];
			log_error(
				__FILE__,
				__LINE__,
				'failed to execute statement: ' . $message
			);
			error_internal_error();
			exit(-1);
		}

		$posts = [];

		while (($result = $query->fetch()) !== FALSE)
		{
			array_push($thread['posts'], $result);
		}

		if ($result === FALSE)
		{
			$error   = $query->errorInfo();
			$message = $error[2];
			log_error(
				__FILE__,
				__LINE__,
				'failed to fetch query: ' . $message
			);
			error_internal_error();
			exit(-1);
		}
	}

	require_once('../views/board.php');

	return;
}


function view_thread($board_abbreviation, $thread_id)
{
	global $DATABASE;

	$sql  = 'SELECT id, creation_timestamp, name, comment, file_id ';
	$sql .= 'FROM Posts ';
	$sql .= 'WHERE parent_id IS NULL id = :thread_id AND board_id = (';
	$sql .= '  SELECT id ';
	$sql .= '  FROM Boards ';
	$sql .= '  WHERE abbreviation = :board_abbreviation';
	$sql .= ')';

	if (($query = $DATABASE->prepare($sql)) === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to prepare statement: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	$values = [
		':thread_id'          => $thread_id,
		':board_abbreviation' => $board_abbreviation
	];

	if ($query->execute($values) === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to execute statement: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	/* 
	 * thread = [
	 *         'thread' => (object),
	 *         'posts'  => [
	 *                 (object),
	 *                 ...
	 * ]
	 */

	$thread = [];

	if (($result = $query->fetch()) !== FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to fetch query: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	$thread['thread'] = $result;
	$thread['posts']  = [];

	$sql  = 'SELECT id, creation_timestamp, name, comment, file_id ';
	$sql .= 'FROM Posts ';
	$sql .= 'WHERE parent_id = :parent_id AND board_id = (';
	$sql .= '  SELECT id ';
	$sql .= '  FROM Boards ';
	$sql .= '  WHERE abbreviation = :board_abbreviation';
	$sql .= ') ';
	$sql .= 'ORDER BY creation_timestamp ASC';

	if (($query = $DATABASE->prepare($sql)) === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to prepare statement: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	$op_id    = $thread['thread'].id;
	$board_id = $thread['thread'].board_id;

	$values = [
		':parent_id'  => $op_id,
		':board_id'   => $board_id
	];

	if ($query->execute($values) === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to execute statement: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	while (($result = $query->fetch()) !== FALSE)
	{
		array_push($thread['posts'], $result);
	}

	if ($result === FALSE)
	{
		$error   = $query->errorInfo();
		$message = $error[2];
		log_error(
			__FILE__,
			__LINE__,
			'failed to fetch query: ' . $message
		);
		error_internal_error();
		exit(-1);
	}

	require_once('../views/thread.php');

	return;
}
