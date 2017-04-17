<?php

namespace NetChiarelli\WP_Plugin_NFe\util;

/**
 * Description of IValidate
 * 
 * Interface funcional usada como assinatura para todas as classes que a 
 * implementam com a finalidade de retornar um Result . 
 *
 * @author raphael
 */
interface IValidate {
    
    function validate()/* : Result */;
    
}
