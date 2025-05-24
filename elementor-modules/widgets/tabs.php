<?php
/**
 * DOT Custom Tabs Widget for Elementor
 * 
 * This widget creates a tabbed interface with the following features:
 * - Repeater field for adding multiple tabs
 * - Each tab can contain:
 *   - Title
 *   - Image
 *   - Rich text content
 *   - Button with URL
 * - Customizable styling through Elementor controls
 * - Responsive design
 * 
 * Connected to:
 * - assets/js/widgets.js (for tab switching functionality)
 * - assets/css/widgets.css (for styling)
 */

class DOT_Tabs_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name
     * Used for registering the widget in Elementor
     */
    public function get_name() {
        return 'dot_custom_tabs';
    }

    /**
     * Get widget title
     * Displayed in the Elementor editor
     */
    public function get_title() {
        return __('DOT Custom Tabs', 'elementor-modules');
    }

    /**
     * Get widget icon
     * Uses Elementor's icon system
     */
    public function get_icon() {
        return 'eicon-tabs';
    }

    /**
     * Get widget categories
     * Determines where the widget appears in Elementor's widget panel
     */
    public function get_categories() {
        return ['dot-modules'];
    }

    /**
     * Register widget controls
     * Defines the widget's settings in the Elementor editor
     */
    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Tabs Content', 'elementor-modules'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Create repeater for tabs
        $repeater = new \Elementor\Repeater();

        // Tab title control
        $repeater->add_control(
            'tab_title',
            [
                'label' => __('Tab Title', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tab Title', 'elementor-modules'),
            ]
        );

        // Tab image control
        $repeater->add_control(
            'tab_image',
            [
                'label' => __('Tab Image', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Tab content control (WYSIWYG editor)
        $repeater->add_control(
            'tab_content',
            [
                'label' => __('Tab Content', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Tab Content', 'elementor-modules'),
            ]
        );

        // Button text control
        $repeater->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Click Here', 'elementor-modules'),
            ]
        );

        // Button URL control
        $repeater->add_control(
            'button_url',
            [
                'label' => __('Button URL', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'elementor-modules'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        // Add repeater to main controls
        $this->add_control(
            'tabs',
            [
                'label' => __('Tabs', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => __('Tab #1', 'elementor-modules'),
                        'tab_content' => __('Tab content goes here', 'elementor-modules'),
                    ],
                    [
                        'tab_title' => __('Tab #2', 'elementor-modules'),
                        'tab_content' => __('Tab content goes here', 'elementor-modules'),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'elementor-modules'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Tab background color control
        $this->add_control(
            'tab_background_color',
            [
                'label' => __('Tab Background Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs .tab-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Tab text color control
        $this->add_control(
            'tab_text_color',
            [
                'label' => __('Tab Text Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs .tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Active tab background color control
        $this->add_control(
            'active_tab_background_color',
            [
                'label' => __('Active Tab Background Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs .tab-title.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Active tab text color control
        $this->add_control(
            'active_tab_text_color',
            [
                'label' => __('Active Tab Text Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs .tab-title.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output
     * Generates the final HTML for the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="custom-tabs">
            <div class="tabs-navigation">
                <?php foreach ($settings['tabs'] as $index => $item) : ?>
                    <div class="tab-title <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo $index; ?>">
                        <?php echo esc_html($item['tab_title']); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="tabs-content">
                <?php foreach ($settings['tabs'] as $index => $item) : ?>
                    <div class="tab-content <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo $index; ?>">
                        <?php if (!empty($item['tab_image']['url'])) : ?>
                            <div class="tab-image">
                                <img src="<?php echo esc_url($item['tab_image']['url']); ?>" alt="<?php echo esc_attr($item['tab_title']); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="tab-text">
                            <?php echo wp_kses_post($item['tab_content']); ?>
                        </div>
                        <?php if (!empty($item['button_text']) && !empty($item['button_url']['url'])) : ?>
                            <div class="tab-button">
                                <a href="<?php echo esc_url($item['button_url']['url']); ?>" <?php echo $item['button_url']['is_external'] ? 'target="_blank"' : ''; ?>>
                                    <?php echo esc_html($item['button_text']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            .custom-tabs {
                width: 100%;
            }
            .tabs-navigation {
                display: flex;
                border-bottom: 1px solid #ddd;
            }
            .tab-title {
                padding: 10px 20px;
                cursor: pointer;
                border: 1px solid #ddd;
                border-bottom: none;
                margin-right: 5px;
                border-radius: 5px 5px 0 0;
            }
            .tab-title.active {
                background-color: #f7f7f7;
                border-bottom: 1px solid #f7f7f7;
                margin-bottom: -1px;
            }
            .tab-content {
                display: none;
                padding: 20px;
                border: 1px solid #ddd;
                border-top: none;
            }
            .tab-content.active {
                display: block;
            }
            .tab-image {
                margin-bottom: 20px;
            }
            .tab-image img {
                max-width: 100%;
                height: auto;
            }
            .tab-button {
                margin-top: 20px;
            }
            .tab-button a {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            .tab-button a:hover {
                background-color: #0056b3;
            }
        </style>

        <script>
            jQuery(document).ready(function($) {
                $('.tab-title').on('click', function() {
                    var tabId = $(this).data('tab');
                    $('.tab-title').removeClass('active');
                    $('.tab-content').removeClass('active');
                    $(this).addClass('active');
                    $('.tab-content[data-tab="' + tabId + '"]').addClass('active');
                });
            });
        </script>
        <?php
    }
} 