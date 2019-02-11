<?php 
/*
 Plugin Name: VW Health Coach Pro Posttype
 lugin URI: https://www.vwthemes.com/
 Description: Creating new post type for VW Health Coach Pro Theme.
 Author: VW Themes
 Version: 1.0
 Author URI: https://www.vwthemes.com/
*/

define( 'VW_HEALTH_COACH_PRO_POSTTYPE_VERSION', '1.0' );

add_action( 'init', 'vw_health_coach_pro_posttype_create_post_type' );

function vw_health_coach_pro_posttype_create_post_type() {
 
  register_post_type( 'services',
    array(
      'labels' => array(
        'name' => __( 'Services','vw-health-coach-pro-posttype' ),
        'singular_name' => __( 'Services','vw-health-coach-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-paperclip',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );

  register_post_type( 'team',
    array(
      'labels' => array(
        'name' => __( 'Team','vw-health-coach-pro-posttype' ),
        'singular_name' => __( 'Team','vw-health-coach-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-groups',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );

  register_post_type( 'testimonials',
    array(
  		'labels' => array(
  			'name' => __( 'Testimonials','vw-health-coach-pro-posttype' ),
  			'singular_name' => __( 'Testimonials','vw-health-coach-pro-posttype' )
  		),
  		'capability_type' => 'post',
  		'menu_icon'  => 'dashicons-businessman',
  		'public' => true,
  		'supports' => array(
  			'title',
  			'editor',
  			'thumbnail'
  		)
		)
	);
}
/*--------------------- Services section ----------------------*/

// Services Meta
function vw_health_coach_pro_posttype_bn_custom_meta_services() {

    add_meta_box( 'bn_meta', __( 'Meta Data', 'vw-health-coach-pro-posttype-posttype' ), 'vw_health_coach_pro_posttype_bn_meta_callback_services', 'services', 'normal', 'high' );
}
/* Hook things in for admin*/
if (is_admin()){
  add_action('admin_menu', 'vw_health_coach_pro_posttype_bn_custom_meta_services');
}

function vw_health_coach_pro_posttype_bn_meta_callback_services( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );
  
    if(!empty($bn_stored_meta['services_external_url'][0]))
      $bn_services_external_url = $bn_stored_meta['services_external_url'][0];
    else
      $bn_services_external_url = '';
    
    ?>
  <div id="property_stuff">
    <table id="list-table">     
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-2">
          <td class="left">
            <?php _e( 'Link to an External Page', 'vw-health-coach-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="services_external_url" id="services_external_url" value="<?php echo esc_attr( $bn_services_external_url ); ?>" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

function vw_health_coach_pro_posttype_bn_meta_save_services( $post_id ) {

  if (!isset($_POST['bn_nonce']) || !wp_verify_nonce($_POST['bn_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  
  if( isset( $_POST[ 'services_external_url' ] ) ) {
      update_post_meta( $post_id, 'services_external_url', esc_url($_POST[ 'services_external_url' ]) );
  }
}
add_action( 'save_post', 'vw_health_coach_pro_posttype_bn_meta_save_services' );

/*----------------------Testimonial section ----------------------*/
/* Adds a meta box to the Testimonial editing screen */
function vw_health_coach_pro_posttype_bn_testimonial_meta_box() {
	add_meta_box( 'vw-health-coach-pro-posttype-testimonial-meta', __( 'Enter Details', 'vw-health-coach-pro-posttype' ), 'vw_health_coach_pro_posttype_bn_testimonial_meta_callback', 'testimonials', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'vw_health_coach_pro_posttype_bn_testimonial_meta_box');
}
/* Adds a meta box for custom post */
function vw_health_coach_pro_posttype_bn_testimonial_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'vw_health_coach_pro_posttype_posttype_testimonial_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
  if(!empty($bn_stored_meta['vw_health_coach_pro_posttype_testimonial_desigstory'][0]))
      $bn_vw_health_coach_pro_posttype_testimonial_desigstory = $bn_stored_meta['vw_health_coach_pro_posttype_testimonial_desigstory'][0];
    else
      $bn_vw_health_coach_pro_posttype_testimonial_desigstory = '';
	?>
	<div id="testimonials_custom_stuff">
		<table id="list">
			<tbody id="the-list" data-wp-lists="list:meta">
				<tr id="meta-1">
					<td class="left">
						<?php _e( 'Designation', 'vw-health-coach-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="text" name="vw_health_coach_pro_posttype_testimonial_desigstory" id="vw_health_coach_pro_posttype_testimonial_desigstory" value="<?php echo esc_attr( $bn_vw_health_coach_pro_posttype_testimonial_desigstory ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}

/* Saves the custom meta input */
function vw_health_coach_pro_posttype_bn_metadesig_save( $post_id ) {
	if (!isset($_POST['vw_health_coach_pro_posttype_posttype_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['vw_health_coach_pro_posttype_posttype_testimonial_meta_nonce'], basename(__FILE__))) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Save desig.
	if( isset( $_POST[ 'vw_health_coach_pro_posttype_testimonial_desigstory' ] ) ) {
		update_post_meta( $post_id, 'vw_health_coach_pro_posttype_testimonial_desigstory', sanitize_text_field($_POST[ 'vw_health_coach_pro_posttype_testimonial_desigstory']) );
	}
}

add_action( 'save_post', 'vw_health_coach_pro_posttype_bn_metadesig_save' );

/*------------------------- Team Section-----------------------------*/
/* Adds a meta box for Designation */
function vw_health_coach_pro_posttype_bn_team_meta() {
    add_meta_box( 'vw_health_coach_pro_posttype_bn_meta', __( 'Enter Details','vw-health-coach-pro-posttype' ), 'vw_health_coach_pro_posttype_ex_bn_meta_callback', 'team', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'vw_health_coach_pro_posttype_bn_team_meta');
}
/* Adds a meta box for custom post */
function vw_health_coach_pro_posttype_ex_bn_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'vw_health_coach_pro_posttype_bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );

    //Email details
    if(!empty($bn_stored_meta['meta-mail'][0]))
      $bn_meta_desig = $bn_stored_meta['meta-mail'][0];
    else
      $bn_meta_desig = '';

    //Phone details
    if(!empty($bn_stored_meta['meta-call'][0]))
      $bn_meta_call = $bn_stored_meta['meta-call'][0];
    else
      $bn_meta_call = '';

    //facebook details
    if(!empty($bn_stored_meta['meta-facebookurl'][0]))
      $bn_meta_facebookurl = $bn_stored_meta['meta-facebookurl'][0];
    else
      $bn_meta_facebookurl = '';

    //linkdenurl details
    if(!empty($bn_stored_meta['meta-linkdenurl'][0]))
      $bn_meta_linkdenurl = $bn_stored_meta['meta-linkdenurl'][0];
    else
      $bn_meta_linkdenurl = '';

    //twitterurl details
    if(!empty($bn_stored_meta['meta-twitterurl'][0]))
      $bn_meta_twitterurl = $bn_stored_meta['meta-twitterurl'][0];
    else
      $bn_meta_twitterurl = '';

    //twitterurl details
    if(!empty($bn_stored_meta['meta-googleplusurl'][0]))
      $bn_meta_googleplusurl = $bn_stored_meta['meta-googleplusurl'][0];
    else
      $bn_meta_googleplusurl = '';

    //twitterurl details
    if(!empty($bn_stored_meta['meta-designation'][0]))
      $bn_meta_designation = $bn_stored_meta['meta-designation'][0];
    else
      $bn_meta_designation = '';

    ?>
    <div id="agent_custom_stuff">
        <table id="list-table">         
            <tbody id="the-list" data-wp-lists="list:meta">
                <tr id="meta-1">
                    <td class="left">
                        <?php esc_html_e( 'Email', 'vw-health-coach-pro-posttype' )?>
                    </td>
                    <td class="left" >
                        <input type="text" name="meta-mail" id="meta-mail" value="<?php echo esc_attr($bn_meta_desig); ?>" />
                    </td>
                </tr>
                <tr id="meta-2">
                    <td class="left">
                        <?php esc_html_e( 'Phone Number', 'vw-health-coach-pro-posttype' )?>
                    </td>
                    <td class="left" >
                        <input type="text" name="meta-call" id="meta-call" value="<?php echo esc_attr($bn_meta_call); ?>" />
                    </td>
                </tr>
                <tr id="meta-3">
                  <td class="left">
                    <?php esc_html_e( 'Facebook Url', 'vw-health-coach-pro-posttype' )?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-facebookurl" id="meta-facebookurl" value="<?php echo esc_url($bn_meta_facebookurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-4">
                  <td class="left">
                    <?php esc_html_e( 'Linkedin URL', 'vw-health-coach-pro-posttype' )?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-linkdenurl" id="meta-linkdenurl" value="<?php echo esc_url($bn_meta_linkdenurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-5">
                  <td class="left">
                    <?php esc_html_e( 'Twitter Url', 'vw-health-coach-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-twitterurl" id="meta-twitterurl" value="<?php echo esc_url( $bn_meta_twitterurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-6">
                  <td class="left">
                    <?php esc_html_e( 'GooglePlus URL', 'vw-health-coach-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-googleplusurl" id="meta-googleplusurl" value="<?php echo esc_url($bn_meta_googleplusurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-7">
                  <td class="left">
                    <?php esc_html_e( 'Designation', 'vw-health-coach-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="text" name="meta-designation" id="meta-designation" value="<?php echo esc_attr($bn_meta_designation); ?>" />
                  </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
}
/* Saves the custom Designation meta input */
function vw_health_coach_pro_posttype_ex_bn_metadesig_save( $post_id ) {
    if( isset( $_POST[ 'meta-mail' ] ) ) {
        update_post_meta( $post_id, 'meta-mail', esc_html($_POST[ 'meta-mail' ]) );
    }
    if( isset( $_POST[ 'meta-call' ] ) ) {
        update_post_meta( $post_id, 'meta-call', esc_html($_POST[ 'meta-call' ]) );
    }
    // Save facebookurl
    if( isset( $_POST[ 'meta-facebookurl' ] ) ) {
        update_post_meta( $post_id, 'meta-facebookurl', esc_url($_POST[ 'meta-facebookurl' ]) );
    }
    // Save linkdenurl
    if( isset( $_POST[ 'meta-linkdenurl' ] ) ) {
        update_post_meta( $post_id, 'meta-linkdenurl', esc_url($_POST[ 'meta-linkdenurl' ]) );
    }
    if( isset( $_POST[ 'meta-twitterurl' ] ) ) {
        update_post_meta( $post_id, 'meta-twitterurl', esc_url($_POST[ 'meta-twitterurl' ]) );
    }
    // Save googleplusurl
    if( isset( $_POST[ 'meta-googleplusurl' ] ) ) {
        update_post_meta( $post_id, 'meta-googleplusurl', esc_url($_POST[ 'meta-googleplusurl' ]) );
    }
    // Save designation
    if( isset( $_POST[ 'meta-designation' ] ) ) {
        update_post_meta( $post_id, 'meta-designation', esc_html($_POST[ 'meta-designation' ]) );
    }
}
add_action( 'save_post', 'vw_health_coach_pro_posttype_ex_bn_metadesig_save' );

add_action( 'save_post', 'bn_meta_save' );
/* Saves the custom meta input */
function bn_meta_save( $post_id ) {
  if( isset( $_POST[ 'vw_health_coach_pro_posttype_team_featured' ] )) {
      update_post_meta( $post_id, 'vw_health_coach_pro_posttype_team_featured', esc_attr(1));
  }else{
    update_post_meta( $post_id, 'vw_health_coach_pro_posttype_team_featured', esc_attr(0));
  }
}

/*------------------- Testimonial Shortcode --------------------*/
function vw_health_coach_pro_posttype_testimonials_func( $atts ) {
    $testimonial = ''; 
    $testimonial = '<div id="testimonials"><div class="row testimonial_shortcodes">';
      $new = new WP_Query( array( 'post_type' => 'testimonials') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = vw_health_coach_pro_string_limit_words(get_the_excerpt(),20);
          $designation = get_post_meta($post_id,'vw_health_coach_pro_posttype_testimonial_desigstory',true);

          $testimonial .= '<div class="col-lg-4 col-md-6 col-sm-6 mb-4"><div class="testimonial_box text-center">
            <div class="row">
              <div class="testimonial-thumb col-lg-5">'; 
                if (has_post_thumbnail()){
                  $testimonial.= '<img src="'.esc_url($url).'">';
                } 
                $testimonial .= '</div>
              <div class="col-lg-7">
                <h4 class="testimonial_name"><a href="'.get_the_permalink().'">'.get_the_title().'</a> <cite>'.esc_html($designation).'</cite></h4>
              </div>
            </div>  
            <div class="qoute_text pb-3">'.$excerpt.'</div> 
            </div></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $testimonial = '<div id="testimonial" class="testimonial_wrap col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','vw-health-coach-pro-posttype').'</h2></div>';
      endif;
    $testimonial .= '</div></div>';
    return $testimonial;
}
add_shortcode( 'vw-health-coach-pro-testimonials', 'vw_health_coach_pro_posttype_testimonials_func' );

/*---------------- Team Shortcode ---------------------*/
function vw_health_coach_pro_posttype_team_func( $atts ) {
    $team = ''; 
    $team = '<div id="team" class="row ">';
      $new = new WP_Query( array( 'post_type' => 'team') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large' );
          $url = $thumb['0'];
          $excerpt = vw_health_coach_pro_string_limit_words(get_the_excerpt(),10);
          $designation = get_post_meta($post_id,'meta-designation',true);
          $facebookurl= get_post_meta($post_id,'meta-facebookurl',true);
          $linkedin=get_post_meta($post_id,'meta-linkdenurl',true);
          $twitter=get_post_meta($post_id,'meta-twitterurl',true);
          $googleplus=get_post_meta($post_id,'meta-googleplusurl',true);
          $team .= '<div class="col-lg-3 col-md-6 col-sm-6 mb-4"> 
            <div class="team-box">';
              if (has_post_thumbnail()){
                $team.= '<img src="'.esc_url($url).'">';
                }
              $team.= '
              <div class="teambox-content">
                <h4 class="team_name"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
                <h6>'.esc_html($designation).'</h6>      
                <span class="teampost">'.$excerpt.'</span>
                <ul class="social-link mt-4">
                  <li>';
                    if($facebookurl != ''){
                    $team .= '<a class="" href="'.esc_url($facebookurl).'" target="_blank"><i class="fab fa-facebook-f"></i></a>';
                    }
                  $team.= '</li>

                  <li>';
                    if($twitter != ''){
                    $team .= '<a class="" href="'.esc_url($twitter).'" target="_blank"><i class="fab fa-twitter"></i></a>';
                    }
                  $team.= '</li>

                  <li>';
                    if($googleplus != ''){
                    $team .= '<a class="" href="'.esc_url($googleplus).'" target="_blank"><i class="fab fa-google-plus-g"></i></a>';
                    }
                  $team.= '</li>

                  <li>';
                    if($linkedin != ''){
                    $team .= '<a class="" href="'.esc_url($linkedin).'" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
                    }
                  $team.= '</li>
                </ul>  
              </div> 
            </div>
          </div>  ';
          $k++;         
        endwhile; 
        wp_reset_postdata();
        $team.= '</div>';
      else :
        $team = '<div id="our_team" class="col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','vw-health-coach-pro-posttype').'</h2></div>';
      endif;
      $team.= '</div>';
    return $team;
}
add_shortcode( 'vw-health-coach-pro-team', 'vw_health_coach_pro_posttype_team_func' );

/*------------------- Services Shortcode -------------------------*/
function vw_health_coach_pro_posttype_services_func( $atts ) {
    $services = ''; 
    $services = '<div id="services"><div class="row inner-test-bg">';
      $new = new WP_Query( array( 'post_type' => 'services') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = vw_health_coach_pro_string_limit_words(get_the_excerpt(),20);
          $read_more_text = get_theme_mod('vw_health_coach_pro_services_read_more_text');
          $services .= '<div class="col-lg-4 col-md-6 col-sm-6 mb-4"> 
          <div class="service-box-shortcodes text-center">';
              if (has_post_thumbnail()){
                $services.= '<img src="'.esc_url($url).'">';
              }
          $services.= '  <div class="service_shortcodes">
              <h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
              <div class="services_content_shortcodes">'.$excerpt.'</div>';
                $custom_url = '';
                if(get_post_meta(get_the_ID(), 'services_external_url', true != '')){  $custom_url = get_post_meta(get_the_ID(), 'services_external_url', true); }
              if($read_more_text != ''){  
                $services .= '<div class="read_more mb-4"><a href="'.esc_url($custom_url).'">'.esc_html($read_more_text).'</a></div>';
              } 
          $services .= '  </div>
          </div>
        </div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $services = '<div id="services" class="col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','vw-health-coach-pro-posttype').'</h2></div></div></div>';
      endif;
    $services .= '</div></div>';
    return $services;
}
add_shortcode( 'vw-health-coach-pro-services', 'vw_health_coach_pro_posttype_services_func' );

