<div class="body_padded">
	<h1>Help - File Upload</h1>

	<div id="code">
	<table width='100%' bgcolor='white' style="border:2px #C0C0C0 solid">
	<tr>
	<td><div id="code">
		<h3>About</h3>
		<p>Uploaded files represent a significant risk to web applications. The first step in many attacks is to get some code to the system to be attacked.
			Then the attacker only needs to find a way to get the code executed. Using a file upload helps the attacker accomplish the first step.</p>

		<p>The consequences of unrestricted file upload can vary, including complete system takeover, an overloaded file system, forwarding attacks to backend systems,
			and simple defacement. It depends on what the application does with the uploaded file, including where it is stored.</p>

		<br /><hr /><br />

		<h3>Objective</h3>
		<p>Upload a JPEG or PNG image and inspect how the server stores and serves the encoded result.</p>

		<br /><hr /><br />

		<h3>Low Level</h3>
		<p>The server checks the actual image format and saves a newly encoded image under a generated name.</p>

		<br />

		<h3>Medium Level</h3>
		<p>The upload is validated from its decoded image content rather than the file type reported by the client.</p>

		<br />

		<h3>High Level</h3>
		<p>The stored image is re-encoded so the original uploaded bytes are not served.</p>

		<br />

		<h3>Impossible Level</h3>
		<p>This level adds an anti-CSRF token and re-encodes accepted images to strip non-image bytes and metadata.</p>
	</div></td>
	</tr>
	</table>

	</div>

	<br />

	<p>Reference: <?php echo dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/vulnerabilities/Unrestricted_File_Upload' ); ?></p>
</div>

