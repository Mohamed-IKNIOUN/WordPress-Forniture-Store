<?php
/**
 * Jeg Elementor Kit Class
 *
 * @package jeg-elementor-kit
 *
 * @author Jegtheme
 *
 * @since 2.0.0
 */

namespace Jeg\Elementor_Kit\Dashboard;

use Jeg\Elementor_Kit\Dashboard\Template\Header_Dashboard_Template;
use Jeg\Elementor_Kit\Dashboard\Template\Footer_Dashboard_Template;

/**
 * Class Dashboard
 *
 * @package Jeg\Elementor_Kit
 */
class Dashboard {
	/**
	 * Slug Default JKit Dashboard
	 *
	 * @var string
	 */
	public static $slug_default;

	/**
	 * Slug for accessing JKit Dashboard
	 *
	 * @var string
	 */
	public static $dashboard = 'jkit-dashboard';

	/**
	 * Slug for accessing JKit Settings
	 *
	 * @var string
	 */
	public static $settings = 'jkit-settings';

	/**
	 * Slug for accessing JKit Templates
	 *
	 * @var string
	 */
	public static $templates = 'jkit-manage-template';

	/**
	 * Slug for accessing JKit Dashboard
	 *
	 * @var string
	 */
	public static $user_data = 'jkit-user-data';

	/**
	 * Slug for accessing JKit Header Post Type
	 *
	 * @var string
	 */
	public static $jkit_header = 'jkit-header';

	/**
	 * Slug for accessing JKit Footer Post Type
	 *
	 * @var string
	 */
	public static $jkit_footer = 'jkit-footer';

	/**
	 * JKit Template Post Type
	 *
	 * @var string
	 */
	public static $jkit_template = 'jkit-template';

	/**
	 * Slug for meta condition
	 *
	 * @var string
	 */
	public static $jkit_condition = 'jkit-condition';

	/**
	 * Ajax endpoint
	 *
	 * @var string
	 */
	private $endpoint = 'jkit-ajax-request';

	/**
	 * Template slug
	 *
	 * @var string
	 */
	private $template_slug = 'templates/dashboard/dashboard';

	/**
	 * Class instance
	 *
	 * @var Element
	 */
	private static $instance;

	/**
	 * Module constructor.
	 */
	public function __construct() {
		if ( current_user_can( 'edit_theme_options' ) ) {
			$this->setup_init();
			$this->setup_hook();
		}
	}

	/**
	 * Setup Classes
	 */
	private function setup_init() {
		self::$slug_default = self::$settings;
	}

	/**
	 * Setup Hooks
	 */
	private function setup_hook() {
		add_action( 'init', array( $this, 'post_type' ), 9 );
		add_action( 'admin_init', array( $this, 'init_dashboard' ) );
		add_action( 'in_admin_header', array( $this, 'render_header_dashboard' ) );

		add_action( 'admin_menu', array( $this, 'parent_menu' ) );
		add_action( 'admin_menu', array( $this, 'child_menu' ) );

		add_action( 'admin_footer', array( $this, 'admin_footer' ) );
		add_action( 'admin_footer', array( $this, 'print_script_template' ) );
		add_filter( 'admin_footer_text', array( $this, 'thankyou_text' ), 99 );

		add_filter( 'elementor/settings/controls/checkbox_list_cpt/post_type_objects', array( $this, 'hide_jkit_cpt_from_elementor' ) );
	}

	/**
	 * Get class instance
	 *
	 * @return Dashboard
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Initialize Dashboard
	 */
	public function init_dashboard() {
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'load_style' ) );
		}

		if ( isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], array( self::$dashboard, 'jkit-settings', 'jkit-user-data', 'jkit-elements', 'jkit-404' ), true ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'load_asset' ) );
		}

		global $pagenow;
		$page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';

		if ( $pagenow == 'admin.php' && $page && self::$dashboard === $page ) {
			wp_safe_redirect( menu_page_url( self::$settings, false ) );
			exit;
		}

		if ( $pagenow == 'admin.php' && $page && self::$templates === $page ) {
			wp_safe_redirect( menu_page_url( self::$jkit_header, false ) );
			exit;
		}

		if ( is_admin() && isset( $_REQUEST['page'] ) && strpos( $_REQUEST['page'], 'jkit' ) !== false ) {
			add_action( 'in_admin_header', array( $this, 'disable_plugins_notices_jkit_dashboard' ) );
			add_filter( 'elementor/admin-top-bar/is-active', '__return_false' );
		}
	}

	/**
	 * Load style
	 */
	public function load_style() {
		wp_enqueue_style( 'jkit-dashboard', JEG_ELEMENTOR_KIT_URL . '/assets/css/admin/dashboard.css', null, JEG_ELEMENTOR_KIT_VERSION );
	}

	/**
	 * Load scripts
	 */
	public function load_asset() {
		wp_enqueue_style( 'notiflix', JEG_ELEMENTOR_KIT_URL . '/assets/js/notiflix/notiflix.min.css', null, '3.2.5' );
		wp_enqueue_script( 'notiflix', JEG_ELEMENTOR_KIT_URL . '/assets/js/notiflix/notiflix.min.js', array(), '3.2.5', true );

		wp_register_script( 'jkit-dashboard', JEG_ELEMENTOR_KIT_URL . '/assets/js/dashboard/dashboard.js', array( 'underscore', 'jquery', 'jquery-ui-draggable', 'jquery-ui-sortable', 'notiflix' ), JEG_ELEMENTOR_KIT_VERSION, true );
		wp_add_inline_script( 'jkit-dashboard', $this->ajax_url() );
		wp_localize_script( 'jkit-dashboard', 'jkit_dashboard_localize', $this->localize_array() );
		wp_enqueue_script( 'jkit-dashboard' );
	}

	/**
	 * Type List
	 *
	 * @return array
	 */
	public static function post_type_list() {
		return array(
			self::$jkit_header   => array(
				'label' => esc_html__( 'JKIT - Header ', 'jeg-elementor-kit' ),
			),
			self::$jkit_footer   => array(
				'label' => esc_html__( 'JKIT - Footer ', 'jeg-elementor-kit' ),
			),
			self::$jkit_template => array(
				'label' => esc_html__( 'JKIT - Template ', 'jeg-elementor-kit' ),
			),
		);
	}

	/**
	 * Post Type
	 */
	public function post_type() {
		foreach ( self::post_type_list() as $post_type => $data ) {
			register_post_type(
				$post_type,
				array(
					'label'             => $data['label'],
					'public'            => true,
					'show_ui'           => false,
					'capability_type'   => 'post',
					'hierarchical'      => false,
					'show_in_nav_menus' => false,
					'supports'          => array( 'title', 'revisions', 'page-attributes', 'elementor' ),
					'map_meta_cap'      => true,
					'rewrite'           => array(
						'slug'       => $post_type,
						'with_front' => false,
					),
				)
			);
		}
	}

	/**
	 * Admin Menu
	 *
	 * @return array
	 */
	public function get_admin_menu() {
		$menu[] = array(
			'title'    => esc_html__( 'Settings', 'jeg-elementor-kit' ),
			'menu'     => esc_html__( 'Settings', 'jeg-elementor-kit' ),
			'slug'     => self::$settings,
			'action'   => array( &$this, 'settings' ),
			'priority' => 56,
			'icon'     => 'fa-cogs',
		);

		$menu[] = array(
			'title'    => esc_html__( 'User Data', 'jeg-elementor-kit' ),
			'menu'     => esc_html__( 'User Data', 'jeg-elementor-kit' ),
			'slug'     => self::$user_data,
			'action'   => array( &$this, 'user_data' ),
			'priority' => 57,
			'icon'     => 'fa-regular fa-circle-user',
		);

		$menu[] = array(
			'title'    => esc_html__( 'Elements', 'jeg-elementor-kit' ),
			'menu'     => esc_html__( 'Elements', 'jeg-elementor-kit' ),
			'slug'     => 'jkit-elements',
			'action'   => array( &$this, 'elements' ),
			'priority' => 58,
			'icon'     => 'fa-solid fa-bars-progress',
		);

		$menu[] = array(
			'title'    => esc_html__( 'Templates', 'jeg-elementor-kit' ),
			'menu'     => esc_html__( 'Templates', 'jeg-elementor-kit' ),
			'slug'     => self::$templates,
			'action'   => array( &$this, 'manage_template' ),
			'priority' => 59,
			'icon'     => 'fa-regular fa-file-lines',
			'class'    => 'have-jkit-child-menu',
		);

		$menu[] = array(
			'title'    => esc_html__( 'Header', 'jeg-elementor-kit' ),
			'menu'     => esc_html__( 'Header', 'jeg-elementor-kit' ),
			'slug'     => self::$jkit_header,
			'action'   => array( $this, 'header_template' ),
			'parent'   => self::$templates,
			'priority' => 60,
			'class'    => 'jkit-child-menu first',
		);

		$menu[] = array(
			'title'    => esc_html__( 'Footer', 'jeg-elementor-kit' ),
			'menu'     => esc_html__( 'Footer', 'jeg-elementor-kit' ),
			'slug'     => self::$jkit_footer,
			'action'   => array( $this, 'footer_template' ),
			'parent'   => self::$templates,
			'priority' => 61,
			'class'    => 'jkit-child-menu',
		);

		$menu[] = array(
			'title'    => esc_html__( 'Not Found 404', 'jeg-elementor-kit' ),
			'menu'     => esc_html__( 'Not Found 404', 'jeg-elementor-kit' ),
			'slug'     => 'jkit-404',
			'action'   => array( $this, 'not_found_template' ),
			'parent'   => self::$templates,
			'priority' => 62,
			'class'    => 'jkit-child-menu last',
		);

		$menu[] = array(
			'title'         => esc_html__( 'Need Help?', 'jeg-elementor-kit' ),
			'menu'          => esc_html__( 'Need Help?', 'jeg-elementor-kit' ),
			'slug'          => 'support-forum',
			'priority'      => 63,
			'icon'          => 'fa-solid fa-life-ring',
			'external_link' => 'https://wordpress.org/support/plugin/jeg-elementor-kit/#new-topic-0',
			'class'         => 'jkit-support-menu',
		);

		return apply_filters( 'jkit_admin_menu', $menu );
	}

	/**
	 * Parent Menu
	 *
	 * @return void
	 */
	public function parent_menu() {
		$args = array(
			'page_title' => esc_html__( 'Jeg Elementor Kit', 'jeg-elementor-kit' ),
			'menu_title' => esc_html__( 'Jeg Elementor Kit', 'jeg-elementor-kit' ),
			'capability' => 'edit_theme_options',
			'menu_slug'  => self::$slug_default,
			'function'   => null,
			'icon_url'   => JEG_ELEMENTOR_KIT_URL . '/assets/img/admin/icon.svg',
			'position'   => 76,
		);

		$args = apply_filters( 'jkit_parent_menu', $args );

		add_menu_page( $args['page_title'], $args['menu_title'], $args['capability'], $args['menu_slug'], $args['function'], $args['icon_url'], $args['position'] );
	}

	/**
	 * Child Menu
	 */
	public function child_menu() {
		$self  = $this;
		$menus = $this->get_admin_menu();

		$position = array_column( $menus, 'priority' );
		array_multisort( $position, SORT_ASC, $menus );

		foreach ( $menus as $key => $menu ) {
			add_submenu_page(
				self::$slug_default,
				$menu['title'],
				$menu['menu'],
				'edit_theme_options',
				$menu['slug'],
				function () use ( $self, $menu ) {
					$self->render_header();
					if ( isset( $menu['action'] ) ) {
						call_user_func( $menu['action'] );
					}
					// $self->render_sidebar();
				}
			);

			$this->add_child_menu_class( $key, $menu );
		}
	}

	/**
	 * Add Class Selector to Child Menu
	 *
	 * @param int   $key Menu offset.
	 * @param array $menu List of menu.
	 */
	private function add_child_menu_class( $key, $menu ) {
		global $submenu;

		if ( isset( $menu['class'] ) ) {
			// @codingStandardsIgnoreStart
			$submenu[ self::$slug_default ][ $key ][4] = $menu['class'];
			// @codingStandardsIgnoreEnd
		}

		if ( isset( $menu['external_link'] ) ) {
			// replace the slug with external url
			// @codingStandardsIgnoreStart
			$submenu[ self::$slug_default ][ $key ][2] = $menu['external_link'];
			// @codingStandardsIgnoreEnd
		}
	}

	/**
	 * Header Dashboard
	 */
	public function render_header() {
		jkit_get_template_part( $this->template_slug, 'header' );
	}

	/**
	 * Footer Dashboard
	 */
	public function render_sidebar() {
		jkit_get_template_part( $this->template_slug, 'sidebar' );
	}

	/**
	 * Dashboard
	 */
	public function dashboard() {}

	/**
	 * Dashboard Content
	 */
	public function dashboard_content() {
		jkit_get_template_part( $this->template_slug, 'content' );
	}

	/**
	 * User Data
	 */
	public function settings() {
		jkit_get_template_part( $this->template_slug, 'settings' );
	}

	/**
	 * User Data
	 */
	public function user_data() {
		jkit_get_template_part( $this->template_slug, 'user-data' );
	}

	/**
	 * Header
	 */
	public function header_template() {
		new Header_Dashboard_Template();
	}

	/**
	 * Footer
	 */
	public function footer_template() {
		new Footer_Dashboard_Template();
	}

	/**
	 * 404 Template
	 */
	public function not_found_template() {
		jkit_get_template_part( $this->template_slug, 'notfound' );
	}

	/**
	 * Manage Template
	 */
	public function manage_template() {}

	/**
	 * Elements
	 */
	public function elements() {
		jkit_get_template_part( $this->template_slug, 'elements' );
	}

	/**
	 * Add ajax URL
	 */
	public function ajax_url() {
		if ( is_admin() ) {
			$ajax_url = add_query_arg( array( $this->endpoint => 'jkit_user_data' ), esc_url( home_url( '/' ) ) );

			return 'var jkit_ajax_url = "' . esc_url( $ajax_url ) . '", jkit_nonce = "' . jkit_create_global_nonce( 'dashboard' ) . '";';
		}

		return null;
	}

	/**
	 * Get URL to Elementor Builder
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return string
	 */
	public static function editor_url( $post_id ) {
		$the_id = ( strlen( $post_id ) > 0 ? $post_id : get_the_ID() );

		$parameter = array(
			'post'   => $the_id,
			'action' => 'elementor',
		);

		return admin_url( 'post.php' ) . '?' . build_query( $parameter );
	}

	/**
	 * Localize Script
	 */
	public function localize_array() {
		return array(
			'something_wrong' => esc_html__( 'Something went wrong', 'jeg-elementor-kit' ),
			'save_failed'     => esc_html__( 'Save Failed', 'jeg-elementor-kit' ),
		);
	}

	/**
	 * Admin footer
	 */
	public function admin_footer() {
		?>
		<div class="create-element-builder-overlay" id="create-element-popup-overlay"></div>
		<div class="create-element-builder-wrapper"></div>
		<?php
	}

	/**
	 * Print Script Template
	 */
	public function print_script_template() {
		?>
		<script id="tmpl-jkit-builder-empty" type="text/html">
			<div class="empty-content">
				<div class="empty-content-wrapper">
					<h1>{{ data.lang.createfirst }}</h1>
					<p>{{ data.lang.createdescription }}</p>
					<button type="button" class='create-element-button jkit-button'>
						{{ data.lang.addnewelement }}
					</button>
				</div>
			</div>
		</script>
		<script id="tmpl-jkit-popup" type="text/html">
			<div class="popup-option">
				<div class="popup-header">
					<h2>{{ data.lang.createelement }}</h2>
					<span class="close">
						<i class="fa fa-close"></i>
					</span>
				</div>
				<div class="popup-body">
					<div class="popup-content"></div>
				</div>
				<div class="popup-footer">
					<div class="close">{{ data.lang.close }}</div>
					<div class="generate">{{ data.lang.create }}</div>
				</div>
			</div>
		</script>
		<script id="tmpl-jkit-condition-container" type="text/html">
			<div class="jkit-condition-container">
				<div class="jkit-condition-empty">
					<h1>{{data.lang.createcondition}}</h1>
					<p>{{data.lang.createconditiondesc}}</p>
				</div>
				<div class="jkit-condition-wrapper"></div>
				<div class="jkit-condition-add">
					<button type="button"> {{data.lang.addcondition}}</button>
				</div>
			</div>
			<div class="jkit-condition-global">
				{{data.lang.globalelement}}
			</div>
		</script>
		<script id="tmpl-form-segment-multi" type="text/html">
			<div class="jkit-condition-item">
				<div class="jkit-condition-header" data-id="{{ data.id }}">
					{{{ data.name }}} <span class="tab-delete dashicons dashicons-trash" title="<?php esc_html_e( 'Delete', 'jeg-elementor-kit' ); ?>"></span>
				</div>
				<div class="jkit-condition-content" data-id="{{ data.id }}"></div>
			</div>
		</script>
		<script id="tmpl-jkit-builder-content" type="text/html">
			<div class="content-exist">
				<h2>{{ data.lang.manageelement }}</h2>
				<p>{{ data.lang.managedescription }}</p>
				<div class="active-element-wrapper">
					<h2>{{data.lang.activeelement}}</h2>
					<div class="active-element-heading">
						<ul>
							<li class="name">{{data.lang.elementname}}</li>
							<li class="priority">{{data.lang.priority}}</li>
							<li class="edit">{{data.lang.edit}}</li>
							<li class="clone">{{data.lang.clone}}</li>
							<li class="delete">{{data.lang.delete}}</li>
						</ul>
					</div>
					<div class="content-body connectedSortable" id="active-element"></div>
					<div class="content-button">
						<button type="button" class='create-element-button jkit-button'>
							{{ data.lang.addnewelement }}
						</button>
					</div>
				</div>
				<div class="inactive-element-wrapper">
					<h2>{{data.lang.inactiveelement}}</h2>
					<p>{{data.lang.inactiveelementdesc}}</p>
					<div class="content-body connectedSortable" id="inactive-element"></div>
				</div>
			</div>
		</script>
		<script id="tmpl-jkit-element-container" type="text/html">
			<div class="jkit-element-container" data-id="{{ data.id }}">
				<div class="jkit-container-header">
					<h3 title="<?php esc_html_e( 'Setup Condition', 'jeg-elementor-kit' ); ?>"><i class="fa fa-arrows"></i> <span>{{{ data.title }}}</span></h3>
					<div class="jkit-header-action">
						<div class="tab-delete" title="<?php esc_html_e( 'Delete', 'jeg-elementor-kit' ); ?>">
							<i class="fa-regular fa-trash-can"></i>
						</div>
						<div class="tab-clone" title="<?php esc_html_e( 'Clone', 'jeg-elementor-kit' ); ?>">
							<i class="fa-regular fa-clone"></i>
						</div>
						<div class="tab-edit" title="<?php esc_html_e( 'Modify', 'jeg-elementor-kit' ); ?>">
							<a href="{{ data.url }}" target="_blank">
								<i class="fa fa-pencil"></i>
							</a>
						</div>
						<div class="tab-priority">&nbsp;</div>
					</div>
				</div>
				<div class="jkit-container-body">
					<div class="jkit-loading">{{data.lang.loading}}</div>
				</div>
			</div>
		</script>
		<?php
	}

	/**
	 * Thank You for using Jeg Elementor Kit
	 *
	 * @param string $text Thank You say.
	 *
	 * @return string $text
	 */
	public function thankyou_text( $text ) {
		$page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';

		if ( $page && strpos( $page, 'jkit-' ) !== false ) {
			$text = sprintf(
				/**
				 * Translators:
				 * %1$s: User Display Name
				 * %2$s: https://wordpress.org/plugins/jeg-elementor-kit/
				 * %3$s: https://wordpress.org/support/plugin/jeg-elementor-kit/reviews/#new-post
				 * %4$s: Jeg Elementor Kit versions
				*/
				__( 'Hello <b>%1$s</b>, thank you for using <a href="%2$s" target="_blank">Jeg Elementor Kit</a> v%4$s. Please take a second to <a href="%3$s" target="_blank"> leave us a <span>★★★★★</span> rating</a>. We\'d really appreciate your support!', 'jeg-elementor-kit' ),
				wp_get_current_user()->display_name,
				'https://wordpress.org/plugins/jeg-elementor-kit/',
				'https://wordpress.org/support/plugin/jeg-elementor-kit/reviews/#new-post',
				JEG_ELEMENTOR_KIT_VERSION
			);
		}

		return $text;
	}

	/**
	 * Header Dashboard Template
	 */
	public function render_header_dashboard() {
		if ( is_admin() && isset( $_REQUEST['page'] ) && strpos( $_REQUEST['page'], 'jkit' ) !== false ) {
			?>
			<div class="jkit-dashboard-topbar-wrap">
				<img src="<?php echo esc_url( JEG_ELEMENTOR_KIT_URL . '/assets/img/admin/icon-dashboard.svg' ); ?>" alt="<?php echo JEG_ELEMENTOR_KIT_NAME; ?>">
				<h2><?php echo esc_html__( JEG_ELEMENTOR_KIT_NAME ); ?></h2>
				<ul>
					<li><a title="<?php esc_html_e( 'Our Website', 'jeg-elementor-kit' ); ?>" href="https://jegtheme.com/" target="_blank"><i class="fa fa-earth-asia"></i></a></li>
					<li><a title="<?php esc_html_e( 'Support Forum', 'jeg-elementor-kit' ); ?>" href="https://wordpress.org/support/plugin/jeg-elementor-kit/" target="_blank"><i class="fa-solid fa-life-ring"></i></a></li>
				</ul>
			</div>
			<?php
		}
	}

	/**
	 * Disable another plugin notices on jkit dashboard
	 *
	 * This function only allow WordPress notices,
	 * notices that using callback with class Jeg\\Elementor_Kit
	 * and notice that using callback with no class
	 */
	public function disable_plugins_notices_jkit_dashboard() {
		global $wp_filter;
		foreach ( $wp_filter['admin_notices'] as $weight => $callbacks ) {
			foreach ( $callbacks as $name => $details ) {
				if ( is_array( $details['function'] ) && is_object( $details['function'][0] ) ) {
					if ( strrpos( \get_class( $details['function'][0] ), 'Jeg\\Elementor_Kit' ) === false ) {
						$wp_filter['admin_notices']->remove_filter( 'admin_notices', $details['function'], $weight );
					}
				}
			}
		}
	}

	/**
	 * Filters the list of post type objects used by Elementor.
	 *
	 * @since 2.6.2
	 *
	 * @param array $post_types_objects List of post type objects used by Elementor.
	 */
	public function hide_jkit_cpt_from_elementor( $post_types_objects ) {
		foreach ( $post_types_objects as $type ) {
			if ( array_key_exists( $type->name, $this->post_type_list() ) ) {
				unset( $post_types_objects[ $type->name ] );
			}
		}

		return $post_types_objects;
	}
}
