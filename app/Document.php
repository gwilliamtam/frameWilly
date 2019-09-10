<?php


class Document
{
    private $validDocuments = ['jpeg', 'jpg', 'jpeg', 'png', 'bmp', 'pdf'];
    private $imageExtensions = ['jpeg', 'jpg', 'jpeg', 'png', 'bmp'];

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

    function getExtensions($name)
    {

    }
}