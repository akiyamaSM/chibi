<?php


namespace Kolores\Template;


trait DoesntUseUnassignedVars {


    /**
     *  Parse the variables in the template
     * @return $this
     * @throws \Exception
     */
    protected function parseVariables()
    {
        if ($this->checkUnassignedVariables($value)) {
            throw new \Exception("variable <b>$".$value."</b> is undefined");
        }
        return $this;
    }

    /**
     * Get the variables in the template
     *
     * @return array
     */
    protected function getTemplateVars() {
        $matches = [];
        preg_match_all('/{{\s*(\$(.*?))\s*}}/', $this->contents,$matches);
        return isset($matches[2]) ? $matches[2] : [];
    }

    /**
     * Check if there are some unassigned variables
     *
     * @param $value
     * @return bool
     */
    protected function checkUnassignedVariables(&$value) {
        $diff = array_diff($this->getTemplateVars(),array_keys($this->vars));
        if (count($diff) > 0)  {
            $value = array_values($diff)[0];
        }
        return count($diff) > 0;
    }
}