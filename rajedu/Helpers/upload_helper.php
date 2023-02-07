<?php

if (! function_exists('upload'))
{
    function upload($fieldName, $path)
    {
        $request = \Config\Services::request();
        $file = $request->getFile($fieldName);
        $ext = $file->guessExtension();
        $orgName = $file->getName();
        $mimeType = $file->getMimeType();
        $size = $file->getSize();
        $encryptedName = $file->getRandomName();
        $file->move($path, $encryptedName);
        if ($file->hasMoved()) {
            return array(
                'encryptedName' => $encryptedName,
                'name' => $orgName,
                'ext' => $ext,
                'mime_type' => $mimeType,
                'size' => $size,
            ); 
        } else {
            return false;
        }
    }
}

if (! function_exists('multipleUpload'))
{
    function multipleUpload($fieldName, $path, $onlyNames = false)
    {
        $request = \Config\Services::request();
        $files = $request->getFileMultiple($fieldName);
        foreach ($files as $file) {
            $ext = $file->guessExtension();
            $orgName = $file->getName();
            $mimeType = $file->getMimeType();
            $size = $file->getSize();
            $encryptedName = $file->getRandomName();
            $file->move($path, $encryptedName);
            if ($file->hasMoved()) {
                if ($onlyNames) {
                    $encryptedNames[] = $encryptedName;
                    $names[] = $orgName;
                } else {
                    $output[] = array(
                        'encryptedName' => $encryptedName,
                        'name' => $orgName,
                        'ext' => $ext,
                        'mime_type' => $mimeType,
                        'size' => $size,
                    );
                }  
            }
        }
        if ($onlyNames) {
            return $output = array(
                'encryptedNames' => implode(',', $encryptedNames),
                'names' => implode(',', $names),
            );
        } else {
            return $output;
        }
        pr($output);
    }
}