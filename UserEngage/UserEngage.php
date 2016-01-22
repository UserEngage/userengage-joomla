<?php
/**
 *
 * Plugin Name: UserEngage.io Plugin
 * Description: UserEngage.io Plugin for Joomla.
 * @package Joomla
 * @subpackage Modules
 * @link https://userengage.io
 * @copyright Copyright 2014  UserEngage.io. All rights reserved.
 * @license GNU/GPL, see LICENSE.php
 *
 * This program is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemUserEngage extends JPlugin
{
    function plgUserEngage(&$subject, $config)
    {
        parent::__construct($subject, $config);
        $this->_plugin = JPluginHelper::getPlugin('system', 'UserEngage');
        $this->_params = new JParameter($this->_plugin->params);
    }

    function onAfterRender()
    {

        $apikey = $this->params->get('code', '');
        $widget = '';
        $app = JFactory::getApplication();

        if ($app->isAdmin()) {
            return;
        }

        $user = JFactory::getUser();

        $buffer = JResponse::getBody();

         $widget .= "<script type=\"text/javascript\">
            window.civchat = {
            apiKey: \"$apikey\",
            name: \"$user->name\",
            email: \"$user->email\"
            };</script>" . "
        <script src=\"https://widget.userengage.io/widget.js\"></script>";

        $buffer = preg_replace("/<\/head>/", "\n\n" . $widget . "\n\n</head>", $buffer);

        JResponse::setBody($buffer);

        return true;
    }
}
?>
