<?php get_header(); ?>

	<div id="slimMenu">
        <div class="width">
            <div class="clearfix">
                <a href="/" class="logo">Paraplan</a>
            </div>
        </div>
    </div>
    <main class="inner">
	<?php while (have_posts()) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
    </main>

<?php get_footer(); ?>