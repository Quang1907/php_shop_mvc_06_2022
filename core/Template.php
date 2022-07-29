<?php

class Template
{
    private $_content = null;
    public function run($content, $data = [])
    {
        echo "<pre>";
        extract($data);
        if (!empty($content)) {
            $this->_content = $content;
            $this->printEntities();
            $this->printRaw();
            $this->ifCondition();
            $this->phpBefore();
            $this->phpAfter();
            $this->foreachLoop();
            $this->forLoop();
            $this->whileLoop();
            // echo $this->_content;
            eval("?>$this->_content<?php");
        }
    }

    public function printEntities()
    {
        preg_match_all("~{{\s*(.+?)\s*}}~", $this->_content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $item) {
                /** $this->_content = preg_replace("~{{\s*(.+?)\s*}}~", "<?= htmlentities($item)?>", $this->_content); */
                $this->_content = str_replace($matches[0][$key], "<?= htmlentities($item)?>", $this->_content);
            }
        }
    }

    public function printRaw()
    {
        preg_match_all("~{!\s*(.+?)\s*!}~", $this->_content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $item) {
                $this->_content = str_replace($matches[0][$key], "<?= $item ?>", $this->_content);
            }
        }
    }

    public function ifCondition()
    {
        // if
        preg_match_all("~@if\s*\((.+?)\s*\)\s*$~im", $this->_content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $item) {
                $this->_content = str_replace($matches[0][$key], "<?php if($item):?>", $this->_content);
            }
        }

        // else
        preg_match_all("~@else\s*$~im", $this->_content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key => $item) {
                $this->_content = str_replace($matches[0][$key], "<?php else: ?>", $this->_content);
            }
        }

        // elseif
        preg_match_all("~@elseif\s*\((.+?)\s*\)\s*$~im", $this->_content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $item) {
                $this->_content = str_replace($matches[0][$key], "<?php elseif($item):?>", $this->_content);
            }
        }

        // endif
        preg_match_all("~@endif\s*$~im", $this->_content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key => $item) {
                $this->_content = str_replace($matches[0][$key], "<?php endif; ?>", $this->_content);
            }
        }
    }

    public function phpBefore()
    {
        preg_match_all("~@php~is", $this->_content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key => $item) {
                $this->_content = str_replace($matches[0][$key], "<?php", $this->_content);
            }
        }
        // print_r($matches);
    }


    public function phpAfter()
    {
        preg_match_all("~@endphp~is", $this->_content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key => $item) {
                $this->_content = str_replace($matches[0][$key], "?>", $this->_content);
            }
        }
    }

    public function forLoop()
    {
        // \s*\((.+?)\s*\)\s*$~im
        preg_match_all("~@for\s*\((.+?)\s*\)\s*$~im", $this->_content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $item) {
                $this->_content = str_replace($matches[0][$key], "<?php for($item): ?>", $this->_content);
            }
        }

        preg_match_all("~@endfor~is", $this->_content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key => $item) {
                // echo $matches[0][$key];
                $this->_content = str_replace($matches[0][$key], "<?php endfor; ?>", $this->_content);
            }
        }
    }

    public function whileLoop()
    {
        // \s*\((.+?)\s*\)\s*$~im
        preg_match_all("~@while\s*\((.+?)\s*\)\s*$~im", $this->_content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $item) {
                $this->_content = str_replace($matches[0][$key], "<?php while($item): ?>", $this->_content);
            }
        }

        preg_match_all("~@endwhile~is", $this->_content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key => $item) {
                // echo $matches[0][$key];
                $this->_content = str_replace($matches[0][$key], "<?php endwhile; ?>", $this->_content);
            }
        }
    }

    public function foreachLoop()
    {
        preg_match_all("~@foreach\s*\((.+?)\s*\)\s*$~im", $this->_content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $item) {
                $this->_content = str_replace($matches[0][$key], "<?php foreach($item): ?>", $this->_content);
            }
        }

        preg_match_all("~@endforeach~is", $this->_content, $matches);
        if (!empty($matches[0])) {
            foreach ($matches[0] as $key => $item) {
                // echo $matches[0][$key];
                $this->_content = str_replace($matches[0][$key], "<?php endforeach; ?>", $this->_content);
            }
        }
    }


}
