<?php

class Template
{
    private $_content = null;
    public function run($content, $data = [])
    {
        echo "<pre>";
        extract($data);
        $this->_content = $content;
        $this->printEntities();
        $this->printRaw();
        $this->ifCondition();
        eval("?>$this->_content<?php");
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
}
