	<div class="clear"></div>
	<div class="workBlock" id="work<?php the_ID(); ?>">
	    <div class="clearfix">
	        <div class="col-12">
	            <?php the_title('<span class="title">', '</span><br>'); ?>
	            <span class="shortDesc"><?php the_field('works_short_desc'); ?></span>
	        </div>
	        <div class="col-12 shortDesc2"><?php 
	            $type_of_work = get_field_object('works_types'); 
	            echo $type_of_work['choices'][$type_of_work['value'][0]];
	        ?></div>
	    </div>
	    <div class="description"><?php 
		    if (get_field('works_web_link')) {
		    	echo '<strong>Ссылка:</strong> <a href="'.get_field('works_web_link').'" target="_blank">'.get_field('works_web_link').'</a><br>';
		    }
		    if (get_field('works_designer')) {
		    	echo '<strong>Дизайнер:</strong> '.get_field('works_designer').'<br>';
		    }
		    the_content(); 
		?></div>
	    <?php if (get_field('works_screenshots')) {
	    	the_field('works_screenshots');
	    }
	    	
        $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        preg_match('/<a.+href=[\'"](?P<src>.+?)[\'"].*>/i', get_field('works_screenshots'), $first_image);
        if (!$url) {
            $url = $first_image['src'];
        }
    	echo '<div class="preview" style="background-image:url('.$url.');"><span></span></div>';
    ?>
	</div>