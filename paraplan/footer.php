	<?php if (!is_404() && !is_singular()) : ?>	
        <section id="contacts" class="bkgColor1">
            <div class="width">
                <div>
                    <?php echo do_shortcode('[contact-form-7 id="4"]'); ?>
                    <div class="bkgParallaxImage" id="bkgParallaxImage4"></div>
                </div>
            </div>
        </section>
	<?php endif; ?>
	
<?php if (is_front_page() || is_404()) : ?>	
	</main><!-- #main -->
<?php endif; ?>
	<?php wp_footer(); ?>
</body>
</html>