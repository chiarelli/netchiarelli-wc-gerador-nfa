<?php

namespace net\chiarelli\wp\plugin\gnfa\kernel;

use net\chiarelli\wp\plugin\gnfa\assert\AssertionSoft;
use net\chiarelli\wp\plugin\gnfa\hook\filter\HooksFilterManager;
use net\chiarelli\wp\plugin\gnfa\util\Result;

/**
 * Description of AppKernel
 * 
 * Essa é a classe é a responsável por carregar o core do plugin.
 *
 * @author raphael
 */
class AppKernel {
    
    const MINIMUM_VER_PHP = '5.6';
    const MINIMUM_VER_WP = '4.7';

    /**
     * Bootstrap do plugin
     */
    static function start() {
        
        static::runHooksCore();
        
        static::validateDependencies();
    }
    
    /**
     * Valida todas as dependencias que o plugin necessita para ser ativado, 
     * ex: outros plugins; versão do PHP, do wordpress, dos plugins, etc.
     * 
     * Caso seja encontrado algum problema o plugin não é iniciado e uma 
     * mensagem no painel admin é disparada 
     */
    private static function validateDependencies() {
        
        $verPHP = explode('-', phpversion())[0];
        $verWP = get_bloginfo('version');
        
        // TODO incluir a validação da dependencia do plugin woocoomerce
        
        $asserts[] = array(
            array(AssertionSoft::class, 'version'), 
            array($verPHP, 'ge', self::MINIMUM_VER_PHP, 'php-version-invalid|%3$s|%1$s' )
        );
        
        $asserts[] = array( 
            array(AssertionSoft::class, 'version'), 
            array($verWP, 'ge', self::MINIMUM_VER_WP, 'wp-version-invalid|%3$s|%1$s' )
        );
        
        $msgErros = array();
        
        foreach ($asserts as $data) {
            $called = $data[0];
            $args   =  $data[1];
                
            /* @var $result Result */
            $result = forward_static_call_array($called, $args);
            
            ($result->isValid() === FALSE) 
                    ? $msgErros = array_merge( $msgErros, $result->getMessagesInSequence() )
                    : NULL;
            
        }
        
        (empty($msgErros) === FALSE)
            ? WP_Notice::getInstance()->error($msgErros, __('Erro ao ativar o plugin', 'wc_gnfa') )
            : NULL;        
        
    }
    
    private static function runHooksCore() {
        HooksFilterManager::run();
    }
    
}
