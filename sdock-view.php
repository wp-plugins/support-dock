<div class="wrap">
  <h2><?php _e('Support Ticket', 'support_dock');?></h2>
  <br>
  <?php
 global $wpdb;
 global $current_user;
  $id = $current_user->ID;
  $sender = $current_user->display_name;
  $sendermail = $current_user->user_email;
 
$count = $wpdb->get_var( "SELECT COUNT(id) FROM {$wpdb->prefix}sdrecords WHERE parentid='$open' ");
 
 $receipt =$wpdb->get_results("SELECT * FROM {$wpdb->prefix}sdtickets WHERE stckid='$open' and sto='$id' LIMIT 1");
  foreach ($receipt as $receipt){
     $to = $receipt->sto;
     $from = $receipt->sfrom;
     $sub= $receipt->subject;
     $message= $receipt->concern;
     $mesg = nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8'));

  
   $getmail =$wpdb->get_var("SELECT user_nicename FROM {$wpdb->prefix}users WHERE ID='$from' ");
   
    echo "<div id='support'>";
    echo "<div class='header'>";
		echo "<div class='wide'>" . "Ticket ID# " . "</div>";
		echo "<div class='xtra'>" . "Subject" . "</div>";
		echo "<td class='thin'>"  . "Username" . "</div>";
		 echo "<div class='heading'>";
		echo "<div class='wide'>" . $open . "</div>";
		echo "<div class='xtra'>" . $sub . "</div>";
		echo "<td class='thin'>"  .$getmail. "</div>";
		echo "<div class='sdreply-body'>" .  $mesg .  "</div>";
		echo "<div class='footer'>" . "<span class='dept'>" . "Support Feedback: " .$count. "</span></div>";
		echo "</div>";
           
                
  }

  
$spt =$wpdb->get_results("SELECT * FROM {$wpdb->prefix}sdrecords WHERE parentid='$open' ORDER BY id DESC LIMIT 5");
  foreach ($spt as $spt){
     $rto = $spt->rto;
     $rfrom = $spt->rfrom;
     $rsub= $spt->subject;
     $rmessage= $spt->concern;
     $rmesg = nl2br(htmlentities($rmessage, ENT_QUOTES, 'UTF-8'));
     $rdate = $spt->date;

    $rget =$wpdb->get_var("SELECT user_nicename FROM {$wpdb->prefix}users WHERE ID='$rto' ");
    $rmail =$wpdb->get_var("SELECT user_nicename FROM {$wpdb->prefix}users WHERE ID='$rfrom' ");
    echo "<div id='support'>";
    echo "<div class='header'>";
		echo "<div class='wide'>" . "From" . "</div>";
		echo "<div class='xtra'>" . "Date" . "</div>";
		echo "<td class='thin'>"  . "To" . "</div>";
		 echo "<div class='heading'>";
		echo "<div class='wide'>" . $rmail . "</div>";
		echo "<div class='xtra'>" . $rdate . "</div>";
		echo "<td class='thin'>"  . $rget . "</div>";
		echo "<div class='sdreply-body'>" .  $rmesg .  "</div>";
		echo "<div class='footer'></div>";
		echo "</div>";
                            
  }
  
  

?>
<?php echo  "<div class='sdock_reply'>";
                echo "<a href='" . admin_url() . "admin.php?page=sdock_options&sdreply_1_1_1=$open'      class='button-primary'>" . "Send Reply" . "</a>";
     
?>
</div>