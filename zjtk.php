<?php
/**
* ZJTK
*
* @author Zoxuyu
* @version 1.0.0
*/
class Alias
{
    private $prefix_divider = "-";
    private $suffix_divider = "-";
    private $alias_replacements_prefixes = array();
    private $language_suffixes = array();
    private $alias;
    function __construct()
    {
        $app = JFactory::getApplication();
        $id = JRequest::getInt('id');
        $article =& JTable::getInstance('content');
        $article->load($id);
        $alias = $article->get('alias');
        if($alias == "")
        {
           $alias = $app->getMenu()->getActive()->alias;
        }
        $this->alias = $alias;
    }
    function AddPrefix($prefix, $replacement)
    {
        $this->alias_replacements_prefixes[$prefix] = $replacement;
    }
    function AddLanguage($suffix, $replacement)
    {
        $this->language_suffixes[$suffix] = $replacement;
    }
    function GetAlias() { return $this->alias; }
    function GetPuredAlias()
    {
        $alias = $this->alias;
        foreach($this->alias_replacements_prefixes as $shortsfx => $longsfx)
        {
            foreach($this->language_suffixes as $shortprx => $longprx)
            {
                $prefix_divider = $this->prefix_divider;
                $suffix_divider = $this->suffix_divider;
                if(preg_match("/{$shortsfx}{$prefix_divider}(.*){$suffix_divider}{$shortprx}/", $alias, $mtchs))
                {
                    return "$longsfx $mtchs[1] $longprx";
                }
            }
            if(preg_match("/{$shortsfx}{$prefix_divider}(.*)/", $alias, $mtchs))
            {
                return "$longsfx $mtchs[1]";
            }
        }
        foreach($this->language_suffixes as $shortprx => $longprx)
        {
            $prefix_divider = $this->prefix_divider;
            $suffix_divider = $this->suffix_divider;
            if(preg_match("/(.*){$suffix_divider}{$shortprx}/", $alias, $mtchs))
            {
                return "$mtchs[1] $longprx";
            }
        }
        return $alias;
    }
    function Config($what, $how)
    {
        if($what=="suffixDivider")
        {
            $this->suffix_divider = $how;
        }
        if($what=="prefixDivider")
        {
            $this->prefix_divider = $how;
        }
    }
}
?>
