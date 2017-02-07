<?php
/* Copyright (C) 2007-2011 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *      \file       dev/skeletons/bbc_ballons.class.php
 *      \ingroup    mymodule othermodule1 othermodule2
 *      \brief      This file is an example for a CRUD class file (Create/Read/Update/Delete)
 *		\version    $Id: bbc_ballons.class.php,v 1.32 2011/07/31 22:21:58 eldy Exp $
 *		\author		Put author name here
 *		\remarks	Initialy built by build_class_from_table on 2012-10-07 17:37
 */

// Put here all includes required by your class file
//require_once(DOL_DOCUMENT_ROOT."/core/class/commonobject.class.php");
//require_once(DOL_DOCUMENT_ROOT."/societe/class/societe.class.php");
//require_once(DOL_DOCUMENT_ROOT."/product/class/product.class.php");


/**
 *      \class      Bbc_ballons
 *      \brief      Put here description of your class
 *		\remarks	Initialy built by build_class_from_table on 2012-10-07 17:37
 */
class Bbc_ballons // extends CommonObject
{
	var $db;							//!< To store db handler
	var $error;							//!< To return error code (or message)
	var $errors=array();				//!< To return several error codes (or messages)
	//var $element='bbc_ballons';			//!< Id that identify managed objects
	//var $table_element='bbc_ballons';	//!< Name of table without prefix where object is stored

    var $id;
    
	var $immat;
	var $marraine;
	var $fk_responsable;
	var $fk_co_responsable;
	var $date='';
	var $init_heure;
	var $is_disable;
	var $picture;

    


    /**
     *      Constructor
     *      @param      DB      Database handler
     */
    function Bbc_ballons($DB)
    {
        $this->db = $DB;
        return 1;
    }


    /**
     *      Create object into database
     *      @param      user        	User that create
     *      @param      notrigger	    0=launch triggers after, 1=disable triggers
     *      @return     int         	<0 if KO, Id of created object if OK
     */
    function create($user, $notrigger=0)
    {
    	global $conf, $langs;
		$error=0;

		// Clean parameters
        
		if (isset($this->immat)) $this->immat=trim($this->immat);
		if (isset($this->marraine)) $this->marraine=trim($this->marraine);
		if (isset($this->fk_responsable)) $this->fk_responsable=trim($this->fk_responsable);
		if (isset($this->fk_co_responsable)) $this->fk_co_responsable=trim($this->fk_co_responsable);
		if (isset($this->init_heure)) $this->init_heure=trim($this->init_heure);
		if (isset($this->is_disable)) $this->is_disable=trim($this->is_disable);
		if (isset($this->picture)) $this->picture=trim($this->picture);

        

		// Check parameters
		// Put here code to add control on parameters values

        // Insert request
		$sql = "INSERT INTO ".MAIN_DB_PREFIX."bbc_ballons(";
		
		$sql.= "immat,";
		$sql.= "marraine,";
		$sql.= "fk_responsable,";
		$sql.= "fk_co_responsable,";
		$sql.= "date,";
		$sql.= "init_heure,";
		$sql.= "is_disable,";
		$sql.= "picture";

		
        $sql.= ") VALUES (";
        
		$sql.= " ".(! isset($this->immat)?'NULL':"'".$this->db->escape($this->immat)."'").",";
		$sql.= " ".(! isset($this->marraine)?'NULL':"'".$this->db->escape($this->marraine)."'").",";
		$sql.= " ".(! isset($this->fk_responsable)?'NULL':"'".$this->fk_responsable."'").",";
		$sql.= " ".(! isset($this->fk_co_responsable)?'NULL':"'".$this->fk_co_responsable."'").",";
		$sql.= " ".(! isset($this->date) || dol_strlen($this->date)==0?'NULL':$this->db->idate($this->date)).",";
		$sql.= " ".(! isset($this->init_heure)?'NULL':"'".$this->init_heure."'").",";
		$sql.= " ".(! isset($this->is_disable)?'0':"'".$this->is_disable."'").",";
		$sql.= " ".(! isset($this->picture)?'NULL':"'".$this->picture."'")."";

        
		$sql.= ")";

		$this->db->begin();

	   	dol_syslog(get_class($this)."::create sql=".$sql, LOG_DEBUG);
        $resql=$this->db->query($sql);
    	if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }

		if (! $error)
        {
            $this->id = $this->db->last_insert_id(MAIN_DB_PREFIX."bbc_ballons");

			if (! $notrigger)
			{
	            // Uncomment this and change MYOBJECT to your own tag if you
	            // want this action call a trigger.

	            //// Call triggers
	            //include_once(DOL_DOCUMENT_ROOT . "/core/class/interfaces.class.php");
	            //$interface=new Interfaces($this->db);
	            //$result=$interface->run_triggers('MYOBJECT_CREATE',$this,$user,$langs,$conf);
	            //if ($result < 0) { $error++; $this->errors=$interface->errors; }
	            //// End call triggers
			}
        }

        // Commit or rollback
        if ($error)
		{
			foreach($this->errors as $errmsg)
			{
	            dol_syslog(get_class($this)."::create ".$errmsg, LOG_ERR);
	            $this->error.=($this->error?', '.$errmsg:$errmsg);
			}
			$this->db->rollback();
			return -1*$error;
		}
		else
		{
			$this->db->commit();
            return $this->id;
		}
    }


    /**
     *    Load object in memory from database
     *    @param      id          id object
     *    @return     int         <0 if KO, >0 if OK
     */
    function fetch($id)
    {
    	global $langs;
        $sql = "SELECT";
		$sql.= " t.rowid,";
		
		$sql.= " t.immat,";
		$sql.= " t.marraine,";
		$sql.= " t.fk_responsable,";
		$sql.= " t.fk_co_responsable,";
		$sql.= " t.date,";
		$sql.= " t.init_heure,";
		$sql.= " t.is_disable,";
		$sql.= " t.picture";

		
        $sql.= " FROM ".MAIN_DB_PREFIX."bbc_ballons as t";
        $sql.= " WHERE t.rowid = ".$id;

    	dol_syslog(get_class($this)."::fetch sql=".$sql, LOG_DEBUG);
        $resql=$this->db->query($sql);
        if ($resql)
        {
            if ($this->db->num_rows($resql))
            {
                $obj = $this->db->fetch_object($resql);

                $this->id    = $obj->rowid;
                
				$this->immat = $obj->immat;
				$this->marraine = $obj->marraine;
				$this->fk_responsable = $obj->fk_responsable;
				$this->fk_co_responsable = $obj->fk_co_responsable;
				$this->date = $this->db->jdate($obj->date);
				$this->init_heure = $obj->init_heure;
				$this->is_disable = $obj->is_disable;
				$this->picture = $obj->picture;

                
            }
            $this->db->free($resql);

            return 1;
        }
        else
        {
      	    $this->error="Error ".$this->db->lasterror();
            dol_syslog(get_class($this)."::fetch ".$this->error, LOG_ERR);
            return -1;
        }
    }


    /**
     *      Update object into database
     *      @param      user        	User that modify
     *      @param      notrigger	    0=launch triggers after, 1=disable triggers
     *      @return     int         	<0 if KO, >0 if OK
     */
    function update($user=0, $notrigger=0)
    {
    	global $conf, $langs;
		$error=0;

		// Clean parameters
        
		if (isset($this->immat)) $this->immat=trim($this->immat);
		if (isset($this->marraine)) $this->marraine=trim($this->marraine);
		if (isset($this->fk_responsable)) $this->fk_responsable=trim($this->fk_responsable);
		if (isset($this->fk_co_responsable)) $this->fk_co_responsable=trim($this->fk_co_responsable);
//		if (isset($this->init_heure)) $this->init_heure=trim($this->init_heure);
		if (isset($this->is_disable)) $this->is_disable=trim($this->is_disable);
		if (isset($this->picture)) $this->picture=trim($this->picture);

        

		// Check parameters
		// Put here code to add control on parameters values

        // Update request
        $sql = "UPDATE ".MAIN_DB_PREFIX."bbc_ballons SET";
        
		$sql.= " immat=".(isset($this->immat)?"'".$this->db->escape($this->immat)."'":"null").",";
		$sql.= " marraine=".(isset($this->marraine)?"'".$this->db->escape($this->marraine)."'":"null").",";
		$sql.= " fk_responsable=".(isset($this->fk_responsable)?$this->fk_responsable:"null").",";
		$sql.= " fk_co_responsable=".(isset($this->fk_co_responsable)?$this->fk_co_responsable:"null").",";
		$sql.= " date=".(dol_strlen($this->date)!=0 ? "'".$this->db->idate($this->date)."'" : 'null').",";
		$sql.= " init_heure=".(isset($this->init_heure)?"'".$this->init_heure."'":"null").",";
		$sql.= " is_disable=".(isset($this->is_disable)?"'".$this->is_disable."'":"'0'").",";
//		$sql.= " is_disable='0',";
		$sql.= " picture=".(isset($this->picture)?$this->picture:"null")."";

        
        $sql.= " WHERE rowid=".$this->id;

        
		$this->db->begin();

		dol_syslog(get_class($this)."::update sql=".$sql, LOG_DEBUG);
        $resql = $this->db->query($sql);
    	if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }

		if (! $error)
		{
			if (! $notrigger)
			{
	            // Uncomment this and change MYOBJECT to your own tag if you
	            // want this action call a trigger.

	            //// Call triggers
	            //include_once(DOL_DOCUMENT_ROOT . "/core/class/interfaces.class.php");
	            //$interface=new Interfaces($this->db);
	            //$result=$interface->run_triggers('MYOBJECT_MODIFY',$this,$user,$langs,$conf);
	            //if ($result < 0) { $error++; $this->errors=$interface->errors; }
	            //// End call triggers
	    	}
		}

        // Commit or rollback
		if ($error)
		{
			foreach($this->errors as $errmsg)
			{
	            dol_syslog(get_class($this)."::update ".$errmsg, LOG_ERR);
	            $this->error.=($this->error?', '.$errmsg:$errmsg);
			}
			$this->db->rollback();
			return -1*$error;
		}
		else
		{
			$this->db->commit();
			return 1;
		}
    }


 	/**
	 *   Delete object in database
     *	 @param     user        	User that delete
     *   @param     notrigger	    0=launch triggers after, 1=disable triggers
	 *   @return	int				<0 if KO, >0 if OK
	 */
	function delete($user, $notrigger=0)
	{
		global $conf, $langs;
		$error=0;

		$sql = "DELETE FROM ".MAIN_DB_PREFIX."bbc_ballons";
		$sql.= " WHERE rowid=".$this->id;

		$this->db->begin();

		dol_syslog(get_class($this)."::delete sql=".$sql);
		$resql = $this->db->query($sql);
    	if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }

		if (! $error)
		{
			if (! $notrigger)
			{
				// Uncomment this and change MYOBJECT to your own tag if you
		        // want this action call a trigger.

		        //// Call triggers
		        //include_once(DOL_DOCUMENT_ROOT . "/core/class/interfaces.class.php");
		        //$interface=new Interfaces($this->db);
		        //$result=$interface->run_triggers('MYOBJECT_DELETE',$this,$user,$langs,$conf);
		        //if ($result < 0) { $error++; $this->errors=$interface->errors; }
		        //// End call triggers
			}
		}

        // Commit or rollback
		if ($error)
		{
			foreach($this->errors as $errmsg)
			{
	            dol_syslog(get_class($this)."::delete ".$errmsg, LOG_ERR);
	            $this->error.=($this->error?', '.$errmsg:$errmsg);
			}
			$this->db->rollback();
			return -1*$error;
		}
		else
		{
			$this->db->commit();
			return 1;
		}
	}



	/**
	 *		Load an object from its id and create a new one in database
	 *		@param      fromid     		Id of object to clone
	 * 	 	@return		int				New id of clone
	 */
	function createFromClone($fromid)
	{
		global $user,$langs;

		$error=0;

		$object=new Bbc_ballons($this->db);

		$this->db->begin();

		// Load source object
		$object->fetch($fromid);
		$object->id=0;
		$object->statut=0;

		// Clear fields
		// ...

		// Create clone
		$result=$object->create($user);

		// Other options
		if ($result < 0)
		{
			$this->error=$object->error;
			$error++;
		}

		if (! $error)
		{



		}

		// End
		if (! $error)
		{
			$this->db->commit();
			return $object->id;
		}
		else
		{
			$this->db->rollback();
			return -1;
		}
	}


	/**
	 *		Initialisz object with example values
	 *		Id must be 0 if object instance is a specimen.
	 */
	function initAsSpecimen()
	{
		$this->id=0;
		
		$this->immat='';
		$this->marraine='';
		$this->fk_responsable='';
		$this->date='';
		$this->init_heure='';
		$this->is_disable='';
		$this->picture='';

		
	}

}
?>
