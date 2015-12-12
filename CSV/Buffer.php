<?php


namespace CSV;


/**
 * Buffer class
 *
 * CSV parser buffer implementation
 */

class Buffer
{


    /**
     * DONT_SHIFT
     *
     * Don't skip matched token (shift buffer data)
     */

    const DONT_SHIFT = false;


    /**
     * SHIFT
     *
     * Force skip matched token (shift buffer data)
     */

    const SHIFT = true;


    /**
     * $_options
     *
     * Parser options
     */

    protected $_options = null;


    /**
     * $_reader
     *
     * Instance of characters reader
     */

    protected $_reader = null;


    /**
     * $_resource
     *
     * Resource of source data (string or file descriptor)
     */

    protected $_resource = null;


    /**
     * $_data
     *
     * Buffer data
     */

    protected $_data = array();


    /**
     * $_filledSize
     *
     * Size of filled buffer in bytes
     */

    protected $_filledSize = 0;


    /**
     * $_sourcePos
     *
     * Position of pointer in source data
     */

    protected $_sourcePos = 0;


    /**
     * $_sourceSize
     *
     * Size (length) of data of source in bytes
     */

    protected $_sourceSize = 0;


    /**
     * __construct
     *
     * Buffer class constructor
     *
     * @param  mixed         $resource Resource of source data
     * @param  ParserOptions $options  Parser options
     * @return null
     */

    public function __construct($resource, ParserOptions $options)
    {
        $this->_resource = $resource;
        $this->_options  = $options;
        switch ($this->_options->encoding) {
            case Encoding::UTF_8:
                $this->_reader = new UTF8Reader($this);
            break;
            case Encoding::BINARY:
                $this->_reader = new BinaryReader($this);
            break;
            default:
                throw new Exception('Undefined encoding mode');
            break;
        }
        // custom buffer initialization
        $this->init();
        // first fill buffer data
        $this->_fill();
    }


    /**
     * match
     *
     * WIll return status of matched token
     *
     * @param  string $token Token value
     * @param  bool   $shift Shift mode
     * @return bool          Match status
     */

    public function match($token, $shift = Buffer::DONT_SHIFT)
    {
        $sub = '';
        $cnt = 0;
        foreach ($this->_data as $char) {
            $sub .= $char;
            $cnt += 1;
            if (strlen($sub) >= strlen($token)) {
                break;
            }
        }
        $status = ($sub === $token);
        if ($shift && $status && $cnt) {
            $this->shift($cnt);
        }

        return $status;
    }


    /**
     * getChar
     *
     * Return next char from buffer data
     *
     * @param  bool        $shift Shift mode
     * @return null|string        Next char from buffer data
     */

    public function getChar($shift = Buffer::SHIFT)
    {
        $char = null;
        if ($this->_filledSize) {
            $char = $this->_data[0];
            if ($shift) {
                $this->shift();
            }
        }

        return $char;
    }


    /**
     * shift
     *
     * Shift buffer data
     *
     * @param  int  $shiftSize Size of shift
     * @return bool            EOF status
     */

    public function shift($shiftSize = 1)
    {
        if ($shiftSize < 1) {
            throw new Exception(
                'Size of shift must be greater than or equal to one byte'
            );
        }
        do {

            if ($this->_filledSize) {
                array_shift($this->_data);
                $this->_filledSize -= 1;
            }
            if (null !== $char = $this->_reader->getChar()) {
                array_push($this->_data, $char);
                $this->_filledSize += 1;
            }
            $shiftSize -= 1;

        } while ($shiftSize);

        return !$this->isEof();
    }


    /**
     * isEof
     *
     * WIll return status of end of source data
     *
     * @return bool EOF status
     */

    public function isEof()
    {
        return ($this->_isSourceEof() && !$this->_filledSize);
    }


    /**
     * _isSourceEof
     *
     * WIll return status of end of source data
     *
     * @return bool EOF status
     */

    protected function _isSourceEof()
    {
        return ($this->_sourcePos == $this->_sourceSize);
    }


    /**
     * _fill
     *
     * Initial fill buffer with increment internal buffer pointers
     *
     * @return null
     */

    protected function _fill()
    {
        while ($this->_filledSize < $this->_options->bufferSize) {
            $char = $this->_reader->getChar();
            if ($char === null) {
                break;
            }
            array_push($this->_data, $char);
            $this->_filledSize += 1;
        }
    }
}
