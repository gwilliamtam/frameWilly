<?php


class Document
{
    private $validDocuments = ['gif', 'jpeg', 'jpg', 'jpeg', 'png', 'bmp', 'pdf'];
    private $imageExtensions = ['gif', 'jpeg', 'jpg', 'jpeg', 'png', 'bmp'];

    function isValidDocument($ext)
    {

        if (in_array($ext, $this->validDocuments)) {
            return true;
        }
        return false;
    }


    function isImage($ext)
    {

        if (in_array($ext, $this->imageExtensions)) {
            return true;
        }
        return false;
    }

    function getExtension($name)
    {
        $extPos = strpos($name, '.');
        return substr($name, $extPos+1);
    }
}