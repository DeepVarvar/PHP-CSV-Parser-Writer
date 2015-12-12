<?php


namespace CSV;


/**
 * Reader class
 *
 * CSV parser reader implementation
 */

class Reader
{


    /**
     * $_buffer
     *
     * Instance of buffer
     */

    protected $_buffer = null;


    /**
     * __construct
     *
     * Reader class constructor
     *
     * @param  Buffer $buffer Instance of buffer
     * @return null
     */

    public function __construct(Buffer $buffer)
    {
        $this->_buffer = $buffer;
    }
}
