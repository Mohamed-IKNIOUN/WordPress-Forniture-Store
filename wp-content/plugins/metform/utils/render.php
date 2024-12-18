<?php

namespace MetForm\Utils;

/**
 * Render html components
 */
class Render
{

    public static $content_data;

    public static function tab($id, $lable, $caption)
    {
?>
        <li>
            <a href="#<?php echo esc_html($id); ?>" class="mf-setting-nav-link">
                <div class="mf-setting-tab-content">
                    <span class="mf-setting-title"><?php echo esc_html($lable); ?></span>
                    <span class="mf-setting-subtitle"><?php echo esc_html($caption); ?></span>
                </div>
                <div>
                    <span class="mf mf-megaphone1 mf-icon"></span>
                </div>
            </a>
        </li>

    <?php
    }

    public static function tab_content($id, $title)
    {

    ?>

        <div class="mf-settings-section" id="<?php echo esc_html($id); ?>">
            <div class="mf-settings-single-section">
                <div class="mf-setting-header">
                    <h3 class="mf-settings-single-section--title"><span class="mf mf-megaphone1"></span><?php echo esc_html($title); ?></h3>
                    <button type="submit" name="submit" id="submit" class="button button-primary"><span class="mf-admin-save-icon dashicons dashicons-yes-alt"></span><?php esc_attr_e('Save Changes', 'metform'); ?>
                    </button>
                </div>

                <div class="attr-form-group">
                    <div class="mf-setting-tab-nav">
                        <ul class="attr-nav attr-nav-tabs" id="nav-tab" role="attr-tablist">

                            <?php do_action('metform_settings_subtab_' . $id); ?>

                        </ul>
                    </div>


                </div>

                <div class="attr-form-group">
                    <div class="attr-tab-content" id="nav-tabContent">


                        <?php do_action('metform_settings_subtab_content_' . $id); ?>

                    </div>

                </div>

            </div>
        </div>
    <?php
    }

    public static function sub_tab($title, $target_id, $is_active = null)
    {
    ?>

        <li class="attr-<?php echo esc_html($is_active); ?> attr-in">
            <a class="attr-nav-item attr-nav-link" data-toggle="tab" href="#<?php echo esc_html($target_id); ?> " role="tab"><?php echo esc_attr($title); ?></a>
        </li>

    <?php
    }

    public static function sub_tab_content($sub_tab_id, $content, $active = '')
    {
    ?>

        <div class="attr-tab-pane attr-fade <?php if ($active == 'active') : ?> attr-active attr-in  <?php endif; ?>" id="<?php echo esc_html($sub_tab_id); ?>" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="attr-row">
                <div class="attr-col-lg-6">

                    <?php call_user_func($content); ?>

                </div>
            </div>

        </div>

    <?php
    }

    public static function button($data)
    {
        $class = isset($data['class']) ? $data['class'] : 'mf-admin-setting-btn';
        $id    = isset($data['id']) ? $data['id'] : '';
        $text  = isset($data['text']) ? $data['text'] : '';
    ?>
        <div class="mf-setting-input-group">
            <button type="button" id="<?php echo esc_html($id) ?>" class="<?php echo esc_html($class) ?>"><?php echo esc_html($text) ?></button>
        </div>
    <?php
    }

    public static function textbox($data)
    {
        $settings = \MetForm\Core\Admin\Base::instance()->get_settings_option();

    ?>

        <div class="mf-setting-input-group">
            <label for="attr-input-label" class="mf-setting-label mf-setting-label attr-input-label"><?php echo esc_html($data['lable']); ?></label>
            <input type="text" name="<?php echo esc_attr($data['name']); ?>" value="<?php echo esc_attr((isset($settings[$data['name']])) ? $settings[$data['name']] : ''); ?>" class="mf-setting-input mf-mailchimp-api-key attr-form-control" placeholder="<?php echo esc_html($data['placeholder']); ?>">
            <p class="description">
                <?php echo esc_html($data['description']); ?>
            </p>
        </div>

    <?php
    }

    public static function checkbox($data)
    {

    ?>

        <div class="mf-input-group">
            <label class="attr-input-label">
                <input type="checkbox" value="1" name="<?php echo esc_html($data['name']); ?>" class="mf-admin-control-input <?php echo esc_html($data['class']); ?>">


                <span>
                    <?php echo esc_html($data['label']); ?>
                </span>

            </label>
            <?php if (isset($data['details'])) : ?>
                <span class='mf-input-help'>
                    <?php echo esc_html($data['details']); ?>

                </span>
            <?php endif; ?>

        </div>

    <?php
    }

    public static function form_tab($id, $lable)
    {
    ?>

        <li role="presentation">
            <a href="#<?php echo esc_attr($id); ?>" aria-controls="crm" role="tab" data-toggle="tab">
                <?php echo esc_html($lable); ?>
            </a>
        </li>

    <?php
    }

    public static function form_tab_content($parent_id)
    {

    ?>

        <div role="tabpanel" class="attr-tab-pane" id="<?php echo esc_html($parent_id); ?>">

            <div class="attr-modal-body" id="metform_form_modal_body">


                <?php do_action('mf_push_tab_content_' . $parent_id); ?>

            </div>

        </div>


    <?php
    }

    public static function div($id = '', $class = '', $content = '')
    {
    ?>

        <div id="<?php echo esc_html($id); ?>" class="<?php echo esc_html($class); ?>">

            <?php \MetForm\Utils\Util::metform_content_renderer($content); ?>

        </div>

    <?php
    }

    public static function seperator()
    {
    ?>

<?php
    }
}
