<?php

   
  // WP Global Settings
  global $wpdb;
  $site = admin_url();
  $blogtitle = get_bloginfo();
  $today = date('M d Y');
  $user_info = get_userdata(1);
  $admin = $user_info->ID;
  $ademail = $user_info->user_email;

  // Send and Store Support Ticket
  if(isset($_POST['supportdock'])) {
  if(isset($_POST['id']))
  $sid = sanitize_text_field($_POST['id']);
  if(isset($_POST['sender']))
  $sduser = sanitize_text_field($_POST['sender']);
  if(isset($_POST['sdmail']))
  $sdmail = sanitize_text_field($_POST['sdmail']);
  if(isset($_POST['subject']))
  $sdsubj = sanitize_title($_POST['subject']);
  if(isset($_POST['dept']))
  $sddept = sanitize_title($_POST['dept']);
  if(isset($_POST['template']))
  $sdconcern = sanitize_text_field($_POST['template']);
  $sdconcern = nl2br(htmlentities($sdconcern, ENT_QUOTES, 'UTF-8'));
  global $wpdb;
  $list = mt_rand();
  
  $table_name = $wpdb->prefix . "sdtickets";
  $wpdb->insert( $table_name, array( 'stckid' => $list, 'dept' =>$_POST['dept'], 'sfrom' =>$_POST['id'] ,'sto' => $admin, 'subject' => $_POST['subject'],'concern' => $_POST['template'], 'sstatus' => 1, 'date' =>$today ) );
  

$content ='<html><head>';
$content .= "<body style='margin: 0px; background-color: '#F4F3F4'; font-family: Helvetica, Arial, sans-serif; font-size:12px;' text='#444444' bgcolor='#FFFFFF' link='#21759B' alink='#21759B' vlink='#21759B' marginheight='0' topmargin='0' marginwidth='0' leftmargin='0'>
		<table cellpadding='0' cellspacing='0' width='600' bgcolor='#FFFFFF' border='0'>
			<tr>
				<td style='padding:15px;'>
					<center>
						<table width='550' cellpadding='0' bgcolor='#FFFFFF' cellspacing='0' align='center'>
							<tr>
								<td align='left'>
									<div style='border:solid 1px #d9d9d9;'>
										<table id='header' width='600' border='0' cellpadding='0' bgcolor='#ffffff' cellspacing='0' style='broder-top:4px solid #39C;line-height:1.6;font-size:12px;font-family: Helvetica, Arial, sans-serif;border:solid 1px #FFFFFF;color:#444;'>
											<tr>
												<td colspan='2' background='' . admin_url('images/white-grad-active.png') . '' height='30' style='color:#ffffff;' valign='bottom'>.</td>
											</tr>
											<tr>
												<td style='line-height:32px;padding-left:30px;' valign='baseline'></td>
								
											</tr>
											<tr>
												<td style='line-height:32px;padding-left:30px;' valign='baseline'>
												Attn:Support Dept.
												<br>
												$sduser has created a new support ticket.
												<br>
												<span style='padding:5px 15px 15px 5px;background:#DCF0F6;'>Support Ticket: ID# $list</span>
												
												<br>
												Dept: $sddept
												<br>
												Subject: $sdsubj
												<br>
												Concern:
												<br>
												$sdconcern
												<br>
												<hr>
												</td>
								
											</tr>
										</table>
										 <table width='100%' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
                    <tr>
           <td style='padding:15px 40px;'>
         <table width='550' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
        <tr style='font-family: Helvetica, Arial, sans-serif; font-size:12px;color:#444444;'>
         <td>
  <p style='margin:0 0 30px 100px;background:#DCF0F6;padding:5px 15px 15px 5px;width:50%;text-align:center;'>
  <a href='$site'>Login</a> to view/reply to this message</p>
  <br><br>
  <br>
  <br><br>
  &copy; $blogtitle. All rights reserved.
</td></tr></table>
</td>
</tr>
</table>
									</div>
								</td>
							</tr>
						</table>
					</center></td></tr>
		</table></body></html>";
  
  $to = "$ademail";
  $subject = "Support Ticket";
  $sender = "$sduser" ;
  $email = "$sduser($sdmail)";
  $headers = "From: " .$email."\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
  $sent = mail($to, $subject, $content, $headers) ;


}



 // Contact Support Email
  global $wpdb;
  $site = admin_url();
  $blogtitle = get_bloginfo();
  $today = date('M d Y');
  $user_info = get_userdata(1);
  $admin = $user_info->ID;
  $ademail = $user_info->user_email;

  // Send and Store Support Ticket
  if(isset($_POST['contactsupportdock'])) {
  if(isset($_POST['id']))
  $sid = sanitize_text_field($_POST['id']);
  if(isset($_POST['sender']))
  $sduser = sanitize_text_field($_POST['sender']);
  if(isset($_POST['sdmail']))
  $sdmail = sanitize_text_field($_POST['sdmail']);
  if(isset($_POST['ticket']))
  $label = sanitize_title($_POST['ticket']);
 
  global $wpdb;
  $list = mt_rand();
  
  $logs = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}sdtickets WHERE stckid='$label' ");
  foreach($logs as $logs){
   $rdept = $logs->dept;
	 $rsubj = $logs->subject;
	 $rconcern = $logs->concern;
	 
  }
  
  $table_name = $wpdb->prefix . "sdrecords";
  $wpdb->insert( $table_name, array( 'rtckid' => $list, 'parentid' =>$label, 'dept' =>$_POST['dept'], 'rfrom' =>$_POST['id'] ,'rto' => $admin, 'subject' => $_POST['subject'],'concern' => $_POST['template'], 'rstatus' => 1, 'date' =>$today ) );
  

$content ='<html><head>';
$content .= "<body style='margin: 0px; background-color: '#F4F3F4'; font-family: Helvetica, Arial, sans-serif; font-size:12px;' text='#444444' bgcolor='#FFFFFF' link='#21759B' alink='#21759B' vlink='#21759B' marginheight='0' topmargin='0' marginwidth='0' leftmargin='0'>
		<table cellpadding='0' cellspacing='0' width='600' bgcolor='#FFFFFF' border='0'>
			<tr>
				<td style='padding:15px;'>
					<center>
						<table width='550' cellpadding='0' bgcolor='#FFFFFF' cellspacing='0' align='center'>
							<tr>
								<td align='left'>
									<div style='border:solid 1px #d9d9d9;'>
										<table id='header' width='600' border='0' cellpadding='0' bgcolor='#ffffff' cellspacing='0' style='broder-top:4px solid #39C;line-height:1.6;font-size:12px;font-family: Helvetica, Arial, sans-serif;border:solid 1px #FFFFFF;color:#444;'>
											<tr>
												<td colspan='2' background='' . admin_url('images/white-grad-active.png') . '' height='30' style='color:#ffffff;' valign='bottom'>.</td>
											</tr>
											<tr>
												<td style='line-height:32px;padding-left:30px;' valign='baseline'></td>
								
											</tr>
											<tr>
												<td style='line-height:32px;padding-left:30px;' valign='baseline'>
												Attn:Support Dept.
												<br>
												$sduser has replied to your support ticket message.
												<br>
												<span style='padding:5px 15px 15px 5px;background:#DCF0F6;'>RE:Support Ticket: ID# $label</span>
												
												<br>
												Dept: $rdept
												<br>
												Subject: $rsubj
												<br>
												Concern:
												<br>
												$rconcern
												<br>
												<hr>
												</td>
								
											</tr>
										</table>
										 <table width='100%' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
                    <tr>
           <td style='padding:15px 40px;'>
         <table width='550' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
        <tr style='font-family: Helvetica, Arial, sans-serif; font-size:12px;color:#444444;'>
         <td>
  <p style='margin:0 0 30px 100px;background:#DCF0F6;padding:5px 15px 15px 5px;width:50%;text-align:center;'>
  <a href='$site'>Login</a> to view/reply to this message</p>
  <br><br>
  <br>
  <br><br>
  &copy; $blogtitle. All rights reserved.
</td></tr></table>
</td>
</tr>
</table>
									</div>
								</td>
							</tr>
						</table>
					</center></td></tr>
		</table></body></html>";
  
  $to = "$ademail";
  $subject = "Support Ticket";
  $sender = "$sduser" ;
  $email = "$sduser($sdmail)";
  $headers = "From: " .$email."\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
  $sent = mail($to, $subject, $content, $headers) ;


}


?>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1"><?php _e('New Tickets', 'support_dock');?></a></li>
    <li><a href="#tabs-2"><?php _e('Contact Support', 'support_dock');?></a></li>
  </ul>
  <div id="tabs-1">
    <form method="post" action="" id="support-dock-form">
		<?php settings_fields('sdock_full_options'); ?>
<?php

  global $wpdb;
  global $current_user;
  $id = $current_user->ID;
  $sender = $current_user->display_name;
  $sendermail = $current_user->user_email;
  echo "<input type='hidden' name='id' value='" . esc_attr($id) . "'>";
  echo "<input type='hidden' name='sender' value='" . esc_attr($sender) . "'>";
  echo "<input type='hidden' name='sdmail' value='" .esc_attr($sendermail) . "'>";
 
?>
<input type="hidden" name="dept" value="<?php echo esc_attr($dept);?>">
<input type="hidden" name="subject" value="<?php echo esc_attr($subject);?>">
<input type="hidden" name="template" value="<?php echo esc_attr($template);?>">

		<!-- Sender options -->
		<table class="form-table">
			<tr valign="top">
			<th scope="row">
<br>
<label for="dept"><?php _e('Dept:', 'support_dock'); ?></label></th>
				<td><select name="dept" style="width:350px;" tabindex="4">
				<option value="Billing">Billing & Payments</option>
  <option value="Tech">Tech Support</option>
  <option value="General">General Support</option>
  <option value="Other">Other</option>
         </select>
				</td>
				</tr>
			<tr valign="top">
				<th scope="row"><label for="subject"><?php _e('Subject', 'support_dock'); ?></label></th>
				<td><input type="text" id="subject" class="regular-text" name="subject" value="" />
				<br>
				</td>
		</table>

		<!-- Template -->
		<th scope="row"><label for="concern"><?php _e('How can we help you?', 'support_dock'); ?></label></th>
                   <td>
		<div id="sd_template_container" style="width:600px;">
<br>
			<textarea id="template" class="template" name="template" cols="80" rows="12" style='margin: 0px; width: 572px; height: 262px;';>Type your question for support here.</textarea>
		</div>
		<p class="submit">
			
			<input type="submit" name="supportdock" class="button-primary" value="<?php _e('Submit Ticket', 'support_dock') ?>" />
		</p>
	</form>
	
	<br>

</td>
</tr>
</tbody>
</table>

  </div>
  <div id="tabs-2">
 <form method="post" action="" id="contact-supportdock-form">
		<?php settings_fields('sdock_full_options'); ?>
<?php

  global $wpdb;
  global $current_user;
  $id = $current_user->ID;
  $sender = $current_user->display_name;
  $sendermail = $current_user->user_email;
  echo "<input type='hidden' name='id' value='" . esc_attr($id) . "'>";
  echo "<input type='hidden' name='sender' value='" . esc_attr($sender) . "'>";
  echo "<input type='hidden' name='sdmail' value='" .esc_attr($sendermail) . "'>";
?>

		<!-- Sender options -->
		<table class="form-table">
<tr valign="top">
				<th scope="row"><label for="subject"><?php _e('Ticket ID', 'support_dock'); ?></label></th>
				<td>
				<input type="hidden" name="ticket" value='<?php echo esc_attr($ticket);?>'>
				<select name="ticket"  style="width:350px;" tabindex="4">
  <?php

global $wpdb;
global $current_user;
$id = $current_user->ID;

 $tck = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}sdtickets WHERE sfrom=$id LIMIT 10" );
  foreach ($tck as $tck){
    $source = $tck->stckid;
            echo  '<option value="'.$source.'">'.$source.'</option>';
         
            }          ?>
         </select>
		
				</td>
				</tr>
		</table>

		<!-- Template -->
		<th scope="row"><label for="concern"><?php _e('Message:', 'support_dock'); ?></label></th>
                   <td>
		<div id="sd_template_container" style="width:600px;">
<br>
			<textarea id="template" class="template" name="template" cols="80" rows="12" style='margin: 0px; height: 260px; width: 676px;'></textarea>
		</div>
		<p class="submit">
			
			<input type="submit" name="contactsupportdock" class="button-primary" value="<?php _e('Contact Support', 'support_dock') ?>" />
		</p>
	</form>
	
	<br>

</td>
</tr>
</tbody>
</table>
  
  </div>
</div>

	

</head>
<body>
 

 
