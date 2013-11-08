<?php 

/**************************************************************************
 * Block to display the products
 **************************************************************************/

/**
 * Implements hook_block_info().
 */
function enquire_products_block_info() {
  $blocks['enquire_products'] = array(
    // The name that will appear in the block list.
    'info' => t('Enquire products - Alberto'),
    // Default setting.
    'cache' => DRUPAL_CACHE_PER_ROLE,
  );
  return $blocks;
}

/**
 * Custom content function. 
 * 
 * Set beginning and end dates, retrieve posts from database
 * saved in that time period.
 * 
 * @return 
 *   A result set of the targeted posts.
 */
// function enquire_products_contents(){
// }

/**
 * Implements hook_block_view().
 * 
 * Prepares the contents of the block.
 */
function enquire_products_block_view($delta = '') {

switch ($delta) {
    case 'enquire_products':
    $block['subject'] = t('List of the enquire products.');
    $block['content'] = '';

/**
 * Get data from the session
 */

    if (!isset($_SESSION['custom_enquire'])) {
      // init the session variable
        $_SESSION['custom_enquire'] = array();
    }

    if (isset($_POST['add_to_enquire'])) {
       $node = $_POST['add_to_enquire'];
         $_SESSION['custom_enquire'][$node] = $node;
    } 
    elseif (isset($_POST['del_to_enquire'])) {
      $node = $_POST['del_to_enquire']; 
      unset($_SESSION['custom_enquire'][$node]); 
    }


/**
 * Add view to the block
 */

    global $base_url;


    foreach ($_SESSION['custom_enquire'] as $node) {
    $nid = $node;
    //$style_name = 'thumbnail';
    $node = node_load($nid); 
    //$path = $node->field_product_picture['und'][0]['uri'];
      $block['content'] .= '<div class="enquireproduct">';
      //$block['content'] .= '<div class="enquirepicture">';
      //$block['content'] .= '<img  src="' . image_style_url($style_name, $path) '">';
      //$block['content'] .= '</div>';
      $block['content'] .= '<div class="textenquire">';
      $block['content'] .= '<a href="'.$base_url.'/node/'. $node->nid .'">';
      //$block['content'] .= $node->field_model['und'][0]['value'];
      //$block['content'] .= ' - ';
      $block['content'] .= $node->title;
      $block['content'] .= '</div>';
      $block['content'] .= '</a>';
      $block['content'] .= '<form action="" method="post">';
      $block['content'] .= '  <input type="hidden" name="del_to_enquire" value="'.$node->nid.'"/>';
      $block['content'] .= '  <input class="delenquirebuttom" type="submit" value="X">';
      $block['content'] .= '</form>';
      $block['content'] .= '</div>';
    }

    if (!isset($_SESSION['custom_enquire']) || empty($_SESSION['custom_enquire'])) {
      // print message if list is empty
        $block['content'] = '<p class="emptyquery">Your request list is empty.</p>';
     }
  
  return $block;
  }

}