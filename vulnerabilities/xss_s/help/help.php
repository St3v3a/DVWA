<div class="body_padded">
	<h1>Help - Cross Site Scripting (Stored)</h1>

	<div id="code">
	<table width='100%' bgcolor='white' style="border:2px #C0C0C0 solid">
	<tr>
	<td><div id="code">
		<p>"Cross-Site Scripting (XSS)" attacks are a type of injection problem, in which malicious scripts are injected into the otherwise benign and trusted web sites.
			XSS attacks occur when an attacker uses a web application to send malicious code, generally in the form of a browser side script,
			to a different end user. Flaws that allow these attacks to succeed are quite widespread and occur anywhere a web application using input from a user in the output,
			without validating or encoding it.</p>

		<p>An attacker can use XSS to send a malicious script to an unsuspecting user. The end user's browser has no way to know that the script should not be trusted,
			and will execute the JavaScript. Because it thinks the script came from a trusted source, the malicious script can access any cookies, session tokens, or other
			sensitive information retained by your browser and used with that site. These scripts can even rewrite the content of the HTML page.</p>

		<p>Guestbook entries are stored in the database and encoded when displayed, including entries saved before the current protections were applied.</p>

		<br /><hr /><br />

		<h3>Objective</h3>
		<p>Observe how guestbook text can be displayed without being interpreted as HTML.</p>

		<br /><hr /><br />

		<h3>Low Level</h3>
		<p>Both the name and message are encoded when the guestbook is rendered.</p>

		<br />

		<h3>Medium Level</h3>
		<p>Both stored fields are encoded at display time, even if older entries were saved with different input checks.</p>

		<br />

		<h3>High Level</h3>
		<p>The display encodes tags and event attributes in both stored fields.</p>

		<br />

		<h3>Impossible Level</h3>
		<p>Output encoding also applies here; stored text remains visible without becoming executable markup.</p>
	</div></td>
	</tr>
	</table>

	</div>

	<br />

	<p>Reference: <?php echo dvwaExternalLinkUrlGet( 'https://www.owasp.org/index.php/Cross-site_Scripting_(XSS)' ); ?></p>
</div>
