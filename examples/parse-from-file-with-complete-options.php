<?php


// include autoloader
require 'autoload.php';


try {


    /*
     * open file
     *
     * But in real code you must check for
     * existence and/or permission access of file
     */

    $fd = fopen(THAT_DIR . 'test-data/utf-8-crlf.csv', 'rb');

    // create parser options example
    $ParserOptions = new CSV\ParserOptions(
        array(
            // now support only binary (single byte encoding) and utf-8
            'encoding' => CSV\Encoding::UTF_8,
            // size of buffer must be great of lenght tokens
            'bufferSize' => 8,
            // custom line separator
            'lineSeparator' => "\r\n",
            // custom field separator
            'fieldSeparator' => ',',
            // custom field enclosure
            'fieldEnclosure' => '"',
            // returl line data has object (or array by default)
            'lineHasObject' => true,
            // list of expected fields with default values of fields
            'expectedFields' => array(

                'id'        => null,
                'firstName' => '',
                'lastName'  => '',
                'price'     => 0

            )
        )
    );

    // create parser example
    $Parser = new CSV\Parser($fd, $ParserOptions);

    // run parse process line by line
    while (null !== $line = $Parser->getLine()) {
        var_dump($line);
    }

    // close file
    fclose($fd);


} catch (CSV\Exception $e) {
    exit('CSV parser error: ' . $e->getMessage() . PHP_EOL);
}


