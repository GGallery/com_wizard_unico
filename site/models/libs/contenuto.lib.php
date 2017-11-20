<?php

/**
 * Cerca nella directory $path/$id/ per i tipi di contenuti disponibili su file 
 * system
 */ 
function get_fs_media($id, $path='mediatv/_contenuti/', $types=array('mp4', 'webm', 'ogv', 'flv', 'jpg', 'mp3', 'swf')) {
    if ('/' !== substr($path, -1))
        $path .= '/';
    $media = array();
    foreach ($types as $ext) 
        $media[$ext] = (int)file_exists($path . $id . '/' . $id . '.' . $ext);
    $media['html5'] = $media['webm'] & $media['mp4'];
    return $media;
}
// @:-]
?>
