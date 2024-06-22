<?php
require('./includes/config.inc.php');
redirect_invalid_user('user_admin');
require(MYSQL);
$page_title = 'Add a PDF';
include('./includes/header.html');
$add_pdf_errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST['title'])) {
		$t = escape_data(strip_tags($_POST['title']), $dbc);
	} else {
		$add_pdf_errors['title'] = 'Please enter the title!';
	}
	
	if (!empty($_POST['description'])) {
		$d = escape_data(strip_tags($_POST['description']), $dbc);
	} else {
		$add_pdf_errors['description'] = 'Please enter the description!';
	}
	
	if (is_uploaded_file($_FILES['pdf']['tmp_name']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
		$file = $_FILES['pdf'];
		$size = ROUND($file['size']/1024);
		if ($size > 5120) {
			$add_pdf_errors['pdf'] = 'The upload file was too large.';
		}
		$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
		if (finfo_file($fileinfo, $file['tmp_name']) !== 'application/pdf') {
			$add_pdf_errors['pdf'] = 'The uploaded file was noit a PDF.';
		}
		finfo_close($fileinfo);
		if (!array_key_exists('pdf', $add_pdf_errors)) {
			$tmp_name = sha1($file['name']) . uniqid('', true);
			$dest = PDFS_DIR . $tmp_name . '_tmp';
			if (move_uploaded_file($file['tmp_name'], $dest)) {
				// Armazena os dados na sessão para uso futuro:
				$_SESSION['pdf']['tmp_name'] = $tmp_name;
				$_SESSION['pdf']['size'] = $size;
				$_SESSION['pdf']['file_name'] = $file['name'];
				
				echo '<div class="alert alert-success"><h3>The file has uploaded!</h3></div>';
			} else {
				trigger_error('The file could not be moved.');
				unlink($file['tmp_name']);
			}
		}
	} elseif (!isset($_SESSION['pdf']))	{
		switch($_FILES['pdf']['error']) {
			case 1:
			case 2:
				$add_pdf_errors['pdf'] = 'The uploaded file was too large.';
				break;
			case 3:
				$add_pdf_errors['pdf'] = 'The file was only partially uploaded.';
				break;
			case 6:
			case 7:
			case 8:
				$add_pdf_errors['pdf'] = 'The file could not be uploaded due to a system error.';
				break;
			case 4:
			default:
				$add_pdf_errors['pdf'] = 'No file was uploaded!';
				break;
		}
	}
	
	if (empty($add_pdf_errors)) {
		$fn = escape_data($_SESSION['pdf']['file_name'], $dbc);
		$tmp_name = escape_data($_SESSION['pdf']['tmp_name'], $dbc);
		$size = (int) $_SESSION['pdf']['size'];
		$q = "INSERT INTO pdfs (title, description, tmp_name, file_name, size) VALUES('$t', '$d', '$tmp_name', '$fn', $size)";
		$r = mysqli_query($dbc, $q);
		if (mysqli_affected_rows($dbc) === 1) {
			$original = PDFS_DIR . $tmp_name . '_tmp';
			$dest = PDFS_DIR . $tmp_name;
			rename($original, $dest);

			echo '<div class="alert alert-success"><h3>The PDF has been added!</h3></div>';
			$_POST = array();
			$_FILES = array();
			unset($file, $_SESSION['pdf']);
		} else {
			trigger_error('The PDF could not be added due to a system error. We apologize for any inconvenience.');
			unlink($dest);
		}
	}
} else {
	unset($_SESSION['pdf']);
}

require('./includes/form_functions.inc.php');
?><h1>Add a PDF</h1>
<form enctype="multipart/form-data" action="add_pdf.php" method="post" accept-charset="utf-8">
<input type="hidden" name="MAX_FILE_SIZE" value="5542880">
<fieldset><legend>Fill out the form to add a PDF to the site:</legend>
<?php
create_form_input('title', 'text', 'Title', $add_pdf_errors);
create_form_input('description', 'textarea', 'Description', $add_pdf_errors);
echo '<div class="form-group';
if (array_key_exists('pdf', $add_pdf_errors)) {
	echo ' has-error';
} else if (isset($_SESSION['pdf'])) {
	echo ' has-success';
}
echo '"><label for="pdf" class="control-label">PDF</label><input type="file" name="pdf" id="pdf">';
if (array_key_exists('pdf', $add_pdf_errors)) {
	echo '<span class="help-block">' . $add_pdf_errors['pdf'] . '</span>';
} else {
	if (isset($_SESSION['pdf'])) {
		echo '<p class="lead">Currently: "' . $_SESSION['pdf']['file_name'] . '"</p>';
	}
}
echo '<span class="help=block">PDF only, 5MB Limit</span></div>';
?>
<input type="submit" name="submit_button" value="Add This PDF" id="submit_button" class="btn btn-default" />
</fieldset>
</form>
<?php include('./includes/footer.html'); ?>
