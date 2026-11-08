<div class="body_padded">
	<h1>Help - Cross Site Scripting (DOM Based)</h1>

	<div id="code">
	<table width='100%' bgcolor='white' style="border:2px #C0C0C0 solid">
	<tr>
	<td><div id="code">
		<h3>About</h3>
		<p>"Cross-Site Scripting (XSS)" attacks are a type of injection problem, in which malicious scripts are injected into the otherwise benign and trusted web sites.
			XSS attacks occur when an attacker uses a web application to send malicious code, generally in the form of a browser side script,
			to a different end user. Flaws that allow these attacks to succeed are quite widespread and occur anywhere a web application using input from a user in the output,
			without validating or encoding it.</p>

		<p>An attacker can use XSS to send a malicious script to an unsuspecting user. The end user's browser has no way to know that the script should not be trusted,
			and will execute the JavaScript. Because it thinks the script came from a trusted source, the malicious script can access any cookies, session tokens, or other
			sensitive information retained by your browser and used with that site. These scripts can even rewrite the content of the HTML page.</p>

		<p>DOM Based XSS is a special case of reflected where the JavaScript is hidden in the URL and pulled out by JavaScript in the page while it is rendering rather than being embedded in the page when it is served. This can make it stealthier than other attacks and WAFs or other protections which are reading the page body do not see any malicious content.</p>

		<p><hr /></p>

		<h3>Objective</h3>
		<p>Select a supported language and inspect how the page handles unrecognized query or fragment values.</p>

		<p><hr /></p>

		<h3>Low Level</h3>
		<p>The menu contains fixed language options and selects only a supported value.</p>

		<p><br /></p>

		<h3>Medium Level</h3>
		<p>The menu ignores unrecognized query values even if the server accepts them.</p>

		<p><br /></p>

		<h3>High Level</h3>
		<p>The server checks supported languages, and the menu reads only the query parameter; URL fragments do not become page content.</p>

		<p><br /></p>

		<h3>Impossible Level</h3>
		<p>The same fixed-option menu selects supported values without generating HTML from URL text.</p>
	</div></td>
	</tr>
	</table>

	</div>

	<br />

	<p>Reference: <?php echo dvwaExternalLinkUrlGet( 'https://www.owasp.org/index.php/Cross-site_Scripting_(XSS)' ); ?></p>
</div>
