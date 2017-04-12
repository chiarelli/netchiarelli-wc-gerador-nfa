<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NetChiarelli\WP_Plugin_NFe\util;

use Assert\Assertion;
use NetChiarelli\WP_Plugin_NFe\assert\AssertionSoft;

/**
 * Description of newPHPClass
 * 
 * Responsável por manipular strings | textos.
 *
 * @author raphael
 */
class RenderShortCode {
    
    private $file;

    function __construct($file) {
        Assertion::notEmpty($file);
        Assertion::string($file);
        
        AssertionSoft::contains($file, '/');
        
        $this->file = GNFA_SRC_ASSETS . '/' . $file;
    }
    
    function filterCode($code, ... $_) {
        
    }
    
}
