<div class="wrap">
	<h2>Timthumb Scanner</h2>
		<div class="postbox metabox-holder" style="float:right;width:300px;padding-top:0px">
		<h3 class="hndle" style="text-align:center"><a href="http://codegarage.com/"><img src="<?php echo WP_PLUGIN_URL; ?>/<?php echo basename( dirname( __FILE__ ) ); ?>/locker_logo.png"></a></h3>
		<div class="inside">
			<p><strong>Tired of worrying about your WordPress sites?</strong></p>
			<p><a href="http://codegarage.com" target="_blank" >Locker</a> from <a href="http://codegarage.com/"  target="_blank" >Code Garage</a> provides rock solid daily backups and hack monitoring and cleanup (for malicious code and vulnerabilities like this one), as well as personal, one on one support when you need it.  Plans start at $15/month for 10 sites.</p>
			<p style="text-align:center;padding-top:15px;"><a href="http://codegarage.com/" target="_blank" class="button-primary">Click here to learn more</a></p>
		</div>
	</div>
	<div style="margin-right:320px;">
		<h4>What's going on here?</h4>
		<p>Here's how this works:  When you click "Scan", we'll gather a list of all the files in your wp-content directory, and then we'll scan all of the php files looking for the timthumb script. If we find it, we'll scan it to make sure it's at least version 2 - which is the version that fixed the vulnerability.  You'll be notified here of any files that need to be updated.</p>
		<form action="tools.php?page=cg-timthumb-scanner" method="post">
			<input type="hidden" name="cg-action" value="scan">
			<button class="button-secondary">Scan!</button>
		</form>
		<?php if ( get_option( 'cg_tvs_last_checked' ) ): ?>
		<h4>What now?</h4>
		<p>We've now scanned all your themes and plugins, and any instances of the timthumb script are listed below.  Problem files (timthumb scripts that are older than version 2.0) are in the "Vulnerable" list, and safe files (Newer than 2.0) are listed in the "Safe" list. "Vulnerable" files can be upgraded to the latest version of timthumb by clicking the "Fix" button next to each file.</p>
		<table class="form-table">
			<tr>
				<th scope="row">Last Scanned:</th>
				<td><?php echo get_option( 'cg_tvs_last_checked' ); ?></td>
			</tr>
			<tr>
				<th scope="row">Vulnerable Timthumb Files:</th>
				<td><?php echo $vulnerable_list_html; ?></td>
			</tr>
			<?php if(count($vulnerable_files)>1): ?>
			<tr>
			 <th scope="row"></th>
			 <td><a href="<?php echo wp_nonce_url( 'tools.php?page=cg-timthumb-scanner&cg-action=fixall', 'fix_all_timthumb_files'); ?>" onclick="return confirm('Are you sure you want to fix ALL of the found files?  This can't easily be undone.  I'd suggest you make a backup of your wp-content directory before proceeding.')" class="button" style="margin-left:23px;">Fix All <?php echo count($vulnerable_files); ?> Vulnerable Files</a>  <strong>Warning:</strong> Make sure you want ALL of the files fixed!</td>
			</tr>
			<?php endif; ?>
			<tr>
				<th scope="row">Safe Timthumb Files:</th>
				<td><?php echo $safe_list_html; ?></td>
			</tr>
		</table>
		<?php endif; ?>
	</div>
</div>