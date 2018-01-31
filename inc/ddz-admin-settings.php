<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
*
*/
class DDZ_testimonial_settings
{

	public function __construct()
	{
		$this->ddz_testimonial_display();
	}

	private function ddz_testimonial_display()
	{
		?>
		 	<div class="container">
			<div class="row ddz_testiminial_container">

            <h1>Testimonial Settings</h1>

            	<div class="col-md-12">
            		<form method="POST" action="#" enctype="multipart/form-data">

	               	<?php $this->ddz_display_settings_fields(); ?>
	               	<div class="form-group">
	                   <button type="submit" name="ddz_settings" class="ddz_test_button_lg" value="save">Submit</button>
	                </div>
	                </p>
	            </form>
            	</div>

        	</div>
        </div>
        <?php
	}

	private function ddz_display_settings_fields() {
		if ($_POST) {
			
			$this->ddz_arugment_update('ddz_settings');
			wp_redirect( admin_url('admin.php?page=ddz-options') );
			exit();
			
		}

		$options = $this->ddz_argument_val('ddz_settings');
		

		?>
		<table class="form-table">
			<tbody>
				<tr><th style="font-size: 20px;">Title Text</th></tr>
				<tr>
					<th><label for="testimonial-title">Testimonial Title</label></th>
					<td><input type="text" name="ddz_testimonial_heading" value="<?php echo $options['ddz_testimonial_heading']; ?>" ></td>
				</tr>
				<tr>
					<th><label for="testimonial-desc">Testimonial Description</label></th>
					<td><textarea name="ddz_testimonial_desc"><?php echo $options['ddz_testimonial_desc']; ?></textarea></td>
				</tr>
				<hr>
				<tr><th style="font-size: 20px;">Testimonial settings</th></tr>
				<tr>
					<th><label for="emailsubject">Select Layout</label></th>
					<td><label for="emailsubject">Layout 1 </label><input type="radio" name="ddz_design_layout" value="1" <?php echo ($options['ddz_design_layout'] == 1) ? 'checked="checked"' : '';  ?>>
						<label for="emailsubject">Layout 2 </label><input type="radio" name="ddz_design_layout" value="2" <?php echo ($options['ddz_design_layout'] == 2) ? 'checked="checked"' : '';  ?>>
						<label for="emailsubject">Layout 3 </label><input type="radio" name="ddz_design_layout" value="3" <?php echo ($options['ddz_design_layout'] == 3) ? 'checked="checked"' : '';  ?>>
					</td>
				</tr>
				<tr>
					<th><label for="emailsubject">Enter Email Body</label></th>
					<td><input type="text" name="ddz_layout" value="<?php echo $options['ddz_layout']; ?>"></td>
				</tr>
			</tbody>
			
		</table>
		
		
		<?php
	}

	private function ddz_return_arr( $field ){

	  switch($field){
	        case 'ddz_settings':
	            $variables = array(

	                                'ddz_testimonial_heading' => 'Testimonial',
	                                'ddz_testimonial_desc' => 'Testimonial description is here',
	                                'ddz_display_image' => on,
	                                'ddz_design_layout' => 1,
	                                'ddz_layout' => ''
	                              );
	        break;

	  }
	    return $variables;
	}

	private function ddz_argument_val( $field ){
	    $variables = $this->ddz_return_arr( $field );
	    foreach($variables as $key => $value){
	        if( get_option( $key )===FALSE ) add_option($key, $value);
	        else $variables[$key] = get_option($key);
	    }
	    return $variables;
	}

	/*
	// function for saving values in optios table
	*/
	private function ddz_arugment_update( $field ){
	    $variables = $this->ddz_return_arr( $field );
	    foreach($variables as $key => $value){
	        if(get_option($key)===FALSE){
	            if(!isset($_REQUEST[$key])){
	                add_option($key, '');
	                //return;
	            }elseif(is_array($_REQUEST[$key])){
	                add_option($key, serialize($_REQUEST[$key]));
	            }else { add_option($key, $_REQUEST[$key]);}
	        }else{
	            if(!isset($_REQUEST[$key])){
	                update_option($key, '');
	                //return;
	            }elseif(is_array($_REQUEST[$key])){
	                update_option($key, serialize($_REQUEST[$key]));
	            }else{
	                update_option($key, $_REQUEST[$key]);
	            }
	        }
	    }

	}


}

new DDZ_testimonial_settings;
