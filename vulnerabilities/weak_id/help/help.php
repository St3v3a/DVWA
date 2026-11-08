<div class="body_padded">
	<h1>Help - Weak Session IDs</h1>

	<div id="code">
	<table width='100%' bgcolor='white' style="border:2px #C0C0C0 solid">
	<tr>
	<td><div id="code">
		<h3>About</h3>
		<p>Knowledge of a session ID is often the only thing required to access a site as a specific user after they have logged in, if that session ID is able to be calculated or easily guessed, then an attacker will have an easy way to gain access to user accounts without having to brute force passwords or find other vulnerabilities such as Cross-Site Scripting.</p>

		<p><hr /></p>

		<h3>Objective</h3>
		<p>This module sets a dvwaSession cookie at each level. Compare values across requests and assess whether a previous value reveals the next one.</p>

		<p><hr /></p>

		<h3>Low Level</h3>
		<p>The cookie value is generated afresh using cryptographic randomness.</p>

		<h3>Medium Level</h3>
		<p>Each button click generates an independent random cookie value.</p>

		<h3>High Level</h3>
		<p>The cookie uses a random value rather than a hash of a predictable counter.</p>
		<p>It is scoped to this challenge path, is HTTP-only, and uses Secure when served over HTTPS.</p>


		<h3>Impossible Level</h3>
		<p>The cookie value should not be predictable at this level but feel free to try.</p>
		<p>As well as the extra flags, the cookie is being tied to the domain and the path of the challenge.</p>
	</div></td>
	</tr>
	</table>

	</div>

	<p>Reference: <?php echo dvwaExternalLinkUrlGet( 'https://owasp.org/www-project-web-security-testing-guide/latest/4-Web_Application_Security_Testing/06-Session_Management_Testing/01-Testing_for_Session_Management_Schema', 'WSTG - Session Management Schema' ); ?></p>
	<p>Reference: <?php echo dvwaExternalLinkUrlGet( 'https://cheatsheetseries.owasp.org/cheatsheets/Session_Management_Cheat_Sheet.html', 'OWASP Cheat Sheet - Session Management' ); ?></p>
</div>
