<?php

add_action('admin_init', 'my_admin');

function my_admin()
{
    add_meta_box(
        'team_review_meta_box',
        'team Review Details',
        'display_team_review_meta_box',
        'team_members',
        'normal',
        'high'
    );
}
function display_team_review_meta_box($team_review)
{
    // Retrieve current name of the Director and team Rating based on review ID
    $position = esc_html(get_post_meta($team_review->ID, 'position', true));
    $email = esc_html(get_post_meta($team_review->ID, 'email', true));
    $phone = esc_html(get_post_meta($team_review->ID, 'phone', true));
    $website = esc_html(get_post_meta($team_review->ID, 'website', true));
    $image = get_post_meta($team_review->ID, 'image', true);
    // $team_rating = intval(get_post_meta($team_review->ID, 'team_rating', true));
    $attachment_id = attachment_url_to_postid($image);
?>
    <table>

        <tr>
            <td style="width: 50%"> Position </td>
            <td>:</td>
            <td><input type="text" size="30" name="wp_position" value="<?php echo $position ?>"></td>
        </tr>
        <br>
        <br>
        <tr>
            <td style="width: 50%"> Email </td>
            <td>:</td>
            <td><input type="email" size="30" name="wp_email" value="<?php echo $email ?>" /></td>
        </tr>
        <tr>
            <td style="width: 50%"> Phone </td>
            <td>:</td>
            <td><input type="number" size="30" name="wp_phone" value="<?php echo $phone ?>" /></td>
        </tr>
        <tr>
            <td style="width: 50%"> Website </td>
            <td>:</td>
            <td><input type="text" size="30" name="wp_website" value="<?php echo $website ?>" /></td>
        </tr>
        <tr>

            <td style="width: 50%"> Image </td>
            <td>:</td>
            <td>
                <input type="file" size="40" id="wp_image" name="wp_image" />
            </td>
        </tr>
    </table>
<?php
}
function update_edit_form()
{
    echo 'enctype="multipart/form-data"';
}
add_action('post_edit_form_tag', 'update_edit_form');
add_action('save_post', 'add_team_review_fields', 10, 2);


function add_team_review_fields($team_review_id, $team_review)
{
    // Check post type for team reviews
    if ($team_review->post_type == 'team_members') {
        // Store data in post meta table if present in post data
        if (isset($_POST['wp_position']) && $_POST['wp_position'] != '') {
            update_post_meta($team_review_id, 'position', $_POST['wp_position']);
        }
        if (isset($_POST['wp_email']) && $_POST['wp_email'] != '') {
            update_post_meta($team_review_id, 'email', $_POST['wp_email']);
        }
        if (isset($_POST['wp_phone']) && $_POST['wp_phone'] != '') {
            update_post_meta($team_review_id, 'phone', $_POST['wp_phone']);
        }
        if (isset($_POST['wp_website']) && $_POST['wp_website'] != '') {
            update_post_meta($team_review_id, 'website', $_POST['wp_website']);
        }
        if (isset($_FILES['wp_image']) && $_FILES['wp_image'] != '') {
            // $upload = wp_upload_bits($_FILES['team_member_image']['name'],null, file_get_contents($_FILES['team_member_image']['tmp_name']));
            if (!function_exists('wp_handle_upload')) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }

            $file = $_FILES['wp_image'];
            $upload = wp_handle_upload($file, array('test_form' => false));

            $arr_file_type = wp_check_filetype(basename($_FILES['wp_image']['name']));
            $uploaded_file_type = $arr_file_type['type'];
            $title      = $file['name'];


            // Set up options array to add this file as an attachment
            $attachment = array(
                'post_mime_type' => $uploaded_file_type,
                'post_title' => 'Uploaded image ' . addslashes($title),
                'post_content' => '',
                'post_status' => 'inherit',
                'post_parent' => $team_review_id
            );
            $attach_id = wp_insert_attachment($attachment, $upload['file']);

            update_post_meta($team_review_id, 'image', $attach_id);
        }
    }
}


?>