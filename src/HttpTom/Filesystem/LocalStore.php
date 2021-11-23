<?php
namespace HttpTom\Filesystem;

class LocalStore {

    /**
     * Determines if the local file contents is different to the
     * $incomingContents data
     * 
     * Useful when needing to determine if local file is out of date
     * and needs to be refreshed. Can be used with file_get_contents()
     * to compare with local data in $localFilename
     * 
     * If local file does not exist, the $incomingContents are stored in $localFilename
     * 
     * If incoming data is different, the $localFilename will be overwritten with $incomingContents
     * 
     * @param string $localFilename     Local filename to compare contents against/store incomingContents
     * @param mixed $incomingContents   New data that has been fetched, to compare against stored data in $localFilename
     * @param bool $overwriteIfChanged (optional)
     * 
     * @return bool true if file contents has changed or local file does not exist.
     */
    public function isUpdated($localFilename, $incomingContents, $overwriteIfChanged = true)
    {
        // does local copy exist?
        if (!file_exists($localFilename))
        {
            // save stock list for later
            file_put_contents($localFilename, $incomingContents);
            return true;
        }
        
        // compare incoming stock list with stored stock list
        $incomingHash = hash('sha256', $incomingContents);
        $storedHash = hash('sha256', file_get_contents($localFilename));

        // if not same, overwrite stock.csv and process new
        if($incomingHash !== $storedHash)
        {
            if ($overwriteIfChanged)
            {
                // overwrite with new incoming file contents
                file_put_contents($localFilename, $incomingContents);
                return true;
            }
        }

        return false;
    }
}
