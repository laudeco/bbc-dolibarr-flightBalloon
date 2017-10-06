<?php
/* Copyright (C) 2017 laurent De Coninck <lau.deconinck@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @param Bbc_ballons $object
 *
 * To show more tab from another module, you have to configure this from the module configuration
 * * 'entity:+tabname:Title:@hello:/hello/mypage.php?id=__ID__'
 * * 'entity:-tabname:Title:@hello:/hello/mypage.php?id=__ID__'
 *
 * @return array
 */
function balloonPrepareHead($object)
{
	global $langs, $conf;

	dol_include_once('/flightballoon/class/tab/Tab.php');
	dol_include_once('/flightballoon/class/tab/TabBar.php');

	$langs->load("mymodule@flightballoon");

	$head = new TabBar();
	$head->addTab(new Tab($langs->trans("CardBalloon"), 'balloon', dol_buildpath("/flightballoon/balloon_card?id=".$object->id, 1)));

	$tabs = $head->toArray();
	complete_head_from_modules($conf, $langs, $object, $tabs, count($tabs), 'balloon');

	return $tabs;
}