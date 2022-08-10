<?php
namespace ElementorExtensions\Modules\TheEventsCalendar;

use ElementorExtensions\Base\Module_Base;
use ElementorExtensions\Modules\TheEventsCalendar\Widgets\EE_The_Events_Calendar;

class Module extends Module_Base {

	public function __construct() {
		parent::__construct();

		$this->add_actions();
	}

	public function get_name() {
		return 'ee-mb-the-events-calendar';
	}

	public function get_widgets() {
		return [
			'The_Events_Calendar',
		];
	}

	public function getEventFilterAjax(){
		if(empty($_POST['action'])){
			wp_send_json_error( new \WP_Error( 'Bad Request' ) );
		}

		$ee_the_events_calendar = new EE_The_Events_Calendar();
		$ee_the_events_calendar->ee_mb_detail_event_view($_POST);
		wp_die();
	}

	public function getSummaryListAjax(){
		if(empty($_POST['action'])){
			wp_send_json_error( new \WP_Error( 'Bad Request' ) );
		}

		$ee_events = new EE_The_Events_Calendar();
		$ee_events->getSummaryListAjax($_POST);
		wp_die();
	}

	protected function add_actions() {
		add_action('wp_ajax_getEventFilterAjax', [ $this, 'getEventFilterAjax' ]);
		add_action('wp_ajax_nopriv_getEventFilterAjax', [ $this, 'getEventFilterAjax' ]);

		add_action('wp_ajax_getSummaryListAjaxTec', [ $this, 'getSummaryListAjax' ]);
		add_action('wp_ajax_nopriv_getSummaryListAjaxTec', [ $this, 'getSummaryListAjax' ]);

		add_action('wp_ajax_getEventListByDayTec', [ $this, 'getEventListByDay' ]);
		add_action('wp_ajax_nopriv_getEventListByDayTec', [ $this, 'getEventListByDay' ]);
	}

	/*
	 * @ Run ajax on calendar click
	 * It will fetch the list of events and display below the calendar
	 */
	public function getEventListByDay(){
		if(empty($_POST['action']) && $_POST['action'] !== 'getEventListByDay'){
			wp_send_json_error( new \WP_Error( 'Bad Request' ) );
		}

		$myeventon = new EE_The_Events_Calendar();
		$myeventon->getEventListByDay($_POST);
		wp_die();
	}
}
