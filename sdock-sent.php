<?php

if(isset($_GET)){
if(isset($_GET["sdview_1_1_1"]))
$open= htmlspecialchars($_GET["sdview_1_1_1"]);
}

if (!empty($open)){

include("sdock-view.php");

}else{ ?>

<div class="wrap">
	<h2><?php _e('Support Logs', 'support_dock'); ?></h2>
<h4><?php _e('All Sent Tickets', 'support_dock');?> (Limit 25)</h4>
	<?php
      global $wpdb;
      global $current_user;
      $id = $current_user->ID;
      $sender = $current_user->display_name;

     $mail = $wpdb->get_results(
  "
	SELECT c.id,c.subject,c.date,c.parentid,c.rtckid,c.rfrom,c.rto,c.rstatus,d.ID,d.user_nicename
	FROM {$wpdb->prefix}sdrecords c, {$wpdb->prefix}users d WHERE d.ID=c.rto and c.rfrom='$id' and c.rstatus='3' LIMIT 25"
  );
  foreach ( $mail as $mail )
 {
  $member = $mail->user_nicename;
  $rid = $mail->rto;
  $link = $mail->parentid;
  $rticket = $mail->rtckid;
  $rdate = $mail->date;
		
    echo "<div class='header'>";
		echo "<div class='wide'>" . "Ticket ID# " . "</div>";
		echo "<div class='xtra'>" . "Date" . "</div>";
		echo "<td class='thin'>"  . "Concerning" . "</div>";
		 echo "<div class='heading'>";
		echo "<div class='wide'>" . "<a href='" . admin_url() . "admin.php?page=sdock_sent&sdview_1_1_1=$link' class='edit'>" . $link . "</a></div>";
		echo "<div class='xtra'>" . $rdate . "</div>";
		echo "<td class='thin'>"  . $member . "</div>";
    echo "</div>";


}
		?>
		
	

<?php } ?>
<br>
<br>
	<!-- Support -->
	<div id="sdock_support">
		<h3><?php _e('Support & bug report', 'support_dock'); ?></h3>
		<p><?php printf(__('If you have any idea to improve this plugin or any bug to report, please email me at : <a href="%1$s">%2$s</a>', 'support_dock'), 'mailto:supportdock@cbfreeman.com?subject=[Support Dock plugin]', 'supportdock@cbfreeman.com'); ?></p>
		<?php $donation_link = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BAZNKCE6Q78PJ'; ?>
		<p><?php printf(__('You like this plugin ? You use it in a business context ? Please, consider a <a href="%s" target="_blank" rel="external">donation</a>.', 'support_dock'), $donation_link ); ?></p>
	</div>
</div>
