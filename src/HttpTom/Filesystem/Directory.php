<?php
namespace HttpTom\Filesystem;

class Directory {

    const SORT_ASC = 0;
    const SORT_DESC = 1;

    /**
     * Reads a directory
     * @param string $path
     * @return array of files in directory
     */
    public function read($path)
    {
        $return = [];

        if(substr($path, -1, 1) !== DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }

        $dh = opendir($path);
        if (is_resource(($dh))) {
            while (false !== ($file = readdir($dh))) {
                // is not cdir or pdir
                if ($file != '.' && $file != '..') {
                    $return[] = [
                        'file' => $file,
                        'path' => $path,
                        'modified' => filemtime($path.$file),
                        'is_dir' => is_dir($path.$file),
                    ];
                }
            }
            closedir($dh);
        }

        return $return;
    }

    public function sortByLastModified(array $directoryContents, $direction)
    {
        switch ($direction) {
            case self::SORT_DESC:
                usort($directoryContents, [$this, '_sortLastModifiedDesc']);
                break;
            case self::SORT_ASC:
                usort($directoryContents, [$this, '_sortLastModifiedAsc']);
                break;
        }
        return $directoryContents;
    }

    private function _sortLastModifiedAsc($a, $b)
    {
        if($a['modified'] < $b['modified']) {
            return -1;
        }
        if($a['modified'] > $b['modified']) {
            return 1;
        }
        return 0;
    }
    private function _sortLastModifiedDesc($a, $b)
    {
        if($a['modified'] < $b['modified']) {
            return 1;
        }
        if($a['modified'] > $b['modified']) {
            return -1;
        }
        return 0;
    }
}
