<?php
$weeks = array();
$len = 0;

while ($len < 5) {
    $len = $len + 1;
    $week_id = 'chart_admin_week_' . $len;
    ${$week_id} = get_option($week_id);
    $weeks[$len] = "Week " . $len;
}

if (isset($_POST['submit'])) {
    $saved = $len;
    foreach ($weeks as $week) {
        $week_id = 'chart_admin_' . strtolower(str_replace(' ', "_", $week));
        $value = explode(",", $_POST[$week_id]);
        if (count($value) == 7 && is_numeric(join("", $value))) {
            update_option($week_id, $_POST[$week_id]);
            ${$week_id} = get_option($week_id);
            $saved = $saved - 1;
        } else {
            echo '<div class="notice notice-error"><p>' . $week . ' has an invalid value.</p></div>';
        }
    }
    if ($saved != $len && $saved != 0) {
        echo '<div class="notice notice-success"><p>' . $len - $saved . ' records updated.</p></div>';
    }else{
        echo '<div class="notice notice-success"><p>All records updated.</p></div>';
    }
}


?>


<div class="wrap">
    <h1>Admin Chart Settings</h1>
    <form method="post">
        <table class="form-table">
            <tbody>
                <?php foreach ($weeks as $week) {
                    $week_id = 'chart_admin_' . strtolower(str_replace(' ', "_", $week));
                ?>
                    <tr>
                        <th>
                            <label>
                                <?php echo $week ?>
                            </label>
                        </th>
                        <td>
                            <input placeholder="1,2,3,4,5,6,7" name="<?php echo $week_id; ?>" value="<? echo esc_attr(${$week_id}) ?>" type="text">
                        </td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
        <?php submit_button() ?>
    </form>
</div>