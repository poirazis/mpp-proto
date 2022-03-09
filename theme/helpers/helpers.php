<?php 

/**
 * Count number of any given post type in the term
 *
 * @param string $taxonomy
 * @param string $term
 * @param string $postType
 * @return int
 */

function count_posts_in_term($taxonomy, $term, $postType = 'post') {
    $query = new WP_Query([
        'posts_per_page' => 1,
        'post_type' => $postType,
        'tax_query' => [
            [
                'taxonomy' => $taxonomy,
                'terms' => $term,
                'field' => 'slug'
            ]
        ]
    ]);

    return $query->found_posts;
}