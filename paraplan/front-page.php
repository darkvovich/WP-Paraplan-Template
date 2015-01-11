<?php get_header(); ?>

	<section class="bkgColor3 current">
        <div id="header" class="t">
            <nav>
                <li><a href="#works" class="smoothScroll">Работы</a></li>
                <li><a href="#other" class="smoothScroll">Услуги</a></li>
                <li><a href="#other" class="smoothScroll">Люди</a></li>
                <li><a href="#contacts" class="smoothScroll">Контакты</a></li>
            </nav>
            <div id="logo">
                <span><?php echo get_bloginfo('name', 'display'); ?></span>
                <div class="slogan" data-words="<?php echo get_bloginfo('description'); ?>, Твоя лучшая студия, Мы работаем для тебя">
                    <i><?php echo get_bloginfo('description'); ?></i>
                </div>
            </div>
            <div class="arrowDown moving"></div>
            <div class="arrowDown stable" id="arrowDown"></div>
        </div>
        <div class="bkgParallaxImage" id="bkgParallaxImage1"></div>
    </section>

    <?php // WORKS
    remove_all_filters('posts_orderby');
    $args_works = array(
        'orderby'        => 'rand',
        'cat'            => 5,
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'     => 'works_show_announce',
                'value'   => 'yes',
                'compare' => '='
            )
        )
    );
    $query_works = new WP_Query($args_works); ?>
    <?php if ($query_works->have_posts()) : ?>
        <?php while ($query_works->have_posts()) : $query_works->the_post(); ?>
        <section id="works" class="bkgColor1">
            <a href="/works" class="nostyle">
                <div class="t row">
                    <div id="workDescription">
                        <div class="title" style="background-color: <?php the_field('works_announce_color'); ?>;"><?php the_title(); ?></div><br><br>
                        <div class="description" style="background-color: <?php the_field('works_announce_color'); ?>;"><?php the_field('works_short_desc'); ?></div><br>
                        <button style="background-color: <?php the_field('works_announce_color'); ?>;">Посмотреть все работы</button>
                    </div>
                </div>
            </a>
            <div class="bkgParallaxImage" style="background-image: url(<?php the_field('works_picture_for_frontpage'); ?>);"></div>
        </section>
        <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

    <section id="other">
    <?php // SERVICES
    $args_services = array(
        'cat'            => 3,
        'posts_per_page' => -1,
        'meta_key'       => 'services_sort',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
    );
    $query_services = new WP_Query($args_services); ?>
    <?php if ($query_services->have_posts()) : $z = 0; ?>
        <div class="otherHolder" id="services">
            <div class="verticalAligner">
                <div class="row">
                    <div class="p50" id="servicesAll">
                        <div class="clearfix">
                            <?php while ($query_services->have_posts()) : $query_services->the_post(); $z++; ?>
                            <?php if($z>1) { echo '<div class="col-1"></div>'; } ?>
                            <div class="col-4">
                                <div>
                                    <?php if (has_post_thumbnail()) { 
                                        $service_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                    ?>
                                        <img src="<?php echo $service_img[0]; ?>" alt="">
                                    <?php } ?>
                                    <div class="hidden text"><?php the_content(); ?></div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div id="serviceClicked" class="hidden">
                        <div class="p50">
                            <div class="col-4"><img src="<?php echo get_template_directory_uri(); ?>/img/s1.svg" alt=""></div>
                            <div class="col-1"></div>
                            <div class="col-19">
                                <div class="textHolder">
                                    <div class="text">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bkgParallaxImage" id="bkgParallaxImage3"></div>
        </div>
    <?php endif; ?>
	<?php // TEAM
	$args_team = array(
		'cat'            => 2,
		'posts_per_page' => -1,
        'meta_key'       => 'team_sort',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
	);
	$query_team = new WP_Query($args_team); ?>
	<?php if ($query_team->have_posts()) : $z = 0; ?>
        <div class="otherHolder" id="people">
            <div class="verticalAligner">
                <div class="row">
                    <div class="p50">
                        <div class="slider single-item">
                        <?php while ($query_team->have_posts()) : $query_team->the_post(); $z++; ?>
                            <?php if ($z == 1) { echo '<div class="clearfix"><div class="col-1"></div>'; } ?>
                                <div class="col-10">
                                    <div class="clearfix">
                                        <div class="col-8">
                                        <?php if (has_post_thumbnail()) { 
                                        	$team_photo = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                        ?>
                                            <img src="<?php echo $team_photo[0]; ?>" alt="" class="avatar">
                                       	<?php } ?>
                                        </div>
                                        <div class="col-1"></div>
                                        <div class="col-15">
                                            <div class="text">
                                                <h3><?php the_title(); ?></h3>
                                                <span class="title"><?php the_field('team_position', get_the_ID()); ?></span>
                                                <span class="desc"><?php the_field('team_description', get_the_ID()); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php if ($z == 1) { 
                            	echo '<div class="col-2"></div>';
                            } else {
                            	echo '<div class="col-1"></div>
                            	</div>'; 
                            	$z = 0; 
                            } ?>
                        <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
	<?php wp_reset_postdata(); ?>
    </section>

<?php get_footer(); ?>