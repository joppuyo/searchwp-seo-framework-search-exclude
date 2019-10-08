<?php
/*
 * Plugin name: SearchWP SEO Framework Exclude from Local Search
 * Description: Integrates SearchWP with SEO Framework "Exclude this post from local search" feature
 * Author: Johannes Siipola, Jon Christopher
 * Version: 1.0.0
 */

function searchwp_seo_framework_integration($ids)
{
    $post_ids = get_posts([
        'post_type' => 'any',
        'fields' => 'ids',
        'nopaging' => true,
        'meta_query' => [
            [
                'key' => 'exclude_local_search',
                'type' => 'BINARY',
                'value' => true,
            ],
        ],
    ]);
    if (!empty($post_ids)) {
        $ids = array_values(
            array_unique(
                array_merge((array)$ids, $post_ids)
            )
        );
    }
    return $ids;
}

add_filter('searchwp_prevent_indexing', 'searchwp_seo_framework_integration');
add_filter('searchwp_exclude', 'searchwp_seo_framework_integration');
