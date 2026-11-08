<div class="body_padded">
	<h1>Help - Brute Force (Login)</h1>

	<div id="code">
	<table width='100%' bgcolor='white' style="border:2px #C0C0C0 solid">
	<tr>
	<td><div id="code">
		<h3>About</h3>
		<p>Password cracking is the process of recovering passwords from data that has been stored in or transmitted by a computer system.
			A common approach is to repeatedly try guesses for the password.</p>

		<p>Users often choose weak passwords. Examples of insecure choices include single words found in dictionaries, family names, any too short password
			(usually thought to be less than 6 or 7 characters), or predictable patterns
			(e.g. alternating vowels and consonants, which is known as leetspeak, so "password" becomes "p@55w0rd").</p>

		<p>Creating a targeted wordlists, which is generated towards the target, often gives the highest success rate. There are public tools out there that will create a dictionary
			based on a combination of company websites, personal social networks and other common information (such as birthdays or year of graduation).

		<p>A last resort is to try every possible password, known as a brute force attack. In theory, if there is no limit to the number of attempts, a brute force attack will always
			be successful since the rules for acceptable passwords must be publicly known; but as the length of the password increases, so does the number of possible passwords
			making the attack time longer.</p>

		<br /><hr /><br />

		<h3>Objective</h3>
		<p>Explore how a login form can limit repeated password guesses while keeping a normal login available.</p>

		<h3>Low, Medium and High Levels</h3>
		<p>All three levels now use the protected credential check. The form submits by POST with a CSRF token. After three failed attempts, the account is locked for 15 minutes. The response does not distinguish an invalid password from a locked account.</p>

		<h3>Impossible Level</h3>
		<p>This level uses the same protected check. Account lockout can temporarily prevent a legitimate user from logging in, so production systems should also consider controls that limit abusive clients.</p>
	</div></td>
	</tr>
	</table>

	</div>

	<br />

	<p>Reference: <?php echo dvwaExternalLinkUrlGet( 'https://en.wikipedia.org/wiki/Password_cracking' ); ?></p>
</div>
