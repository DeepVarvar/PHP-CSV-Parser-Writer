<?php


namespace CSV;


/**
 * FileBuffer class
 *
 * CSV parser file buffer implementation
 */

class FileBuffer extends Buffer implements BufferInterface
{


    /**
     * init
     *
     * Buffer initialization process
     *
     * @return null
     */

    public function init()
    {
        fseek($this->_resource, 0, SEEK_END);
        $this->_sourceSize = ftell($this->_resource);
        fseek($this->_resource, 0, SEEK_SET);
    }


    /**
     * readByte
     *
     * Read next byte of source.
     * Increment internal buffer pointers
     *
     * @return null|string Next byte of source
     */

    public function readByte()
    {
        $byte = null;
        if (!$this->_isSourceEof()) {
            $byte = fgetc($this->_resource);
            $this->_sourcePos += 1;
        }

        return $byte;
    }
}
