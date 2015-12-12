<?php


namespace CSV;


/**
 * ReaderInterface interface
 *
 * Interface of reader implementation
 */

interface ReaderInterface
{


    /**
     * getChar
     *
     * Return next char of source data
     *
     * @return null|string Next char of source data
     */

    public function getChar();
}
