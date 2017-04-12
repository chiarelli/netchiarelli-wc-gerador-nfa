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

use Assert\Assertion;
use NetChiarelli\WP_Plugin_NFe\assert\Assertions;
use NetChiarelli\WP_Plugin_NFe\util\inner\ProcessoIterator;

/**
 * Description of ProcessoChain
 *
 * @author raphael
 */
class ProcessoChain {
    
    /** @var IProcesso[] */
    protected $processList;
    
    public function __construct(array $processList) {        
        Assertion::satisfy(
            array($processList, ITask::class), 
            array(Assertions::class, 'valuesArrayIsInstanceOf')
        );
        
        $this->processList = $processList;
    }

    public function getOutput() {
        $result = [];
        foreach ($this->processList as $process) {
            $result[] = $process->getOutput();
        }
        return new ProcessoIterator($result);
    }

    public function process(callable $callback) {
        foreach ($this->processList as $process) {
            $process->process($callback);
        }
    }

    public function wait() {
        foreach ($this->processList as $process) {
            $process->wait();
        }
    }

}

namespace NetChiarelli\WP_Plugin_NFe\util\inner;

/**
 * @internal Classe interna. Somente para ser associada à classe ProcessoChain.
 */
class ProcessoIterator implements \Iterator {
    
    protected $position;
    
    /** var mixed[] */
    protected $outputList;
    
    public function __construct(array $outputList) {
        $this->outputList = $outputList;
        $this->position = 0;
    }

    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->outputList[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->outputList[$this->position]);
    }

}