<?php
defined('_JEXEC') or die;

/**
 * Joomla component com_gglms
 *
 * @package WebTV
 * Router.php
 */
class wizardRouter extends JComponentRouterBase
{

    function build(&$query)
    {
        $segments = array();

//        if (isset($query['view'])) {
//            $segments[] = $query['view'];
//            unset($query['view']);
//        }

        if (isset($query['id'])) {
            $segments[] = $query['id'];
            unset($query['id']);
        }

        if (isset($query['type'])) {
            $segments[] = $query['type'];
            unset($query['type']);
        }

        return $segments;
    }

    function parse(&$segments)
    {

        $db = JFactory::getDbo();
        $vars = array();

        switch ($segments[0]) {

            default:
            
                $vars['view'] = 'wizard';
                break;

                return $vars;


        }
    }

    function wizardBuildRoute(&$query)
    {
        $router = new GglmsRouter;
        return $router->build($query);
    }

    function wizardParseRoute($segments)
    {
        $router = new wizardRouter;

        return $router->parse($segments);
    }
}


