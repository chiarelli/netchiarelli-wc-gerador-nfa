<?php

namespace net\chiarelli\wp\plugin\gnfa\util;

/**
 * Description of Level
 * 
 * As constantes dessa classe sinalizam o estado da severidade para o cliente 
 * que for consumí-la. Uma vez atribuido o estado ele é imutável por todo ciclo 
 * de vida da instância.
 *
 * @author raphael
 */
class Severity extends Enum {
   
    const INFO       = 'INFO';
    const SUCCESS    = 'SUCCESS';
    const WARN       = 'WARN';
    const ERROR      = 'ERROR';
    const FAIL       = 'FAIL';


    protected function __construct($ordinal, $value, $constName) {
        parent::__construct($ordinal, $value, $constName);
    }
    
    public static function valueOf($constName) {
        return parent::prepareDefine(__CLASS__, $constName);
    }

    public static function indexOf($int) {
        return parent::prepareIndexOf(__CLASS__, $int);
    }

}