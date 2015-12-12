<?php


// include autoloader
require 'autoload.php';


try {


    // get source data
    $source = file_get_contents(THAT_DIR . 'test-data/utf-8-crlf.csv');

    // create parser options example
    $ParserOptions = new CSV\ParserOptions(
        array(
            'encoding' => CSV\Encoding::UTF_8
        )
    );

    // create parser example
    $Parser = new CSV\Parser($source, $ParserOptions);

    // run parse process line by line
    while (null !== $line = $Parser->getLine()) {
        var_dump($line);
    }


} catch (CSV\Exception $e) {
    exit('CSV parser error: ' . $e->getMessage() . PHP_EOL);
}


