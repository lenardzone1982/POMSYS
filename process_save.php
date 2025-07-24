<?php 
	include '../config.php';
	include('../phpqrcode/qrlib.php');
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../vendor/PHPMailer/src/Exception.php';
	require '../vendor/PHPMailer/src/PHPMailer.php';
	require '../vendor/PHPMailer/src/SMTP.php';
	date_default_timezone_set('Asia/Manila');

	// SAVE SYSTEM USER - USERS_ADD.PHP
	if(isset($_POST['create_system_user'])) {
	
		$user_type	     = mysqli_real_escape_string($conn, $_POST['usertype']);
		$username		 = mysqli_real_escape_string($conn, $_POST['username']);
		$firstname       = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename      = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname        = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix          = mysqli_real_escape_string($conn, $_POST['suffix']);
		$contact         = mysqli_real_escape_string($conn, $_POST['contact']);
		$email           = mysqli_real_escape_string($conn, $_POST['email']);
		$password        = mysqli_real_escape_string($conn, md5($_POST['password']));
		$date_registered = date('Y-m-d');

		$check_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
		if(mysqli_num_rows($check_username)>0) {
	      $_SESSION['message'] = "Username already exists.";
	      $_SESSION['text'] = "Please try again.";
	      $_SESSION['status'] = "error";
		  header("Location: users.php");
		} else {
			$save = mysqli_query($conn, "INSERT INTO users (username, firstname, middlename, lastname, suffix, contact, email, password, user_type, date_registered) VALUES ('$username', '$firstname', '$middlename', '$lastname', '$suffix', '$contact', '$email', '$password', '$user_type', '$date_registered')");
	        if($save) {
		      	$_SESSION['message'] = "System user has been saved!";
		        $_SESSION['text'] = "Saved successfully!";
		        $_SESSION['status'] = "success";
				header("Location: users.php");
	        } else {
		        $_SESSION['message'] = "Something went wrong while saving the information.";
		        $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: users.php");
	        }
		}

	}


	// SAVE RESIDENT - RESIDENT_ADD.PHP
	if(isset($_POST['create_resident'])) {
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		$age              = mysqli_real_escape_string($conn, $_POST['age']);
		$birthplace       = mysqli_real_escape_string($conn, $_POST['birthplace']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$civilstatus      = mysqli_real_escape_string($conn, $_POST['civilstatus']);
		$citizenship      = mysqli_real_escape_string($conn, $_POST['citizenship']);
		$occupation       = mysqli_real_escape_string($conn, $_POST['occupation']);
		$religion		  = mysqli_real_escape_string($conn, $_POST['religion']);
		$contact	      = mysqli_real_escape_string($conn, $_POST['contact']);
		$house_no         = mysqli_real_escape_string($conn, $_POST['house_no']);
		$street_name      = mysqli_real_escape_string($conn, $_POST['street_name']);
		$purok            = mysqli_real_escape_string($conn, $_POST['purok']);
		$barangay         = mysqli_real_escape_string($conn, $_POST['barangay']);
		$municipality     = mysqli_real_escape_string($conn, $_POST['municipality']);
		$province         = mysqli_real_escape_string($conn, $_POST['province']);
		$region           = mysqli_real_escape_string($conn, $_POST['region']);
		$familyIndicator  = mysqli_real_escape_string($conn, $_POST['familyIndicator']);
		$headName 	      = mysqli_real_escape_string($conn, $_POST['headName'] ?? '');
		$familyRole       = mysqli_real_escape_string($conn, $_POST['familyRole'] ?? '');
		$sector           = mysqli_real_escape_string($conn, $_POST['sector'] ?? '');
		$resident_status  = mysqli_real_escape_string($conn, $_POST['resident_status'] ?? '');
		$voter_status     = mysqli_real_escape_string($conn, $_POST['voter_status'] ?? '');
		$ID_status        = mysqli_real_escape_string($conn, $_POST['ID_status'] ?? '');
		$QR_status        = mysqli_real_escape_string($conn, $_POST['QR_status'] ?? '');
		$months_of_stay   = mysqli_real_escape_string($conn, $_POST['months_of_stay'] ?? '');
		$years_of_stay    = mysqli_real_escape_string($conn, $_POST['years_of_stay'] ?? '');
		$added_By		  = mysqli_real_escape_string($conn, $_POST['added_By']);	  
		$date_registered  = date('Y-m-d');


		// SAVING QR CODES**********************************************************************
		$bms = 'BMS-';
    	$residentCode = $bms.uniqid();

    	// $residentCode = $firstname. ' ' .$middlename. ' ' .$lastname. ' ' .$suffix;

	    $path = '../images-qr-codes/';
	    $qr_image = $path.uniqid().".png";

	    $ecc = 'L';
	    $pixel_Size = 10;
	    $frame_Size = 10;
	    QRcode::png($residentCode,$qr_image,$ecc,$pixel_Size,$frame_Size);
	    // *************************************************************************************

		$ageClassification = "";

		preg_match('/\d+/', $age, $matches); 
		$ageNum = isset($matches[0]) ? (int)$matches[0] : 0;

		if (strpos($age, 'day') !== false || strpos($age, 'week') !== false || strpos($age, 'month') !== false || $ageNum <= 4) {
		    echo $ageClassification = "Toddler";
		} elseif ($ageNum >= 5 && $ageNum <= 11) {
		    echo $ageClassification = "Child";
		} elseif ($ageNum >= 12 && $ageNum <= 17) {
		    echo $ageClassification = "Teen";
		} elseif ($ageNum >= 18 && $ageNum <= 24) {
		    echo $ageClassification = "Young";
		} elseif ($ageNum >= 25 && $ageNum <= 59) {
		    echo $ageClassification = "Adult";
		} else {
		    echo $ageClassification = "Senior";
		}

		$file = "";
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
            $profileFile = $_FILES['fileToUpload'];
            $timestamp = time();
            $certificate_extension = pathinfo($profileFile['name'], PATHINFO_EXTENSION);
            $file = $timestamp . '_profile.' . $certificate_extension;

            $allowed_certificate_types = array('image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            if (!in_array($profileFile['type'], $allowed_certificate_types)) {
                $response['message'] = "Only JPG, JPEG, PNG, GIF, PDF, and DOCX files are allowed for the profile.";
                echo json_encode($response);
                exit;
            }

            if ($profileFile['size'] > 500000) { // 2 MB (in bytes)
                $response['message'] = "Profile size exceeds the limit (2 MB).";
                echo json_encode($response);
                exit;
            }

            $certificate_destination = '../images-residence/' . $file;
            if (!move_uploaded_file($profileFile['tmp_name'], $certificate_destination)) {
                $response['message'] = "Failed to upload the profile file.";
                echo json_encode($response);
                exit;
            }
        }

        $signature = "";
		if (isset($_FILES['signature']) && $_FILES['signature']['error'] === UPLOAD_ERR_OK) {
		    $signatureFile = $_FILES['signature']; 
		    $timestamp = time();
		    $certificate_extension = pathinfo($signatureFile['name'], PATHINFO_EXTENSION);
		    $signature = $timestamp . '_signature.' . $certificate_extension;

		    $allowed_certificate_types = array(
		        'image/jpeg', 'image/png', 'image/gif',
		        'application/pdf',
		        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
		    );

		    if (!in_array($signatureFile['type'], $allowed_certificate_types)) {
		        $response['message'] = "Only JPG, JPEG, PNG, GIF, PDF, and DOCX files are allowed for the signature.";
		        echo json_encode($response);
		        exit;
		    }

		    if ($signatureFile['size'] > 500000) {
		        $response['message'] = "Signature file size exceeds the limit (2 MB).";
		        echo json_encode($response);
		        exit;
		    }

		    $certificate_destination = '../images-signature/' . $signature;
		    if (!move_uploaded_file($signatureFile['tmp_name'], $certificate_destination)) {
		        $response['message'] = "Failed to upload the signature file.";
		        echo json_encode($response);
		        exit;
		    }
		}


        $certificate = "";
        if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] === UPLOAD_ERR_OK) {
            $certificateFile = $_FILES['certificate'];
            $timestamp = time();
            $certificate_extension = pathinfo($certificateFile['name'], PATHINFO_EXTENSION);
            $certificate = $timestamp . '_profile.' . $certificate_extension;

            $allowed_certificate_types = array('image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            if (!in_array($certificateFile['type'], $allowed_certificate_types)) {
                $response['message'] = "Only JPG, JPEG, PNG, GIF, PDF, and DOCX files are allowed for the certificate.";
                echo json_encode($response);
                exit;
            }

            if ($certificateFile['size'] > 500000) { // 2 MB (in bytes)
                $response['message'] = "Certificate file size exceeds the limit (2 MB).";
                echo json_encode($response);
                exit;
            }

            $certificate_destination = '../images-certificates/' . $certificate;
            if (!move_uploaded_file($certificateFile['tmp_name'], $certificate_destination)) {
                $response['message'] = "Failed to upload the certificate file.";
                echo json_encode($response);
                exit;
            }
        }


		$save = mysqli_query($conn, "INSERT INTO residence (firstname, middlename, lastname, suffix, dob, age, ageClassification, birthplace, gender, civilstatus, citizenship, occupation, religion, contact, house_no, street_name, purok, zone, barangay, municipality, province, region, familyIndicator, headName, familyRole, sector, resident_status, voter_status, ID_status, QR_status, months_of_stay, years_of_stay, image, digital_signature, personalDocuments, qrCode, residentCode, added_By, date_registered) VALUES ('$firstname', '$middlename', '$lastname', '$suffix', '$dob', '$age', '$ageClassification', '$birthplace',  '$gender', '$civilstatus', '$citizenship', '$occupation', '$religion', '$contact', '$house_no', '$street_name', '$purok', '$zone', '$barangay', '$municipality', '$province', '$region', '$familyIndicator', '$headName', '$familyRole', '$sector', '$resident_status', '$voter_status', '$ID_status', '$QR_status', '$months_of_stay', '$years_of_stay', '$file', '$signature', '$certificate', '$qr_image', '$residentCode', '$added_By', '$date_registered')");

  	    if($save) {
          	$_SESSION['message'] = "Accused person information has been saved!";
            $_SESSION['text'] = "Saved successfully!";
	        $_SESSION['status'] = "success";
			header("Location: resident_add.php");
        } else {
            $_SESSION['message'] = "Something went wrong while saving the information.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: resident_add.php");
        }

	}


	// SAVE OFFICIAL - OFFICIAL_ADD.PHP
	if(isset($_POST['create_official'])) {
	
		$position        = mysqli_real_escape_string($conn, $_POST['position']);
		$firstname	     = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename      = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname        = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix          = mysqli_real_escape_string($conn, $_POST['suffix']);
		$description     = mysqli_real_escape_string($conn, $_POST['description']);
		$file            = basename($_FILES["fileToUpload"]["name"]);
		$date_registered = date('Y-m-d');

		$cap = mysqli_query($conn, "SELECT * FROM officials WHERE position='Barangay Captain' && position='$position'");
		if(mysqli_num_rows($cap) > 0) {
		  $_SESSION['message'] = "Barangay Captain position already exists.";
	      $_SESSION['text'] = "Please try again.";
	      $_SESSION['status'] = "error";
		  header("Location: officials.php");
		} else {

			$check = mysqli_query($conn, "SELECT * FROM officials WHERE firstname='$firstname' AND middlename='$middlename' AND lastname='$lastname' AND suffix='$suffix' AND position='$position' ");
			if(mysqli_num_rows($check)>0) {
		      $_SESSION['message'] = "This person is already added as an official.";
		      $_SESSION['text'] = "Please try again.";
		      $_SESSION['status'] = "error";
			  header("Location: officials.php");
			} else {
			    // Check if image file is a actual image or fake image
			    $sign_target_dir = "../images-signature/";
			    $sign_target_file = $sign_target_dir . basename($_FILES["fileToUpload"]["name"]);
			    $sign_uploadOk = 1;
			    $sign_imageFileType = strtolower(pathinfo($sign_target_file,PATHINFO_EXTENSION));

			    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check == false) {
				    $_SESSION['message']  = "Signature file is not an image.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: officials.php");
			    	$uploadOk = 0;
			    } 

				// Check file size // 500KB max size
				elseif ($_FILES["fileToUpload"]["size"] > 500000) {
				  	$_SESSION['message']  = "File must be up to 500KB in size.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: officials.php");
			    	$uploadOk = 0;
				}

			    // Allow certain file formats
			    elseif($sign_imageFileType != "jpg" && $sign_imageFileType != "png" && $sign_imageFileType != "jpeg" && $sign_imageFileType != "gif" ) {
				    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: officials.php");
				    $sign_uploadOk = 0;
			    }

			    // Check if $sign_uploadOk is set to 0 by an error
			    elseif ($sign_uploadOk == 0) {
				    $_SESSION['message'] = "Your file was not uploaded.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: officials.php");

			    // if everything is ok, try to upload file
			    } else {

		    		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $sign_target_file)) {
	    				  $save = mysqli_query($conn, "INSERT INTO officials (firstname, middlename, lastname, suffix, position, description, digital_signature, date_registered) VALUES ('$firstname', '$middlename', '$lastname', '$suffix', '$position', '$description', '$file', '$date_registered')");
					      if($save) {
					      	$_SESSION['message'] = "Barangay Official has been saved!";
					        $_SESSION['text'] = "Saved successfully!";
					        $_SESSION['status'] = "success";
							header("Location: officials.php");
					      } else {
					        $_SESSION['message'] = "Something went wrong while saving the information.";
					        $_SESSION['text'] = "Please try again.";
					        $_SESSION['status'] = "error";
							header("Location: officials.php");
					      }  
		    		} else {
	    				$_SESSION['message'] = "There was an error uploading your digital signature.";
		            	$_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: officials.php");
		    		}
			    }
			}
		}

	}


	// SAVE CUSTOMIZATION - CUSTOMIZATION_ADD.PHP
	if(isset($_POST['create_customization'])) {
		$file            = basename($_FILES["fileToUpload"]["name"]);
		$date_registered = date('Y-m-d');

		$count = mysqli_query($conn, "SELECT COUNT(customID) AS countID FROM customization");
		$row = mysqli_fetch_array($count);
		if($row['countID'] == 6) {
			$_SESSION['message'] = "Maximum number of customization have been reached.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: customize.php");
		} else {
			$exist = mysqli_query($conn, "SELECT * FROM customization WHERE picture='$file'");
			if(mysqli_num_rows($exist) > 0) {
				$_SESSION['message'] = "Image already exists in the database.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: customize.php");
			} else {
				// Check if image file is a actual image or fake image
			    $sign_target_dir = "../images-customization/";
			    $sign_target_file = $sign_target_dir . basename($_FILES["fileToUpload"]["name"]);
			    $sign_uploadOk = 1;
			    $sign_imageFileType = strtolower(pathinfo($sign_target_file,PATHINFO_EXTENSION));

			    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check == false) {
				    $_SESSION['message']  = "File is not an image.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: customize.php");
			    	$uploadOk = 0;
			    } 

				// Check file size // 500KB max size
				elseif ($_FILES["fileToUpload"]["size"] > 500000) {
				  	$_SESSION['message']  = "File must be up to 500KB in size.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: customize.php");
			    	$uploadOk = 0;
				}

			    // Allow certain file formats
			    elseif($sign_imageFileType != "jpg" && $sign_imageFileType != "png" && $sign_imageFileType != "jpeg" && $sign_imageFileType != "gif" ) {
				    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: customize.php");
				    $sign_uploadOk = 0;
			    }

			    // Check if $sign_uploadOk is set to 0 by an error
			    elseif ($sign_uploadOk == 0) {
				    $_SESSION['message'] = "Your file was not uploaded.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: customize.php");

			    // if everything is ok, try to upload file
			    } else {

		    		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $sign_target_file)) {
						  $save = mysqli_query($conn, "INSERT INTO customization (picture, date_added) VALUES ('$file', '$date_registered')");
					      if($save) {
					      	$_SESSION['message'] = "Image has been saved.";
					        $_SESSION['text'] = "Saved successfully!";
					        $_SESSION['status'] = "success";
							header("Location: customize.php");
					      } else {
					        $_SESSION['message'] = "Something went wrong while saving the information.";
					        $_SESSION['text'] = "Please try again.";
					        $_SESSION['status'] = "error";
							header("Location: customize.php");
					      }  
		    		} else {
						$_SESSION['message'] = "There was an error uploading your digital signature.";
		            	$_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: customize.php");
		    		}
			    }
			}
		}	
		
	}


	// ACQUIRE INDIGENCY - DOCUMENT_REQUIREMENTS.PHP
	if(isset($_POST['acquire_Indigency'])) {

		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$type          = 'Barangay Indigency';
		$residenceId   = mysqli_real_escape_string($conn, $_POST['residenceId']);
		$purpose       = mysqli_real_escape_string($conn, $_POST['purpose']);
		$paidAmount    = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM residence WHERE residenceId='$residenceId'");
		$row = mysqli_fetch_array($fetch);
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

		$save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		  if($save) {

			  $save2 = mysqli_query($conn, "INSERT INTO income (paid_by, paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$name', '$type', '$purpose', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired') ");
		  	  if($save2) {
				header('Location: cert_brgyIndigency.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
			  } else {
			    $_SESSION['message'] = "Something went wrong while saving the information.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: documents_requirements.php?page=indigency");
			  }  
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: documents_requirements.php?page=indigency");
		  } 

		// ORIGINAL CODE WHEN *INCOME TABLE* HAS NOT BEEN CREATED YET
		// $type          = 'Barangay Indigency';
		// $residenceId   = $_POST['residenceId'];
		// $purpose       = $_POST['purpose'];
		// $paidAmount    = $_POST['paidAmount'];
		// $date_acquired = date('Y-m-d');
		// $save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		//   if($save) {
		// 	header('Location: cert_brgyIndigency.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
		//   } else {
		//     $_SESSION['message'] = "Something went wrong while saving the information.";
		//     $_SESSION['text'] = "Please try again.";
		//     $_SESSION['status'] = "error";
		// 	header("Location: documents_requirements.php?page=indigency");
		//   }   
		// ORIGINAL CODE WHEN *INCOME TABLE* HAS NOT BEEN CREATED YET
	}

	// ACQUIRE RESIDENCY - DOCUMENT_REQUIREMENTS.PHP
	if(isset($_POST['acquire_Residency'])) {

		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$type          = 'Barangay Residency';
		$residenceId   = mysqli_real_escape_string($conn, $_POST['residenceId']);
		$purpose       = mysqli_real_escape_string($conn, $_POST['purpose']);
		$paidAmount    = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM residence WHERE residenceId='$residenceId'");
		$row = mysqli_fetch_array($fetch);
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

		$save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		  if($save) {
		  	  $save2 = mysqli_query($conn, "INSERT INTO income (paid_by, paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$name', '$type', '$purpose', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired') ");
		  	  if($save2) {
				header('Location: cert_brgyResidency.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
			  } else {
			    $_SESSION['message'] = "Something went wrong while saving the information.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: documents_requirements.php?page=Residency");
			  } 
			
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: documents_requirements.php?page=Residency");
		  } 

		// ORIGINAL CODE WHEN *INCOME TABLE* HAS NOT BEEN CREATED YET
	    // $type          = 'Barangay Residency';
		// $residenceId   = $_POST['residenceId'];
		// $purpose       = $_POST['purpose'];
		// $paidAmount    = $_POST['paidAmount'];
		// $date_acquired = date('Y-m-d');
		// $save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		//   if($save) {
		// 	header('Location: cert_brgyResidency.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
		//   } else {
		//     $_SESSION['message'] = "Something went wrong while saving the information.";
		//     $_SESSION['text'] = "Please try again.";
		//     $_SESSION['status'] = "error";
		// 	header("Location: documents_requirements.php?page=Residency");
		//   }  
		// ORIGINAL CODE WHEN *INCOME TABLE* HAS NOT BEEN CREATED YET
	}


	// ACQUIRE JOB SEEKER CERT. - DOCUMENT_REQUIREMENTS.PHP
	if(isset($_POST['acquire_Job'])) {

		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$type          = 'First Time Job Seeker';
		$residenceId   = mysqli_real_escape_string($conn, $_POST['residenceId']);
		$purpose       = 'Get First Time Job Seeker Certificate';
		$paidAmount    = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM residence WHERE residenceId='$residenceId'");
		$row = mysqli_fetch_array($fetch);
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

		$save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		  if($save) {
	  		  $save2 = mysqli_query($conn, "INSERT INTO income (paid_by, paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$name', '$type', '$purpose', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired') ");
		  	  if($save2) {
				header('Location: cert_brgyJobseeker.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
			  } else {
			    $_SESSION['message'] = "Something went wrong while saving the information.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: documents_requirements.php?page=JobSeeker");
			  } 
			
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: documents_requirements.php?page=JobSeeker");
		  }  
		// ORIGINAL CODE WHEN *INCOME TABLE* HAS NOT BEEN CREATED YET
		// $type          = 'First Time Job Seeker';
		// $residenceId   = $_POST['residenceId'];
		// $purpose       = 'Get First Time Job Seeker Certificate';
		// $paidAmount    = $_POST['paidAmount'];
		// $date_acquired = date('Y-m-d');
		// $save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		//   if($save) {
		// 	header('Location: cert_brgyJobseeker.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
		//   } else {
		//     $_SESSION['message'] = "Something went wrong while saving the information.";
		//     $_SESSION['text'] = "Please try again.";
		//     $_SESSION['status'] = "error";
		// 	header("Location: documents_requirements.php?page=JobSeeker");
		//   } 
		// ORIGINAL CODE WHEN *INCOME TABLE* HAS NOT BEEN CREATED YET
	}


	// ACQUIRE NON-RESIDENCY CERT. - DOCUMENT_REQUIREMENTS.PHP
	if(isset($_POST['acquire_NonResident'])) {

		$adminId	     = mysqli_real_escape_string($conn, $_POST['adminId']);
		$type            = 'Brgy. Non-Residency';
		$nonresidentname = mysqli_real_escape_string($conn, $_POST['nonresidentname']);
		$address    	 = mysqli_real_escape_string($conn, $_POST['address']);
		$purpose         = 'Get Brgy. Non-Residency';
		$paidAmount      = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired   = date('Y-m-d');
		$save = mysqli_query($conn, "INSERT INTO documents (doc_type, NonResident, NonResident__Address, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$nonresidentname', '$address', '$purpose', '$paidAmount', '$date_acquired')");

		  if($save) {
		  	$save2 = mysqli_query($conn, "INSERT INTO income (paid_by, paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$nonresidentname', '$type', '$purpose', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired') ");
		  	  if($save2) {
				header('Location: cert_brgyNon-Residency.php?nonresidentname='.$nonresidentname.'&&purpose='.$purpose.'&&date='.$date_acquired.'&&address='.$address.'');
			  } else {
			    $_SESSION['message'] = "Something went wrong while saving the information.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: documents_requirements.php?page=NonResidency");
			  } 
			
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: documents_requirements.php?page=NonResidency");
		  }  

		// ORIGINAL CODE WHEN *INCOME TABLE* HAS NOT BEEN CREATED YET
	    // $type            = 'Brgy. Non-Residency';
		// $nonresidentname = $_POST['nonresidentname'];
		// $address    	 = $_POST['address'];
		// $purpose         = 'Get Brgy. Non-Residency';
		// $paidAmount      = $_POST['paidAmount'];
		// $date_acquired   = date('Y-m-d');
		// $save = mysqli_query($conn, "INSERT INTO documents (doc_type, NonResident, NonResident__Address, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$nonresidentname', '$address', '$purpose', '$paidAmount', '$date_acquired')");

		//   if($save) {
		// 	header('Location: cert_brgyNon-Residency.php?nonresidentname='.$nonresidentname.'&&purpose='.$purpose.'&&date='.$date_acquired.'&&address='.$address.'');
		//   } else {
		//     $_SESSION['message'] = "Something went wrong while saving the information.";
		//     $_SESSION['text'] = "Please try again.";
		//     $_SESSION['status'] = "error";
		// 	header("Location: documents_requirements.php?page=NonResidency");
		//   } 
		// ORIGINAL CODE WHEN *INCOME TABLE* HAS NOT BEEN CREATED YET
	}


	// ACQUIRE BRGY. CLEARANCE - DOCUMENT_REQUIREMENTS.PHP
	if(isset($_POST['acquire_BrgyClearance'])) {

		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$type          = 'Barangay Clearance';
		$residenceId   = mysqli_real_escape_string($conn, $_POST['residenceId']);
		$purpose       = mysqli_real_escape_string($conn, $_POST['purpose']);
		$paidAmount    = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM residence WHERE residenceId='$residenceId'");
		$row = mysqli_fetch_array($fetch);
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

		$save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		  if($save) {
		  	$save2 = mysqli_query($conn, "INSERT INTO income (paid_by, paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$name', '$type', '$purpose', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired') ");
		  	  if($save2) {
				header('Location: cert_brgyClearance.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
			  } else {
			    $_SESSION['message'] = "Something went wrong while saving the information.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: documents_requirements.php?page=BarangayClearance");
			  } 
			
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: documents_requirements.php?page=BarangayClearance");
		  } 

		// ORIGINAL CODE WHEN *INCOME TABLE* HAS NOT BEEN CREATED YET
		// $type            = 'Barangay Clearance';
		// $residenceId     = $_POST['residenceId'];
		// $purpose         = 'Get Barangay Clearance';
		// $paidAmount      = $_POST['paidAmount'];
		// $date_acquired   = date('Y-m-d');
		// $save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		//   if($save) {
		// 	header('Location: cert_brgyClearance.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
		//   } else {
		//     $_SESSION['message'] = "Something went wrong while saving the information.";
		//     $_SESSION['text'] = "Please try again.";
		//     $_SESSION['status'] = "error";
		// 	header("Location: documents_requirements.php?page=BarangayClearance");
		//   }  
		// ORIGINAL CODE WHEN *INCOME TABLE* HAS NOT BEEN CREATED YET
	}


	// ACQUIRE BRGY. OWNERSHIP - DOCUMENT_REQUIREMENTS.PHP
	if(isset($_POST['acquire_BrgyOwnership'])) {

		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$type          = 'Barangay Ownership';
		$residenceId   = mysqli_real_escape_string($conn, $_POST['residenceId']);
		$purpose       = 'Get Brgy. Ownership Certificate';
		$paidAmount    = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM residence WHERE residenceId='$residenceId'");
		$row = mysqli_fetch_array($fetch);
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

		$save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		  if($save) {
		  	$save2 = mysqli_query($conn, "INSERT INTO income (paid_by, paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$name', '$type', '$purpose', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired') ");
		  	  if($save2) {
				header('Location: cert_brgyOwnership.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
			  } else {
			    $_SESSION['message'] = "Something went wrong while saving the information.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: documents_requirements.php?page=BarangayOwnership");
			  } 
			
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: documents_requirements.php?page=BarangayOwnership");
		  } 
	}


	// ACQUIRE BRGY. PLATE - DOCUMENT_REQUIREMENTS.PHP
	if(isset($_POST['acquire_BrgyPlate'])) {

		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$type          = 'Barangay Plate';
		$residenceId   = mysqli_real_escape_string($conn, $_POST['residenceId']);
		$purpose       = 'Get Brgy. Plate Certificate';
		$paidAmount    = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM residence WHERE residenceId='$residenceId'");
		$row = mysqli_fetch_array($fetch);
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

		$save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		  if($save) {
		  	$save2 = mysqli_query($conn, "INSERT INTO income (paid_by, paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$name', '$type', '$purpose', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired') ");
		  	  if($save2) {
				header('Location: cert_brgyPlate.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
			  } else {
			    $_SESSION['message'] = "Something went wrong while saving the information.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: documents_requirements.php?page=BarangayPlate");
			  } 
			
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: documents_requirements.php?page=BarangayPlate");
		  } 
	}


	// ACQUIRE BRGY. ID - DOCUMENT_REQUIREMENTS.PHP
	if(isset($_POST['acquire_BrgyID'])) {

		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$type          = 'Barangay ID Card';
		$residenceId   = mysqli_real_escape_string($conn, $_POST['residenceId']);
		$purpose       = 'Get Brgy. ID Card';
		$IDNumber	   = mysqli_real_escape_string($conn, $_POST['IDNumber']);
		$paidAmount    = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM residence WHERE residenceId='$residenceId'");
		$row = mysqli_fetch_array($fetch);
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

		$save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, brgyIDnumber, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$IDNumber', '$paidAmount', '$date_acquired')");

		  if($save) {
		  	$save2 = mysqli_query($conn, "INSERT INTO income (paid_by, paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$name', '$type', '$purpose', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired') ");
		  	  if($save2) {
				header('Location: cert_brgyID.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&IDNumber='.$IDNumber.'&&date='.$date_acquired.'');
			  } else {
			    $_SESSION['message'] = "Something went wrong while saving the information.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: documents_requirements.php?page=BarangayID");
			  } 
			
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: documents_requirements.php?page=BarangayID");
		  } 
	}


	// ACQUIRE BRGY. BUSINESS CLEARANCE PERMIT - DOCUMENT_REQUIREMENTS.PHP
	if(isset($_POST['acquire_BrgyPermit'])) {

		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$type          = 'Barangay Permit';
		$residenceId   = mysqli_real_escape_string($conn, $_POST['residenceId']);
		$purpose       = 'Get Brgy. Business Clearance Permit';
		$tradeName     = mysqli_real_escape_string($conn, $_POST['tradeName']);
		$scopeBusiness = mysqli_real_escape_string($conn, $_POST['scopeBusiness']);
		$controlNumber = mysqli_real_escape_string($conn, $_POST['controlNumber']);
		$ORNumber      = mysqli_real_escape_string($conn, $_POST['ORNumber']);
		$paidAmount    = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM residence WHERE residenceId='$residenceId'");
		$row = mysqli_fetch_array($fetch);
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

		  $save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, tradeName, businessNature, controlNumber, ORNumber, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$tradeName', '$scopeBusiness', '$controlNumber', '$ORNumber', '$paidAmount', '$date_acquired')");

		  if($save) {
		  	$save2 = mysqli_query($conn, "INSERT INTO income (paid_by, paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$name', '$type', '$purpose', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired') ");
		  	  if($save2) {
				header('Location: cert_brgyPermit.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'&&ORNumber='.$ORNumber.'');
			  } else {
			    $_SESSION['message'] = "Something went wrong while saving the information.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: documents_requirements.php?page=permit");
			  } 
			
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: documents_requirements.php?page=permit");
		  }
	}


	// ACQUIRE BRGY. CONSTRUCTION CLEARANCE - DOCUMENT_REQUIREMENTS.PHP
	if(isset($_POST['acquire_BrgyConstruction'])) {

		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$type          = 'Barangay Construction';
		$residenceId   = mysqli_real_escape_string($conn, $_POST['residenceId']);
		$purpose       = 'Get Barangay Construction Certificate';
		$paidAmount    = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM residence WHERE residenceId='$residenceId'");
		$row = mysqli_fetch_array($fetch);
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

		$save = mysqli_query($conn, "INSERT INTO documents (doc_type, doc_residenceId, doc_purpose, doc_paidAmount, date_acquired) VALUES ('$type', '$residenceId', '$purpose', '$paidAmount', '$date_acquired')");

		  if($save) {
		  	$save2 = mysqli_query($conn, "INSERT INTO income (paid_by, paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$name', '$type', '$purpose', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired') ");
		  	  if($save2) {
				header('Location: cert_brgyConstruction.php?residenceId='.$residenceId.'&&purpose='.$purpose.'&&date='.$date_acquired.'');
			  } else {
			    $_SESSION['message'] = "Something went wrong while saving the information.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: documents_requirements.php?page=BarangayConstruction");
			  } 
			
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: documents_requirements.php?page=BarangayConstruction");
		  } 
	}


	// CREATE/SAVE ACTIVITIY - ACTIVITY_ADD.PHP
	if(isset($_POST['create_activity'])) {

		$activity       = mysqli_real_escape_string($conn, $_POST['activity']);
		$actDate        = mysqli_real_escape_string($conn, $_POST['actDate']);
		$date_acquired  = date('Y-m-d');
		$save = mysqli_query($conn, "INSERT INTO activity (actName, actDate, date_added) VALUES ('$activity', '$actDate', '$date_acquired')");

		  if($save) {
		  	$_SESSION['message'] = "New activity has been added.";
		    $_SESSION['text'] = "Saved successfully!";
		    $_SESSION['status'] = "success";
			header("Location: dashboard.php?#activity");
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: dashboard.php?#activity");
		  }
	}


	// SAVE NEW INCOME - BRGYINCOME_ADD.PHP
	if(isset($_POST['new_income'])) {
		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$paymentType       = mysqli_real_escape_string($conn, $_POST['paymentType']);
		$description        = mysqli_real_escape_string($conn, $_POST['description']);
		$paidAmount        = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired  = date('Y-m-d');
		$save = mysqli_query($conn, "INSERT INTO income (paymentFor, paymentDesc, paymentAmount, date_paid, added_by, date_added) VALUES ('$paymentType', '$description', '$paidAmount', '$date_acquired', '$adminId', '$date_acquired')");

		  if($save) {
		  	$_SESSION['message'] = "New income record has been added.";
		    $_SESSION['text'] = "Saved successfully!";
		    $_SESSION['status'] = "success";
			header("Location: brgyIncome_Add.php?page=newIncome");
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: brgyIncome_Add.php?page=newIncome");
		  }
	}


	// CONTACT EMAIL MESSAGING - CONTACT-US.PHP
	if(isset($_POST['sendEmail'])) {

		$name    = mysqli_real_escape_string($conn, $_POST['name']);
		$email	 = mysqli_real_escape_string($conn, $_POST['email']);
		$subject = mysqli_real_escape_string($conn, $_POST['subject']);
		$msg     = mysqli_real_escape_string($conn, $_POST['message']);

	    $message = '<h3>'.$subject.'</h3>
			<p>
				Good day!<br>
				'.$msg.'
			</p>
			<p>
				Name of Sender: '.$name.'<br>
				Email: '.$email.'
			</p>
			<p><b>Note:</b> This is a system generated email please do not reply.</p>';
			//Load composer's autoloader

	    $mail = new PHPMailer(true);                            
	    try {
	        //Server settings
	        $mail->isSMTP();                                     
	        $mail->Host = 'smtp.gmail.com';                      
	        $mail->SMTPAuth = true;                             
	        $mail->Username = 'pomsystem0108@gmail.com';     
			$mail->Password = 'hvuhdxtotwhlsbpp';                
	        $mail->SMTPOptions = array(
	            'ssl' => array(
	            'verify_peer' => false,
	            'verify_peer_name' => false,
	            'allow_self_signed' => true
	            )
	        );                         
	        $mail->SMTPSecure = 'ssl';                           
	        $mail->Port = 465;                                   

	        //Send Email
	        $mail->setFrom('pomsystem0108@gmail.com');
	        
	        //Recipients
	        $mail->addAddress('pomsystem0108@gmail.com');              
	        $mail->addReplyTo('pomsystem0108@gmail.com');
	        
	        //Content
	        $mail->isHTML(true);                                  
	        $mail->Subject = $subject;
	        $mail->Body    = $message;

	        $mail->send();
			$_SESSION['success'] = "Email sent successfully!";
			header("Location: contact-us.php");

	    } catch (Exception $e) {
	    	$_SESSION['success'] = "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;
			header("Location: contact-us.php");
	    }
	}


	$output = '';
	 if(isset($_POST['export_excel_btn'])) {
	 	$select = mysqli_query($conn, "SELECT * FROM residence");
	 	if(mysqli_num_rows($select) > 0) {
	 		$output .= '
	 			<table class="table" bordered="1">
	                  <tr> 
	                    <th>NAME</th>
	                    <th>GENDER</th>
	                    <th>SECTOR</th>
	                    <th>CITIZENSHIP</th>
	                    <th>RESIDENT STATUS</th>
	                  </tr>
	 		';
	 		while ($row = mysqli_fetch_array($select)) {
	 				$output .= '
	 					<tr>
		                    <td>'.$row["firstname"].'</td>
		                    <td>'.$row["gender"].'</td>
		                    <td>'.$row["sector"].'</td>
		                    <td>'.$row["citizenship"].'</td>
		                    <td>'.$row["resident_status"].'</td>
	                    </tr>
	 				';
	 		}
	 		$output .= '</table>';
	 		header("Content-Type: application/xls");
	 		header("Content-Disposition:attachment; filename=download.csv");
	 		echo $output;
	 	}
	 }


	// CREATE/SAVE BLOTTER - BLOTTER_ADD.PHP
	if(isset($_POST['create_blotter'])) {
		$added_by            = mysqli_real_escape_string($conn, $_POST['added_by']);
		$c_firstname         = mysqli_real_escape_string($conn, $_POST['c_firstname']);
		$c_middlename        = mysqli_real_escape_string($conn, $_POST['c_middlename']);
		$c_lastname          = mysqli_real_escape_string($conn, $_POST['c_lastname']);
		$c_suffix            = mysqli_real_escape_string($conn, $_POST['c_suffix']);
		$c_contact           = mysqli_real_escape_string($conn, $_POST['c_contact']);
		$c_address           = mysqli_real_escape_string($conn, $_POST['c_address']);
		$incidentDate        = mysqli_real_escape_string($conn, $_POST['incidentDate']);
		$incidentTime        = mysqli_real_escape_string($conn, $_POST['incidentTime']);
		$incidentNature      = mysqli_real_escape_string($conn, $_POST['incidentNature']);
		$incidentAddress     = mysqli_real_escape_string($conn, $_POST['incidentAddress']);
		$acc_firstname       = mysqli_real_escape_string($conn, $_POST['acc_firstname']);
		$acc_middlename      = mysqli_real_escape_string($conn, $_POST['acc_middlename']);
		$acc_lastname        = mysqli_real_escape_string($conn, $_POST['acc_lastname']);
		$acc_suffix          = mysqli_real_escape_string($conn, $_POST['acc_suffix']);
		$acc_contact         = mysqli_real_escape_string($conn, $_POST['acc_contact']);
		$acc_address         = mysqli_real_escape_string($conn, $_POST['acc_address']);
		$witnesses           = mysqli_real_escape_string($conn, $_POST['witnesses']);
		$witnessesContact    = mysqli_real_escape_string($conn, $_POST['witnessesContact']);
		$incidentDescription = mysqli_real_escape_string($conn, $_POST['incidentDescription']);
		$actionTaken         = mysqli_real_escape_string($conn, $_POST['actionTaken']);
		
		$file_name = $_FILES["fileToUpload"]["name"];
		$location  = "../images-blotter/";
		$image_name = implode(",",$file_name);

		if(!empty($file_name)) {
			foreach ($file_name as $key => $val) {
				$targetPath = $location .$val;
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key],$targetPath);
			}
		}

		// GENERATE CASE NUMBER
		$currentYear = date("Y");
		$latest = mysqli_query($conn, "SELECT case_no FROM blotter WHERE case_no LIKE 'BLTR-$currentYear-%' ORDER BY case_no DESC LIMIT 1");

		if (mysqli_num_rows($latest) > 0) {
		    $row = mysqli_fetch_assoc($latest);
		    $lastCaseNo = $row['case_no'];

		    $lastNumber = (int)substr($lastCaseNo, -4);
		    $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
		} else {
		    $newNumber = "0001";
		}

		$case_no = "BLTR-$currentYear-$newNumber";


		$save = mysqli_query($conn, "INSERT INTO blotter (case_no, added_by, c_firstname, c_middlename, c_lastname, c_suffix, c_contact, c_address, incidentDate, incidentTime, incidentNature, incidentAddress, acc_firstname, acc_middlename, acc_lastname, acc_suffix, acc_contact, acc_address, witnesses, witnessesContact, incidentDescription, actionTaken, attachments, date_added) VALUES ('$case_no', '$added_by', '$c_firstname', '$c_middlename', '$c_lastname', '$c_suffix', '$c_contact', '$c_address', '$incidentDate', '$incidentTime', '$incidentNature', '$incidentAddress', '$acc_firstname', '$acc_middlename', '$acc_lastname', '$acc_suffix', '$acc_contact', '$acc_address', '$witnesses', '$witnessesContact', '$incidentDescription', '$actionTaken', '$image_name' ,NOW())");
		
		  if($save) {

		  	// Compose the SMS message
			$message = "Good day, Mr./Ms. $c_lastname,\n\n"
			         . "This is to inform you that your blotter report has been successfully filed.\n\n"
			         . "Details:\n"
			         . "• Case No.: $case_no\n"
			         . "• Complainant: $c_firstname $c_middlename $c_lastname $c_suffix\n"
			         . "• Nature of Incident: $incidentNature\n"
			         . "• Date and Time: $incidentDate at $incidentTime\n"
			         . "• Location: $incidentAddress\n"
			         . "• Accused: $acc_firstname $acc_middlename $acc_lastname $acc_suffix\n"
			         . "• Witnesses: $witnesses (0$witnessesContact)\n"
			         . "• Description: $incidentDescription\n"
			         . "• Action Taken: $actionTaken\n\n"
			         . "If you have any further concerns or updates, please do not hesitate to contact our office.\n\n"
			         . "Thank you,\n"
			         . "Barangay Office";

	        // Send the SMS
	        sendSms($c_contact, $message);

		  	$_SESSION['message'] = "New blotter has been added.";
		    $_SESSION['text'] = "Saved successfully!";
		    $_SESSION['status'] = "success";
			header("Location: blotter.php");
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: blotter.php");
		  }
	}


?>



