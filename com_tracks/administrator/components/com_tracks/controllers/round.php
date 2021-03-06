<?php
/**
* @version    $Id: round.php 94 2008-05-02 10:28:05Z julienv $ 
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

jimport('joomla.application.component.controller');

/**
 * Joomla Tracks Component Controller
 *
 * @package		Tracks
 * @since 0.1
 */
class TracksControllerRound extends BaseController
{
  
  function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add',  'edit' );
		$this->registerTask( 'apply', 'save' );
	}
	
	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'round' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}
	
  function save()
	{
		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = (int) $cid[0];
		// data from editor must be retrieved as raw
        $post['description'] = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$model = $this->getModel('round');

		if ($returnid = $model->store($post)) {
			$msg = JText::_( 'Round Saved' );
		} else {
			$msg = JText::_( 'Error Saving Round' ).$model->getError();
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		 
    //redirect
    if ( !$returnid || $this->getTask() == 'save' ) {
      $link = 'index.php?option=com_tracks&view=rounds';
    }
    else {
      $link = 'index.php?option=com_tracks&controller=round&task=edit&cid[]='.$returnid;
    }
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('round');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Rounds Could not be Deleted' );
		} else {
			$msg = JText::_( 'Round(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_tracks&view=rounds', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
    // Checkin the project
    $model = $this->getModel('round');
    $model->checkin();
    
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_tracks&view=rounds', $msg );
	}
	
	
	function publish()
	{		
	  $cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('round');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
    $link = 'index.php?option=com_tracks&view=rounds';
		$this->setRedirect($link);
	}


	function unpublish()
	{
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('round');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
    $link = 'index.php?option=com_tracks&view=rounds';
		$this->setRedirect($link);
	}
	
	function saveorder()
	{
		$cid    = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order  = JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel('round');
		$model->saveorder($cid, $order);

		$msg = 'New ordering saved';
		$this->setRedirect( 'index.php?option=com_tracks&view=rounds', $msg );
	}
	
}
?>
