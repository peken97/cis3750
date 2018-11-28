<?php

	include "functions.php";
	include "sql_setup.php";
	global $conn;
	global $table_advertisements;
	global $return_success;
	global $return_error;

	ini_set('display_errors',1);
	error_reporting(E_ALL);
	$err_upload = "";
	$image_file = $_FILES['file_name'];
	$temporary_name = $image_file['tmp_name'];
	$suffix = "";

	
	if (is_uploaded_file($temporary_name)) {

		// get image information
		$image_metadata = getimagesize($temporary_name);

		if ($image_metadata) {
			$image_width = $image_metadata[0];
			$image_height = $image_metadata[1];
			$image_type = $image_metadata[2];

			$save_name = $temporary_name;

			switch ($image_type)
			{
				case IMAGETYPE_GIF:
					$save_name .= ".gif";
					$suffix = ".gif";
					break;
				case IMAGETYPE_PNG:
					$save_name .= ".png";
					$suffix = ".png";
					break;
				default:
					$err_upload = "Sorry... we only allow gif and png images.";
					break;
			}
			$ad_id = getNextAdvertisementId() + 1;
			$ad_file_name =  $_POST['ad_name'] . $ad_id . $suffix;
			if (! $err_upload) {
				if (move_uploaded_file($temporary_name, "/var/www/html/images/" . $ad_file_name  )) {
				 	if(isset($_POST['ad_id'])) {
						edit_advertisement($_POST['ad_id'], $_POST['user_id'], $_POST['ad_name'], $ad_file_name);
					}
					else
					{
						addNewAdvertisement($_POST['user'], $_POST['ad_name'], $ad_file_name);
					}
				 	header("Location: http://buttholes.fun/manage_ads.php");
					die();
				} else {
					$err_upload = "Sorry... something went horribly awry.";
				}
			}
		}

	} else {

		// some error occurred: handle it
		switch ($image_file['error'])
		{
			case 1: // file too big (based on php.ini)
				$err_upload .= "EXTRA STUFF";
				break;
			case 2: // file too big (based on MAX_FILE_SIZE)
				$err_upload .= "Sorry... image too big.";
				break;
			case 3: // file only partially uploaded
				$err_upload .= "EXTRA STUFF";
				break;
			case 4: // no file was uploaded
				$err_upload .= "EXTRA STUFF";
				break;
			case 6: // missing a temporary folder
				$err_upload .= "EXTRA STUFF";
				break;
			case 7: // failed to write to disk (only in PHP 5.1+)
				$err_upload .= "Sorry... failed to upload... problem with server.";
				break;
		}
	}

	if ($err_upload) {
		print $err_upload;
	} else {
		print "Success!!!";
	}


?>