<?php
/**
* @version    $Id: view.html.php 135 2008-06-08 21:50:12Z julienv $ 
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
class TracksFrontViewRanking extends JView
{
  function display($tpl = null)
  {
    global $mainframe;

    $project_id = JRequest::getVar( 'p', 0, '', 'int' );
    
    $model =& $this->getModel();
    $rankings =& $model->getRankings( $project_id );
    $project  =& $model->getProject( $project_id );
        
    $params =& $model->getParams( $project_id );
    $params->merge( JComponentHelper::getParams( 'com_tracks' ) );

    $breadcrumbs =& $mainframe->getPathWay();
    $breadcrumbs->addItem( $project->name. ' ' . JText::_( 'Rankings' ), 'index.php?option=com_tracks&view=ranking&p=' . $project_id );

    $document =& JFactory::getDocument();
    $document->setTitle( $project->name. ' ' . JText::_( 'Rankings' ) );

    $this->assignRef( 'params',    $params );
    $this->assignRef( 'project',    $project );
    $this->assignRef( 'rankings',	$rankings );

    parent::display($tpl);
  }
}
?>
