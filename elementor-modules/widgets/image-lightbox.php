<?php
/**
 * DOT Image Lightbox Widget for Elementor
 * 
 * This widget creates an image with lightbox functionality:
 * - Allows users to select an image and add a caption
 * - Clicking the image opens it in a lightbox overlay
 * - Supports custom styling through Elementor controls
 * 
 * Connected to:
 * - assets/js/widgets.js (for lightbox functionality)
 * - assets/css/widgets.css (for styling)
 */

class DOT_Image_Lightbox_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name
     * Used for registering the widget in Elementor
     */
    public function get_name() {
        return 'dot_image_lightbox';
    }

    /**
     * Get widget title
     * Displayed in the Elementor editor
     */
    public function get_title() {
        return __('DOT Image Lightbox', 'elementor-modules');
    }

    /**
     * Get widget icon
     * Uses Elementor's icon system
     */
    public function get_icon() {
        return 'eicon-image-box';
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
                'label' => __('Content', 'elementor-modules'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Image control
        $this->add_control(
            'image',
            [
                'label' => __('Choose Image', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Caption control
        $this->add_control(
            'caption',
            [
                'label' => __('Caption', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Image Caption', 'elementor-modules'),
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

        // Image width control
        $this->add_control(
            'image_width',
            [
                'label' => __('Image Width', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .image-lightbox img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Caption color control
        $this->add_control(
            'caption_color',
            [
                'label' => __('Caption Color', 'elementor-modules'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-lightbox-caption' => 'color: {{VALUE}};',
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
        <div class="image-lightbox">
            <a href="<?php echo esc_url($settings['image']['url']); ?>" data-lightbox="image-lightbox" data-title="<?php echo esc_attr($settings['caption']); ?>">
                <img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo esc_attr($settings['caption']); ?>">
            </a>
            <div class="image-lightbox-caption"><?php echo esc_html($settings['caption']); ?></div>
        </div>
        <?php
    }
} 