<section class="footer-social-bar"><div class="container"><div class="row"><ul class="footer-social-items">
	<?php
	$vision_church_options = vision_church_options();
	$vision_church_options['vision_church_social_first'] = isset($vision_church_options['vision_church_social_first']) ? $vision_church_options['vision_church_social_first'] : '' ;
	$vision_church_options['vision_church_social_second'] = isset($vision_church_options['vision_church_social_second']) ? $vision_church_options['vision_church_social_second'] : '' ;
	$vision_church_options['vision_church_social_third'] = isset($vision_church_options['vision_church_social_third']) ? $vision_church_options['vision_church_social_third'] : '' ;
	$vision_church_options['vision_church_social_fourth'] = isset($vision_church_options['vision_church_social_fourth']) ? $vision_church_options['vision_church_social_fourth'] : '' ;
	$vision_church_options['vision_church_social_fifth'] = isset($vision_church_options['vision_church_social_fifth']) ? $vision_church_options['vision_church_social_fifth'] : '' ;
	$vision_church_options['vision_church_social_sixth'] = isset($vision_church_options['vision_church_social_sixth']) ? $vision_church_options['vision_church_social_sixth'] : '' ;
	$vision_church_options['vision_church_social_seventh'] = isset($vision_church_options['vision_church_social_seventh']) ? $vision_church_options['vision_church_social_seventh'] : '' ;
	$vision_church_options['vision_church_social_first_url'] = isset($vision_church_options['vision_church_social_first_url']) ? $vision_church_options['vision_church_social_first_url'] : '' ;
	$vision_church_options['vision_church_social_second_url'] = isset($vision_church_options['vision_church_social_second_url']) ? $vision_church_options['vision_church_social_second_url']  : '' ; 
	$vision_church_options['vision_church_social_third_url'] = isset($vision_church_options['vision_church_social_third_url']) ? $vision_church_options['vision_church_social_third_url'] : '' ;
	$vision_church_options['vision_church_social_fourth_url'] = isset($vision_church_options['vision_church_social_fourth_url']) ? $vision_church_options['vision_church_social_fourth_url'] : '' ;
	$vision_church_options['vision_church_social_fifth_url'] = isset($vision_church_options['vision_church_social_fifth_url']) ? $vision_church_options['vision_church_social_fifth_url'] : '' ;
	$vision_church_options['vision_church_social_sixth_url'] = isset($vision_church_options['vision_church_social_sixth_url']) ? $vision_church_options['vision_church_social_sixth_url'] : '' ;
	$vision_church_options['vision_church_social_seventh_url'] = isset($vision_church_options['vision_church_social_seventh_url']) ? $vision_church_options['vision_church_social_seventh_url'] : '' ;
	
	$social = array();
	$social[1] = strtolower(trim($vision_church_options['vision_church_social_first']));
	$social[2] = strtolower(trim($vision_church_options['vision_church_social_second']));
	$social[3] = strtolower(trim($vision_church_options['vision_church_social_third']));
	$social[4] = strtolower(trim($vision_church_options['vision_church_social_fourth']));
	$social[5] = strtolower(trim($vision_church_options['vision_church_social_fifth']));
	$social[6] = strtolower(trim($vision_church_options['vision_church_social_sixth']));
	$social[7] = strtolower(trim($vision_church_options['vision_church_social_seventh']));
	$social_url = array();
	$social_url[1] = trim($vision_church_options['vision_church_social_first_url']);
	$social_url[2] = trim($vision_church_options['vision_church_social_second_url']);
	$social_url[3] = trim($vision_church_options['vision_church_social_third_url']);
	$social_url[4] = trim($vision_church_options['vision_church_social_fourth_url']);
	$social_url[5] = trim($vision_church_options['vision_church_social_fifth_url']);
	$social_url[6] = trim($vision_church_options['vision_church_social_sixth_url']);
	$social_url[7] = trim($vision_church_options['vision_church_social_seventh_url']);
	for ($x = 1; $x <= 7; $x++) {
		echo($social[$x] && $social_url[$x])?'<li><a target="_blank" href="'. $social_url[$x] .'" class="'.$social[$x].'"><i class="fa-'.$social[$x].'"></i><div><strong>'.$social[$x].'</strong><span>'.esc_html__('Join us on ','vision-church').$social[$x].'</span></div></a></li>':'';
	} ?>
</ul></div></div></section>