<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


/**
*
*/
class DDZ_testimonial_admin
{

	public function __construct()
	{
		$this->ddz_admin_main_testimonial_page();
		

	}

	public function ddz_admin_main_testimonial_page()
	{
		if ($_GET['ddz_id'] && $_GET['action'] == 'delete') {

				$this->ddz_delete_testimonial($_GET['ddz_id']);


		}
		if ($_POST) {
			$this->ddz_save_testimonial($_POST,$_GET['ddz_id']);
		}
		if ($_GET['page'] == 'add_testimonial') {
			$this->ddz_add_testimonial();
		} elseif($_GET['page'] == 'ddz-testimonial') {
			$this->ddz_testimonial_list();
		}
		?>
		<?php
	}

	public function ddz_add_testimonial()
	{

		$fields = $this->ddz_fields_array();

		if (!isset($_GET['ddz_id'] ) || $_GET['ddz_id'] == null) {
			?>
				<div class="container">
			<div class="row ddz_testiminial_container">

					<h1>Enter testimonial Details</h1><label>Testimonial</label><div></div>
					<form action="#" method="POST">

						<textarea name="ddz_t_main"></textarea>
						<?php $this->ddz_testimonial_input_fields($fields); ?>
						<input type="submit"  name="button" id="upload_image_button" class="button" value="Add Logo"/>
						<input type="hidden" name="ddz_testimonial_logo" id="ddz_logo" value="">
						<input type="submit" name="save_testimonial" class="ddz_test_button_lg" value="Save Testimonial">
					</form>
				</div>
			</div>
			<?php
		} elseif (isset($_GET['ddz_id'] )|| $_GET['ddz_id'] != null ) {
			$post_id = $_GET['ddz_id'];
			$post = get_post($post_id);
			$post_meta = $this->ddz_testimonial_meta($post_id,$fields);
			
			?>
				<div class="container">
			<div class="row ddz_testiminial_container">

					<h1>Edit testimonial Details</h1><div></div>
					<label>Testimonial</label>
					<form action="#" method="POST">

					<textarea name="ddz_t_main"><?php echo $post->post_content; ?></textarea>
					<?php $this->ddz_testimonial_input_fields($fields,$post_meta); ?>

					<?php $im_id = get_post_meta( $post_id, 'ddz_testimonial_logo', true );
					if ($im_id) {
					 	$image = wp_get_attachment_url( $im_id );
					 	echo '<img id="ddz_img_url" src="'.$image.'" width="200px" height="auto" >';
					 	echo '<input type="hidden" name="ddz_testimonial_logo" id="ddz_logo" value="'.$im_id.'">';
					 }  else {
					 	echo '<img id="ddz_img_url" src="" width="200px" height="auto" >';
					 	echo '<input type="hidden" name="ddz_testimonial_logo" id="ddz_logo" value="">';
					 }

					?>
					
					<input type="submit"  name="button" id="upload_image_button" class="button" value="Add Logo"/><p>Try to use square image</p>
					<br>
					<br>
					<p><input type="submit" name="save_testimonial" class="ddz_test_button_lg" value="Save Testimonial"> </p>
						
					</form>
				</div>
			</div>


		<?php

		}

	}

	public function ddz_fields_array()
	{
		$fields = array(array('Author','ddz_t_author','text') ,
						array('Company','ddz_t_company','text'),

		 );

		return $fields ;
	}

	private function ddz_testimonial_meta($post_id,$feilds)
	{

		if ($post_id) {
			foreach ($feilds as $key) {

				$post_meta [$key[1]] = get_post_meta( $post_id, $key[1]);
			}

			return $post_meta;
		}

	}

	private function ddz_save_testimonial($data,$id=null)
	{
		$fields = $this->ddz_fields_array();
		if ($id != null) {
			//print_r($data); die();
			$post_update = array(
			      'ID'           => $id,
			      'post_content' =>  $data['ddz_t_main'],
			  );
			$post_id = $id;
			// Update the post into the database
			wp_update_post( $post_update );
			update_post_meta( $post_id,'testimonial_editor', get_current_user_id());
			update_post_meta( $post_id,'ddz_testimonial_logo', $data['ddz_testimonial_logo'] );
			foreach ($fields as $key) {
				
				update_post_meta(  $post_id, $key[1], $data[$key[1]] );
			}

			
			wp_safe_redirect( admin_url( 'admin.php?page=add_testimonial&ddz_id='.$id ) ); exit;
		} else {
			if (is_array($data)) {
				$pieces = explode(" ", $data['ddz_t_main']);
				$string = implode(" ", array_splice($pieces, 0, 5));
				$insert_array = array(	'post_title' => $string,
										'post_type' => 'testimonial',
										'post_content' => $data['ddz_t_main'],
										'post_status' => 'publish');
				$post_id = wp_insert_post($insert_array);
				
				add_post_meta( $post_id,'testimonial_editor', get_current_user_id(), true );
				add_post_meta( $post_id,'ddz_testimonial_logo', $data['ddz_testimonial_logo'], true );

				foreach ($fields as $key) {
					add_post_meta( $post_id, $key[1], $data[$key[1]], true );
					}

				wp_safe_redirect( admin_url( 'admin.php?page=add_testimonial&ddz_id='.$post_id ) ); exit;
			}
		}

	}

	private function ddz_edit_testimonial_url($post_id=null,$delete=false)
	{
		if ($post_id==null) {
			return admin_url( 'admin.php?page=add_testimonial' );
		} elseif ($post_id != null  && $delete ==true) {
			return admin_url( 'admin.php?page=ddz-testimonial&ddz_id='.$post_id .'&action=delete' );
		}

		else {
			return admin_url( 'admin.php?page=add_testimonial&ddz_id='.$post_id  );
		}

	}

	private function ddz_testimonial_input_fields($fields,$fields_value=null) {

		if (is_array($fields)) {
			foreach ($fields as $key) {
				?>
				<div class="form-group">
				    <label for="<?php echo $key[2] ?>"><?php echo $key[0] ?></label>
				    <input type="<?php echo $key[2] ?>" class="form-control"  name="<?php echo $key[1] ?>" value="<?php echo $this->ddz_testimonial_input_fields_value( $key[1],$fields_value); ?>" >

				 </div>
				<?php
			}
		} else {
			return;
		}

	}

	private function ddz_testimonial_input_fields_value($field_name,$fields_value)
	{

		if (is_array($fields_value)) {


			return $fields_value[$field_name][0];
		} else {
			return;
		}


	}

	private function ddz_testimonial_list()
	{
		$testimonials = $this->ddz_testimonial_list_data();
		?>
		<div class="container">
			<div class="row ddz_testiminial_container">
				<a href="<?php echo $this->ddz_edit_testimonial_url(); ?>" class="ddz_test_button_lg">Add Testimonial</a>

				<div class="ddz_tm_table">
         <div class="ddz_tm_table-row ddz_tm_table_head_row">
          <div class="ddz_tm_table-cell">#</div>
          <div class="ddz_tm_table-cell">Testimonial</div>
          <div class="ddz_tm_table-cell">Added by</div>
          <div class="ddz_tm_table-cell">Date</div>
        </div>
        	<?php
				  	$i = 1;
				  	foreach ($testimonials as $testimonial) {
				  		?>
         <div class="ddz_tm_table-row">
          <div class="ddz_tm_table-cell"><?php echo $i; ?></div>
          <div class="ddz_tm_table-cell"><?php echo $testimonial->post_title; ?><div><a class="ddz_test_button_sm" href="<?php echo $this->ddz_edit_testimonial_url($testimonial->ID); ?>">edit</a><a class="ddz_test_button_sm" href="<?php echo $this->ddz_edit_testimonial_url($testimonial->ID,true); ?>">delete</a></div></div>
          <div class="ddz_tm_table-cell"><?php $user_id= get_post_meta( $testimonial->ID, $key = 'testimonial_editor', true );
					      	$data = $this->ddz_user_data($user_id);
					      	echo $data->display_name;
					      ?></div>
          <div class="ddz_tm_table-cell"><?php echo date('F j, Y', strtotime($testimonial->post_date)); ?></div>
        </div>

				  		<?php
				  		 $i++;
				  	}

				  	?>

       </div>



			</div>
		</div>

		<?php
	}

	public function ddz_testimonial_list_data()
	{
		$args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'testimonial',
			'post_status'      => 'publish',
			'suppress_filters' => true
		);
		$testimonials = get_posts( $args );
		return $testimonials;
	}

	private function ddz_user_data($user_id)
	{
	 	if (isset($user_id)) {
	      	$user_data = get_userdata($user_id);
	      	return $user_data;
      	}
	}

	private function ddz_delete_testimonial($post_id)
	{
		if (intval($post_id)) {
			wp_delete_post($post_id,true);

			$post_meta = $this->ddz_fields_array();
			delete_post_meta( $post_id,'testimonial_editor' );
			foreach ($post_meta as $key) {
				delete_post_meta( $post_id, $key[1] );
				}
			wp_reset_postdata ();

			wp_safe_redirect( admin_url( 'admin.php?page=ddz-testimonial' ) ); exit;
		} else {
			return false;
		}


	}
}
new DDZ_testimonial_admin;
