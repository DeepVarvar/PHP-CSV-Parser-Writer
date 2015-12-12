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
            'encoding' => CSV\Encoding::UTF_8
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


