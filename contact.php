<?php

/* set the email of the recipient (your email) */
$recipient = "hatimgenius@hotmail.com";
$output = array();
if ( isset($_POST) ) // just send the email if the $_POST variable is set
{
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
    $website = $_POST['website'];
	$message = $_POST['message'];
	
	$subject = "Contact Us - Digia " . $name; // subject of the email msg
	
	$errors = array(); // empty array of the err
	
	/*
	 * The fields
	 * 1st param: submitted data
	 * 2nd param: reuqired (TRUE) or not (FALSE)  
	 * 3rd param: the name for the error
	*/
	$fields = array(
		'name'		=> array($name, TRUE, "Name"),
		'website'   => array($website, FALSE, "Website"),
		'email' 	=> array($email, TRUE, "E-mail Address"),
		'phone' 	=> array($phone, TRUE, "Phone"),
		'message' 	=> array($message, TRUE, "Message"),
	);
	
	$i=0;
	foreach ($fields as $key => $field) {
		if ( FALSE == validate_field( $field[0], $field[1] ) ) {
			$errors[$key] = "The field '".$field[2]."' is required.";
		}
		$i++;
	}
	
	//var_dump($errors);
	
	if (empty($errors)) { // if there is no errors, we can send the mail
		$body = "";
		$body .= "----- Info about the sender -----\n\n";
		$body .= "Name: ".$fields['name'][0]."\n";
		$body .= "Phone: ".$fields['phone'][0]."\n";
		$body .= "Email: ".$fields['email'][0]."\n";
		$body .= "Website: ".$fields['website'][0]."\n";
		$body .= "\n\n----- Message -----\n\n";
		$body .= $fields['message'][0];
		
		if( mail( $recipient, $subject, $body, "FROM: ".$fields['email'][0] ) ) { // try to send the message, if not successful, print out the error
			$output['msgtype'] = 'success';
			$output['msg'] = 'Your message was sent successfully!';
        } else {
			$output['msgtype'] = 'error';
			$output['msg'] = 'It is not possible to send the email. Check out your PHP settings!';
		}
	} else { // if there are any errors
		$output['msgtype'] = 'error';
		$output['msg'] = $errors;
	}
}
echo json_encode($output);

/**
 * Returns TRUE if field is required and OK
 */
function validate_field($content, $required) {
	if ( TRUE === $required ) {
	    return strlen($content) > 0;
        
	} else {
		return TRUE;
	}
}

?>