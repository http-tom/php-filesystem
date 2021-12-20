<?php
require_once '../../vendor/autoload.php';

use HttpTom\Filesystem\Directory as Directory;

$directory = new Directory();
$contents = $directory->read('../../src/HttpTom/Filesystem');

$sorted = $directory->sortByLastModified($contents, Directory::SORT_DESC);
if(isset($sorted[0]))
{
    // most recent file in directory
}