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

namespace net\chiarelli\wp\plugin\gnfa\util;

/**
 * Description of Processo
 *
 * @author raphael
 */
abstract class Processo {
    
    protected $id;
    
    protected $input;
    
    protected $output;
    
    /** 
     * @param array $input
     * @param string|integer $id
     */
    public function __construct(array $input = [], $id = null) {
        $this->input = $input;
        $this->id = $id;
    }
    
    /** 
     * @param callable $callback
     */
    public function process(callable $callback) {
        $this->output = call_user_func_array($callback, $this->input);
    }
    
    /** 
     * @return mixed
     */
    public function getOutput() {
        return $this->output;
    }
    
    /**
     * @return void Somente retorna quando existe algum output do processamento.
     */
    public function wait() {
        
        while ( ! isset($this->output)) {
            
        }
        
    }

    
}
