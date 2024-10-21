<?php
/**
 * Register Bricks Element
 */
add_action('init', function () {
    $element_files = [
        __DIR__ . '/bricks-widget.php',
    ];

    foreach ($element_files as $file) {
        if (class_exists('Bricks\Elements')) {
            \Bricks\Elements::register_element($file);
        }
    }
}, 11);
// Register Elementor Widget
function register_custom_widget($widgets_manager)
{

    require_once(__DIR__ . '/elementor-widget.php');

    $widgets_manager->register(new \Elementor_Hello_World_Widget_1());

}
add_action('elementor/widgets/register', 'register_custom_widget');

// Add action to modify the query
add_action('jet-engine/query-builder/query/after-query-setup', function ($query) {
    if (isset($_POST['singleID'])) {
        // echo "<script>console.log('" . json_encode($query) . "');</script>"; // For Debugging
        $singleID = intval($_POST['singleID']);
        switch ($query->query_type) {
            case 'posts':
                $query->final_query['p'] = $singleID;
                break;
            case 'custom-content-type':
                if(isset($query->final_query['args'][0]['field'])){
                    $query->final_query['args'][0]['value'] = $singleID;
                }
                break;
            case 'users':
                $query->final_query['include'] = $singleID;
                break;
            case 'terms':
                $query->final_query['include'] = $singleID;
                break;
            case 'sql':
                if(isset($query->query['advanced_mode']) && $query->query['advanced_mode'] == 'true'){
                    $manual_query = $query->final_query['manual_query'];
                    if(str_contains($manual_query, '{singleID}')){
                        $query->final_query['manual_query'] = str_replace('{singleID}', $singleID, $query->final_query['manual_query']);
                    }
                } else {
                    if(isset($query->final_query['where'][0]['column'])){
                        $query->final_query['where'][0]['value'] = $singleID;
                    }
                }
                break;
            case 'comments':
                $query->final_query['comment__in'] = $singleID;
                break;
            case 'wc-product-query':
                $query->final_query['include'] = [$singleID];
                break;
            default:
                break;
        }
        return $query;
    }
});