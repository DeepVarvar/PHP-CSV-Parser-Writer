<?php


namespace CSV;


/**
 * BufferInterface interface
 *
 * Interface of buffer implementation
 */

interface BufferInterface
{


    /**
     * init
     *
     * Buffer initialization process
     *
     * @return null
     */

    public function init();


    /**
     * readByte
     *
     * Read next byte of source.
     * Increment internal buffer pointers
     *
     * @return null|string Next byte of source
     */

    public function readByte();
}
