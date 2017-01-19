<?php


require_once '../config/config.php';


function submit_thread($board_id, $ip_address_hash, $name, $comment, $file_id)
{
	global $DATABASE;

	/* Takes in parameters for a thread, checks them, and adds them to the
	 * database. returns 0 on success.
	 *
	 * Errors:
	 *   1: Insert statement failed to execute
	 *   2: No file provided
	 */

	if ($file_id === NULL)
	{
		/* First post in a thread must have a file attached */
		return 2;
	}

	/* Prepared statements replace php null with '', so they are to be
	 * replaced by 'NULL'
	 */

	if ($name === NULL)
	{
		$name = 'NULL';
	}

	if ($comment === NULL)
	{
		$comment = 'NULL';
	}

	$sql = 'INSERT INTO Posts(board_id, ip_address_hash, name, comment, file_id) VALUES (:board_id, :ip_address_hash, :name, :comment, :file_id)';
	
	if (($statement = $DATABASE->prepare($sql)) === FALSE)
	{
		error_internal_error();
		exit(-1);
	}

	$values = [
		':board_id'        => $board,
		':ip_address_hash' => $ip_address_hash,
		':name'            => $name,
		':comment'         => $comment,
		':file_id'         => $file_id
	];

	if ($statement->execute($value) === FALSE)
	{
		error_internal_error();
		exit(-1);
	}

	return 0;
}


function submit_post($board_id, $parent_id, $ip_address_hash, $name, $comment, $file_id)
{
	global $DATABASE;

	/* Takes in parameters for a post, checks them, and adds them to the database. returns 0 on success.
	Errors:
	1: Insert statement failed to execute
	2: No content provided*/

	/*A post on a thread must have content: either a file, a comment, or both*/
	if ($comment === NULL && $file_id === NULL)
	{
		return 2;
	}

	/*Prepared statements replace php null with '', so they are to be replaced by 'NULL'*/
	if ($name === NULL)
	{
		$name = 'NULL';
	}

	if ($comment === NULL)
	{
		$comment = 'NULL';
	}

	if ($file_id === NULL)
	{
		$file_id = 'NULL';
	}

	$sql = 'INSERT INTO Posts(board_id, parent_id, ip_address_hash, name, comment, file_id) VALUES (:board_id, :parent_id, :ip_address_hash, :name, :comment, :file_id)';

	if (($statement = $DATABASE->prepare($sql)) === FALSE)
	{
		error_internal_error();
		exit(-1);
	}

	$values = [
		':board_id'        => $board,
		':ip_address_hash' => $ip_address_hash,
		':name'            => $name,
		':comment'         => $comment,
		'file_id'          => $file_id
	];

	if ($statement->execute($values) === FALSE)
	{
		error_internal_error();
		exit(-1);
	}

	return 0;
}
