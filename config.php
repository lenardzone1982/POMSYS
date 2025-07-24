<?php 
	session_start();
	$conn = mysqli_connect("localhost","root","","brgy_mgmt_2");
	if(!$conn) {
		exit();
	}

	// SMS
	function sendSms($c_contact, $message) {
		$ch = curl_init();
	    $parameters = array(
	        'apikey' => 'fe5d3234d02e1a88e476a22184b35c2e', // Your API KEY
	        'number' => '0' . $c_contact, // Recipient's phone number
	        'message' => $message,  // The formatted message content
	        'sendername' => 'CDCOC' // Sender's name
	    );

	    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/priority');
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $output = curl_exec($ch);
	    curl_close($ch);

	    // Optionally, you can log the SMS sending status if needed.
	    // error_log("SMS Response: " . $output);
	}
?>