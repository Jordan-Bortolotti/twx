<?php
require_once('FileLock.php');

//
// To obtain a "lock" on the file...
//
//   1) Create a FileLock object and pass in the name of the file you wish to access.
//      The FileLock class will then create a file with that name suffixed with '.lock'.
//      (So, no existing file in the file system should end in .lock.)
//
$lock = new FileLock('user.db');

//
// If you want to only read the file, then call requestReadLock() just before you need to
// read from the file.
//
//$lock->requestReadLock();

//
// If you want to write to the file, then call requestWriteLock() just before you need
// to write to the file. Please note that a write lock implies that there are no readers and
// that there are no other writers. Only request a write lock if it is truly needed!
//
//$lock->requestWriteLock();

//
// When done reading/writing, you should manually release the lock so that other processes
// can access the file. NOTE: Release it after flushing any and all buffers and/or closing
// the file.
//
$lock->releaseLock();

//
// If you don't release the lock, the FileLock's destructor will free it once the object
// is destroyed by the PHP engine.
//


//
// You can request and release locks as many times as needed.
//
// Do not request a lock and then request another lock for the same file without having
// released the previous lock first. If you do, then it will deadlock (it will lock up).
//

?>
