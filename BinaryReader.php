<?php


namespace CSV;


/**
 * BinaryReader class
 *
 * CSV parser binary mode reader implementation
 */

class BinaryReader extends Reader implements ReaderInterface
{


    /**
     * getChar
     *
     * Return next char of source data
     *
     * @return null|string Next char of source data
     */

    public function getChar()
    {
        return $this->_buffer->readByte();
    }
}
