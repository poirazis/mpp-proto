<?php

/** 
* Function to Render a Single Team Member Card
*/

function the_team_member_card (int $member_id) {

    $mypods = pods('team_member' , $member_id);

    if ($mypods)
    {
        $thumb = wp_get_attachment_image_src ( get_post_thumbnail_id( $member_id , 'large' ));

        if ( empty($thumb) ) { 
            $thumb_url = get_stylesheet_directory_uri() . '/assets/no_profile_pic.png';
        }
        else {
            $thumb_url = $thumb[0];
        }
        
        ?>

            <div class="proto-team-member-card">
                <a href="<?php echo get_permalink($member_id); ?> ">
                    <div class = "proto-thumb-container">
                        <div class = "proto-thumb" style="background-image: url( <?php echo $thumb_url; ?> )"></div> 
                    </div>
          
                    <h5> <?php echo get_the_title($member_id); ?> </h5>
                    <p>  <?php echo $mypods->display('professional_title'); ?>  </p>
                </a>
            </div>

        <?php          
    }
}


/**
 * Generate the team member vertical activity timeline
 * 
 * 
 */

function the_team_member_activity (int $member_id) {

    $query_args = array(
        'post_type' => array('post', 'policy_proposal'),
        'post_status' => 'publish',
        'order' => 'DESC',
        'orderby' => 'date',
        'posts_per_page' => '5',
        'meta_query' => array(
            '0' => array(
                'key' => 'contributors',
                'value' => $member_id,
                'compare' => 'IN',
            ),
            'relation' => 'AND',
        ),
    );


    // The Query
    $the_query = new WP_Query( $query_args );

    // The Loop
    if ( $the_query->have_posts() ) {
        echo '<section id="cd-timeline" class="cd-container">';

        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $the_terms = null;
            $the_terms_html = null;

            if (get_post_type() === 'policy_proposal') { 
                $the_terms = get_the_terms( $post->ID, 'polsector', '' , ' | ' );     
            } else {
                $the_terms = get_the_terms ($post->ID, 'category', '', ' ', '');
            }

            if ($the_terms) {

                $the_terms_html = '<div>';
                foreach ($the_terms as $term) {
                    $the_terms_html .= '<spanl class="pc-tax-pill">' . $term->name . '</span>';
                }
                $the_terms_html .= '</div>';
            }

            ?>

            <div class="cd-timeline-block">
                <div class="cd-timeline-img cd-picture">
                </div>

                <div class="cd-timeline-content">
                    <h5 class="posted_on"> <?php echo get_the_date('F j, Y'); ?> </h5>
                    <?php echo $the_terms_html; ?> 
                    <a href="<?php the_permalink(); ?>"><h2> <?php the_title(); ?> </h2> </a>
                    <p> <?php the_excerpt(); ?></p>
                </div> <!-- cd-timeline-content -->
            </div> <!-- cd-timeline-block -->
            

        <?php
        }

        echo '</section>';
        /* Restore original Post Data */
        wp_reset_postdata();
    } else {
        // no posts found
    }
}

function the_policy_proposal_card (int $pp_id, bool $show_tags = true) 
{
    $mypods = pods('policy_proposal', $pp_id);
    if ($mypods)
    {
        $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $pp_id , 'large' ));
        $dat = date_create_from_format('Y-m-d H:s', $mypods->display('post_date') );
        $pol_sector = $mypods->display('polsector');

        echo '<a class="no-underline" href="' . $mypods->display('permalink') .'" >';
        echo '<div class="proto-ppcard">';
            if ($show_tags) {
                echo '<div class="pp-tax">' . $pol_sector . '</div>';
            }
            echo '<div class="pp-title">' . $mypods->display('title') .'</div>';
/*             echo '<HR class="proto-hr"></HR>';
 */            echo '<div class="pp-excerpt">' . $mypods->display('excerpt') . '</div>';
            echo '<HR class="proto-hr"></HR>';
            echo '<div class="pp-footer">' . date_format($dat, 'F, j, Y') . '</div>';
        echo '</div>';
        echo '</a>';

    }
}


function pc_show_taxonomy ( string $taxname )
{
    $terms = get_terms( array (
        'taxonomy' => $taxname,
        'hide_empty' => false,
        'parent' => 0,
        'orderby' => 'name',
        'order' => 'ASC',
    ) ); 

    echo '<div class="polsector-wrapper">';
    foreach ($terms as $term )
    {
        the_policy_sector_card ($term);
    }
    echo '</div>';

}

function the_policy_sector_card (Object $term) {
    ?>

        <a class="no-underline" href=" <?php echo get_term_link($term); ?> ">
        <div class="polsector-card"> 
            <div class="title"> <?php echo $term->name; ?> </div>
            <div class="count"> <?php echo count_posts_in_term($term->taxonomy, $term->slug, 'policy_proposal'); ?> 
                <div class="small-caps"> ΠΡΟΤΑΣΕΙΣ</div>
            </div>
        </div>
        </a>

    <?php
}

