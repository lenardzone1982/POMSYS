<?php 
	include '../config.php';

	// UPDATE SYSTEM USER - USER_UPDATE_DELETE.PHP
	if(isset($_POST['update_system_user'])) {

		$user_Id    = $_POST['user_Id'];
		$user_type  = mysqli_real_escape_string($conn, $_POST['usertype']);
		$username   = mysqli_real_escape_string($conn, $_POST['username']);
		$firstname  = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname   = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix     = mysqli_real_escape_string($conn, $_POST['suffix']);
		$contact    = mysqli_real_escape_string($conn, $_POST['contact']);
		$email      = mysqli_real_escape_string($conn, $_POST['email']);

		$fetch        = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id' ");
		$row          = mysqli_fetch_array($fetch);
		$get_email    = $row['email'];
		$get_username = $row['username'];

		if($email == $get_email) {
			if($username == $get_username) {
				$save = mysqli_query($conn, "UPDATE users SET username='$username', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', contact='$contact', email='$email', user_type='$user_type' WHERE user_Id='$user_Id'");
			    if($save) {
			      $_SESSION['message'] = "System user has been updated!";
			      $_SESSION['text'] = "Updated successfully!";
			      $_SESSION['status'] = "success";
				  header("Location: users.php");
			    } else {
			      $_SESSION['message'] = "Something went wrong while updating the information.";
			      $_SESSION['text'] = "Please try again.";
			      $_SESSION['status'] = "error";
				  header("Location: users.php");
			    }
			} else {
				$exist = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' ");
			  	if(mysqli_num_rows($exist) > 0) {
				  	$_SESSION['message'] = "Username already exists.";
					$_SESSION['text'] = "Please try again.";
					$_SESSION['status'] = "error";
					header("Location: users.php");
			  	} else {
		  			$save = mysqli_query($conn, "UPDATE users SET username='$username', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', contact='$contact', email='$email', user_type='$user_type' WHERE user_Id='$user_Id'");
				    if($save) {
				    	$_SESSION['message'] = "System user has been updated!";
				      	$_SESSION['text'] = "Updated successfully!";
				      	$_SESSION['status'] = "success";
						header("Location: users.php");
				    } else {
				        $_SESSION['message'] = "Something went wrong while updating the information.";
				        $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: users.php");
				    }
			  	}
			}
	  } else {
			$exist = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");
		  	if(mysqli_num_rows($exist) > 0) {
	  			$_SESSION['message'] = "Email already exists.";
		      	$_SESSION['text'] = "Please try again.";
	  			$_SESSION['status'] = "error";
				header("Location: users.php");
		  	} else {
	  			if($username == $get_username) {
					$save = mysqli_query($conn, "UPDATE users SET username='$username', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', contact='$contact', email='$email', user_type='$user_type' WHERE user_Id='$user_Id'");
				    if($save) {
			    	    $_SESSION['message'] = "System user has been updated!";
				        $_SESSION['text'] = "Updated successfully!";
				        $_SESSION['status'] = "success";
						header("Location: users.php");
				    } else {
					    $_SESSION['message'] = "Something went wrong while updating the information.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: users.php");
				    }
				} else {
					$exist = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' ");
				  	if(mysqli_num_rows($exist) > 0) {
			  			  $_SESSION['message'] = "Username already exists.";
					      $_SESSION['text'] = "Please try again.";
					      $_SESSION['status'] = "error";
						  header("Location: users.php");
				  	} else {
			  			$save = mysqli_query($conn, "UPDATE users SET username='$username', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', contact='$contact', email='$email', user_type='$user_type' WHERE user_Id='$user_Id'");
					    if($save) {
				    	  $_SESSION['message'] = "System user has been updated!";
					      $_SESSION['text'] = "Updated successfully!";
					      $_SESSION['status'] = "success";
						  header("Location: users.php");
					    } else {
					      $_SESSION['message'] = "Something went wrong while updating the information.";
					      $_SESSION['text'] = "Please try again.";
					      $_SESSION['status'] = "error";
						  header("Location: users.php");
					    }
				  	}
				}
		  	}
	  }
	}

	// CHANGE SYSTEM USER PASSWORD - USER_UPDATE_DELETE.PHP
	if(isset($_POST['password_system_user'])) {

    	$user_Id     = $_POST['user_Id'];
    	$OldPassword = md5($_POST['OldPassword']);
    	$password    = md5($_POST['password']);
    	$cpassword   = md5($_POST['cpassword']);

    	$check_old_password = mysqli_query($conn, "SELECT * FROM users WHERE password='$OldPassword' AND user_Id='$user_Id'");

    	// CHECK IF THERE IS MATCHED PASSWORD IN THE DATABASE COMPARED TO THE ENTERED OLD PASSWORD
    	if(mysqli_num_rows($check_old_password) === 1 ) {
			// COMPARE BOTH NEW AND CONFIRM PASSWORD
    		if($password != $cpassword) {
				$_SESSION['message']  = "Password does not matched. Please try again";
            	$_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: users.php");
    		} else {
    			$update_password = mysqli_query($conn, "UPDATE users SET password='$password' WHERE user_Id='$user_Id' ");
    			if($update_password) {
        			$_SESSION['message'] = "Password has been changed.";
	           	    $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: users.php");
                } else {
          			$_SESSION['message'] = "Something went wrong while changing the password.";
            		$_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: users.php");
                }
    		}
    	} else {
			$_SESSION['message']  = "Old password is incorrect.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: users.php");
    	}

    }

    // UPDATE RESIDENT - RESIDENT_UPDATE.PHP
	if(isset($_POST['update_resident'])) {

		$residenceId 	  = $_POST['residenceId'];
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
		$contact 		  = mysqli_real_escape_string($conn, $_POST['contact']);
		$house_no         = mysqli_real_escape_string($conn, $_POST['house_no']);
		$street_name      = mysqli_real_escape_string($conn, $_POST['street_name']);
		$purok            = mysqli_real_escape_string($conn, $_POST['purok']);
		$zone             = mysqli_real_escape_string($conn, $_POST['zone']);
		$barangay         = mysqli_real_escape_string($conn, $_POST['barangay']);
		$municipality     = mysqli_real_escape_string($conn, $_POST['municipality']);
		$province         = mysqli_real_escape_string($conn, $_POST['province']);
		$region           = mysqli_real_escape_string($conn, $_POST['region']);
		$familyIndicator  = mysqli_real_escape_string($conn, $_POST['familyIndicator']);
		$headName 	      = mysqli_real_escape_string($conn, $_POST['headName']);
		$familyRole       = mysqli_real_escape_string($conn, $_POST['familyRole']);
		$sector           = mysqli_real_escape_string($conn, $_POST['sector']);
		$resident_status  = mysqli_real_escape_string($conn, $_POST['resident_status']);
		$voter_status     = mysqli_real_escape_string($conn, $_POST['voter_status']);
		$ID_status        = mysqli_real_escape_string($conn, $_POST['ID_status']);
		$QR_status        = mysqli_real_escape_string($conn, $_POST['QR_status']);
		$years_of_stay    = mysqli_real_escape_string($conn, $_POST['years_of_stay']);

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


		$fetchAll = mysqli_query($conn, "SELECT * FROM residence WHERE residenceId = ".$residenceId);
		$rowAll = mysqli_fetch_array($fetchAll); 

		$file = $rowAll['image'];
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

        $signature = $rowAll['digital_signature'];
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


        $certificate = $rowAll['personalDocuments'];
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


		$save3 = mysqli_query($conn, "UPDATE residence SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', ageClassification='$ageClassification', birthplace='$birthplace', gender='$gender', civilstatus = '$civilstatus', citizenship = '$citizenship', occupation = '$occupation', religion='$religion', contact='$contact', house_no = '$house_no', street_name = '$street_name', purok = '$purok', zone = '$zone', barangay = '$barangay', municipality = '$municipality', province = '$province', region = '$region', familyIndicator='$familyIndicator', headName='$headName', familyRole='$familyRole', sector = '$sector', resident_status = '$resident_status', voter_status = '$voter_status', ID_status = '$ID_status', QR_status = '$QR_status', years_of_stay = '$years_of_stay', image='$file', digital_signature='$signature', personalDocuments = '$certificate' WHERE residenceId='$residenceId'");
        if($save3) {
	            $_SESSION['message']  = "Accused person information has been updated!";
	            $_SESSION['text'] = "Updated successfully!";
		        $_SESSION['status'] = "success";
				header('Location: resident_update.php?residenceId='.$residenceId.'');                          
        } else {
	            $_SESSION['message'] = "Something went wrong while updating the information.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header('Location: resident_update.php?residenceId='.$residenceId.'');     
        }
	
	}


	// UPDATE RESIDENT DOCUMENTS - RESIDENT_DOCUMENT.PHP
	if(isset($_POST['updateDocument'])) {

		$residenceId  = $_POST['residenceId'];
		$certificate  = basename($_FILES["certificate"]["name"]);

		  // Check if image file is a actual image or fake image
		    $target_dir = "../images-certificates/";
		    $target_file = $target_dir . basename($_FILES["certificate"]["name"]);
		    $uploadOk = 1;
		    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		    $check = getimagesize($_FILES["certificate"]["tmp_name"]);
			if($check == false) {
			    $_SESSION['message']  = "Selected file is not an image.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: resident_document.php?residenceId=".$residenceId);
		    	$uploadOk = 0;
		    } 

			// Check file size // 500KB max size
			elseif ($_FILES["certificate"]["size"] > 500000) {
			  	$_SESSION['message']  = "File must be up to 500KB in size.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: resident_document.php?residenceId=".$residenceId);
		    	$uploadOk = 0;
			}

		    // Allow certain file formats
		    elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
			    $_SESSION['message']  = "Only JPG, JPEG, PNG & GIF files are allowed.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: resident_document.php?residenceId=".$residenceId);
		    	$uploadOk = 0;
		    }

		    // Check if $uploadOk is set to 0 by an error
		    elseif ($uploadOk == 0) {
			    $_SESSION['message']  = "Your file was not uploaded.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: resident_document.php?residenceId=".$residenceId);

		    // if everything is ok, try to upload file
		    } else {

		        if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $target_file)) {
		          	$save = mysqli_query($conn, "UPDATE residence SET personalDocuments	='$certificate' WHERE residenceId='$residenceId'");
		     
		            if($save) {
		            	$_SESSION['message'] = "Document has been updated!";
			            $_SESSION['text'] = "Updated successfully!";
				        $_SESSION['status'] = "success";
						header("Location: resident_document.php?residenceId=".$residenceId);
		            } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: resident_document.php?residenceId=".$residenceId);
		            }
		        } else {
		            $_SESSION['message'] = "There was an error uploading your file.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: resident_document.php?residenceId=".$residenceId);
		        }

			}
	}


	// UPDATE ADMIN INFORMATION - PROFILE.PHP
	if(isset($_POST['update_profile'])) {

		$user_Id    = $_POST['user_Id'];
		$username   = mysqli_real_escape_string($conn, $_POST['username']);
		$firstname  = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname   = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix     = mysqli_real_escape_string($conn, $_POST['suffix']);
		$contact    = mysqli_real_escape_string($conn, $_POST['contact']);
		$email      = mysqli_real_escape_string($conn, $_POST['email']);

		$fetch        = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id' ");
		$row          = mysqli_fetch_array($fetch);
		$get_email    = $row['email'];
		$get_username = $row['username'];

		if($email == $get_email) {
			if($username == $get_username) {
				$save = mysqli_query($conn, "UPDATE users SET username='$username', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', email='$email', contact='$contact' WHERE user_Id='$user_Id'");
			    if($save) {
			          $_SESSION['message']  = "Your information has been updated!";
			          $_SESSION['text'] = "Updated successfully!";
			          $_SESSION['status'] = "success";
					  header("Location: profile.php");                          
			    } else {
		            $_SESSION['message'] = "Something went wrong while saving the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: profile.php");
			    }
			} else {
				$exist = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' ");
			  	if(mysqli_num_rows($exist) > 0) {
				  	$_SESSION['message'] = "Username already exists.";
					$_SESSION['text'] = "Please try again.";
					$_SESSION['status'] = "error";
					header("Location: profile.php");
			  	} else {
		  			$save = mysqli_query($conn, "UPDATE users SET username='$username', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', email='$email', contact='$contact' WHERE user_Id='$user_Id'");
				    if($save) {
				          $_SESSION['message']  = "Your information has been updated!";
				          $_SESSION['text'] = "Updated successfully!";
				          $_SESSION['status'] = "success";
						  header("Location: profile.php");                          
				    } else {
			            $_SESSION['message'] = "Something went wrong while saving the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: profile.php");
				    }
			  	}
			}
	  } else {
			$exist = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");
		  	if(mysqli_num_rows($exist) > 0) {
	  			$_SESSION['message'] = "Email already exists.";
		      	$_SESSION['text'] = "Please try again.";
	  			$_SESSION['status'] = "error";
				header("Location: profile.php");
		  	} else {
	  			if($username == $get_username) {
					$save = mysqli_query($conn, "UPDATE users SET username='$username', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', email='$email', contact='$contact' WHERE user_Id='$user_Id'");
				    if($save) {
				          $_SESSION['message']  = "Your information has been updated!";
				          $_SESSION['text'] = "Updated successfully!";
				          $_SESSION['status'] = "success";
						  header("Location: profile.php");                          
				    } else {
			            $_SESSION['message'] = "Something went wrong while saving the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: profile.php");
				    }
				} else {
					$exist = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' ");
				  	if(mysqli_num_rows($exist) > 0) {
			  			  $_SESSION['message'] = "Username already exists.";
					      $_SESSION['text'] = "Please try again.";
					      $_SESSION['status'] = "error";
						  header("Location: profile.php");
				  	} else {
			  			$save = mysqli_query($conn, "UPDATE users SET username='$username', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', email='$email', contact='$contact' WHERE user_Id='$user_Id'");
					    if($save) {
					          $_SESSION['message']  = "Your information has been updated!";
					          $_SESSION['text'] = "Updated successfully!";
					          $_SESSION['status'] = "success";
							  header("Location: profile.php");                          
					    } else {
				            $_SESSION['message'] = "Something went wrong while saving the information.";
				            $_SESSION['text'] = "Please try again.";
					        $_SESSION['status'] = "error";
							header("Location: profile.php");
					    }
				  	}
				}
		  	}
	  }

		
	}


	// CHANGE ADMIN PASSWORD - PROFILE.PHP
	if(isset($_POST['update_password_admin'])) {

    	$user_Id    = $_POST['user_Id'];
    	$OldPassword = md5($_POST['OldPassword']);
    	$password    = md5($_POST['password']);
    	$cpassword   = md5($_POST['cpassword']);

    	$check_old_password = mysqli_query($conn, "SELECT * FROM users WHERE password='$OldPassword' AND user_Id='$user_Id'");

    	// CHECK IF THERE IS MATCHED PASSWORD IN THE DATABASE COMPARED TO THE ENTERED OLD PASSWORD
    	if(mysqli_num_rows($check_old_password) === 1 ) {
			// COMPARE BOTH NEW AND CONFIRM PASSWORD
    		if($password != $cpassword) {
				$_SESSION['message']  = "Password does not matched. Please try again";
            	$_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: profile.php");
    		} else {
    			$update_password = mysqli_query($conn, "UPDATE users SET password='$password' WHERE user_Id='$user_Id' ");
    			if($update_password) {
                	$_SESSION['message'] = "Password has been changed.";
		            $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: profile.php");
                } else {
                    $_SESSION['message'] = "Something went wrong while changing the password.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: profile.php");
                }
    		}
    	} else {
			$_SESSION['message']  = "Old password is incorrect.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: profile.php");
    	}

    }


  	// UPDATE ADMIN PROFILE - PROFILE.PHP
	if(isset($_POST['update_profile_admin'])) {

		$user_Id    = $_POST['user_Id'];
		$file       = basename($_FILES["fileToUpload"]["name"]);

		  // Check if image file is a actual image or fake image
	    $target_dir = "../images-users/";
	    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	    $uploadOk = 1;
	    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check == false) {
		    $_SESSION['message']  = "Selected file is not an image.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: profile.php");
	    	$uploadOk = 0;
	    } 

		// Check file size // 500KB max size
		elseif ($_FILES["fileToUpload"]["size"] > 500000) {
		  	$_SESSION['message']  = "File must be up to 500KB in size.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: profile.php");
	    	$uploadOk = 0;
		}

	    // Allow certain file formats
	    elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
		    $_SESSION['message']  = "Only JPG, JPEG, PNG & GIF files are allowed.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: profile.php");
	    	$uploadOk = 0;
	    }

	    // Check if $uploadOk is set to 0 by an error
	    elseif ($uploadOk == 0) {
		    $_SESSION['message']  = "Your file was not uploaded.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: profile.php");

	    // if everything is ok, try to upload file
	    } else {

	        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	          	$save = mysqli_query($conn, "UPDATE users SET image='$file' WHERE user_Id='$user_Id'");
	     
	            if($save) {
	            	$_SESSION['message'] = "Profile picture has been updated!";
		            $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: profile.php");
	            } else {
		            $_SESSION['message'] = "Something went wrong while updating the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: profile.php");
	            }
	        } else {
	            $_SESSION['message'] = "There was an error uploading your file.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: profile.php");
	        }

		}
	}


	// UPDATE OFFICIAL - OFFICIAL_UPDATE_DELETE.PHP
	if(isset($_POST['update_official'])) {
		$officialID      = mysqli_real_escape_string($conn, $_POST['officialID']);
		$position        = mysqli_real_escape_string($conn, $_POST['position']);
		$firstname	     = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename      = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname        = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix          = mysqli_real_escape_string($conn, $_POST['suffix']);
		$description     = mysqli_real_escape_string($conn, $_POST['description']);
		$file            = basename($_FILES["fileToUpload"]["name"]);

		$cap = mysqli_query($conn, "SELECT * FROM officials WHERE position='Barangay Captain' AND officialID!='$officialID'");
		if(mysqli_num_rows($cap) > 0) {
		  $_SESSION['message'] = "Barangay Captain position already exists.";
	      $_SESSION['text'] = "Please try again.";
	      $_SESSION['status'] = "error";
		  header("Location: officials.php");
		} else {

			$fetch = mysqli_query($conn, "SELECT * FROM officials WHERE officialID='$officialID' ");
			$row = mysqli_fetch_array($fetch);

			if(empty($file)) {

				if($row['firstname'] == $firstname && $row['middlename'] == $middlename && $row['lastname'] == $lastname && $row['suffix'] == $suffix && $row['position'] == $position) {
						$update = mysqli_query($conn, "UPDATE officials SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', position='$position', description='$description' WHERE officialID='$officialID' ");
						if($update) {
			            	$_SESSION['message'] = "Barangay Official has been updated!";
				            $_SESSION['text'] = "Updated successfully!";
					        $_SESSION['status'] = "success";
							header("Location: officials.php");
			            } else {
				            $_SESSION['message'] = "Something went wrong while updating the information.";
				            $_SESSION['text'] = "Please try again.";
					        $_SESSION['status'] = "error";
							header("Location: officials.php");
			            }
				} else {
					$check = mysqli_query($conn, "SELECT * FROM officials WHERE firstname='$firstname' AND middlename='$middlename' AND lastname='$lastname' AND suffix='$suffix' AND position='$position' ");
					if(mysqli_num_rows($check)>0) {
				      $_SESSION['message'] = "This person is already added as an official.";
				      $_SESSION['text'] = "Please try again.";
				      $_SESSION['status'] = "error";
					  header("Location: officials.php");
					} else {
						$update = mysqli_query($conn, "UPDATE officials SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', position='$position', description='$description' WHERE officialID='$officialID' ");
						if($update) {
			            	$_SESSION['message'] = "Barangay Official has been updated!";
				            $_SESSION['text'] = "Updated successfully!";
					        $_SESSION['status'] = "success";
							header("Location: officials.php");
			            } else {
				            $_SESSION['message'] = "Something went wrong while updating the information.";
				            $_SESSION['text'] = "Please try again.";
					        $_SESSION['status'] = "error";
							header("Location: officials.php");
			            }
					}

				}

			} else {

				if($row['firstname'] == $firstname && $row['middlename'] == $middlename && $row['lastname'] == $lastname && $row['suffix'] == $suffix && $row['position'] == $position) {
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
			    				$update = mysqli_query($conn, "UPDATE officials SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', position='$position', description='$description', digital_signature='$file' WHERE officialID='$officialID' ");
								if($update) {
					            	$_SESSION['message'] = "Barangay Official has been updated!";
						            $_SESSION['text'] = "Updated successfully!";
							        $_SESSION['status'] = "success";
									header("Location: officials.php");
					            } else {
						            $_SESSION['message'] = "Something went wrong while updating the information.";
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
						    $_SESSION['message']  = "Official signature file is not an image.";
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
			    				$update = mysqli_query($conn, "UPDATE officials SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', position='$position', description='$description', digital_signature='$file' WHERE officialID='$officialID' ");
								if($update) {
					            	$_SESSION['message'] = "Barangay Official has been updated!";
						            $_SESSION['text'] = "Updated successfully!";
							        $_SESSION['status'] = "success";
									header("Location: officials.php");
					            } else {
						            $_SESSION['message'] = "Something went wrong while updating the information.";
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
		}
	}


	// UPDATE CUSTOMIZATION - CUSTOMIZE_UPDATE_DELETE.PHP
	if(isset($_POST['update_customization'])) {
		$customID = $_POST['customID'];
		$file     = basename($_FILES["fileToUpload"]["name"]);
		
		$exist = mysqli_query($conn, "SELECT * FROM customization WHERE customID='$customID'");	
		$row = mysqli_fetch_array($exist);
		if($file == $row['picture']) {
			$_SESSION['message'] = "Image is still the same.";
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
			    $_SESSION['message']  = "Signature file is not an image.";
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
					$update = mysqli_query($conn, "UPDATE customization SET picture='$file' WHERE customID='$customID' ");
					if($update) {
			        	$_SESSION['message'] = "Image customization has been updated!";
			            $_SESSION['text'] = "Updated successfully!";
				        $_SESSION['status'] = "success";
						header("Location: customize.php");
			        } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
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


	// SET ACTIVE - CUSTOMIZE_UPDATE_DELETE.PHP
	if(isset($_POST['setActive_customization'])) {

		$customID = $_POST['customID'];

		$exist = mysqli_query($conn, "SELECT * FROM customization WHERE status='Active' ");
		
		if(mysqli_num_rows($exist) > 0) {
			$update = mysqli_query($conn, "UPDATE customization SET status='Inactive'");
			if($update) {
				$update2 = mysqli_query($conn, "UPDATE customization SET status='Active' WHERE customID='$customID'");
	        	if($update2) {
	        		$_SESSION['message'] = "Image is now Active.";
		            $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: customize.php");
				} else {
					$_SESSION['message'] = "Something went wrong while settings the image as Active.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: customize.php");
				}
	        } else {
	            $_SESSION['message'] = "Something went wrong while settings the image as Active.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: customize.php");
	        }  
		} else {
			$update2 = mysqli_query($conn, "UPDATE customization SET status='Active' WHERE customID='$customID'");
	    	if($update2) {
	    		$_SESSION['message'] = "Image is now Active.";
	            $_SESSION['text'] = "Updated successfully!";
		        $_SESSION['status'] = "success";
				header("Location: customize.php");
			} else {
				$_SESSION['message'] = "Something went wrong while settings the image as Active.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: customize.php");
			}
		}
	}


	// UPDATE ACTIVITIY - ACTIVITY_UPDATE_DELETE.PHP
	if(isset($_POST['update_activity'])) {
		$actId 			= $_POST['actId'];
		$activity       = $_POST['activity'];
		$actDate        = $_POST['actDate'];
		$date_acquired  = date('Y-m-d');
		$update = mysqli_query($conn, "UPDATE activity SET actName='$activity', actDate='$actDate' WHERE actId='$actId'");

		  if($update) {
		  	$_SESSION['message'] = "Activity has been updated.";
		    $_SESSION['text'] = "Updated successfully!";
		    $_SESSION['status'] = "success";
			header("Location: dashboard.php?#activity");
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: dashboard.php?#activity");
		  }
	}


	// UPDATE INCOME - BRGYINCOME_ADD.PHP
	if(isset($_POST['update_income'])) {
		$adminId	   = mysqli_real_escape_string($conn, $_POST['adminId']);
		$incomeId	   = mysqli_real_escape_string($conn, $_POST['incomeId']);
		$paymentType   = mysqli_real_escape_string($conn, $_POST['paymentType']);
		$description   = mysqli_real_escape_string($conn, $_POST['description']);
		$paidAmount    = mysqli_real_escape_string($conn, $_POST['paidAmount']);
		$date_acquired = date('Y-m-d');

		$update = mysqli_query($conn, "UPDATE income SET paymentFor='$paymentType', paymentDesc='$description', paymentAmount='$paidAmount', updated_by='$adminId', date_updated='$date_acquired' WHERE incomeId='$incomeId'");

		  if($update) {
		  	$_SESSION['message'] = "Income record has been updated.";
		    $_SESSION['text'] = "Saved successfully!";
		    $_SESSION['status'] = "success";
			header("Location: brgyIncome_Add.php?page=".$incomeId);
		  } else {
		    $_SESSION['message'] = "Something went wrong while saving the information.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: brgyIncome_Add.php?page=".$incomeId);
		  }
	}


	// RESET PIN - RESIDENT_DELETE.PHP
	if(isset($_POST['resetPIN'])) {
		$residenceId = mysqli_real_escape_string($conn, $_POST['residenceId']);
		$PIN	     = mysqli_real_escape_string($conn, $_POST['PIN']);
		$cPIN        = mysqli_real_escape_string($conn, $_POST['cPIN']);

		if($PIN != $cPIN) {
			$_SESSION['message'] = "PIN does not matched.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: resident.php");
		} else {
			$update = mysqli_query($conn, "UPDATE residence SET residentPIN='$PIN' WHERE residenceId='$residenceId'");
			  if($update) {
			  	$_SESSION['message'] = "PIN has been updated.";
			    $_SESSION['text'] = "Saved successfully!";
			    $_SESSION['status'] = "success";
				header("Location: resident.php");
			  } else {
			    $_SESSION['message'] = "Something went wrong while updating PIN.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: resident.php");
			  }
		}
	}


	// UPDATE BLOTTER - BLOTTER_UPDATE.PHP
	if(isset($_POST['update_blotter'])) {
			$blotter_Id          = mysqli_real_escape_string($conn, $_POST['blotter_Id']);
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
			if(!empty($file_name)) {

				$existingData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM blotter WHERE blotter_Id = '$blotter_Id'"));

				$previous_actionTaken = $existingData['actionTaken'];
				$stored_case_no = $existingData['case_no'];
				$send_sms = false;

				if (trim($actionTaken) !== trim($previous_actionTaken)) {
				    $send_sms = true;
				}

				if ($send_sms) {
				    $message = "Good day, Mr./Ms. $c_lastname,\n\n"
			             . "Please be informed that the action taken on your blotter report has been updated.\n\n"
			             . "Details:\n"
			             . "• Case No.: $stored_case_no\n"
			             . "• Complainant: $c_firstname $c_middlename $c_lastname $c_suffix\n"
			             . "• Nature of Incident: $incidentNature\n"
			             . "• Date and Time: $incidentDate at $incidentTime\n"
			             . "• Location: $incidentAddress\n"
			             . "• Accused: $acc_firstname $acc_middlename $acc_lastname $acc_suffix\n"
			             . "• Witnesses: $witnesses ($witnessesContact)\n"
			             . "• Description: $incidentDescription\n"
			             . "• Previous Action Taken: $previous_actionTaken\n"
			             . "• New Action Taken: $actionTaken\n\n"
			             . "If you have any further concerns or questions, feel free to contact our office.\n\n"
			             . "Thank you,\n"
			             . "Barangay Office";

				    sendSms($c_contact, $message);
				}


				 $updated = mysqli_query($conn, "UPDATE blotter SET c_firstname='$c_firstname', c_middlename='$c_middlename', c_lastname='$c_lastname', c_suffix='$c_suffix', c_contact='$c_contact', c_address='$c_address', incidentDate='$incidentDate', incidentTime='$incidentTime', incidentNature='$incidentNature', incidentAddress='$incidentAddress', acc_firstname='$acc_firstname', acc_middlename='$acc_middlename', acc_lastname='$acc_lastname', acc_suffix='$acc_suffix', acc_contact='$acc_contact', acc_address='$acc_address', witnesses='$witnesses', witnessesContact='$witnessesContact', incidentDescription='$incidentDescription', actionTaken='$actionTaken', attachments='$image_name' WHERE blotter_Id='$blotter_Id'");
			
				  if($updated) {
				  	$_SESSION['message'] = "Blotter has been updated.";
				    $_SESSION['text'] = "Updated successfully!";
				    $_SESSION['status'] = "success";
					header("Location: blotter_update.php?blotter_Id=".$blotter_Id);
				  } else {
				    $_SESSION['message'] = "Something went wrong while updating the information.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: blotter_update.php?blotter_Id=".$blotter_Id);
				  }
			} else {

				$existingData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM blotter WHERE blotter_Id = '$blotter_Id'"));

				$previous_actionTaken = $existingData['actionTaken'];
				$stored_case_no = $existingData['case_no'];
				$send_sms = false;

				if (trim($actionTaken) !== trim($previous_actionTaken)) {
				    $send_sms = true;
				}

				if ($send_sms) {
				    $message = "Good day, Mr./Ms. $c_lastname,\n\n"
			             . "Please be informed that the action taken on your blotter report has been updated.\n\n"
			             . "Details:\n"
			             . "• Case No.: $stored_case_no\n"
			             . "• Complainant: $c_firstname $c_middlename $c_lastname $c_suffix\n"
			             . "• Nature of Incident: $incidentNature\n"
			             . "• Date and Time: $incidentDate at $incidentTime\n"
			             . "• Location: $incidentAddress\n"
			             . "• Accused: $acc_firstname $acc_middlename $acc_lastname $acc_suffix\n"
			             . "• Witnesses: $witnesses (0$witnessesContact)\n"
			             . "• Description: $incidentDescription\n"
			             . "• Previous Action Taken: $previous_actionTaken\n"
			             . "• New Action Taken: $actionTaken\n\n"
			             . "If you have any further concerns or questions, feel free to contact our office.\n\n"
			             . "Thank you,\n"
			             . "Barangay Office";

				    sendSms($c_contact, $message);
				}

				 $updated = mysqli_query($conn, "UPDATE blotter SET c_firstname='$c_firstname', c_middlename='$c_middlename', c_lastname='$c_lastname', c_suffix='$c_suffix', c_contact='$c_contact', c_address='$c_address', incidentDate='$incidentDate', incidentTime='$incidentTime', incidentNature='$incidentNature', incidentAddress='$incidentAddress', acc_firstname='$acc_firstname', acc_middlename='$acc_middlename', acc_lastname='$acc_lastname', acc_suffix='$acc_suffix', acc_contact='$acc_contact', acc_address='$acc_address', witnesses='$witnesses', witnessesContact='$witnessesContact', incidentDescription='$incidentDescription', actionTaken='$actionTaken' WHERE blotter_Id='$blotter_Id'");
			
				  if($updated) {
				  	$_SESSION['message'] = "Blotter has been updated.";
				    $_SESSION['text'] = "Updated successfully!";
				    $_SESSION['status'] = "success";
					header("Location: blotter_update.php?blotter_Id=".$blotter_Id);
				  } else {
				    $_SESSION['message'] = "Something went wrong while updating the information.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: blotter_update.php?blotter_Id=".$blotter_Id);
				  }
			}
	}

	// UPDATE BLOTTER - BLOTTER_UPDATE.PHP
	if (isset($_POST['update_blotter_status'])) {
		$blotter_Id = mysqli_real_escape_string($conn, $_POST['blotter_Id']);
		$new_status = mysqli_real_escape_string($conn, $_POST['blotter_status']);

		$result = mysqli_query($conn, "SELECT * FROM blotter WHERE blotter_Id = '$blotter_Id'");
		$blotter = mysqli_fetch_assoc($result);
		$old_status = $blotter['blotter_status'];

		if ($old_status !== $new_status) {

			$status_texts = [
				'0' => 'Open',
				'1' => 'Closed',
				'2' => 'Under Investigation'
			];
			$readable_status = $status_texts[$new_status] ?? 'Unknown';

			$updated = mysqli_query($conn, "UPDATE blotter SET blotter_status='$new_status' WHERE blotter_Id='$blotter_Id'");

			if ($updated) {
				$c_fullname   = trim("{$blotter['c_firstname']} {$blotter['c_middlename']} {$blotter['c_lastname']} {$blotter['c_suffix']}");
				$acc_fullname = trim("{$blotter['acc_firstname']} {$blotter['acc_middlename']} {$blotter['acc_lastname']} {$blotter['acc_suffix']}");

				$message = "Good day, Mr./Ms. {$blotter['c_lastname']},\n\n"
				         . "We would like to inform you that the status of your blotter report has been updated to: *$readable_status*.\n\n"
				         . "Complaint Details:\n"
				         . "• Complainant: $c_fullname\n"
				         . "• Case No.: {$blotter['case_no']}\n"
				         . "• Contact: 0{$blotter['c_contact']}\n"
				         . "• Nature of Incident: {$blotter['incidentNature']}\n"
				         . "• Date & Time: {$blotter['incidentDate']} at {$blotter['incidentTime']}\n"
				         . "• Location: {$blotter['incidentAddress']}\n"
				         . "• Accused: $acc_fullname\n"
				         . "• Witnesses: {$blotter['witnesses']} (0{$blotter['witnessesContact']})\n"
				         . "• Description: {$blotter['incidentDescription']}\n"
				         . "• Action Taken: {$blotter['actionTaken']}\n\n"
				         . "If you have any questions or need further assistance, please contact the barangay office.\n\n"
				         . "Thank you,\n"
				         . "Barangay Office";

				sendSms($blotter['c_contact'], $message);

				$_SESSION['message'] = "Blotter status has been updated.";
				$_SESSION['text'] = "Updated successfully!";
				$_SESSION['status'] = "success";
			} else {
				$_SESSION['message'] = "Something went wrong while updating the status.";
				$_SESSION['text'] = "Please try again.";
				$_SESSION['status'] = "error";
			}
		} else {
			$_SESSION['message'] = "No changes were made to the status.";
			$_SESSION['text'] = "Status remains the same.";
			$_SESSION['status'] = "info";
		}

		header("Location: blotter.php");
	}


?>
