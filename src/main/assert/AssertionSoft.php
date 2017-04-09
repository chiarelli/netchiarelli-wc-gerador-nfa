<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace net\chiarelli\wp\plugin\gnfa\assert;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use net\chiarelli\wp\plugin\gnfa\util\Result;
use net\chiarelli\wp\plugin\gnfa\util\Severity;

/**
 * Description of Assertion
 * 
 * Proxy dinâmico estático da classe Assert\Assertion para não lançar exceções, mas somente 
 * instâncias da classe Result para informar o estado do resultado ao cliente.
 * 
 * @todo Futuramente ao refatorar o package net\chiarelli\wp\plugin\gnfa\api para 
 * um projeto independente, não esquecer de desacoplar net\chiarelli\wp\plugin\gnfa\util\Result.
 * 
 * @author raphael
 */
class AssertionSoft {
    
    /**
     * 
     * @param string $name
     * @param array $arguments
     * 
     * @return Result
     */
    public static function __callStatic($name, $arguments) {
        try {
            \forward_static_call_array(array(Assertion::class, $name), $arguments);

            return new Result('OK', Severity::valueOf(Severity::SUCCESS));
            
        } catch (InvalidArgumentException $exc) {
            
            return new Result($exc->getMessage(), Severity::valueOf(Severity::ERROR));
        }
    }
    
}
