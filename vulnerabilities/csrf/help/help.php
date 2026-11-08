<div class="body_padded">
	<h1>Help - Cross Site Request Forgery (CSRF)</h1>

	<div id="code">
	<table width='100%' bgcolor='white' style="border:2px #C0C0C0 solid">
	<tr>
	<td><div id="code">
		<h3>About</h3>
		<p>CSRF is an attack that forces an end user to execute unwanted actions on a web application in which they are currently authenticated.
			With a little help of social engineering (such as sending a link via email/chat), an attacker may force the users of a web application to execute actions of
			the attacker's choosing.</p>

		<p>A successful CSRF exploit can compromise end user data and operation in case of normal user. If the targeted end user is
			the administrator account, this can compromise the entire web application.</p>

		<p>This attack may also be called "XSRF", similar to "Cross Site scripting (XSS)", and they are often used together.</p>

		<br /><hr /><br />

		<h3>Objective</h3>
		<p>Change your own password through the form and inspect how the server validates the request.</p>

		<br /><hr /><br />

		<h3>Low Level</h3>
		<p>Password changes require a POST containing the form's session token. A link with query parameters cannot change the password.</p>

		<br />

		<h3>Medium Level</h3>
		<p>A Referer header is not treated as proof of authorization. The POST token is checked before a password update.</p>

		<br />

		<h3>High Level</h3>
		<p>The anti-CSRF token is required on POST, and GET requests cannot change the password.</p>

		<h4>Bonus Challenge</h4>
		<p>At this level, the site will also accept a change password request as a JSON object in the following format:</p>
		<pre><code>{"password_new":"a","password_conf":"a","Change":1}</code></pre>
		<p>When done this way, the CSRF token must be passed as a header named <code>user-token</code>.</p>

		<p>Here is a sample request:</p>
		<pre><code><span class="spoiler">POST /vulnerabilities/csrf/ HTTP/1.1
Host: dvwa.test
Content-Length: 51
Content-Type: application/json
Cookie: PHPSESSID=0hr9ikmo07thlcvjv3u3pkfeni; security=high
user-token: 026d0caed93471b507ed460ebddbd096

{"password_new":"a","password_conf":"a","Change":1}</span></pre></code>

		<br />

		<h3>Impossible Level</h3>
		<p>The form also requires the current password, in addition to a POST and a valid session token.</p>
	</div></td>
	</tr>
	</table>

	</div>

	<br />

	<p>Reference: <?php echo dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/attacks/csrf' ); ?></p>
</div>
