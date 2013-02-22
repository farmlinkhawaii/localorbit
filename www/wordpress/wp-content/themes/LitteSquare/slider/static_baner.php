<?php
global $theme_options;
$content = $theme_options['static_baner_textbox'];
$image_baner = $theme_options["static_baner_image"];
?>
<section id="home-top-content">
    	<div id="static-content">
        
	    	<div class="container">
	        	<div class="row">
		           
					<div class="span6 form-request">
		                 <?php
							echo  do_shortcode($content);
							?>
						<?php
						global $theme_options;
						if(!isset($_POST["quote_guest_submit"]) && isset($theme_options["enable_submit_form"]) && $theme_options["enable_submit_form"] == "1"):
						?>
						<div class="row">
		                    <form  method = "POST" class="span4">
	                        	<fieldset class="row">
			                        <input name="quote_received_email" class="span4" placeholder="Your email…" type="hidden" value="<?php echo $theme_options["enable_submit_form_email"];  ?>">
			                        <input name="quote_guest_email" class="span4" placeholder="Your email…" type="text">
			                        <input name="quote_guest_name" class="span2" placeholder="Your name…" type="text"><input  name="quote_guest_lastname" class="span2" placeholder="Your last name…" type="text">
	                            </fieldset>
	                            <input name="quote_guest_submit" class="span4 button button-big" value="Get a Free Quote Now" type="submit">
		                    </form>
	                    </div>
						<?php
						endif;
						if(isset($_POST["quote_guest_submit"])):
							$quote_received_email = $_POST["quote_received_email"];	
							$quote_guest_email = $_POST["quote_guest_email"];	
							$quote_guest_name = $_POST["quote_guest_name"];	
							$quote_guest_lastname = $_POST["quote_guest_lastname"];	
							$quote_guest_name = $_POST["quote_guest_name"];	
							
							$quote_send = "Have a require from ".$quote_guest_lastname." ".$quote_guest_name." Via ".site_url();
							$quote_title = "Have a Client Require Your Quote";

							
							
							$headers  = "From: $quote_received_email\r\n";
							$headers .= "Reply-To: $quote_guest_email\r\n";
							if(wp_mail($quote_guest_email, $quote_title, $quote_send, $headers)){
								echo '<div class="row"><p>Hello '.$quote_guest_name.' '.$quote_guest_lastname.'</p><p>We have just send u email. Plz Check Your Mail</p></row>'; // we are sending this text to the ajax request telling it that the mail is sent..      
							}else{
								echo '<div class="row"><div class="span4"><p>Send Mail Error! Plz reinput</p></div>
								<form  method = "POST" class="span4">
	                        	<fieldset class="row">
			                        <input name="quote_received_email" class="span4" placeholder="Your email…" type="hidden" value="'.$theme_options["enable_submit_form_email"].'">
			                        <input name="quote_guest_email" class="span4" placeholder="Your email…" type="text">
			                        <input name="quote_guest_name" class="span2" placeholder="Your name…" type="text"><input  name="quote_guest_lastname" class="span2" placeholder="Your last name…" type="text">
	                            </fieldset>
	                            <input name="quote_guest_submit" class="span4 button button-big" value="Get a Free Quote Now" type="submit">
		                    </form>
								
								</row>
								
								'; // we are sending this text to the ajax request telling it that the mail is sent..      
								
							}
							//$attack_files = 
						endif;
						?>
		            </div>
					<div class="span6">
						<img height="273" width="518" alt="" class="static-image" src="<?php echo $image_baner; ?>">
					</div>
					<div class="clearfix"></div>
	        	</div>
               
				
	       	</div>
            
        </div>
    </section>