<?php

namespace MetForm;

use MetForm\Core\Integrations\Onboard\Attr;
use MetForm\Core\Integrations\Onboard\Onboard;

defined('ABSPATH') || exit;

final class Plugin {

    private static $instance;

    private $entries;
    private $global_settings;

    public function __construct()
    {
        Autoloader::run();
	   add_action( 'wp_head', array( $this, 'add_meta_for_search_excluded' ) );
       add_action( 'init', array ($this, 'metform_permalink_setup'));
       add_action("metform/pro_awareness/before_grid_contents", ['\MetForm\Utils\Util', 'banner_consent']);
       add_action( 'wp_ajax_metform_admin_action', ['\MetForm\Utils\Util', 'metform_admin_action'] );
    }

    public function version()
    {
        return '3.9.1';
    }

    public function package_type()
    {
        return apply_filters( 'metform/core/package_type', 'free' );
    }

    public function plugin_url()
    {
        return trailingslashit(plugin_dir_url(__FILE__));
    }

    public function plugin_dir()
    {
        return trailingslashit(plugin_dir_path(__FILE__));
    }

    public function core_url()
    {
        return $this->plugin_url() . 'core/';
    }

    public function core_dir()
    {
        return $this->plugin_dir() . 'core/';
    }

    public function base_url()
    {
        return $this->plugin_url() . 'base/';
    }

    public function base_dir()
    {
        return $this->plugin_dir() . 'base/';
    }

    public function utils_url()
    {
        return $this->plugin_url() . 'utils/';
    }

    public function utils_dir()
    {
        return $this->plugin_dir() . 'utils/';
    }

    public function widgets_url()
    {
        return $this->plugin_url() . 'widgets/';
    }

    public function widgets_dir()
    {
        return $this->plugin_dir() . 'widgets/';
    }

    public function public_url()
    {
        return $this->plugin_url() . 'public/';
    }

    public function public_dir()
    {
        return $this->plugin_dir() . 'public/';
    }

    public function account_url(){
		return 'https://account.wpmet.com';
	}

    public function i18n()
    {
        load_plugin_textdomain('metform', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    public function init()
    {
        /**
         * ----------------------------------------
         *  Ask for rating ⭐⭐⭐⭐⭐
         *  A rating notice will appear depends on
         *  @set_first_appear_day methods
         * ----------------------------------------
         */
        Onboard::instance()->init();

        if(isset($_GET['met-onboard-steps']) && isset($_GET['met-onboard-steps-nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['met-onboard-steps-nonce'])),'met-onboard-steps-action')) {
            Attr::instance();
		}

        $filter_string = ''; // elementskit,metform-pro
        $filter_string .= ((!in_array('elementskit/elementskit.php', apply_filters('active_plugins', get_option('active_plugins')))) ? '' : ',elementskit');
        $filter_string .= (!class_exists('\MetForm\Plugin') ? '' : ',metform');
        $filter_string .= (!class_exists('\MetForm_Pro\Plugin') ? '' : ',metform-pro');

        if ( is_admin() && \MetForm\Utils\Util::get_settings( 'metform_user_consent_for_banner', 'yes' ) == 'yes' ) {
      
            //Rating notice
            \Wpmet\Libs\Rating::instance('metform')
            ->set_plugin_logo('https://ps.w.org/metform/assets/icon-128x128.png')
            ->set_plugin('Metform', 'https://wpmet.com/wordpress.org/rating/metform')
            ->set_allowed_screens('edit-metform-entry')
            ->set_allowed_screens('edit-metform-form')
            ->set_allowed_screens('metform_page_metform_get_help')
            ->set_priority(30)
            ->set_first_appear_day(7)
            ->set_condition(true)
            ->call();

            // banner
            \Wpmet\Libs\Banner::instance('metform')
                ->set_filter(ltrim($filter_string, ','))
                ->set_api_url('https://api.wpmet.com/public/jhanda')
                ->set_plugin_screens('edit-metform-form')
                ->set_plugin_screens('edit-metform-entry')
                ->set_plugin_screens('metform_page_metform-menu-settings')
                ->call();

            /**
             * Show WPMET stories widget in dashboard
             */
            \Wpmet\Libs\Stories::instance('metform')

                ->set_filter($filter_string)
                ->set_plugin('Metform', 'https://wpmet.com/plugin/metform/')
                ->set_api_url('https://api.wpmet.com/public/stories/')
                ->call();

        }

        /**
         * Pro awareness feature;
         */

        $is_pro_active = '';

        if (!in_array('metform-pro/metform-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $is_pro_active = 'Go Premium';
        }

		$pro_awareness = \Wpmet\Libs\Pro_Awareness::instance('metform');
		if(version_compare($pro_awareness->get_version(), '1.2.0', '>=')) {
			$pro_awareness
			    ->set_parent_menu_slug('metform-menu')
			    ->set_pro_link(
			        (in_array('metform-pro/metform-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) ? '' :
			            'https://wpmet.com/metform-pricing'
			    )
			    ->set_plugin_file('metform/metform.php')
			    ->set_default_grid_thumbnail($this->utils_url() . '/pro-awareness/assets/images/support.png')
			    ->set_page_grid([
			        'url' => 'https://wpmet.com/fb-group',
			        'title' => 'Join the Community',
			        'thumbnail' => $this->utils_url() . '/pro-awareness/assets/images/community.png',
					'description' => 'Join our Facebook group to get 20% discount coupon on premium products. Follow us to get more exciting offers.'

			    ])
			    ->set_page_grid([
			        'url' => 'https://www.youtube.com/playlist?list=PL3t2OjZ6gY8NoB_48DwWKUDRtBEuBOxSc',
			        'title' => 'Video Tutorials',
			        'thumbnail' => $this->utils_url() . '/pro-awareness/assets/images/videos.png',
					'description' => 'Learn the step by step process for developing your site easily from video tutorials.'
			    ])
			    ->set_page_grid([
			        'url' => 'https://wpmet.com/plugin/metform/roadmaps#ideas',
			        'title' => 'Request a feature',
			        'thumbnail' => $this->utils_url() . '/pro-awareness/assets/images/request.png',
					'description' => 'Have any special feature in mind? Let us know through the feature request.'
			    ])
			    ->set_page_grid([
						'url'       => 'https://wpmet.com/doc/metform/',
						'title'     => 'Documentation',
						'thumbnail' => $this->utils_url() . 'pro-awareness/assets/images/documentation.png',
						'description' => 'Detailed documentation to help you understand the functionality of each feature.'
				])
				->set_page_grid([
						'url'       => 'https://wpmet.com/plugin/metform/roadmaps/',
						'title'     => 'Public Roadmap',
						'thumbnail' => $this->utils_url() . 'pro-awareness/assets/images/roadmaps.png',
						'description' => 'Check our upcoming new features, detailed development stories and tasks'
				])

			    ->set_plugin_row_meta('Documentation', 'https://help.wpmet.com/docs-cat/metform/', ['target' => '_blank'])
			    ->set_plugin_row_meta('Facebook Community', 'https://wpmet.com/fb-group', ['target' => '_blank'])
			    ->set_plugin_row_meta('Rate the plugin ★★★★★', 'https://wordpress.org/support/plugin/metform/reviews/#new-post', ['target' => '_blank'])
			    ->set_plugin_action_link('Settings', admin_url() . 'admin.php?page=metform-menu-settings')
			    ->set_plugin_action_link($is_pro_active, 'https://wpmet.com/plugin/metform', ['target' => '_blank', 'style' => 'color: #FCB214; font-weight: bold;'])
			    ->call();
		}

        $apps_img_path = $this->public_url() . 'assets/img/apps-page/';

        /**
         * Show apps menu for others wpmet plugins
         */
        \Wpmet\Libs\Apps::instance()->init('metform')
        ->set_parent_menu_slug('metform-menu')
        ->set_submenu_name('Our Plugins')
        ->set_section_title('Unleash the Full Potential of Elementor and WordPress!')
        ->set_section_description('Install other plugins from us and take your website to the next level for absolutely free!')
        ->set_items_per_row(4)
        ->set_plugins(
        [
            'elementskit-lite/elementskit-lite.php' => [
                'name' => esc_html__('ElementsKit', 'metform'),
                'url'  => 'https://wordpress.org/plugins/elementskit-lite/',
                'icon' => $apps_img_path. 'elementskit.gif',
                'desc' => esc_html__('All-in-one Elementor addon trusted by 1 Million+ users, makes your website builder process easier with ultimate freedom.', 'metform'),
                'docs' => 'https://wpmet.com/doc/elementskit/',
            ],
            'getgenie/getgenie.php' => [
                'name' => esc_html__('GetGenie', 'metform'),
                'url'  => 'https://wordpress.org/plugins/getgenie/',
                'icon' => $apps_img_path.'getgenie.gif',
                'desc' => esc_html__('Your personal AI assistant for content and SEO. Write content that ranks on Google with NLP keywords and SERP analysis data.', 'metform'),
                'docs' => 'https://getgenie.ai/docs/',
            ],
            'gutenkit-blocks-addon/gutenkit-blocks-addon.php' => [
                'name' => esc_html__('GutenKit', 'metform'),
                'url'  => 'https://wordpress.org/plugins/gutenkit-blocks-addon/',
                'icon' => $apps_img_path. 'guten-kit.png',
                'desc' => esc_html__('Gutenberg blocks, patterns, and templates that extend the page-building experience using the WordPress block editor.', 'metform'),
                'docs' => 'https://wpmet.com/doc/gutenkit/',
            ],
            'shopengine/shopengine.php' => [
                'name' => esc_html__('ShopEngine', 'metform'),
                'url'  => 'https://wordpress.org/plugins/shopengine/',
                'icon' => $apps_img_path. 'shopengine.gif',
                'desc' => esc_html__('Complete WooCommerce solution for Elementor to fully customize any pages including cart, checkout, shop page, and so on.
                ', 'metform'),
                'docs' => 'https://wpmet.com/doc/shopengine/',
            ],
            'emailkit/EmailKit.php' => [
                'name' => esc_html__('EmailKit', 'metform'),
                'url'  => 'https://wordpress.org/plugins/emailkit/',
                'icon' => $apps_img_path . 'emailkit.png',
                'desc' => esc_html__('Advanced email customizer for WooCommerce and WordPress. Build, customize, and send emails from WordPress to boost your sales!', 'metform'),
                'docs' => 'https://wpmet.com/doc/emailkit/',
            ],
            'wp-social/wp-social.php' => [
                'name' => esc_html__('Wp Social', 'metform'),
                'url'  => 'https://wordpress.org/plugins/wp-social/',
                'icon' => $apps_img_path . 'wp-social.png',
                'desc' => esc_html__('Add social share, login, and engagement counter — unified solution for all social media with tons of different styles for your website.', 'metform'),
                'docs' => 'https://wpmet.com/doc/wp-social/',
            ],
            'wp-ultimate-review/wp-ultimate-review.php' => [
                'name' => esc_html__('WP Ultimate Review', 'metform'),
                'url'  => 'https://wordpress.org/plugins/wp-ultimate-review/',
                'icon' => $apps_img_path . 'ultimate-review.png',
                'desc' => esc_html__('Collect and showcase reviews on your website to build brand credibility and social proof with the easiest solution.', 'metform'),
                'docs' => 'https://wpmet.com/doc/wp-ultimate-review/',
            ],
            'wp-fundraising-donation/wp-fundraising.php' => [
                'name' => esc_html__('FundEngine', 'metform'),
                'url'  => 'https://wordpress.org/plugins/wp-fundraising-donation/',
                'icon' => $apps_img_path . 'fundengine.png',
                'desc' => esc_html__('Create fundraising, crowdfunding, and donation websites with PayPal and Stripe payment gateway integration.', 'metform'),
                'docs' => 'https://wpmet.com/doc/fundengine/',
            ],
            'blocks-for-shopengine/shopengine-gutenberg-addon.php' => [
                'name' => esc_html__('Blocks for ShopEngine', 'metform'),
                'url'  => 'https://wordpress.org/plugins/blocks-for-shopengine/',
                'icon' => $apps_img_path . 'shopengine.gif',
                'desc' => esc_html__('All in one WooCommerce solution for Gutenberg! Build your WooCommerce pages in a block editor with full customization.', 'metform'),
                'docs' => 'https://wpmet.com/doc/shopengine/',
            ],
            'genie-image-ai/genie-image-ai.php' => [
                'name' => esc_html__('Genie Image', 'metform'),
                'url'  => 'https://wordpress.org/plugins/genie-image-ai/',
                'icon' => $apps_img_path . 'genie-image.png',
                'desc' => esc_html__('AI-powered text-to-image generator for WordPress with OpenAI’s DALL-E 2 technology to generate high-quality images in one click.', 'metform'),
                'docs' => 'https://getgenie.ai/docs/',
            ],
        ]
        )
        ->call();
    
        if( class_exists('WooCommerce') && !class_exists('EmailKit') && !did_action('edit_with_emailkit_loaded') && class_exists('\Wpmet\Libs\Emailkit') && \MetForm\Utils\Util::get_settings( 'metform_user_consent_for_banner', 'yes' ) == 'yes') {
            new \Wpmet\Libs\Emailkit();        
        }

        // Check if Elementor installed and activated.
        if (!did_action('elementor/loaded')) {
            $this->missing_elementor();
            return;
        }
        // Check for required Elementor version.
        if (!version_compare(ELEMENTOR_VERSION, '3.0.1', '>=')) {
            $this->failed_elementor_version();
            // add_action('admin_notices', array($this, 'failed_elementor_version'));
            return;
        }

        // pro available notice
        if (!file_exists(WP_PLUGIN_DIR . '/metform-pro/metform-pro.php')) {
            $this->available_metform_pro();
            // add_action('admin_notices', [$this, 'available_metform_pro']);
        }

        if (current_user_can('manage_options')) {
            add_action('admin_menu', [$this, 'admin_menu']);
        }

        add_action('elementor/editor/before_enqueue_scripts', [$this, 'edit_view_scripts']);
	    add_action( 'elementor/editor/after_enqueue_scripts', [$this, 'metform_editor_script'] );

        add_action('init', [$this, 'i18n']);

        add_action('admin_enqueue_scripts', [$this, 'js_css_admin']);
        add_action('wp_enqueue_scripts', [$this, 'js_css_public']);

        $my_theme = wp_get_theme();
        if(current_user_can('manage_options') && $my_theme->get('Name') == 'Cleano'){
            add_action( 'admin_enqueue_scripts', [$this, 'cleanoThemeConflict'], 100 );
        }
        
        add_action('elementor/frontend/before_enqueue_scripts', [$this, 'elementor_js']);

        add_action('elementor/editor/before_enqueue_styles', [$this, 'elementor_css']);

        add_action('admin_footer', [$this, 'footer_data']);

        Core\Forms\Base::instance()->init();
        Controls\Base::instance()->init();
        $this->entries = Core\Entries\Base::instance();

        Widgets\Manifest::instance()->init();

        // settings page
        Core\Admin\Base::instance()->init();

        Core\Forms\Auto_Increment_Entry::instance();
    }

    function metform_editor_script(){
	    	wp_enqueue_script('editor-panel-script', $this->public_url() . '/assets/js/editor-panel.js', ['jquery'], $this->version(), true);
    }

    function js_css_public()
    {
        $this->global_settings = \MetForm\Core\Admin\Base::instance()->get_settings_option();
        $is_form_cpt = ('metform-form' === get_post_type());

        wp_register_style('metform-ui', $this->public_url() . 'assets/css/metform-ui.css', false, $this->version());

        wp_register_style('metform-style', $this->public_url() . 'assets/css/style.css', false, $this->version());

        wp_register_style('text-editor-style', $this->public_url() . 'assets/css/text-editor.css', false, $this->version());

        wp_register_script('htm', $this->public_url() . 'assets/js/htm.js', null, $this->version(), true);

        wp_register_script('metform-app', $this->public_url() . 'assets/js/app.js', ['htm', 'jquery', 'wp-element'], $this->version(), true);

        wp_localize_script('metform-app', 'mf', [
            'postType' => get_post_type(),
            'restURI' => get_rest_url(null, 'metform/v1/forms/views/'),
            'minMsg1' => __("Minimum length should be ","metform"),
            'Msg2' => __(" character long.","metform"),
            'maxMsg1' => __("Maximum length should be ","metform"),
            'maxNum' => __("Maximum number should be ","metform"),
            'minNum' => __("Minimum number should be ","metform"),
        ]);

        // Recaptcha Support Script.
        wp_register_script( 'recaptcha-support', $this->public_url() . 'assets/js/recaptcha-support.js', ['jquery'], $this->version(), true );


        // begins pro feature
        // begins for mf-simple-repeater
        wp_register_style('asRange', $this->public_url() . 'assets/css/asRange.min.css', false, $this->version());
        wp_register_script('asRange', $this->public_url() . 'assets/js/jquery-asRange.min.js', [], $this->version(), true);
        wp_enqueue_script('cute-alert', $this->public_url() . 'assets/lib/cute-alert/cute-alert.js', [], $this->version(), true);
        wp_register_style('mf-select2', $this->public_url() . 'assets/css/select2.min.css', false, $this->version());
        wp_register_script('mf-select2', $this->public_url() . 'assets/js/select2.min.js', [], $this->version(), true);
        // ends for mf-simple-repeater

        wp_register_script('recaptcha-v2', 'https://google.com/recaptcha/api.js?render=explicit', [], null, true);

        if (isset($this->global_settings['mf_recaptcha_version']) && ($this->global_settings['mf_recaptcha_version'] == 'recaptcha-v3') && isset($this->global_settings['mf_recaptcha_site_key_v3']) && ($this->global_settings['mf_recaptcha_site_key_v3'] != '')) {
            wp_register_script('recaptcha-v3', 'https://www.google.com/recaptcha/api.js?render=' . $this->global_settings['mf_recaptcha_site_key_v3'], [], $this->version(), false);
        }

        if (isset($this->global_settings['mf_google_map_api_key']) && ($this->global_settings['mf_google_map_api_key'] != '')) {
            wp_register_script('maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . $this->global_settings['mf_google_map_api_key'] . '&libraries=places&&callback=mfMapLocation', [], '', true);
        }

        // for date, time, simple repeater
        wp_deregister_style('flatpickr'); // flatpickr stylesheet
        wp_register_style('flatpickr', $this->public_url() . 'assets/css/flatpickr.min.css', false, $this->version()); // flatpickr stylesheet
        wp_enqueue_style('cute-alert', $this->public_url() . 'assets/lib/cute-alert/style.css', false, $this->version());
        // ends pro feature


        wp_enqueue_style('text-editor-style');
        
        if($is_form_cpt){
            wp_enqueue_style('metform-ui');
            wp_enqueue_style('metform-style');
            wp_enqueue_script('htm');
            wp_enqueue_script('metform-app');
        } 

        do_action('metform/onload/enqueue_scripts');
    }

   

    public function edit_view_scripts()
    {
        wp_enqueue_style('metform-ui', $this->public_url() . 'assets/css/metform-ui.css', false, $this->version());
        wp_enqueue_style('metform-admin-style', $this->public_url() . 'assets/css/admin-style.css', false, null);

        wp_enqueue_script('metform-ui', $this->public_url() . 'assets/js/ui.min.js', [], $this->version(), true);
        wp_enqueue_script('metform-admin-script', $this->public_url() . 'assets/js/admin-script.js', [], null, true);

        wp_add_inline_script('metform-admin-script', "
            var metform_api = {
                resturl: '" . get_rest_url() . "'
            }
        ");
    }

    public function elementor_js()
    {
    }

    public function elementor_css()
    {
        if ('metform-form' == get_post_type()) {
            wp_enqueue_style('metform-category-top', $this->public_url() . 'assets/css/category-top.css', false, $this->version());
        }
    }



    /**
     * @function - {cleanoThemeConflict}
     * @description - this function is used to remove conflict of bootstrap between metform & cleano theme.
     */
    function cleanoThemeConflict() {

        $screen = get_current_screen();
        if(in_array($screen->id, ['edit-metform-form', 'metform_page_mt-form-settings', 'metform-entry', 'metform_page_metform-menu-settings'])){
            wp_dequeue_script( 'bootstrap' );
        }
     }


    function js_css_admin()
    {


        wp_enqueue_style( 'mf-wp-dashboard', $this->core_url() . 'admin/css/mf-wp-dashboard.css', [], $this->version() );

        $screen = get_current_screen();

        if (in_array($screen->id, ['edit-metform-form', 'metform_page_mt-form-settings', 'metform-entry', 'metform_page_metform-menu-settings'])) {
            wp_enqueue_style('metform-admin-fonts', $this->public_url() . 'assets/admin-fonts.css', false, $this->version());
            wp_enqueue_style('metform-ui', $this->public_url() . 'assets/css/metform-ui.css', false, $this->version());
            wp_enqueue_style('metform-admin-style', $this->public_url() . 'assets/css/admin-style.css', false, null);

            wp_enqueue_script('metform-ui', $this->public_url() . 'assets/js/ui.min.js', [], $this->version(), true);
            wp_enqueue_script('metform-admin-script', $this->public_url() . 'assets/js/admin-script.js', [], null, true);
            wp_localize_script('metform-admin-script', 'metform_api', ['resturl' => get_rest_url(), 'admin_url' => get_admin_url()]);
        }

        if ($screen->id == 'edit-metform-entry' || $screen->id == 'metform-entry') {
            wp_enqueue_style('metform-ui', $this->public_url() . 'assets/css/metform-ui.css', false, $this->version());
            wp_enqueue_script('metform-entry-script', $this->public_url() . 'assets/js/admin-entry-script.js', [], $this->version(), true);
        }
    }

    /**
	 * Excluding Metform form from search engine.
	 *
	 */
	public function add_meta_for_search_excluded() {
       


		if ( in_array(get_post_type(), ['metform-form']) ) {
			echo '<meta name="robots" content="noindex,nofollow" />', "\n";
		}
	}

    public function footer_data()
    {

        $screen = get_current_screen();

        if ($screen->id == 'edit-metform-entry') {
            $args = [
                'post_type'   => 'metform-form',
                'post_status' => 'publish',
                'numberposts' => -1,
            ];

            $forms = get_posts($args);
            //phpcs:ignore WordPress.Security.NonceVerification -- Nonce can't be added in CPT URL
            $get_form_id = isset($_GET['form_id']) ? sanitize_key($_GET['form_id']) : '';
?>
            <div id='metform-formlist' style='display:none;'><select name='mf_form_id' id='metform-form_id'>
                <option value='all' <?php echo esc_attr(((($get_form_id == 'all') || ($get_form_id == '')) ? 'selected=selected' : '')); ?>>All</option>
                <?php

                foreach ($forms as $form) {
                    $form_list[$form->ID] = $form->post_title;
                    ?>
                    <option value="<?php echo esc_attr($form->ID); ?>" <?php echo esc_attr(($get_form_id == $form->ID) ? 'selected=selected' : ''); ?>><?php echo esc_html($form->post_title); ?></option>
        <?php
                }
            echo "</select></div>";
        }
    }

    function admin_menu()
    {
        add_menu_page(
            esc_html__('MetForm', 'metform'),
            esc_html__('MetForm', 'metform'),
            'read',
            'metform-menu',
            '',
            $this->core_url() . 'admin/images/icon-menu.png',
            5
        );
    }

    public function missing_elementor()
    {
        //phpcs:disable WordPress.Security.NonceVerification -- Can't set nonce. Cause it's fire on 'plugins_loaded' hook
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
        //phpcs:enable
        if (file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php')) {
            $btn['text'] = esc_html__('Activate Elementor', 'metform');
            $btn['id'] = 'unsupported-elementor-version';
            $btn['class'] = 'button-primary';
            $btn['url'] = wp_nonce_url('plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php');
        } else {
            $btn['id'] = 'unsupported-elementor-version';
            $btn['class'] = 'button-primary';
            $btn['text'] = esc_html__('Install Elementor', 'metform');
            $btn['url'] = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
        }
        // translators: MetForm plugin version requirement. %s is the required Elementor version.
        $message = sprintf(esc_html__('MetForm requires Elementor version %1$s+, which is currently NOT RUNNING.', 'metform'), '2.6.0');

        \Oxaim\Libs\Notice::instance('metform', 'unsupported-elementor-version')
            ->set_dismiss('global', (3600 * 24 * 15))
            ->set_message($message)
            ->set_button($btn)
            ->call();
    }

    public function available_metform_pro()
    {
        //phpcs:disable WordPress.Security.NonceVerification -- Can't set nonce. Cause it's fire on 'plugins_loaded' hook
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
        //phpcs:enable 
        $btn['text'] = esc_html__('MetForm Pro', 'metform');
        $btn['url'] = esc_url('https://products.wpmet.com/metform/');
        $btn['class'] = 'button-primary';

        $message = sprintf(esc_html__('We have MetForm Pro version. Check out our pro feature.', 'metform'), '2.6.0');
        \Oxaim\Libs\Notice::instance('metform', 'unsupported-metform-pro-version')
            ->set_dismiss('global', (3600 * 24 * 15))
            ->set_message($message)
            ->set_button($btn)
            ->call();
    }


    public function failed_elementor_version()
    {

        $btn['text'] = esc_html__('Update Elementor', 'metform');
        // translators: MetForm plugin version requirement. %s is the required Elementor version.
        $btn['url'] = sprintf(esc_html__('MetForm requires Elementor version %1$s+, which is currently NOT RUNNING.', 'metform'), '2.6.0');
        $btn['class'] = 'button-primary';

        $message = sprintf(esc_html__('We have MetForm Pro version. Check out our pro feature.', 'metform'), '2.6.0');
        \Oxaim\Libs\Notice::instance('metform', 'unsupported-elementor-version')
            ->set_dismiss('global', (3600 * 24 * 15))
            ->set_message($message)
            ->set_button($btn)
            ->call();
    }

    public function flush_rewrites()
    {
        $form_cpt = new Core\Forms\Cpt();
        $form_cpt->flush_rewrites();
    }


    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function metform_permalink_setup(){
       
        Utils\Util::permalink_setup();
    }


}
