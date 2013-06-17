<?php

function pb_request_list_archived_page() {
global $wpdb;
?>

<div class="wrap">
<h2>PrayBox Archived Prayer Request List</h2>

<p>In future updates, we hope to provide further tools for managing archives.</p>

<h3>Archived Prayer Requests</h3>

<table class="gdadmin">
<tr class="headrow"><td>ID</td><td>First/Last/Email</td><td width="250">Prayer Request</td><td>IP</td><td>Posted</td><td># Prayers</td><td>&nbsp;</td></tr>

<?php
echo getRequestList('archived');
?>
</table>
</div>
<?php }