<?php

 // WP Global Settings
  global $wpdb;
  $url = site_url();
  $name = get_bloginfo();
  $today = date('M d Y');
  
  // Send REPLY HTML Mail
  if(isset($_POST['sdockreply'])) {
  if(isset($_POST['senderidreply']))
  $id = intval($_POST['senderidreply']);
  if(isset($_POST['senderreply']))
  $user = sanitize_text_field($_POST['senderreply']);
  if(isset($_POST['sendermailreply']))
  $useremail = sanitize_email($_POST['sendermailreply']);
  if(isset($_POST['mailtoreply']))
  $mailto = sanitize_text_field($_POST['mailtoreply']);
  if(isset($_POST['subjectmailreply']))
  $msubject = sanitize_text_field($_POST['subjectmailreply']);
  if(isset($_POST['templatereply']))
  $template = sanitize_text_field($_POST['templatereply']);
  if(isset($_POST['ticketid']))
  $ticket = sanitize_text_field($_POST['ticketid']);
  global $wpdb;
  $list = mt_rand();
  $midreply = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE user_nicename='$mailto'");
  $reply = htmlspecialchars($_GET["sdreply_1_1_1"]);
  $table = $wpdb->prefix . "sdrecords";
  $wpdb->insert( $table, array('rtckid' => $list, 'parentid' => $reply, 'dept' =>$dept, 'rfrom' =>$_POST['senderidreply'] ,'rto' => $midreply, 'subject' => $_POST['subjectmailreply'],'concern' => $_POST['templatereply'], 'rstatus' => 3, 'date' =>$today ) );
 
  $sdreply = $wpdb->get_results(
  "
	SELECT user_email
	FROM {$wpdb->prefix}users WHERE user_nicename='$mailto' and mail='Y'"
  );
  foreach ( $sdreply as $sdreply )
 {
  $sdbox = $sdreply->user_email;
  
  $content ='<html><head>';
$content .= "<body style='margin: 0px; background-color: '#FFF'; font-family: Helvetica, Arial, sans-serif; font-size:12px;' text='#444444' bgcolor='#FFFFFF' link='#21759B' alink='#21759B' vlink='#21759B' marginheight='0' topmargin='0' marginwidth='0' leftmargin='0'>
		<table cellpadding='0' cellspacing='0' width='600' bgcolor='#FFFFFF' border='0'>
			<tr>
				<td style='padding:15px;'>
					<center>
						<table width='550' cellpadding='0' bgcolor='#FFF' cellspacing='0' align='center'>
							<tr>
								<td align='left'>
									<div style='border:solid 1px #d9d9d9;'>
										<table id='header' width='600' border='0' cellpadding='0' bgcolor='#FFF' cellspacing='0' style='broder-top:4px solid #39C;line-height:1.6;font-size:12px;font-family: Helvetica, Arial, sans-serif;border:solid 1px #FFFFFF;color:#444;'>
											<tr>
												<td colspan='2' background='' . admin_url('images/white-grad-active.png') . '' height='30' style='color:#ffffff;' valign='bottom'>.</td>
											</tr>
											<tr>
												<td style='line-height:32px;padding-left:30px;' valign='baseline'><span style='font-size:12px;'>Dear $mailto,
												<br>
												We have submitted a reply to Ticket ID# $ticket.</span>
												<br><br>
												Support Feedback:
												<br>
												$template
												</td>
								
											</tr>
										</table>
										 <table width='100%' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
                    <tr>
           <td style='padding:15px 40px;'>
         <table width='550' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
        <tr style='font-family: Helvetica, Arial, sans-serif; font-size:12px;text='#444444;'>
         <td>
  <p style='margin:0 0 30px 100px;background:#DCF0F6;padding:5px 15px 15px 5px;width:50%;text-align:center;'>
  <a href='$url'>Login</a> to view/reply to this message</a></p>
  <br><br>
  This message was intended for $mailto.
  <br>
  <br><br>
  &copy; $name. All rights reserved.
</td></tr></table>
</td>
</tr>
</table>
									</div>
								</td>
							</tr>
						</table>
					</center>
				</td>
			</tr>
		</table>
	</body>
</html>";
  $to = "$sdbox";
  $subject = "Re:Support Ticket ID:$ticket";
  $sender = "$name" ;
  $email = "$user($useremail)";
  $headers = "From: " .$email."\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
  $sent = mail($to, $subject, $content, $headers) ;

 }

}


?>
<div class="wrap">
	<h2><?php _e('Reply to Ticket', 'support_dock'); ?></h2>

<h3><?php
$reply = htmlspecialchars($_GET["sdreply_1_1_1"]);
 _e('Ticket ID#', 'support_dock');
?><?php echo $reply;?></label></h3></th>

<form method="post" action="" id="support_dock-form">
	
<?php
  $reply = htmlspecialchars($_GET["sdreply_1_1_1"]);
  global $wpdb;
  global $current_user;
  $id = $current_user->ID;
  $sender = $current_user->display_name;
  $sendermail = $current_user->user_email;
  echo "<input type='hidden' name='senderidreply' value='" .esc_attr($id) ."'>";
  echo "<input type='hidden' name='senderreply' value='" .esc_attr($sender) . "'>";
  echo "<input type='hidden' name='sendermailreply' value='" .esc_attr($sendermail) ."'>";
  echo "<input type='hidden' name='ticketid' value='$reply'>";

  $receipt =$wpdb->get_results("SELECT * FROM {$wpdb->prefix}sdtickets WHERE stckid='$reply' and sto='$id' ORDER   BY id DESC LIMIT 1 ");
   foreach ($receipt as $receipt){
     $to = $receipt->sto;
     $from = $receipt->sfrom;
     $message= $receipt->concern;
     $mesg = nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8'));
     $sub= $receipt->subject;
  }
  
   $getmail =$wpdb->get_var("SELECT user_nicename FROM {$wpdb->prefix}users WHERE ID='$from' ");
  

?>
		<input type="hidden" name="mailtoreply" value="<?php echo esc_attr($getmail);?>">
<input type="hidden" name="subjectmailreply" value="<?php echo esc_attr($sub);?>">
<input type="hidden" name="templatereply" value="<?php echo esc_attr($templatereply);?>">
		

 <?php
  
    echo "<div id='support'>";
    echo "<div class='header'>";
		echo "<div class='wide'>" . "Ticket ID# " . "</div>";
		echo "<div class='xtra'>" . "Subject" . "</div>";
		echo "<td class='thin'>"  . "Username" . "</div>";
		 echo "<div class='heading'>";
		echo "<div class='wide'>" . $reply . "</div>";
		echo "<div class='xtra'>" . $sub . "</div>";
		echo "<td class='thin'>"  .$getmail. "</div>";
		echo "<div class='sdreply-body'>" .  $mesg .  "</div>";
		echo "<div class='footer'></div>";
		echo "</div>";
                
           ?>

<!-- Sender options -->
		<table class="form-table" width="600">
			<tr valign="top">
			<td>

		<p><h4><?php _e('Enter Support Feedback here:', 'support_dock');?></h4></p>
		<div>
			<textarea id="reply" name="templatereply" cols="68" rows="12">
                        
                         



</textarea>
	
		<p class="submit">
			<input type="submit" name="sdockreply" class="button-primary" value="<?php _e('Send Reply', 'support_dock') ?>" />
		</p>
	</form>
	
	<br>

</td>
</tr>
</tbody>
</table>
