<?php

/*
 * Copyright (C) 2017 raphael
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace NetChiarelli\WP_Plugin_NFe\util;

/**
 * Description of Util
 * 
 * @deprecated
 * @internal Uso interno
 *
 * @author raphael
 */
class Util {
    
    /**
     * Converte html tag &lt;select&gt; (juntamente com sua list de tags &lt;option&gt;) 
     * em array.
     * 
     * @param string $html
     * @return array
     */
    static function tagSelectToArray($html) {
        $matches = array();
        $result = array();

        if(preg_match_all('/value="(.*)".*?>(.*)<\\/option>/', $html, $result)){
            $matches = array_pop($matches);
            
            foreach( (array) $matches[1] as $i => $key){
                $key = htmlspecialchars($key);
                $val = htmlspecialchars($matches[2][$i]);
                $result[$key] = $val;                
            }
            
        }

        return array_combine($result[1], $result[2]);
    }
    
    static function objectToArrayFeatureless($obj) {
        
        $callback = function ($value, $attribute) use (&$newArray, &$obj) {
        
            $classNamePattern = preg_quote(get_class($obj));    

            $attribute = preg_replace("/^(.*)(({$classNamePattern})|\\*)/", '', $attribute);

            $newArray[$attribute] = $value;
        };  
        
        $serializeSoft = (array) $obj;
        \array_walk($serializeSoft, $callback);

        return $newArray;    
    }
    
    
}
