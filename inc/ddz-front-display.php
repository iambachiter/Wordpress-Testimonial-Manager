<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
* 
*/
class DDZ_testimonial_front
{
	
	public function __construct()
	{
		add_shortcode( 'ddz_testimonial_display', array($this,'ddz_testimonial_front_display') );
        
	}

	public function ddz_testimonial_front_display()
	{
       
		?>
		<div class="container text-center">
			<h1 class="font-bold h1 py-5"><?php echo get_option( 'ddz_testimonial_heading'); ?></h1>
            <!--Section description-->
            <p class="section-description"><?php echo get_option( 'ddz_testimonial_desc'); ?></p>
			<div class="row">

             <?php
             $layout = get_option( 'ddz_design_layout');
             if ($layout == 1) {
                  $this->ddz_testimonial_layout_1();
             } elseif ($layout == 2) {
                $this->ddz_testimonial_layout_2();
             }
              ?>
				
			</div>
		</div>
		<?php
	}

    public function ddz_testimonial_list()
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

    public function ddz_testimonial_layout_1()
    {
           
        $i = 1;
        $testimonials = $this->ddz_testimonial_list();
        foreach ($testimonials as $testimonial) {
            

        ?>
        <div class="col-lg-4 col-md-4 mb-r">
            <div class="card testimonial-card">
                <div class="card-up info-color">
                </div>
                <div class="avatar">
                    <?php 
                        $im_id = get_post_meta( $testimonial->ID, 'ddz_testimonial_logo', true );
                        $image = wp_get_attachment_url( $im_id );

                    ?>
                    <img src="<?php echo $image; ?>" class="rounded-circle img-responsive">
                </div>
                <div class="card-body">
                    <!--Name-->
                    <h4 class="mt-1">
                        <strong><?php echo get_post_meta( $testimonial->ID, 'ddz_t_author', true ); ?></strong>
                    </h4>
                    <hr>
                    <!--Quotation-->
                    <p class="dark-grey-text"><?php echo $testimonial->post_content; ?></p>
                </div>
            </div>
            
        </div>
        <?php 
        if ($i == 3) {
           break;
        }

         $i++;  } 
            
    }
    public function ddz_testimonial_layout_2()
    {
        ?>
      <!--Section: Testimonials v.2-->
<section class="text-center pb-5">
        
    <!--Section heading-->
    <h1 class="font-bold h1 py-5">Testimonials</h1>
    <!--Section description-->
    
    <!--Carousel Wrapper-->
    <div id="carousel-example-1" class="carousel no-flex testimonial-carousel slide carousel-fade" data-ride="carousel" data-interval="false">
    
        <!--Slides-->
        <div class="carousel-inner" role="listbox">
            <!--First slide-->
            <div class="carousel-item active">
    
                <div class="testimonial">
                    <!--Avatar-->
                    <div class="avatar">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(30).jpg" class="rounded-circle img-fluid" alt="First sample avatar image">
                    </div>
                    <!--Content-->
                    <p>
                        <i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod eos id officiis hic tenetur quae
                        quaerat ad velit ab. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore cum accusamus eveniet
                        molestias voluptatum inventore laboriosam labore sit, aspernatur praesentium iste impedit quidem dolor
                        veniam.</p>
    
                    <h4>Anna Deynah</h4>
                    <h6>Founder at ET Company</h6>
    
                    <!--Review-->
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star-half-full blue-text"> </i>
                </div>
    
            </div>
            <!--First slide-->
    
            <!--Second slide-->
            <div class="carousel-item">
    
                <div class="testimonial">
                    <!--Avatar-->
                    <div class="avatar">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(31).jpg" class="rounded-circle img-fluid" alt="Second sample avatar image">
                    </div>
                    <!--Content-->
                    <p>
                        <i class="fa fa-quote-left"></i> Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur
                        magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum
                        quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut
                        labore. </p>
    
                    <h4>Maria Kate</h4>
                    <h6>Photographer at Studio LA</h6>
    
                    <!--Review-->
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star blue-text"> </i>
                </div>
    
            </div>
            <!--Second slide-->
    
            <!--Third slide-->
            <div class="carousel-item">
    
                <div class="testimonial">
                    <!--Avatar-->
                    <div class="avatar">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(3).jpg" class="rounded-circle img-fluid" alt="Third sample avatar image">
                    </div>
                    <!--Content-->
                    <p>
                        <i class="fa fa-quote-left"></i> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                        laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
    
                    <h4>John Doe</h4>
                    <h6>Front-end Developer in NY</h6>
    
                    <!--Review-->
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star blue-text"> </i>
                    <i class="fa fa-star-o blue-text"> </i>
                </div>
    
            </div>
            <!--Third slide-->
    
        </div>
        <!--Slides-->
    
        <!--Controls-->
        <a class="carousel-item-prev left carousel-control" href="#carousel-example-1" role="button" data-slide="prev">
            <span class="icon-prev" aria-hidden="true"></span>
            
        </a>
        <a class="carousel-item-next right carousel-control" href="#carousel-example-1" role="button" data-slide="next">
            <span class="icon-next" aria-hidden="true"></span>
            
        </a>
        <!--Controls-->
    
    </div>
    <!--Carousel Wrapper-->
    
</section>
<!--Section: Testimonials v.2-->
        <?php
    }


}

new DDZ_testimonial_front;