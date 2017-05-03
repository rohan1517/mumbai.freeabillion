<?php
vc_map( array(
        'name' =>'Single Cause',
        'base' => 'acause',
        "icon" => "causes",
		"description" => "Show a cause",
        'category' => esc_html__( 'Webnus Shortcodes', 'vision-church' ),
        'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Cause ID', 'vision-church' ),
				'param_name' => 'post',
				'value'=>'',
				'description' => esc_html__( 'Pick up the ID & follow this instruction: admin panel > causes > ID column. Note: When you type nothing it puts latest cause as default to show.', 'vision-church'),
			), 
		),    
) );
?>