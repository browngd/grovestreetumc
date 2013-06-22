<?php
/**
 * 
 * @author alexhermann
 *
 */
Class AWD_facebook_app_requests extends AWD_facebook_plugin_abstract
{
	/**
	 * The Slug of the plugin
	 * @var string
	 */
    public $plugin_slug = 'awd_fcbk_app_requests';
    
    /**
     * The Name of the plugin
     * @var string
     */
    public $plugin_name = 'Facebook AWD App Requests';
    
    /**
     * The text domain of the plugin
     * @var string
     */
    public $ptd = 'AWD_facebook_app_requests';
    
    /**
     * The version required for AWD_facebook object
     * @var float
     */
    public $version_requiered = 1.4;
    
    /**
     * The array of deps
     * @var array
     */
    public $deps = array('connect'=>1);
	
	/**
	 * Constructor
	 */
	public function __construct($file,$AWD_facebook)
	{
		parent::__construct(__FILE__,$AWD_facebook);
	}
	
	/**
	 * Initialisation of the Facebook AWD plugin
	 */
	public function initialisation()
	{
		parent::init();
		add_shortcode('AWD_facebook_app_requests_button', array($this, 'shortcode_app_requests'));
	}
	
	/**
	 * Enqueus JS on admin and front
	 */
	public function global_enqueue_js()
	{
		wp_register_script($this->plugin_slug,$this->plugin_url.'/assets/js/facebook_awd_app_requests.js',array($this->AWD_facebook->plugin_slug));
		wp_enqueue_script($this->plugin_slug);
	}
	
	/**
	 * Define default $options
	 * @param array $options
	 */
	public function default_options($options)
	{
		$options = parent::default_options($options);
		$default_options = array();
		$default_options['label'] = __('Invite Your Friends',$this->ptd);
		$default_options['message'] = sprintf(__('Join me on %s',$this->ptd), get_bloginfo('name'));
		$default_options['class'] = 'btn';
		$default_options['callbackjs'] = '';
		
		//attach options to Container
		if(!isset($options['app_requests']))
			$options['app_requests'] = array();
		$options['app_requests'] = wp_parse_args($options['app_requests'], $default_options);

		return $options;
	}
	
	/**
	 * Register widget
	 */
	public function register_widgets()
	{
		global $wp_widget_factory;
		$fields = apply_filters('AWD_facebook_plugins_form', array());
		$fields = isset($fields['app_requests']) ? $fields['app_requests'] : array();
		$wp_widget_factory->widgets['AWD_facebook_widget_app_requests'] = new AWD_facebook_widget(array('id_base' => 'app_requests', 'name' => $this->plugin_name, 'description' => __('Allow your users to invite their friends', $this->ptd), 'model' => $fields, 'self_callback' => array($this, 'shortcode_app_requests'), 'text_domain' => $this->ptd, 'preview' => true));
	}
	
	/**
	 * Plugins menu filter
	 * @param array $list
	 */
	public function plugin_settings_menu($list)
	{
		$list['app_requests_settings'] = __('App Requests', $this->ptd);
		return $list;
	}
	
	/**
	 * Model of form
	 * @param array $fields
	 */
	public function plugin_settings_form($fields)
	{
		$fields['app_requests'] = array(
			
			'title_config' => array(
				'type'=>'html',
				'html'=> '
					<h1>'.__('Configure the button',$this->ptd).'</h1>
				',
				'widget_no_display' => true
			),
			
			'before_config' => array(
				'type'=>'html',
				'html'=> '
					<div class="row">
				'
			),
			
			'widget_title'=> array(
				'type'=> 'text',
				'label'=> __('Title',$this->ptd),
				'class'=>'span4',
				'attr'=> array('class'=>'span4'),
				'widget_only' => true
			),	
				
			'label'=> array(
				'type'=> 'text',
				'label'=> __('Label',$this->ptd),
				'class'=>'span4',
				'attr'=> array('class'=>'span4')
			),
			
			'message'=> array(
				'type'=> 'text',
				'label'=> __('Message',$this->ptd),
				'class'=>'span4',
				'attr'=> array('class'=>'span4')
			),
			
			'class'=> array(
				'type'=> 'text',
				'label'=> __('Css Class',$this->ptd),
				'class'=>'span4',
				'attr'=> array('class'=>'span4')
			),
			
			'after_config' => array(
				'type'=>'html',
				'html'=> '
					</div>
				'
			),
			
			'preview' => array(
				'type'=>'html',
				'html'=> '
					<h1>'.__('Preview',$this->ptd).'</h1>
					<div class="well">'.do_shortcode('[AWD_facebook_app_requests_button]').'</div>
					<h1>'.__('Options List',$this->ptd).'</h1>
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<th>Option</th>
								<th>Value</th>
							</tr>
						</thead>
						<tbody>
							<tr><td>label</td><td>string</td></tr>
							<tr><td>message</td><td>string</td></tr>
							<tr><td>class</td><td>number</td></tr>
						</tbody>
						<tfoot>
							<th colspan="2">[AWD_facebook_app_requests_button option="value"]</th>
						</tfoot>
					</table>
				',
				'widget_no_display' => true
			)
		);
		return $fields;
	}
	
	/**
	 * Shortcode function hook
	 * @param array $options
	 */
	public function shortcode_app_requests($options=array())
	{
		return $this->get_the_app_requests_button($options);
	}
	
	/**
	 * Get the app request button
	 * @param array $options
	 */
	public function get_the_app_requests_button($options=array())
	{
		$options = wp_parse_args($options, $this->AWD_facebook->options['app_requests']);
		return '<div class="AWD_facebook_wrap"><a href="#" class="AWD_facebook_app_requests_button '.$options['class'].'" data-type-event="click" data-message="'.$options['message'].'" data-callbackjs="'.$options['callbackjs'].'">'.$options['label'].'</a></div>';
	}
}