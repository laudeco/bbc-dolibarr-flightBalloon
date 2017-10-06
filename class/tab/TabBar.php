<?php
/**
 *
 */

/**
 * TabBar class
 *
 * @author Laurent De Coninck <lau.deconinck@gmail.com>
 */
class TabBar
{

	/**
	 * @var array|Tab[]
	 */
	private $bar;

	/**
	 * TabBar constructor.
	 */
	public function __construct()
	{
		$this->bar = [];
	}

	/**
	 * @param Tab $tab
	 */
	public function addTab(Tab $tab) {
		$this->bar[] = $tab;
	}

	/**
	 * @retuern array
	 */
	public function toArray() {
		$menuAsArray = [];
		foreach ($this->bar as $tab) {
			$menuAsArray[] = $tab->toArray();
		}

		return $menuAsArray;
	}


}