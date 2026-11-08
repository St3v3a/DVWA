<?php

function dvwaSqliFindUsers($rawId, $single = false) {
	global $_DVWA, $db, $sqlite_db_connection;

	if (!is_string($rawId) && !is_int($rawId)) {
		return array();
	}
	$input = (string)$rawId;
	if ($input === '' || strlen($input) > 18 || !ctype_digit($input)) {
		return array();
	}
	$id = (int)$input;
	if ($id < 1) {
		return array();
	}

	$query = 'SELECT first_name, last_name FROM users WHERE user_id = :id'
		. ($single ? ' LIMIT 1' : '');
	if ($_DVWA['SQLI_DB'] === MYSQL) {
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	if ($_DVWA['SQLI_DB'] === SQLITE) {
		$statement = $sqlite_db_connection->prepare($query);
		if ($statement === false) {
			return array();
		}
		$statement->bindValue(':id', $id, SQLITE3_INTEGER);
		$result = $statement->execute();
		if ($result === false) {
			return array();
		}
		$rows = array();
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$rows[] = $row;
		}
		$result->finalize();
		return $rows;
	}
	return array();
}

function dvwaSqliUserCount() {
	global $_DVWA, $db, $sqlite_db_connection;

	if ($_DVWA['SQLI_DB'] === MYSQL) {
		return (int)$db->query('SELECT COUNT(*) FROM users')->fetchColumn();
	}
	if ($_DVWA['SQLI_DB'] === SQLITE) {
		return (int)$sqlite_db_connection->querySingle('SELECT COUNT(*) FROM users');
	}
	return 0;
}
