<?php
namespace BootstrapWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Bootstrap_Modal extends Widget_Base {

	public function get_name() {
		return 'ele-bootstrap-modal';
	}

	public function get_title() {
		return __( 'Bootstrap Modal', 'ele-bootstrap-widgets' );
	}

	public function get_icon() {
		return 'fa fa-window-restore';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'settings_section',
			[
				'label' => __( 'Trigger Settings', 'ele-bootstrap-widgets' ),
				'tab' => Controls_Manager::TAB_SETTINGS,
			]
		);
		$this->add_control(
			'trigger_type',
			[
				'label' => __( 'Trigger Type', 'ele-bootstrap-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image',
				'description' => __( 'Please fill the below settings of what trigger type you selected.', 'ele-bootstrap-widgets' ),
				'options' => [
					// 'image'  => __( 'Image', 'ele-bootstrap-widgets' ),
					'gallery' => __( 'Gallery', 'ele-bootstrap-widgets' ),
					// 'textlink' => __( 'Text Link', 'ele-bootstrap-widgets' ),
				],
				//'section' => 'section_trigger_settings',
				// 'selectors' => [ // You can use the selected value in an auto-generated css rule.
				// 	'{{WRAPPER}} .your-element' => 'border-style: {{VALUE}}',
				// ],
			]
		);

		$this->start_controls_tabs(
			'trigger_tabs'
		);

		// Gallery Settings

		$this->start_controls_tab(
			'trigger_gallery_tab',
			[
				'label' => __( 'Gallery', 'ele-bootstrap-widgets' ),
			]
		);

		$this->add_control(
			'gallery',
			[
				'label' => __( 'Add Images', 'ele-bootstrap-widgets' ),
				'type' => Controls_Manager::GALLERY,
				// 'section' => 'section_gallery_settings',
			]
		);
		$this->end_controls_tab();

		// Image Settings

		// $this->start_controls_tab(
		// 	'trigger_image_tab',
		// 	[
		// 		'label' => __( 'Image', 'ele-bootstrap-widgets' ),
		// 	]
		// );

		// $this->add_control(
		// 	'image',
		// 	[
		// 		'label' => __( 'Choose Image', 'ele-bootstrap-widgets' ),
		// 		'type' => Controls_Manager::MEDIA,
		// 		'default' => [
		// 			'url' => Utils::get_placeholder_image_src(),
		// 		],
		// 		// 'section' => 'section_image_settings',
		// 	]
		// );
		// $this->end_controls_tab();

		// // TEXT

		// $this->start_controls_tab(
		// 	'trigger_text_tab',
		// 	[
		// 		'label' => __( 'Text', 'ele-bootstrap-widgets' ),
		// 	]
		// );

		// $this->add_control(
		// 	'link_title',
		// 	[
		// 		'label' => __( 'Link Title', 'ele-bootstrap-widgets' ),
		// 		'type' => Controls_Manager::TEXT,
		// 		'default' => __('Click Me', 'ele-bootstrap-widgets'),
		// 		'title' => __( 'Enter a link title', 'ele-bootstrap-widgets' ),
		// 		// 'section' => 'section_text_link_settings',
		// 	]
		// );
		// $this->end_controls_tab();

		// // Posts

		// $this->start_controls_tab(
		// 	'trigger_posts_tab',
		// 	[
		// 		'label' => __( 'Posts', 'ele-bootstrap-widgets' ),
		// 	]
		// );

		// $this->add_control(
		// 	"_test_multiselect",
		// 	[
		// 		'label'	=> 'Multiselect',
		// 		'type'	=> 'multiselect',
		// 		'options'	=> array(
		// 			'val1'	=> 'Value 1',
		// 			'val2'	=> 'Value 2',
		// 			'val3'	=> 'Value 3',
		// 			'val4'	=> 'Value 4',
		// 			'val5'	=> 'Value 5',
		// 		),
		// 		//'section' => 'section_trigger_settings',
		// 	]
		// );

		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		$this->end_controls_section();


		// Modal Settings

		$this->add_control(
			'section_modal_settings',
			[
				'label' => __( 'Modal Settings', 'ele-bootstrap-widgets' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'bootstrap_version',
			[
				'label'       => __( 'Bootstrap Version', 'ele-bootstrap-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'v3x',
				'options' => [
					'v3x'  => __( '3.x', 'ele-bootstrap-widgets' ),
					// 'v4b' => __( '4.x beta', 'ele-bootstrap-widgets' ),
					// 'v4x' => __( '4.x', 'ele-bootstrap-widgets' ),
				],
				'selectors' => [ // You can use the selected value in an auto-generated css rule.
					'{{WRAPPER}} .your-element' => 'border-style: {{VALUE}}',
				],
				'section' => 'section_modal_settings',
			]
		);

		// $this->add_control(
		// 	'modal_title',
		// 	[
		// 		'label' => __( 'Modal Title', 'ele-bootstrap-widgets' ),
		// 		'type' => Controls_Manager::TEXT,
		// 		'default' => '(no title)',
		// 		'title' => __( 'Enter modal window title', 'ele-bootstrap-widgets' ),
		// 		'section' => 'section_modal_settings',
		// 	]
		// );

		$this->end_controls_section();

	}

	protected function render( $instance = [] ) {
		$widget_instance_id = $this->get_id();
		$settings = $this->get_settings();

		echo '<div class="bootstrap-widgets thumbs" data-wid="wid_'.$widget_instance_id.'">';

		$trigger_type = $settings['trigger_type'];

		switch ($trigger_type) {
			case 'gallery':
				$images = $this->get_settings( 'gallery' );
				if (!empty($images)) {
					?>
					<div class="row">

					<div class="col-lg-12">
						<?php
						$i = 1;
						foreach ( $images as $image ) {
							//print_r($image);
							$img_id = $image['id'];
							$img_ori_url = $image['url'];
							$attachment = get_post($img_id);
							$img_thm_url = wp_get_attachment_image_url($img_id, 'medium');
							$img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
							$img_title = $attachment->post_title;
							$img_caption = $attachment->post_excerpt;
							$img_desc = $attachment->post_content;
							?>
							<div class="col-lg-6 col-md-6 col-xs-6 thumb">
								<a class="thumbnail" href="#" 
									data-image-id="<?php echo $i++;?>" 
									data-toggle="modal" 
									data-title="<?php echo $img_title;?>" 
									data-caption="<?php echo $img_caption;?>" 
									data-image="<?php echo $img_ori_url;?>" 
									data-target="#image-gallery_<?php echo $widget_instance_id;?>" style="outline: 0;"
								>
									<img class="img-responsive" src="<?php echo $img_thm_url;?>" alt="<?php echo $img_alt;?>">
								</a>
								<div style="text-align:center;"><?php echo $img_caption;?></div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
				}else{
					echo '<div style="text-align:center; background-color:#dfdfdf; padding: 10px;">';
					echo __('Please fill the gallery section settings.', 'ele-bootstrap-widgets');
					echo '</div>';
				}
				break;

			case 'image':
				$image = $this->get_settings( 'image' );
				if (!empty($image) && !empty($image['url'])) {
					echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal">
						<img src="' . $image['url'] . '"></a>';
					// Get image by id
					// echo wp_get_attachment_image( $image['id'], 'thumbnail' );
				}
				break;

			case 'textlink':
				if (!empty($settings['link_title'])) {
					?>
					<div>
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
							<?php echo esc_html($settings['link_title'] );?>
						</button>
					</div>
					<?php
				}else{
					echo __('Please fill the text link section settings.', 'ele-bootstrap-widgets');
				}
				break;

			default:

		}

		echo '</div>';
		?>

		<!-- Modal -->
		<div class="modal fade bootstrap-widgets" id="image-gallery_<?php echo $widget_instance_id;?>" tabindex="-1" role="dialog" aria-labelledby="BootstrapModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">
						<span class="fa fa-close"></span>
					</span>
					<span class="sr-only">
						<?php _e('Close', 'ele-bootstrap-widgets');?>
					</span>
				</button>
				<div class="modal-content">
				<!--
					<div class="modal-header">
					
				 		<div class="row">
				 			<div class="col-xs-10">
								<h4 class="modal-title image-gallery-title" style="margin-top:0px; "></h4>
							</div>
							<div class="col-xs-2">

							 </div>
						 </div>
						 
					</div>
					-->
					<div class="modal-body">
						<img class="image-gallery-image img-responsive" src="">
					</div>
					<div class="modal-footer">
						<div class="text-justify image-gallery-caption">
							This text will be overwritten by jQuery
						</div>
					</div>
				</div>
			</div>
			<button type="button" class="btn_prev" data-id="show-previous-image"><span class="fa fa-arrow-left"></button>
			<button type="button" class="btn_next" data-id="show-next-image"><span class="fa fa-arrow-right"></button>
		</div>

		<?php
	}
	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		// echo 'preview content template';
	}

	public function render_plain_content( $instance = [] ) {
		echo '<!-- render_plain_content -->';
	}
}
