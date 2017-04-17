<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NetChiarelli\WP_Plugin_NFe\hook\filter;

use Assert\Assertion;

/**
 * Description of HooksFilter
 *
 * @author raphael
 */
class HooksFilterManager {
    
    /** 
     * @static
     * @var HooksFilterManager 
     */
    private static $instance;
    
    /**
     * @static 
     * @var array 
     */
    private static $callabeMap = array();

    /**
     * protect constructor
     */
    protected function __construct() { }
    
    static function run() {
        if (isset(self::$instance)) {
            return;
        }

        self::$instance = new static;                
    }
    
    /**
     * @static
     * 
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public static function __callStatic($name, $arguments) {
        
        if(empty($name) || empty($arguments)) {
            return;
        }
        
        $method_name = str_replace('REGISTER_', '', $name);
        $callabe = $arguments[0];
        $priority = (int) $arguments[1] ? $arguments[1] : '10';
        $accepted_args = (int) $arguments[2] ? $arguments[2] : '1';
                
        Assertion::methodExists($method_name, static::$instance);
        Assertion::isCallable($callabe);
        
        self::$callabeMap[$method_name] = $callabe;
        
        add_filter($method_name, array(static::$instance, $method_name), $priority, $accepted_args);
    }
    
    /**
     * 
     * @static
     * 
     * @param string $key
     * @param array $args
     * @return void
     */
    static protected function caller($key, $args) {
        
        if( ! array_key_exists($key, static::$callabeMap) ) {
            return;
        }
        $callabe = static::$callabeMap[$key];
        
        return call_user_func_array($callabe, $args);
    }
    
    function gnfa_notice_row_msg_error() {
        return $this->caller(__FUNCTION__, func_get_args());
    }    
    
    
}
