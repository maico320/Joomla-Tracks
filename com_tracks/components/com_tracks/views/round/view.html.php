<?php
/**
* @version    $Id: view.html.php 77 2008-04-30 03:32:25Z julienv $ 
* @package    JoomlaTracks
* @copyright	Copyright (C) 2008 Julien Vonthron. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla Tracks is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Tracks component
 *
 * @static
 * @package		Tracks
 * @since 0.1
 */
class TracksFrontViewRound extends JView
{
    function display($tpl = null)
    {
        global $mainframe;
        
				$dispatcher = & JDispatcher::getInstance();
		
        $round_id = JRequest::getVar( 'r', 0, '', 'int' );
                
    		$model =& $this->getModel();
        $round = $model->getRound( $round_id );
                
        $breadcrumbs =& $mainframe->getPathWay();
        $breadcrumbs->addItem( $round->name, 
                        'index.php?view=round&r=' . $round_id );
        
        $document =& JFactory::getDocument();
        $document->setTitle( $round->name );
        
        // parse description with content plugins
				$round->description = JHTML::_('content.prepare', $round->description);
				
        $this->assignRef( 'round',    $round );

        parent::display($tpl);
    }
}
?>
