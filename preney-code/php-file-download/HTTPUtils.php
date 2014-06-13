<?php
// Copyright (c) 2012 Paul Preney. All Rights Reserved.

final class HTTPUtils
{
  //
  // redirect($uri)
  //
  // Function to redirect web client to URL $uri
  //
  public static function redirect($uri)
  {
    header('Location: '.$uri);
  }

  //
  // sendFile($lfn,$rfn,$mime,$desc,$clean)
  //
  // Function to send the server (local) file $lfn to a web client
  // telling the web client the file name is $rfn, has MIME type
  // $mime, having a short description $desc, and optionally 
  // invoke a special cleanup() function $clean when it is done sending 
  // it.
  //
  // The $clean function, if set, must be a function taking two
  // arguments:
  //
  //   1) the local file name, and,
  //   2) the returned value from readfile()
  //   3) a $status value
  //      - is 200 if file completely sent
  //      - is 404 if file doesn't exist (404 header sent)
  //      - is 403 if file doesn't have read perms (403 header sent)
  //      - is 0 otherwise
  //
  // If $clean is set to any value other than null, then it is always
  // called.
  //
  // It is assumed that $localFileName is valid.
  //
  // NOTE: sendFile() does not return! Use $cleanUpAction if needed!
  //
  public static function sendFile($localFileName, $asRemoteFileName,
    $mimeType, $desc, $cleanUpFunc=null)
  {
    // Turn off server-side auto compression if it is present...
    @apache_setenv('no-gzip', 1);
    @ini_set('zlib.output_compression', 0);

    $okay = TRUE;
    $status = 200;
    $result = FALSE;

    if (!is_file($localFileName))
    {
      header('HTTP/1.0 404 Not Found');
      $okay = FALSE;
      $status = 404;
    }

    if ($okay === TRUE && !is_readable($localFileName))
    {
      header('HTTP/1.0 403 Forbidden');
      $okay = FALSE;
      $status = 403;
    }

    if ($okay == TRUE)
    {
      // Set the headers...
      header('Pragma: public');
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // some day in the past
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header("Cache-Control: private",false); // required for certain browsers 
      header('Last-Modified: '.gmdate('D, d M Y H:i:s',
        filemtime($localFileName)).' GMT');

      if ($desc !== null)
        header('Content-Description: '.$desc);

      if ($mimeType !== null)
        header('Content-Type: '.$mimeType);
      else
        header('Content-Type: application/octet-stream'); 

      if ($asRemoteFileName == null)
        header('Content-Disposition: attachment');
      else
        header('Content-Disposition: attachment; filename="'.$asRemoteFileName.'"');

      header('Content-Transfer-Encoding: binary');

      $len = filesize($localFileName);
      header('Content-Length: '.$len);

      flush();
      ob_clean();
      ob_end_flush();

      // Send the file...
      $result = @readfile($localFileName);

      if ($result === FALSE || $result !== $len)
      {
        $okay = FALSE;
        $status = 0;
      }
    }

    if ($cleanUpFunc !== null)
      @call_user_func($cleanUpFunc, $localFileName, $result, $status);

    exit;
  }
}

?>
