(function( $ ) {
	'use strict';
 
    
    var page = 2;
          
	$('body').on('click', '.loadmore', function() {
        
        var collection_color = $("#color-filter option:selected").val();
        var collection_size = $("#filter-size option:selected").val();
        var data = {
            'action': 'load_posts_by_ajax',
            'page': page,
            'collection_color': collection_color,
            'collection_size': collection_size,
            'security': blog.security
        };
 
        $.post(blog.ajaxurl, data, function(response) {
            if($.trim(response) != '') {
                $('.collection-product').append(response);
                page++;
            } else {
                $('.loadmore').hide();
            }
        });
        
    });
    
    $(".custom-filter").on('submit', function (e){
       
         /* stop form from submitting normally */
          e.preventDefault();
          var page = 0;
        
          var collection_color = $("#color-filter option:selected").val();
        var collection_size = $("#filter-size option:selected").val();
        $('.custom-loader img').show();
        var data = {
            'action': 'load_posts_by_ajax',
            'page': page,
            'collection_color': collection_color,
            'collection_size': collection_size,
            'security': blog.security
        };
 
        $.post(blog.ajaxurl, data, function(response) {
            if($.trim(response) != '') {
                $('.loadmore').hide();
                $('.collection-product').html(response);
                $('.custom-loader img').hide();  
              
            } 
        });
    });

    $('.create-collection').on('submit',function(e){
        e.preventDefault();
        var collectionData = $("form.create-collection").serializeArray();
        $('.custom-loader img').show();
        // submitted normally 
        var data = {
            'action': 'create_collection',
            'security': blog.security,
            'collection_data' : collectionData
        }
        $.post(blog.ajaxurl,data, function(response){
            if($.trim(response) != ''){
                $('.create-collection').trigger('reset');
                $('.create-collection').append("<p class='success'>Your Data successfully recorded!!</p>");
                $('.custom-loader img').hide();
            }
        });


    });

})( jQuery );
