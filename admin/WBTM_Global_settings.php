<?php
	/*
   * @Author 		engr.sumonazma@gmail.com
   * Copyright: 	mage-people.com
   */
	if (!defined('ABSPATH')) {
		die;
	} // Cannot access pages directly.
	if (!class_exists('WBTM_Global_settings')) {
		class WBTM_Global_settings {
			protected $settings_api;
			public function __construct() {
				$this->settings_api = new MAGE_Setting_API;
				add_action('admin_menu', array($this, 'global_settings_menu'));
				add_action('admin_init', array($this, 'admin_init'));
				add_filter('mp_settings_sec_reg', array($this, 'settings_sec_reg'), 10);
				add_filter('mp_settings_sec_fields', array($this, 'settings_sec_fields'), 10);
			}
			public function global_settings_menu() {
				$label = WBTM_Functions::get_name();
				$cpt = WBTM_Functions::get_cpt();
				add_submenu_page('edit.php?post_type=' . $cpt, $label . esc_html__(' Settings', 'bus-ticket-booking-with-seat-reservation'), $label . esc_html__(' Settings', 'bus-ticket-booking-with-seat-reservation'), 'manage_options', 'wbtm_settings_page', array($this, 'settings_page'));
			}
			public function settings_page() {
				$label = WBTM_Functions::get_name();
				?>
				<div class="mpStyle mp_global_settings">
					<div class="mpPanel">
						<div class="mpPanelHeader"><?php echo esc_html($label . esc_html__(' Global Settings', 'ecab-taxi-booking-manager')); ?></div>
						<div class="mpPanelBody mp_zero">
							<div class="mpTabs leftTabs">
								<?php $this->settings_api->show_navigation(); ?>
								<div class="tabsContent">
									<?php $this->settings_api->show_forms(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			public function admin_init() {
				$this->settings_api->set_sections($this->get_settings_sections());
				$this->settings_api->set_fields($this->get_settings_fields());
				$this->settings_api->admin_init();
			}
			public function get_settings_sections() {
				$sections = array();
				return apply_filters('mp_settings_sec_reg', $sections);
			}
			public function get_settings_fields() {
				$settings_fields = array();
				return apply_filters('mp_settings_sec_fields', $settings_fields);
			}
			public function settings_sec_reg($default_sec): array {
				$label = WBTM_Functions::get_name();
				$sections = array(
					array(
						'id' => 'wbtm_general_settings',
						'title' => $label . ' ' . esc_html__('Settings', 'bus-ticket-booking-with-seat-reservation')
					)
				);
				return array_merge($default_sec, $sections);
			}
			public function settings_sec_fields($default_fields): array {
				$label = WBTM_Functions::get_name();
				$settings_fields = array(
					'wbtm_general_settings' => apply_filters('filter_wbtm_general_settings', array(
						array(
							'name' => 'label',
							'label' => $label . ' ' . esc_html__('Label', 'bus-ticket-booking-with-seat-reservation'),
							'desc' => esc_html__('If you like to change the label in the dashboard menu, you can change it here.', 'bus-ticket-booking-with-seat-reservation'),
							'type' => 'text',
							'default' => 'Bus',
							'placeholder' => $label . ' ' . esc_html__('Label', 'bus-ticket-booking-with-seat-reservation'),
						),
						array(
							'name' => 'slug',
							'label' => $label . ' ' . esc_html__('Slug', 'bus-ticket-booking-with-seat-reservation'),
							'desc' => esc_html__('Please enter the slug name you want. Remember, after changing this slug; you need to flush permalink; go to', 'bus-ticket-booking-with-seat-reservation') . '<strong>' . esc_html__('Settings-> Permalinks', 'bus-ticket-booking-with-seat-reservation') . '</strong> ' . esc_html__('hit the Save Settings button.', 'bus-ticket-booking-with-seat-reservation'),
							'type' => 'text',
							'default' => 'bus',
							'placeholder' => $label . ' ' . esc_html__('Slug', 'bus-ticket-booking-with-seat-reservation'),
						),
						array(
							'name' => 'icon',
							'label' => $label . ' ' . esc_html__('Icon', 'bus-ticket-booking-with-seat-reservation'),
							'desc' => esc_html__('If you want to change the  icon in the dashboard menu, you can change it from here, and the Dashboard icon only supports the Dashicons, So please go to ', 'bus-ticket-booking-with-seat-reservation') . '<a href=https://developer.wordpress.org/resource/dashicons/#calendar-alt target=_blank>' . esc_html__('Dashicons Library.', 'bus-ticket-booking-with-seat-reservation') . '</a>' . esc_html__('and copy your icon code and paste it here.', 'bus-ticket-booking-with-seat-reservation'),
							'type' => 'text',
							'default' => ''
						),
						array(
							'name' => 'bus_return_show',
							'label' => esc_html__('Show return Date Search', 'bus-ticket-booking-with-seat-reservation'),
							'desc' => esc_html__('Disable if you don\'t want to show return field in search. By default Enable', 'bus-ticket-booking-with-seat-reservation'),
							'default' => 'enable',
							'type' => 'select',
							'options' => array(
								'disable' => esc_html__('Disable', 'bus-ticket-booking-with-seat-reservation'),
								'enable' => esc_html__('Enable', 'bus-ticket-booking-with-seat-reservation'),
							),
						),
						array(
							'name' => 'ticket_sale_close_date',
							'label' => esc_html__('Ticket sale off after date', 'bus-ticket-booking-with-seat-reservation'),
							'desc' => esc_html__('Please select Seat sale off after date . if you dont want to off sale then it will be blank', 'bus-ticket-booking-with-seat-reservation'),
							'default' => '',
							'type' => 'datepicker',
							'date_format' => 'dd-mm-yy',
							'placeholder' => current_time('Y-m-d'),
						),
						array(
							'name' => 'wbtm_ticket_sale_max_date',
							'label' => esc_html__('Maximum advanced day Sale', 'bus-ticket-booking-with-seat-reservation'),
							'desc' => esc_html__('Please select Maximum advanced day Ticket Sale . if you dont want to off sale then it will be blank', 'bus-ticket-booking-with-seat-reservation'),
							'default' => '30',
							'type' => 'number',
							'placeholder' => 30,
						),
						array(
							'name' => 'bus_buffer_time',
							'label' => esc_html__('Buffer Time', 'bus-ticket-booking-with-seat-reservation'),
							'desc' => esc_html__('Please enter here car buffer time in minute. By default is 0', 'bus-ticket-booking-with-seat-reservation'),
							'type' => 'number',
							'default' => 0,
							'placeholder' => esc_html__('Ex:50', 'bus-ticket-booking-with-seat-reservation'),
						),
					)),
				);
				return array_merge($default_fields, $settings_fields);
			}
		}
		new  WBTM_Global_settings();
	}