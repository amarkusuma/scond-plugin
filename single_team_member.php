<?php
/*Template Name: New Template
 */

add_shortcode('member', 'teamMember');

function team_member($wp_position, $wp_email, $wp_website, $wp_image)
{
    get_header();
?>
    <div class="content">
        <div id="content" role="main">
            <h5>Detail Team Member</h5>
            <?php
            $mypost = array('post_type' => 'team_members',);
            $loop = new WP_Query($mypost);
            ?>
            <?php while ($loop->have_posts()) : $loop->the_post();

                $id = get_the_ID();
                $position   = get_post_meta($id, 'position', true);
                $email      = get_post_meta($id, 'email', true);
                $website    = get_post_meta($id, 'website', true);
                $image      = get_post_meta($id, 'image', true);

            ?>

                <table class="table-form" border="0" width="100%" cellpadding="0" cellspacing="0" style="color: crimson ;font-size: 20px">

                    <?php if ($wp_position != 0) {
                        echo '
                    
                        <tr>
                            <td width="40%"> Position </td>
                            <td width="1%">:</td>
                            <td>' . $position . '</td>
                        </tr>
                    
                    ';
                    } ?>
                    <?php if ($wp_email != 0) {
                        echo ' 
                    <tr>
                        <td width="40%"> Email </td>
                        <td width="1%">:</td>
                        <td>' . $email . '</td>
                    </tr>
                    
                    ';
                    } ?>
                    <?php if ($wp_website != 0) {
                        echo ' 
                    <tr>
                        <td width="40%"> Website </td>
                        <td width="1%">:</td>
                        <td>' . $website . '</td>
                    </tr>
                    ';
                    } ?>
                    <?php if ($wp_image != 0) {
                        echo '
                    <tr>
                        <td width="40%"> Image </td>
                        <td width="1%">:</td>
                        <td><img src="' . $image . '" alt=""></td>
                    </tr>
                    ';
                    } ?>
                </table>
                <hr>

            <?php endwhile; ?>
        </div>
    </div>


<?php
}

function teamMember($atts, $content = null)
{

    $value = shortcode_atts([
        'position' => '',
        'email' => '',
        'website' => '',
        'image' => '',
    ], $atts);
    ob_start();
    team_member($value['position'], $value['email'], $value['website'], $value['image']);
    return ob_get_clean();
}

?>