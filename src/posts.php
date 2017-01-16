<?php


function submit_thread($board_id, $ip_address_hash, $name, $comment, $file_id)
{
	/* Takes in parameters for a thread, checks them, and adds them to the database. returns 0 on success.
	Errors:
	1: Insert statement failed to execute
	2: No file provided*/

	if (!$file_id){
		/*First post in a thread must have a file attached*/
		return 2;
	}

	/*Prepared statements replace php null with '', so they are to be replaced by 'NULL'*/
	if (!$name){
		$name = 'NULL';
	}
	if (!$comment){
		$comment = 'NULL';
	}

	$sql = "INSERT INTO Posts(board_id, ip_address_hash, name, comment, file_id) VALUES 
	(:board_id, :ip_address_hash, :name, :comment, :file_id)";
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	if (sth->execute(array(':board_id' -> $board, ':ip_address_hash' -> $ip_address_hash,
						':name' -> $name, ':comment' -> $comment, ':file_id' -> $file_id))){
		return 0;
	} else {
		return 1;
	}
}


function submit_post($board_id, $parent_id, $ip_address_hash, $name, $comment, $file_id)
{
	/* Takes in parameters for a post, checks them, and adds them to the database. returns 0 on success.
	Errors:
	1: Insert statement failed to execute
	2: No content provided*/

	/*A post on a thread must have content: either a file, a comment, or both*/
	if (!$comment && !$file_id){
		return 2;
	}

	/*Prepared statements replace php null with '', so they are to be replaced by 'NULL'*/
	if (!$name){
		$name = 'NULL';
	}
	if (!$comment){
		$comment = 'NULL';
	}
	if (!$file_id){
		$file_id = 'NULL';
	}

	$sql = "INSERT INTO Posts(board_id, parent_id, ip_address_hash, name, comment, file_id) VALUES 
	(:board_id, :parent_id, :ip_address_hash, :name, :comment, :file_id)";
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	if (sth->execute(array(':board_id' -> $board, ':ip_address_hash' -> $ip_address_hash,
						':name' -> $name, ':comment' -> $comment, ':file_id' -> $file_id))){
		return 0;
	} else {
		return 1;
	}
}
