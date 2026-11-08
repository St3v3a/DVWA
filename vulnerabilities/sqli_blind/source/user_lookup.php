<?php

function dvwaSqliBlindUserExists($rawId) {
	global $_DVWA, $db, $sqlite_db_connection;

	if (!is_string($rawId) && !is_int($rawId)) {
		return null;
	}
	$input = (string)$rawId;
	if ($input === '' || strlen($input) > 18 || !ctype_digit($input)) {
		return null;
	}
	$id = (int)$input;
	if ($id < 1) {
		return null;
	}

	$query = 'SELECT 1 FROM users WHERE user_id = :id LIMIT 1';
	if ($_DVWA['SQLI_DB'] === MYSQL) {
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement->execute();
		return $statement->fetchColumn() !== false;
	}
	if ($_DVWA['SQLI_DB'] === SQLITE) {
		$statement = $sqlite_db_connection->prepare($query);
		if ($statement === false) {
			return false;
		}
		$statement->bindValue(':id', $id, SQLITE3_INTEGER);
		$result = $statement->execute();
		if ($result === false) {
			return false;
		}
		$exists = $result->fetchArray(SQLITE3_NUM) !== false;
		$result->finalize();
		return $exists;
	}
	return false;
}

function dvwaSqliBlindUserCount() {
	global $_DVWA, $db, $sqlite_db_connection;

	if ($_DVWA['SQLI_DB'] === MYSQL) {
		return (int)$db->query('SELECT COUNT(*) FROM users')->fetchColumn();
	}
	if ($_DVWA['SQLI_DB'] === SQLITE) {
		return (int)$sqlite_db_connection->querySingle('SELECT COUNT(*) FROM users');
	}
	return 0;
}
