<?php
/**
 * The main archive template file for inner content.
 *
 * @package kadence
 */

namespace Kadence;

get_header();

kadence()->print_styles( 'kadence-content' );

/**
 * Hook for Hero Section
 */
do_action( 'kadence_hero_header' );
?>
<div id="primary" class="content-area category">
	<div class="content-container site-container">
		<main id="main" class="site-main" role="main">
			<?php
			/**
			 * Hook for anything before main content
			 */
			do_action( 'kadence_before_archive_content' );
			if ( kadence()->show_in_content_title() ) {
				get_template_part( 'template-parts/content/archive_header' );
			}



			if ( have_posts() ) {
				?>
				<div id="archive-container" class="proto-polsector-archive-container">
					<?php
					while ( have_posts() ) {
						the_post();

						the_policy_proposal_card(get_the_ID(), false);
					}
					?>
				</div>
				<?php
				get_template_part( 'template-parts/content/pagination' );
			} else {
				get_template_part( 'template-parts/content/error' );
			}
			
			?>

			<div class="contrib-header">
				<hr class="header">
				<span> Coordinators </span>
				<hr class="header">
			</div>

			<?php

			

			$mypods = pods();

			$coordinators = $mypods->field('coordinators');
			$accent_color = $mypods->field('accent_color');

			if (!empty($coordinators))
			{
				?>
				<div class="proto-content-wrap-horizontal">

				<?php
				foreach ($coordinators as $coordinator)
				{
					the_team_member_card($coordinator['ID']);
				}
				?>
				</div>
				<?php

			}

			/**
			 * Hook for anything after main content
			 */
			do_action( 'kadence_after_archive_content' );
			?>
		</main><!-- #main -->
		<?php
		get_sidebar();
		?>
	</div>
</div><!-- #primary -->

<?php get_footer(); ?>