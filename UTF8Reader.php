<?php


namespace CSV;


/**
 * UTF8Reader class
 *
 * CSV parser UTF-8 mode reader implementation
 */

class UTF8Reader extends Reader implements ReaderInterface
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
        $char = $this->_buffer->readByte();
        if (null !== $char) {

            $ord = ord($char);
            if ($ord < 128) {
                $len = 0;
            } else if ($ord < 224) {
                $len = 1;
            } else if ($ord < 240) {
                $len = 2;
            } else if ($ord < 248) {
                $len = 3;
            } else if ($ord < 252) {
                $len = 4;
            } else {
                $len = 5;
            }

            while ($len > 0 && null !== $next = $this->_buffer->readByte()) {
                $char .= $next;
                $len  -= 1;
            }

        }

        return $char;
    }
}
