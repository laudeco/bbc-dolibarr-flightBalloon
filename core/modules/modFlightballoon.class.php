<?php

/* Copyright (C) 2003      Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2009 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2010 Regis Houssin        <regis@dolibarr.fr>
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
 *      \file       htdocs/includes/modules/modFlightballoon.class.php
 *      \ingroup    mymodule
 *      \brief      Description and activation file for module MyModule
 * 		\version	$Id: modFlightballoon.class.php,v 1.67 2011/08/01 13:26:21 hregis Exp $
 */
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';

/**
 * 		\class      modFlightballoon
 *      \brief      Description and activation class for module MyModule
 */
class modFlightballoon extends DolibarrModules {

    const MENU_TYPE_LEFT = 'left';
    const MENU_TYPE_TOP = 'top';

    /**
     *   \brief      Constructor. Define names, constants, directories, boxes, permissions
     *   \param      DB      Database handler
     */
    function __construct($db) {
        global $langs, $conf;

        $this->db = $db;

        $this->numero = 500001;
        $this->rights_class = 'flightballoon';
        $this->family = "Belgian Balloon Club";
        $this->module_position = 501;

        $this->name = preg_replace('/^mod/i','',get_class($this));
        $this->description = "Manage balloons";
        $this->descriptionlong = "Manage balloon for the Belgian Balloon Club";
        $this->editor_name = 'De Coninck Laurent';
        $this->editor_url = 'http://www.dolibarr.org';
        $this->version = '1.0';
        $this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
        // Name of image file used for this module.
        // If file is in theme/yourtheme/img directory under name object_pictovalue.png, use this->picto='pictovalue'
        // If file is in module/img directory under name object_pictovalue.png, use this->picto='pictovalue@module'
        $this->picto='generic';
        $this->module_parts = array();
        $this->dirs = array();

        // Config pages. Put here list of php page, stored into mymodule/admin directory, to use to setup module.
        $this->config_page_url = array();

        // Dependencies
        $this->hidden = false;
        $this->depends = array();
        $this->requiredby = array();
        $this->phpmin = array(5, 5);
        $this->need_dolibarr_version = array(4,0);
        $this->langfiles = array("mymodule@flightballoon");
        $this->tabs = array();

        $this->initDictionnaries();
        $this->initPermissions();
        $this->initMenus();
    }

    /**
     * 		Function called when module is enabled.
     * 		The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
     * 		It also creates data directories.
     *      @return     int             1 if OK, 0 if KO
     */
    function init() {
        $sql = array();

        $result = $this->load_tables();

        return $this->_init($sql);
    }

    /**
     * 		Function called when module is disabled.
     *      Remove from database constants, boxes and permissions from Dolibarr database.
     * 		Data directories are not deleted.
     *      @return     int             1 if OK, 0 if KO
     */
    function remove() {
        $sql = array();

        return $this->_remove($sql);
    }

    /**
     * 		\brief		Create tables, keys and data required by module
     * 					Files llx_table1.sql, llx_table1.key.sql llx_data.sql with create table, create keys
     * 					and create data commands must be stored in directory /mymodule/sql/
     * 					This function is called by this->init.
     * 		\return		int		<=0 if KO, >0 if OK
     */
    function load_tables() {
        return $this->_load_tables('/flightballoon/sql/');
    }

    /**
     * Initi dictionnaries
     */
    private function initDictionnaries()
    {
        $this->initPieceTypesDictionnaries();
    }

    /**
     * Init piece type dictionnaries
     */
    private function initPieceTypesDictionnaries()
    {
        $this->dictionaries = array(
            'langs' => 'dictionnaries@flightballoon',
            'tabname' => array(MAIN_DB_PREFIX . "bbc_types_pieces"),
            'tablib' => array("Types de pièces"),
            'tabsql' => array('SELECT f.idType, f.numero, f.nom, f.active FROM ' . MAIN_DB_PREFIX . 'bbc_types_pieces as f',),
            'tabsqlsort' => array("numero ASC"),
            'tabfield' => array("idType,numero,nom"),
            'tabfieldvalue' => array("numero,nom"),
            'tabfieldinsert' => array("numero,nom"),
            'tabrowid' => array("idType"),
            'tabcond' => array('$conf->flightballoon->enabled'),
        );
    }

    /**
     *
     */
    private function initPermissions()
    {
        $this->rights = [];

        $this->addPermission(9981,'Ajouter un nouveau Ballon.', 'bal','access', true);
        $this->addPermission(9988,'Ajouter un nouveau Ballon.', 'bal','add');
        $this->addPermission(9986,'Permet de supprimer un ballon.', 'bal','del');
        $this->addPermission(9985,'Editer un ballon.', 'bal','edit');
        $this->addPermission(9984,'ajouter un composant un ballon', 'piece','add');
        $this->addPermission(9983,'retirer une piece d\'un ballon', 'piece','del');
        $this->addPermission(9982,'editer une piece', 'piece','edit');
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $levelOne
     * @param string $levelTwo
     * @param bool $default
     */
    private function addPermission($id, $name, $levelOne, $levelTwo, $default = false)
    {

        $this->rights[] = [
            $id,
            $name,
            null,
            (int)$default,
            $this->camelCase($levelOne),
            $this->camelCase($levelTwo)
        ];
    }

    /**
     * @return string
     */
    private function camelCase($word){
        return lcfirst(str_replace('' ,'', ucwords(strtr($word, '_-', ' '))));
    }

    /**
     * 
     */
    private function initMenus()
    {
        $this->menus = array();

        $this->menu[] = array(
            'fk_menu'  => '',
            'type'     => self::MENU_TYPE_TOP,
            'titre'    => 'Ballons',
            'mainmenu' => 'flightballoon',
            'leftmenu' => '',
            'url'      => '/flightballoon/list.php',
            'langs'    => 'mylangfile',
            'position' => 100,
            'enabled'  => '1',
            'perms'    => '$user->rights->flightballoon->bal->access',
            'target'   => '',
            'user'     => 0,
        );

        $this->menu[] = array(
            'fk_menu' => 'fk_mainmenu=flightballoon',
            'type' => self::MENU_TYPE_LEFT,
            'titre' => 'Ballons',
            'mainmenu' => 'flightballoon',
            'leftmenu' => 'listBalloons',
            'url' => '/flightballoon/list.php',
            'langs' => 'mylangfile',
            'position' => 201,
            'enabled' => '1',
            'perms' => '1',
            'target' => '',
            'user' => 2
        );

        $this->menu[] = array(
            'fk_menu' => 'fk_mainmenu=flightballoon,fk_leftmenu=listBalloons',
            'type' => self::MENU_TYPE_LEFT,
            'titre' => 'Ajouter',
            'mainmenu' => 'flightballoon',
            'url' => '/flightballoon/balloon_card.php?action=add',
            'langs' => 'mylangfile',
            'position' => 202,
            'enabled' => '1',
            'perms' => '$user->rights->flightballoon->bal->add',
            'target' => '',
            'user' => 2
        );

        $this->menu[] = array(
            'fk_menu' => 'fk_mainmenu=flightballoon',
            'type' => self::MENU_TYPE_LEFT,
            'titre' => 'Pieces',
            'mainmenu' => 'flightballoon',
            'url' => '/flightballoon/pages/pieces/pieces.php',
            'langs' => 'mylangfile',
            'position' => 204,
            'enabled' => '1',
            'perms' => '$user->rights->flightballoon->piece->add',
            'target' => '',
            'user' => 2
        );
    }

}

?>
