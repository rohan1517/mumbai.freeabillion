<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC coupons class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_feature_coupons extends MEC_base
{
    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // Import MEC Factory
        $this->factory = $this->getFactory();
        
        // Import MEC Book
        $this->book = $this->getBook();
        
        // Import MEC Main
        $this->main = $this->getMain();
        
        // MEC Settings
        $this->settings = $this->main->get_settings();
    }
    
    /**
     * Initialize coupons feature
     * @author Webnus <info@webnus.biz>
     */
    public function init()
    {
        // Show coupons feature only if booking module is enabled
        if(!isset($this->settings['booking_status']) or (isset($this->settings['booking_status']) and !$this->settings['booking_status'])) return false;
        
        // Show coupons feature only if coupons module is enabled
        if(!isset($this->settings['coupons_status']) or (isset($this->settings['coupons_status']) and !$this->settings['coupons_status'])) return false;
        
        $this->factory->action('init', array($this, 'register_taxonomy'), 30);
        $this->factory->action('mec_coupon_edit_form_fields', array($this, 'edit_form'));
        $this->factory->action('mec_coupon_add_form_fields', array($this, 'add_form'));
        $this->factory->action('edited_mec_coupon', array($this, 'save_metadata'));
        $this->factory->action('created_mec_coupon', array($this, 'save_metadata'));
        
        $this->factory->filter('manage_edit-mec_coupon_columns', array($this, 'filter_columns'));
        $this->factory->filter('manage_mec_coupon_custom_column', array($this, 'filter_columns_content'), 10, 3);
        
        // Apply Coupon Form
        $this->factory->action('wp_ajax_mec_apply_coupon', array($this, 'apply_coupon'));
        $this->factory->action('wp_ajax_nopriv_mec_apply_coupon', array($this, 'apply_coupon'));
    }
    
    /**
     * Register label taxonomy
     * @author Webnus <info@webnus.biz>
     */
    public function register_taxonomy()
    {
        register_taxonomy(
            'mec_coupon',
            $this->main->get_book_post_type(),
            array(
                'label'=>__('Coupons', 'mec'),
                'labels'=>array(
                    'name'=>__('Coupons', 'mec'),
                    'singular_name'=>__('Coupon', 'mec'),
                    'all_items'=>__('All Coupons', 'mec'),
                    'edit_item'=>__('Edit Coupon', 'mec'),
                    'view_item'=>__('View Coupon', 'mec'),
                    'update_item'=>__('Update Coupon', 'mec'),
                    'add_new_item'=>__('Add New Coupon', 'mec'),
                    'new_item_name'=>__('New Coupon Name', 'mec'),
                    'popular_items'=>__('Popular Coupons', 'mec'),
                    'search_items'=>__('Search Coupons', 'mec'),
                ),
                'public'=>true,
                'show_ui'=>true,
                'publicly_queryable'=>false,
                'hierarchical'=>false,
            )
        );
        
        register_taxonomy_for_object_type('mec_coupon', $this->main->get_book_post_type());
    }
    
    /**
     * Show edit form of labels
     * @author Webnus <info@webnus.biz>
     * @param object $term
     */
    public function edit_form($term)
    {
        $discount_type = get_metadata('term', $term->term_id, 'discount_type', true);
        $discount = get_metadata('term', $term->term_id, 'discount', true);
        $usage_limit = get_metadata('term', $term->term_id, 'usage_limit', true);
    ?>
        <tr class="form-field">
            <th scope="row">
                <label for="mec_discount_type"><?php _e('Discount Type', 'mec'); ?></label>
            </th>
            <td>
                <select name="discount_type" id="mec_discount_type">
                    <option value="percent" <?php echo ($discount_type == 'percent' ? 'selected="selected"' : ''); ?>><?php _e('Percent', 'mec'); ?></option>
                    <option value="amount" <?php echo ($discount_type == 'amount' ? 'selected="selected"' : ''); ?>><?php _e('Amount', 'mec'); ?></option>
                </select>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="mec_discount"><?php _e('Discount', 'mec'); ?></label>
            </th>
            <td>
                <input type="text" name="discount" id="mec_discount" value="<?php echo $discount; ?>" />
                <p class="description"><?php _e('Discount percent, considered as amount if you set the discount type to amount', 'mec'); ?></p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="mec_usage_limit"><?php _e('Usage Limit', 'mec'); ?></label>
            </th>
            <td>
                <input type="text" name="usage_limit" id="mec_usage_limit" value="<?php echo $usage_limit; ?>" />
                <p class="description"><?php _e('Insert -1 for unlimited usage', 'mec'); ?></p>
            </td>
        </tr>
    <?php
    }
    
    /**
     * Show add form of labels
     * @author Webnus <info@webnus.biz>
     */
    public function add_form()
    {
    ?>
        <div class="form-field">
            <label for="mec_discount_type"><?php _e('Discount Type', 'mec'); ?></label>
            <select name="discount_type" id="mec_discount_type">
                <option value="percent"><?php _e('Percent', 'mec'); ?></option>
                <option value="amount"><?php _e('Amount', 'mec'); ?></option>
            </select>
        </div>
        <div class="form-field">
            <label for="mec_discount"><?php _e('Discount', 'mec'); ?></label>
            <input type="text" name="discount" id="mec_discount" value="10" />
            <p class="description"><?php _e('Discount percent, considered as amount if you set the discount type to amount', 'mec'); ?></p>
        </div>
        <div class="form-field">
            <label for="mec_usage_limit"><?php _e('Usage Limit', 'mec'); ?></label>
            <input type="text" name="usage_limit" id="mec_usage_limit" value="100" />
            <p class="description"><?php _e('Insert -1 for unlimited usage', 'mec'); ?></p>
        </div>
    <?php
    }
    
    /**
     * Save label meta data
     * @author Webnus <info@webnus.biz>
     * @param int $term_id
     */
    public function save_metadata($term_id)
    {
        $discount_type = (isset($_POST['discount_type']) and in_array($_POST['discount_type'], array('percent', 'amount'))) ? $_POST['discount_type'] : 'percent';
        update_term_meta($term_id, 'discount_type', $discount_type);
        
        $discount = (isset($_POST['discount']) and trim($_POST['discount'])) ? $_POST['discount'] : 10;
        update_term_meta($term_id, 'discount', $discount);
        
        $usage_limit = (isset($_POST['usage_limit']) and trim($_POST['usage_limit'])) ? $_POST['usage_limit'] : 10;
        update_term_meta($term_id, 'usage_limit', $usage_limit);
    }
    
    /**
     * Filter label taxonomy columns
     * @author Webnus <info@webnus.biz>
     * @param array $columns
     * @return array
     */
    public function filter_columns($columns)
    {
        unset($columns['name']);
        unset($columns['slug']);
        unset($columns['description']);
        unset($columns['posts']);
        
        $columns['name'] = __('Name/Code', 'mec');
        $columns['description'] = __('Description', 'mec');
        $columns['discount'] = __('Discount', 'mec');
        $columns['limit'] = __('Usage Limit', 'mec');
        $columns['posts'] = __('Count', 'mec');

        return $columns;
    }
    
    /**
     * Filter content of label taxonomy
     * @author Webnus <info@webnus.biz>
     * @param string $content
     * @param string $column_name
     * @param int $term_id
     * @return string
     */
    public function filter_columns_content($content, $column_name, $term_id)
    {
        switch($column_name)
        {
            case 'discount':
                
                $discount = get_metadata('term', $term_id, 'discount', true);
                $discount_type = get_metadata('term', $term_id, 'discount_type', true);
                
                $content = $discount.' ('.($discount_type == 'percent' ? '%' : '$').')';
                break;
            
            case 'limit':
                
                $usage_limit = get_metadata('term', $term_id, 'usage_limit', true);
                
                $content = ($usage_limit == '-1' ? __('Unlimited', 'mec') : $usage_limit);
                break;

            default:
                break;
        }

        return $content;
    }
    
    public function apply_coupon()
    {
        $transaction_id = sanitize_text_field($_GET['transaction_id']);
        
        // Check if our nonce is set.
        if(!isset($_GET['_wpnonce'])) $this->main->response(array('success'=>0, 'code'=>'NONCE_MISSING'));

        // Verify that the nonce is valid.
        if(!wp_verify_nonce($_GET['_wpnonce'], 'mec_apply_coupon_'.$transaction_id)) $this->main->response(array('success'=>0, 'code'=>'NONCE_IS_INVALID'));
        
        $coupon = sanitize_text_field($_GET['coupon']);
        $validity = $this->book->coupon_check_validity($coupon);
        
        // Coupon is not valid
        if($validity == 0) $this->main->response(array('success'=>0, 'code'=>'COUPON_INVALID', 'message'=>__('Discount copupon is invalid!', 'mec')));
        // Coupon is valid but usage limit reached!
        elseif($validity == -1) $this->main->response(array('success'=>0, 'code'=>'COUPON_USAGE_REACHED', 'message'=>__('Discount copupon usage limit reached!', 'mec')));
        // Coupon is valid
        else
        {
            $discount = $this->book->coupon_apply($coupon, $transaction_id);
            $transaction = $this->book->get_transaction($transaction_id);
            $price_details = '<li class="mec-book-price-detail mec-book-price-detail-typediscount">
                <span class="mec-book-price-detail-description">'.__('Discount', 'mec').'</span>
                <span class="mec-book-price-detail-amount">'.$this->main->render_price($discount).'</span>
            </li>';
            
            $this->main->response(array('success'=>1, 'message'=>sprintf(__('Coupon is valid and you get %s discount.', 'mec'), $this->main->render_price($discount)), 'data'=>array('discount'=>$discount, 'price_raw'=>$transaction['price'], 'price'=>$this->main->render_price($transaction['price']), 'price_details'=>$price_details, 'transaction_id'=>$transaction_id)));
        }
    }
}