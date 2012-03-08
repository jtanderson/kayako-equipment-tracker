<?php
/**
 * This is the model for the TB_APISetting table on the database.
 *
 * @author Joseph Anderson
 */

class APISetting extends MY_Model{
	/**
	 * This is the constructor function.  It just initializes the custom
	 * Model class and sets the appropriate table name.
	 *
	 * @author Joseph Anderson
	 * @since 2012-03-08
	 * @version 2012-03-08
	 */
	function __construct(){
		parent::__construct();
		$this->table = "TB_APISetting";
	}
}

/**
 * End of apisetting.php
 */
?>