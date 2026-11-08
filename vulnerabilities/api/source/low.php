<?php
$errors = "";
$success = "";
$messages = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
}

$request_url = $_SERVER['REQUEST_URI'];
$stripped_url = str_replace ("/vulnerabilities/api/", "", $request_url);

$html .= "
<p>
	Versioning is important in APIs, running multiple versions of an API can allow for backward compatibility. Each version must apply the same rules for public user data.
</p>
";

$html .= "
<script>
	function update_username(user_json) {
		console.log(user_json);
		var user_info = document.getElementById ('user_info');
		var name_input = document.getElementById ('name');

		if (user_json.name == '') {
			user_info.innerHTML = 'User details: unknown user';
			name_input.value = 'unknown';
		} else {
			if (user_json.level == 0) {
				level = 'admin';
			} else {
				level = 'user';
			}
			user_info.innerHTML = 'User details: ' + user_json.name + ' (' + level + ')';
			name_input.value = user_json.name;
		}

		const message_line = document.getElementById ('message');
		if (user_json.id == 2 && user_json.level == 0) {
			message_line.style.display = 'block';
		} else {
			message_line.style.display = 'none';
		}
	}

	function get_users() {
		const url = '" . $stripped_url . "/vulnerabilities/api/v2/user/';
		 
		fetch(url, { 
				method: 'GET',
			}) 
			.then(response => { 
				if (!response.ok) { 
					throw new Error('Network response was not ok'); 
			} 
			return response.json(); 
			}) 
			.then(data => { 
				loadTableData(data);
			}) 
			.catch(error => { 
				console.error('There was a problem with your fetch operation:', error); 
		}); 
	}

	HTMLTableRowElement.prototype.insert_th_Cell = function(index) {
		let cell = this.insertCell(index)
		, c_th = document.createElement('th');
		cell.replaceWith(c_th);
		return c_th;
	}

	function loadTableData(items) {
		const table = document.getElementById('table');
		const tableHead = table.createTHead();
		const row = tableHead.insertRow(0);

		item = items[0];
		Object.keys(item).forEach(function(k){
			let cell = row.insert_th_Cell(-1);
			cell.innerHTML = k;
		});

		const tableBody = document.getElementById('tableBody');

		items.forEach( item => {
			let row = tableBody.insertRow();
			for (const [key, value] of Object.entries(item)) {
				let cell = row.insertCell(-1);
				cell.innerHTML = value;
			}
		});
	}
	</script>
";

$html .= "

<table id='table' class=''>
  <thead>
    <tr id='tableHead'>
    </tr>
  </thead>
  <tbody id='tableBody'></tbody>
</table>


		<p>
			Compare the version one and version two user records. Both expose only public fields.
		</p>
		<script>
			get_users();
		</script>
";

?>
