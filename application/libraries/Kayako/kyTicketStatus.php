<?php
require_once('kyObjectBase.php');

/**
 * Part of PHP client to REST API of Kayako v4 (Kayako Fusion).
 * Compatible with Kayako version >= 4.01.204.
 *
 * Kayako TicketStatus object.
 *
 * @author Tomasz Sawicki (https://github.com/Furgas)
 */
class kyTicketStatus extends kyObjectBase {

	const TYPE_PUBLIC = 'public';
	const TYPE_PRIVATE = 'private';

	static protected $controller = '/Tickets/TicketStatus';
	static protected $object_xml_name = 'ticketstatus';
	protected $read_only = true;

	private $id = null;
	private $title = null;
	private $display_order = null;
	private $department_id = null;
	private $display_icon = null;
	private $type = null;
	private $display_in_main_list = null;
	private $mark_as_resolved = null;
	private $display_count = null;
	private $status_color = null;
	private $status_bg_color = null;
	private $reset_due_time = null;
	private $trigger_survey = null;
	private $staff_visibility_custom = null;
	private $staff_group_ids = array();

	protected function parseData($data) {
		$this->id = intval($data['id']);
		$this->title = $data['title'];
		$this->display_order = intval($data['displayorder']);
		$this->department_id = intval($data['departmentid']);
		$this->display_icon = $data['displayicon'];
		$this->type = $data['type'];
		$this->display_in_main_list = intval($data['displayinmainlist']) === 0 ? false : true;
		$this->mark_as_resolved = intval($data['markasresolved']) === 0 ? false : true;
		$this->display_count = intval($data['displaycount']) === 0 ? false : true;
		$this->status_color = $data['statuscolor'];
		$this->status_bg_color = $data['statusbgcolor'];
		$this->reset_due_time = intval($data['resetduetime']) === 0 ? false : true;
		$this->trigger_survey = intval($data['triggersurvey']) === 0 ? false : true;

		$this->staff_visibility_custom = intval($data['staffvisibilitycustom']) === 0 ? false : true;
		if ($this->staff_visibility_custom && is_array($data['staffgroupid'])) {
			foreach ($data['staffgroupid'] as $staff_group_id) {
				$this->staff_group_ids[] = intval($staff_group_id);
			}
		}
	}

	public function toString() {
		return sprintf("%s (type: %s)", $this->getTitle(), $this->getType());
	}

	public function getId($complete = false) {
		return $complete ? array($this->id) : $this->id;
	}

	/**
	 *
	 * @return string
	 * @filterBy()
	 * @orderBy()
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 *
	 * @return int
	 * @filterBy()
	 * @orderBy()
	 */
	public function getDisplayOrder() {
		return $this->display_order;
	}

	/**
	 *
	 * @return int
	 * @filterBy()
	 */
	public function getDepartmentId() {
		return $this->department_id;
	}

	/**
	 *
	 * @todo Cache the result in object private field.
	 * @return kyDepartment
	 */
	public function getDepartment() {
		if ($this->department_id === null || $this->department_id <= 0)
			return null;

		return kyDepartment::get($this->department_id);
	}

	/**
	 *
	 * @return string
	 */
	public function getDisplayIcon() {
		return $this->display_icon;
	}

	/**
	 *
	 * @return string
	 * @filterBy()
	 * @orderBy()
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 *
	 * @return bool
	 * @filterBy()
	 */
	public function getDisplayInMainList() {
		return $this->display_in_main_list;
	}

	/**
	 *
	 * @return bool
	 * @filterBy()
	 * @orderBy()
	 */
	public function getMarkAsResolved() {
		return $this->mark_as_resolved;
	}

	/**
	 *
	 * @return bool
	 * @filterBy()
	 * @orderBy()
	 */
	public function getDisplayCount() {
		return $this->display_count;
	}

	/**
	 *
	 * @return string
	 * @filterBy()
	 */
	public function getStatusColor() {
		return $this->status_color;
	}

	/**
	 *
	 * @return string
	 * @filterBy()
	 */
	public function getStatusBackgroundColor() {
		return $this->status_bg_color;
	}

	/**
	 *
	 * @return bool
	 * @filterBy()
	 */
	public function getResetDueTime() {
		return $this->reset_due_time;
	}

	/**
	 *
	 * @return bool
	 * @filterBy()
	 */
	public function getTriggerSurvey() {
		return $this->trigger_survey;
	}

	/**
	 *
	 * @return bool
	 * @filterBy()
	 */
	public function getStaffVisibilityCustom() {
		return $this->staff_visibility_custom;
	}

	/**
	 *
	 * @return int[]
	 * @filterBy(StaffGroupId)
	 * @orderBy(StaffGroupId)
	 */
	public function getStaffGroupIds() {
		return $this->staff_group_ids;
	}

	/**
	 *
	 * @todo Cache the result in object private field.
	 * @return kyResultSet
	 */
	public function getStaffGroups() {
		$staff_groups = array();
		foreach ($this->staff_group_ids as $staff_group_id) {
			$staff_groups[] = kyStaffGroup::get($staff_group_id);
		}
		return new kyResultSet($staff_groups);
	}
}