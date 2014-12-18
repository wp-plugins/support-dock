<?php

if(isset($_GET)){
if(isset($_GET["sdreply_1_1_1"]))
$reply = htmlspecialchars($_GET["sdreply_1_1_1"]);

if(isset($_GET["sdclose_1_1_1"]))
$close = htmlspecialchars($_GET["sdclose_1_1_1"]);
}

if(!empty($close)){
global $wpdb;
$wpdb->query("UPDATE {$wpdb->prefix}sdtickets SET sstatus ='2' WHERE stckid='$close' ");

}

if(!empty($reply)){
  
  include('sdock-reply.php');
}else { ?>

<div class="wrap">
	<h2><?php _e('Support Tickets', 'support_dock'); ?></h2>

<?php
  global $wpdb;
  global $current_user;
  $id = $current_user->ID;
  $useremail = $current_user->user_email;
  $count = $wpdb->get_var( "SELECT COUNT(id) FROM {$wpdb->prefix}sdtickets WHERE sto=$id LIMIT 25" );

?>
<h4><?php _e('Showing: All','support_dock');?></h4>
Maximum Tickets:25 | Current Tickets: (<?php echo esc_attr($count);?>)
<br>
<br>
<?php
  if($count == 0){
   echo "<h3>You have no support tickets.</h3>";
  }else{

  global $wpdb;
  global $current_user;
  $id = $current_user->ID;
  $sender = $current_user->display_name;
  $mail = $wpdb->get_results(
  "
	SELECT * FROM {$wpdb->prefix}sdtickets WHERE sto=$id ORDER BY id DESC LIMIT 25"
  );
  foreach ( $mail as $mail )
 {
  $sid = $mail->stckid;
  $link = $mail->stckid;
  $subject = $mail->subject;
  $concern = $mail->concern;
  $date = $mail->date;
  $dept = $mail->dept;
  $status = $mail->sstatus;
  if($status == 1){
  $status = "OPEN";
  }else{
   $status = "CLOSED";
  }
 
  
  
    echo "<div id='support'>";
    echo "<div class='header'>";
		echo "<div class='wide'>" . "Ticket ID# " . "</div>";
		echo "<div class='xtra'>" . "Subject" . "</div>";
		echo "<td class='thin'>"  . "Date" . "</div>";
		 echo "<div class='heading'>";
		echo "<div class='wide'>" . "<a href='" . admin_url() . "admin.php?page=ticket&reply_1_1_1=$link' class='edit'>" . $sid . "</a></div>";
		echo "<div class='xtra'>" . $subject . "</div>";
		echo "<td class='thin'>"  .$date. "</div>";
		echo "<div class='sd-body'>" .  $concern .  "</div>";
		echo "<div class='footer'>" . "<span class='dept'>" . $dept . "</span>" . "<span class='status'>" . $status . "</span>"  . "<a href='" . admin_url() . "admin.php?page=sdock_options&sdreply_1_1_1=$link' class='edit'>" . "reply" . "</a>" . "|" . "<a href='" . admin_url() . "admin.php?page=sdock_sent&sdview_1_1_1=$link' class='edit'>" . "view" . "</a>" .  "|" . "<a href='" . admin_url() . "admin.php?page=sdock_options&sdclose_1_1_1=$link' class='delete'>" . "close" . "</a></div>";

		echo "</div>";

}

}
		?>
		
<?php } ?>

<!-- Support -->
	<div id="sdock_support">
		<h3><?php _e('Support & bug report', 'support_dock'); ?></h3>
		<p><?php printf(__('If you have any idea to improve this plugin or any bug to report, please email me at : <a href="%1$s">%2$s</a>', 'support_dock'), 'mailto:supportdock@cbfreeman.com?subject=[Support Dock Plugin]', 'supportdock@cbfreeman.com'); ?></p>
	<?php $donation_link = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BAZNKCE6Q78PJ'; ?>
		<p><?php printf(__('You like this plugin ? You use it in a business context ? Please, consider a <a href="%s" target="_blank" rel="external">donation</a>.', 'support_dock'), $donation_link ); ?></p>
	</div>
</div>