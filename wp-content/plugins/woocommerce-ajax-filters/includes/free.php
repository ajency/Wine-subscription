<?php
class BeRocket_AAPF_Free extends BeRocket_plugin_variations {
    public $plugin_name = 'ajax_filters';
    public $version_number = 0;
    public function __construct() {
        parent::__construct();
        add_filter('brfr_ajax_filters_section_feature', array($this, 'section_feature'));
    }
    public function settings_page($data) {
        $data['Features'] = array(
            'section_feature' => array(
                "section"   => "section_feature",
                "value"     => "",
            )
        );
        return $data;
    }
    public function settings_tabs($data) {
        $data = berocket_insert_to_array(
            $data,
            'JavaScript/CSS',
            array(
                'Features' => array(
                    'icon' => 'info',
                ),
            )
        );
        return $data;
    }
    public function section_feature ($html) {
        ob_start();
        include_once(AAPF_TEMPLATE_PATH.'free/feature.php');
        $html = ob_get_clean();
        return $html;
    }
}
new BeRocket_AAPF_Free();
