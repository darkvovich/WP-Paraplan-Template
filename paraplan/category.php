<?php get_header(); ?>

	<div id="slimMenu">
        <div class="width">
            <div class="clearfix">
                <a href="/" class="logo">Paraplan</a>
                <nav class="menu">
                    <li><a href="/#works" class="active changeJS">Работы</a></li>
                    <li><a href="/#other" class="changeJS">Услуги</a></li>
                    <li><a href="/#other" class="changeJS">Люди</a></li>
                    <li><a href="#contacts" class="smoothScroll">Контакты</a></li>
                </nav>
            </div>
        </div>
    </div>

	<div class="width">
        <div class="clearfix" id="content">
        	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/fonts.css">
            <div class="col-5">
                <div class="sideMenu">
                <?php 
                	$categories = get_categories(array('child_of' => 4, 'order' => 'ASC', 'posts_per_page' => '-1'));
                	if ($categories) {
                		foreach ($categories as $cat) {
                			echo '<span>'.$cat->name. '</span>';
                			$query_works = new WP_Query('cat='.$cat->term_id.'&order=DESC');
		                	if ($query_works->have_posts()) {
		                		echo '<ul>';
								while ( $query_works->have_posts() ) {
									$query_works->the_post();
									//print_r($query_works);
									echo '<li data-scrollTo="#work'.get_the_ID().'">'.get_the_title().'</li>';
								}
								echo '</ul>';
							} 
							wp_reset_postdata();
                		}
                	}
				?>
                </div>
            </div>
            <div class="col-1"></div>
            <div class="col-18">
			<?php if (have_posts()) {
				$des_i = 0;
				while (have_posts()) {
					the_post();

					$des_i++;
					$types = wp_get_post_categories(get_the_ID());

				    if (count(get_field('work_block_size')) == 1 && get_field('work_block_size') == 'small') {
				        // design ?>
						<div class="workBlock design<?php if ($des_i % 2 != 1) { echo ' margin'; } ?>" id="work<?php the_ID(); ?>">
						    <div class="clearfix">
						        <div class="col-12">
						            <?php the_title('<span class="title">', '</span><br>'); ?>
						        </div>
						        <div class="col-12 shortDesc2"><?php 
						            $type_of_work = get_field_object('works_types'); 
						            echo $type_of_work['choices'][$type_of_work['value'][0]];
						        ?></div>
						    </div>
						    <div class="description"><?php
							    if (get_field('works_designer')) {
							    	echo '<strong>Дизайнер:</strong> '.get_field('works_designer').'<br>';
							    }
							?></div>
						    <?php if (get_field('works_screenshots')) {
						    	the_field('works_screenshots');
						    }
				            $url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
				            //print_r($url);
				            if ($url) {
				            	if (!get_field('works_screenshots')) {
					                echo '<div class="preview" style="background-image:url('.$url[0].');"></div>';
					            } else {
						            echo '<a href="#" data-slickOn="#work'.$post->ID.' .slide:first"><div class="preview" style="background-image:url('.$url[0].');"><span></span></div></a>';
						        }
					        } ?>
						</div>
				    <?php } else {
				    	$des_i = 0;
						get_template_part('content', get_post_format());
					}
				}
			} else {
				get_template_part('content', 'none');
			} ?>
			</div>
    	</div>
	</div>

<?php get_footer(); ?>