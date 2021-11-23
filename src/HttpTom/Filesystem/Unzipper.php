<?php
namespace HttpTom\Filesystem;

use ZipArchive;

class Unzipper {

    private $zip = null;

    public function __construct()
    {
        $this->zip = new ZipArchive();
    }

    /**
     * Unzips all zip archives in the path specified and all folders within that path
     * @param string $path
     */
    public function unzipAll($path)
    {
        $dh = opendir($path);
        if (is_resource(($dh))) {
            while (false !== ($file = readdir($dh))) {
                // is not cdir or pdir
                if ($file != '.' && $file != '..') {
                    // is dir
                    if (is_dir($path.$file)) {
                        echo 'Entering dir: '.$path.$file.DIRECTORY_SEPARATOR.PHP_EOL;
                        $this->unzipAll($path.$file.DIRECTORY_SEPARATOR);
                    }
                    if (substr($file, -4) === '.zip') {
                        // is zip
                        echo "Extracting archive: {$path}{$file} to {$path}".PHP_EOL;
                        $zh = $this->zip->open($path.$file);
                        if ($zh) {
                            $this->zip->extractTo(addslashes($path));
                            $this->zip->close();
                        }
                    }
                }
            }
            closedir($dh);
        }
    }
}