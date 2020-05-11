<?php 
   /**
    * This is taxonomy collection page
    */
    get_header();
   
   ?>
<div class="container">
   <div class="row">
      <div class="mt-5">
          <?php 
          $color_lists = array(
             'red'=> 'Red',
             'green' => 'Green',
             'blue' => 'Blue',
             'white' => 'White',
             'black' => 'Black' );

          $sizes = array(20,22,25,30,32);
          ?>
          <form action="#" method="POST" name="custom-filter" class="custom-filter"  >
               <select name="select_color" id="color-filter" class="mr-5">
                   <option value="">Select Color</option>
                   <?php foreach($color_lists AS $key => $value){ ?>
                           <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                   <?php } ?>
               </select> 
               <select name="select-size" id="filter-size">
                 <option value="">Select Size</option>
                  <?php foreach( $sizes AS $size ){ ?>
                   <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                  <?php } ?>
               </select> 
               <input type="submit" value="Find Collection" class="find-collection"/>
          </form>
      </div>
      <div class="">
         <div class="main bg-white box-shadow">
            <h5 class="p-4 border-bottom">MT Collection</h5>
            <?php 
               if (have_posts() ) :                         
               ?>
            <div class="collection-product row">
            <?php 
                $demo_image = site_url() .'/wp-content/plugins/mt-collection/public/images/social.jpeg';
                
                while($collection_post->have_posts()):$collection_post->the_post();
                $featured_image_url = get_the_post_thumbnail_url() ?: $demo_image;
                ?>
               <div class="col-md-4 collection-post">
                  <div class="product-item">
                     <figure>
                        <img src="<?php echo $featured_image_url; ?>" alt="" />
                     </figure>
                     <div class="p-3">
                        <h6 class="product-title"><?php echo ucfirst(get_the_title()); ?></h6>
                        <p><?php the_excerpt();?></p>
                        <button class="btn-collection text-center">Add Collection</button>
                     </div>
                  </div>
               </div>
               <?php endwhile;?>
            </div>
            <div class="loadmore btn-collection">Load More...</div>
            <?php  endif;  ?>
         </div>
      </div>
   </div>
</div>
<?php 
get_footer();