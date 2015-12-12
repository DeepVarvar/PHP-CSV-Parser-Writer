<?php


namespace CSV;


/**
 * StringBuffer class
 *
 * CSV parser source string buffer implementation
 */

class StringBuffer extends Buffer implements BufferInterface
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
        $this->_sourceSize = strlen($this->_resource);
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
            $byte = $this->_resource{$this->_sourcePos};
            $this->_sourcePos += 1;
        }

        return $byte;
    }
}
