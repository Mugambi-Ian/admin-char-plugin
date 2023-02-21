<?php
$field = 'admin_chart_week_';
$domain =  "admin-chart";
$weeks = array();
$len = 0;

while ($len < 5) {
    $len = $len + 1;
    $week_id = $field . $len;
    ${$week_id} = get_option($week_id);
    $weeks[$len] =  $len;
}

if (isset($_POST['submit'])) {
    $saved = $len;
    foreach ($weeks as $week) {
        $week_id = $field . $week;
        $value = explode(",", $_POST[$week_id]);
        if (count($value) == 7 && is_numeric(join("", $value))) {
            update_option($week_id, sanitize_text_field($_POST[$week_id]));
            ${$week_id} = get_option($week_id);
            $saved = $saved - 1;
        } else {
            echo '<div class="notice notice-error"><p>' . __("Week", $domain) . " " . $week . ' has an invalid value.</p></div>';
        }
    }
    $processed = $len - $saved;
    if ($processed != $len && $processed > 0) {
        echo '<div class="notice notice-success"><p>' . esc_attr($processed) . ' records updated.</p></div>';
    } else if ($processed == $len) {
        echo '<div class="notice notice-success"><p>All records updated.</p></div>';
    }
}


?>


<div class="wrap">
    <h1><?php esc_html_e("Admin Chart Settings", $domain) ?></h1>
    <form method="post">
        <table class="form-table">
            <tbody>
                <?php foreach ($weeks as $week) {
                    $week_id = $field . $week;
                ?>
                    <tr>
                        <th>
                            <label>
                                <?php echo __("Week", $domain) . " " . $week ?>
                            </label>
                        </th>
                        <td>
                            <input placeholder="1,2,3,4,5,6,7" name="<?php echo esc_attr($week_id) ?>" value="<? echo esc_attr(${$week_id}) ?>" type="text">
                        </td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
        <?php submit_button() ?>
    </form>
</div>