<?php


namespace CSV;


/**
 * Parser class
 *
 * CSV parser implementation
 */

class Parser
{


    /**
     * $_options
     *
     * Parser options
     */

    private $_options = null;


    /**
     * $_buffer
     *
     * Buffer example
     */

    private $_buffer = null;


    /**
     * __construct
     *
     * Parser class constructor
     *
     * @param  mixed         $resource Resource of source (string or descriptor)
     * @param  ParserOptions $options  Parser options
     * @return null
     */

    public function __construct($resource, ParserOptions $options)
    {
        $this->_options = $options;
        if (is_resource($resource)) {
            $this->_buffer = new FileBuffer($resource, $options);
        } else if (is_string($resource)) {
            $this->_buffer = new StringBuffer($resource, $options);
        } else {
            throw new Exception('Unsuppoted type of source');
        }
    }


    /**
     * getLine
     *
     * WIll return next line data
     *
     * @return mixed Next line data
     */

    public function getLine()
    {
        $line = null;
        while (!$this->_buffer->isEof()) {
            if ($line === null) {
                $line = array();
            }
            $endOfLine = $this->_buffer->match(
                $this->_options->lineSeparator,
                Buffer::SHIFT
            );
            if ($endOfLine) {
                break;
            }
            if (null !== $field = $this->_getField()) {
                $line[] = $field;
            }
        }
        if (null !== $line) {
            if ($this->_options->expectedFields) {
                $index = 0;
                $lSize = sizeof($line);
                $lData = array();
                foreach ($this->_options->expectedFields as $k => $default) {
                    if ($index == $lSize) {
                        break;
                    }
                    if (strlen($line[$index])) {
                        $lData[$k] = $line[$index];
                    } else {
                        $lData[$k] = $default;
                    }
                    $index += 1;
                }
                $line = $lData;
                if ($this->_options->lineHasObject) {
                    $line = (object) $line;
                }
            }
        }

        return $line;
    }


    /**
     * _getField
     *
     * WIll return next field data of current line context
     *
     * @return mixed Next field data
     */

    private function _getField()
    {
        $buff  = $this->_buffer;
        $opts  = $this->_options;
        $field = null;
        if (!$buff->isEof()) {
            if ($field === null) {
                $field = '';
            }
            $ec = $buff->match($opts->fieldEnclosure, Buffer::SHIFT);
            $fs = $opts->fieldSeparator;
            if ($ec) {
                $fs = $opts->fieldEnclosure . $fs;
            }
            while (!$buff->isEof()) {
                if (!$ec && $this->_buffer->match($opts->lineSeparator)) {
                    break;
                }
                if ($buff->match($fs, Buffer::SHIFT)) {
                    break;
                }
                $field .= $buff->getChar();
            }
        }

        return $field;
    }
}
