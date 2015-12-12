<?php


namespace CSV;


/**
 * ParserOptions class
 *
 * CSV parser options implementation
 */

class ParserOptions
{


    /**
     * $_defaults
     *
     * Default parser options
     */

    private $_defaults = array(
        'encoding'       => Encoding::BINARY,
        'bufferSize'     => 8,
        'lineSeparator'  => "\r\n",
        'fieldSeparator' => ',',
        'fieldEnclosure' => '"',
        'lineHasObject'  => false,
        'expectedFields' => array()
    );


    /**
     * __construct
     *
     * ParserOptions class constructor
     *
     * @param  array $options Parser options
     * @return null
     */

    public function __construct(array $options = array())
    {
        foreach (array_merge($this->_defaults, $options) as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
