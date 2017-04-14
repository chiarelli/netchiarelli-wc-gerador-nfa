<?php

/**
 * Plugin Name: Gerador NFA-e
 * Version: 0.1.0
 * Description: Gerador de Nota Eletrônica Avulsa (Brazil somente)
 * Author: Raphael Mathias
 * Author URI: https://www.facebook.com/chiarelli.gomes
 * Text Domain: netchiarelli-wc-gerador-nfa
 * License: GPL v2 or later
 */

/*
 * @todo TODO remover essas duas linhas abaixo
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');    

 require_once plugin_dir_path(__FILE__) . '/vendor/autoload.php';


// AppKernel::start();


try {
    
//    \net\chiarelli\wp\plugin\gnfa\draft\SefazRjDraft1::main();
    
//    \net\chiarelli\wp\plugin\gnfa\draft\SefazFormExaustivoDraft1::main();
    
//    \net\chiarelli\wp\plugin\gnfa\draft\SefazFormExaustivoDraft_V2::main();
    
//    \net\chiarelli\wp\plugin\gnfa\draft\SefazRJController_Draft::main();
    
//    \net\chiarelli\wp\plugin\gnfa\draft\GerandoDANFE_Draft::main();
    
    \NetChiarelli\WP_Plugin_NFe\draft\Main::main();
    
//    echo '<pre>';
//
//    echo '</pre>';
    
//    $enum = TipoDocEnum::valueOf(TipoDocEnum::CPF[0]);
    
//    var_dump(serialize($enum));

} catch (Exception $exc) {    
    
    function stackException(Exception $exc) {
        echo '<h4><span style="margin: 0; color: red;">Exception Class:</span> ' . get_class($exc) . '</h4><p><span style="margin: 0; color: blue;">error:</span> <span style="margin: 0; color: green;">'. $exc->getMessage().'</span></p>';
        echo '<p>';
        echo 'TRACE:<br>';
        echo $exc->getTraceAsString();
        echo '<hr>';
        
        if($previous = $exc->getPrevious()) {
            stackException($previous);
        }
        
    }
    
    echo '<pre>';
    stackException($exc);
    echo '</pre>';
}


die('<br><br><hr><span style="color: pink;">MASTER_DIE</span>');


//$client = new Client([
//    // Base URI is used with relative requests
//    'base_uri' => 'http://www4.fazenda.rj.gov.br',
//    // You can set any number of default request options.
//    'timeout'  => 2.0,
//]);
//
//// $jar = new \GuzzleHttp\Cookie\CookieJar;
//
//$file = fopen(__DIR__ . "/cookie.jar", "r");
//$jar = unserialize( fread($file, filesize(__DIR__ . "/cookie.jar")) );
//fclose($file);
//
//$response = $client->request('GET', '/sefaz-dfe-nfae/paginas/identificacao.faces', [
//    'cookies' => $jar
//]);
//
//$body = $response->getBody();
//$xml = $body->getContents();
//
//// enable user error handling
//libxml_use_internal_errors(true);
//
//$document = new DOMDocument;
//$document->loadHTML($xml);
//
//
//$crawler = new Crawler();
//$crawler->addDocument($document);
//
//// var_dump( $crawler->filter('form input')->attr('value') );
//
//$crawler->filter('form input[name="javax.faces.ViewState"]')->each(function (Crawler $node, $i) {
//    echo $node->attr('name') . ' | ' . $node->attr('value');
//    echo '<p />';
//});



// Save cookie file
//$myfile = fopen(__DIR__ . "/cookie.jar", "w") or die("Unable to open file!");
//$txt = serialize($jar);
//fwrite($myfile, $txt);
//fclose($myfile);
        
//$onRedirect = function(
//            \Psr\Http\Message\RequestInterface $request,
//            \Psr\Http\Message\ResponseInterface $response,
//            \Psr\Http\Message\UriInterface $uri
//            ) {
//        echo PHP_EOL . 'onRedirect:' . PHP_EOL;
//        
//        echo 'Redirecting! ' . $request->getUri() . ' to ' . $uri . "\n";
//    };
//    
//    
//    $onStats = function (\GuzzleHttp\TransferStats $stats) {
//        echo PHP_EOL . 'onStats:' . PHP_EOL;
//        
//        $request = $stats->getRequest();
//        
//        echo 'Method used: '. $request->getMethod() . PHP_EOL;
//        echo $stats->getEffectiveUri() . "\n";
//        echo $stats->getTransferTime() . "\n";
//        var_dump($stats->getHandlerStats());
//
//        // You must check if a response was received before using the
//        // response object.
//        if ($stats->hasResponse()) {
//            echo $stats->getResponse()->getStatusCode();
//        } else {
//            // Error data is handler specific. You will need to know what
//            // type of error data your handler uses before using this
//            // value.
//            var_dump($stats->getHandlerErrorData());
//        }
//    };
