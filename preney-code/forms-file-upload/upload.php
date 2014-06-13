<?php
// For more information read http://php.net/manual/en/features.file-upload.php .
// For contents of $_FILE see http://www.php.net/manual/en/features.file-upload.post-method.php .

// $uploaddir should be set to a private directory not accessible directly
// via a URL. In this example it is set to the current directory which
// Apache must have write access to for the code to work.
$uploaddir = dirname(__FILE__);

// You should always set the server-side file name or check the
// filename for hacking. Generally the server-side file name can
// be a counter variable (e.g., a database integer that is a primary
// key). Here it is set to "1.dat".
$uploadfilename = $uploaddir.'/'.'1.dat';

// $form_name is the name of the form's field for the file.
$form_name = 'myfile';

if (array_key_exists($form_name, $_FILES))
{
  // Never trust the mime type sent by the client.
  //   i.e., Don't trust $_FILES[*]['type']!!
  // This method will compute the mime type under Linux...
  #$mime_type = trim(shell_exec('/usr/bin/file -bi '.escapeshellarg($_FILES[$form_name]['tmp_name'])));

  $fi = finfo(MIME_TYPE_INFO);
  $mime_type = $fi->;

  // Check if all is okay. We'll assume it is.
  
  // Now move the file from its uploaded position to the final
  // destination.
  if (move_uploaded_file($_FILES[$form_name]['tmp_name'], $uploadfilename))
  {
    // All is okay.
    // Tell user the upload was successful.
    die('Success.');
  }
  else
  {
    // All is not okay.
    // Tell user an error.
    // Look at the HTTP response codes if any are eligible. If so, return it.
    
    // Be paranoid and delete the temporary file and any possibly created 
    // $uploadfilename file.
    @unlink($_FILES[$form_name]['tmp_name']);
    @unlink($uploadfilename);
    die('Failure.');
  }

  // Bare bones example. Obviously better feedback is needed.
}
else
  die('No file.');

?>
