<?php 
   /**
    * This is archive Custome post type file
    */
   
    get_header();
    $loader_image = site_url() .'/wp-content/plugins/mt-collection/public/images/loader.gif';
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
            <div class="mt-collection">
               <h5 class="p-4 border-bottom">MT Collection</h5>
               
               <h5 class="p-4 border-bottom create-collection" <?php if(is_user_logged_in()) echo 'data-toggle="modal" data-target="#create-collection"'; ?> >Create Collection</h5>
               <!-- <h5 class="p-4 border-bottom">Create Collection</h5> -->
            </div>
            
            <?php 
               $args = array(
                 'post_type' => 'collection',
                 'post_status' => 'publish',
                 'posts_per_page' => 3,
                 'paged' => 1,
               );
               $collection_post = new WP_Query( $args );
               if ( $collection_post->have_posts() ) :                         
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
                     </div>
                  </div>
               </div>
               <?php endwhile;?>
            </div>
            <div class="custom-loader">
            <div class="loadmore btn-collection">Load More...</div>
               <img src="<?php echo $loader_image; ?>" alt="" style="display:none;">
            </div>
           

            <?php wp_reset_query(); endif;  ?>
         </div>
      </div>
   </div>
</div>

<!-- Modal -->
<div id="create-collection" class="modal fade" role="dialog">
   <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Create Collection</h4>
         </div>
         <div class="modal-body">
         <form method="post" name="create-collection" class="create-collection">
            <div class="form-group">
               <label for="collecectionTitle">Collection Title</label>
               <input type="text" name="collection_title" class="form-control" id="collecectionTitle" placeholder="Collection Title" required>
            </div>
            <div class="form-group">
               <label for="collecectionDetails">Collection Details</label>
               <textarea id="collectionDetails" name="collection_details" required></textarea>
            </div>
            <div class="form-group">
               <label for="collectionCategory">Collection Category</label>
               <?php 
                  $args = array(
                     'taxonomy' => 'collection_category',
                     'orderby' => 'name',
                     'order'   => 'ASC'
                 );
      
                 $collection_category = get_categories($args);
                
                 
               ?>
               <select class="form-control" id="collectionCategory" name="collection_category" required>
                  <option>Select Collection Category</option>
                  <?php foreach($collection_category AS $cat) { ?>
                  <option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
                  <?php } ?>
               </select>
            </div>
            <?php 
               $collection_size = array(20,22,25,30,32);
               $collection_color = array(
                  'red' => 'Red',
                  'green' => 'Green',
                  'blue' => 'Blue',
                  'white' => 'White',
                  'black' => 'Black',
               );
            ?>
            <div class="form-group">
               <label for="collectionSize">Collection Size</label>
               <select class="form-control" id="collectionSize" name="collection_size" required>
                  <option>Select Collection Size</option>
                  <?php foreach($collection_size AS $size){ ?>
                        <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                  <?php } ?>
                  
               </select>
            </div>

            <div class="form-group">
               <label for="collectionColor">Collection Color</label>
               <select class="form-control" id="collectionColor" name="collection_color">
                  <option>Select Collection Color</option>
                  <?php foreach($collection_color AS $key => $value){ ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                  <?php } ?>
                  
               </select>
            </div>
           
            <div class="custom-loader">
            <button type="submit" class="btn btn-primary">Submit</button>
               <img src="<?php echo $loader_image; ?>" alt="" style="display:none;">
            </div>
         </form>


                  
         </div>
         <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>

  </div>
</div>
<?php 
if(!is_user_logged_in()){
   ?>
   <script>
      jQuery('.create-collection').on('click',function(){
         Swal.fire("Please Login First enable this feature");
      });
   </script>
   <?php
}
get_footer();