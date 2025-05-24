<?php
/**
 * DOT Custom Tabs Widget for Elementor
 * 
 * This widget creates a custom tabs interface with:
 * - Repeater field for adding multiple tabs
 * - Each tab contains a title, image, rich text content, and a button with URL
 * - Customizable styling through Elementor controls
 * - Responsive design with mobile-friendly layout
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
        return 'dot_tabs';
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
                'label' => __('Tabs', 'elementor-modules'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Tabs repeater
        $repeater = new \Elementor\Repeater();

        // Tab title
        $repeater->add_control(
            'tab_title',
            [
                'label' => __('Tab Title', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tab Title', 'elementor-modules'),
            ]
        );

        // Tab image
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

        // Tab content
        $repeater->add_control(
            'tab_content',
            [
                'label' => __('Tab Content', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Tab Content', 'elementor-modules'),
            ]
        );

        // Tab button text
        $repeater->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Click Here', 'elementor-modules'),
            ]
        );

        // Tab button URL
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

        // Add repeater to widget
        $this->add_control(
            'tabs',
            [
                'label' => __('Tabs', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => __('Tab 1', 'elementor-modules'),
                        'tab_content' => __('Tab 1 Content', 'elementor-modules'),
                    ],
                    [
                        'tab_title' => __('Tab 2', 'elementor-modules'),
                        'tab_content' => __('Tab 2 Content', 'elementor-modules'),
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

        // Tab navigation style
        $this->add_control(
            'tab_nav_style',
            [
                'label' => __('Tab Navigation', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Tab background color
        $this->add_control(
            'tab_background_color',
            [
                'label' => __('Background Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs-nav-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Active tab background color
        $this->add_control(
            'active_tab_background_color',
            [
                'label' => __('Active Background Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs-nav-item.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Tab text color
        $this->add_control(
            'tab_text_color',
            [
                'label' => __('Text Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs-nav-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Active tab text color
        $this->add_control(
            'active_tab_text_color',
            [
                'label' => __('Active Text Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs-nav-item.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Tab typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_typography',
                'selector' => '{{WRAPPER}} .custom-tabs-nav-item',
            ]
        );

        // Tab content style
        $this->add_control(
            'tab_content_style',
            [
                'label' => __('Tab Content', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Content text color
        $this->add_control(
            'content_text_color',
            [
                'label' => __('Text Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Content typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .custom-tabs-content',
            ]
        );

        // Button style
        $this->add_control(
            'button_style',
            [
                'label' => __('Button', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Button background color
        $this->add_control(
            'button_background_color',
            [
                'label' => __('Background Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Button text color
        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-tabs-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .custom-tabs-button',
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
            <div class="custom-tabs-nav">
                <?php foreach ($settings['tabs'] as $index => $item) : ?>
                    <div class="custom-tabs-nav-item <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo $index; ?>">
                        <?php echo esc_html($item['tab_title']); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="custom-tabs-content-wrapper">
                <?php foreach ($settings['tabs'] as $index => $item) : ?>
                    <div class="custom-tabs-content <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo $index; ?>">
                        <?php if (!empty($item['tab_image']['url'])) : ?>
                            <img src="<?php echo esc_url($item['tab_image']['url']); ?>" alt="<?php echo esc_attr($item['tab_title']); ?>">
                        <?php endif; ?>
                        <div class="custom-tabs-text">
                            <?php echo wp_kses_post($item['tab_content']); ?>
                        </div>
                        <?php if (!empty($item['button_text']) && !empty($item['button_url']['url'])) : ?>
                            <a href="<?php echo esc_url($item['button_url']['url']); ?>" class="custom-tabs-button" <?php echo $item['button_url']['is_external'] ? 'target="_blank"' : ''; ?>>
                                <?php echo esc_html($item['button_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
} 