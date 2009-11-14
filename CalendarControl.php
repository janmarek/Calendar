<?php

/**
 * Description of CalendarControl
 *
 * @author Honza
 */
class CalendarControl extends Control {

	/** @var int */
	public $month;
	
	/** @var int */
	public $year;

	protected function createTemplate() {
		$template = parent::createTemplate();
		$template->setFile(dirname(__FILE__) . "/calendar.phtml");
		return $template;
	}

	public function setTemplateFile($filename) {
		$this->getTemplate()->setFile($filename);
	}

	/**
	 * Render calendar
	 */
	public function render($mont = null, $year = null) {
		if ($month === null) {
			$month = $this->month ? $this->month : (int) date("n");
		}

		$this->setTemplate();

		if ($year === null) {
			$year = $this->year ? $this->year : (int) date("Y");
		}

		$template = $this->createTemplate();
		$template->setFile();

		$timestamp = mktime(0, 0, 0, $this->month, 1, $this->year);

		// current date
		$template->currentDay = date("j");
		$template->currentMonth = date("n");
		$template->currentYear = date("Y");

		// days
		$template->day = date("j", $timestamp);
		$template->firstDay = date("N", $timestamp) - 1;
		$template->daysInMonth = date("t", $timestamp);

		// month
		$template->month = $this->month;
		$template->prevMonth = $this->month === 1 ? 12 : $this->month - 1;
		$template->nextMonth = $this->month === 12 ? 1 : $this->month + 1;

		// year
		$template->year = $this->year;
		$template->prevYear = $this->month === 1 ? $this->year - 1 : $this->year;
		$template->nextYear = $this->month === 12 ? $this->year + 1 : $this->year;

		// events
		$template->events = $this->model->events->getMonthList($this->month, $this->year);

		$template->render();
	}
}