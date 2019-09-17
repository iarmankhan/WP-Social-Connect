<?php
if (isset($_POST['wpsoccon']['main']['header']) && isset($_POST['wpsoccon']['main']['footer']) && isset($_POST['contacts'])) {
    $header = $_POST['wpsoccon']['main']['header'];
    $footer = $_POST['wpsoccon']['main']['footer'];
    $contacts = $_POST['contacts'];
    update_option(WPSOCCON_DOMAIN . '-header', $_POST['wpsoccon']['main']['header']);
    update_option(WPSOCCON_DOMAIN . '-footer', $_POST['wpsoccon']['main']['footer']);
    update_option(WPSOCCON_DOMAIN . '-button_text', $_POST['wpsoccon']['main']['button_text']);
    update_option(WPSOCCON_DOMAIN . '-button_color', $_POST['wpsoccon']['main']['button_color']);
    $savecontacts = array();
    foreach ($_POST['contacts'] as $c) {
        if (!empty($c) && $c['phone'] != '') {
            $savecontacts[] = $c;
        }
    }
    update_option(WPSOCCON_DOMAIN . '-contacts', $savecontacts);
}
?>
<form method="post" action="#">
    <?php settings_fields(sanitize_key(WPSOCCON_DOMAIN . '-group')); ?>
    <?php do_settings_sections(sanitize_key(WPSOCCON_DOMAIN . '-group')); ?>
    <table class="form-table">
        <tbody>
			<tr>
                <td><?php esc_html_e('Button Text', 'wp-social-connect'); ?>
                <input type="text" name="<?php echo esc_attr(WPSOCCON_DOMAIN) . '[main][button_text]'; ?>" value="<?php echo get_option(WPSOCCON_DOMAIN . '-button_text');  ?>" style="width:100%;">
				<br><br>
				<?php esc_html_e('Button Color', 'wp-social-connect'); ?> <input type="text" id="color" name="<?php echo esc_attr(WPSOCCON_DOMAIN) . '[main][button_color]'; ?>" value="<?php echo get_option(WPSOCCON_DOMAIN . '-button_color');  ?>">
				<br><br>
				<?php esc_html_e('Header', 'wp-social-connect'); ?>
                    <?php wp_editor(get_option(WPSOCCON_DOMAIN . '-header'), 'wpsoccon_main_header', array('editor_height' => 120, 'textarea_name' => esc_attr(WPSOCCON_DOMAIN) . '[main][header]')); ?>
                <br><br>
				<?php esc_html_e('Footer', 'wp-social-connect'); ?>
                    <?php wp_editor(get_option(WPSOCCON_DOMAIN . '-footer'), 'wpsoccon_main_footer', array('editor_height' => 120, 'textarea_name' => esc_attr(WPSOCCON_DOMAIN) . '[main][footer]')); ?>
                </td>
                <td>
					<?php esc_html_e('Contacts', 'wp-social-connect'); ?>
                    <table id="wpsoccon-contacts-table" class="form-table widefat striped">
                        <thead>
                            <tr>
                                <td><b><?php esc_html_e('Avatar', 'wp-whatsapp-chat'); ?></b></td>
                                <td><b><?php esc_html_e('Phone', 'wp-whatsapp-chat'); ?></b></td>
                                <td><b><?php esc_html_e('Name', 'wp-whatsapp-chat'); ?></b></td>
                                <td><b><?php esc_html_e('Label', 'wp-whatsapp-chat'); ?></b></td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php $i = 0; ?>
                        <tbody id="allContacts">
                            <?php
                            if (!empty(get_option(WPSOCCON_DOMAIN . '-contacts'))) {
                                foreach (get_option(WPSOCCON_DOMAIN . '-contacts') as $c) { 
                                    ?>
                                    <tr class="entry">
                                        <td>
                                            <img src="<?php echo wp_get_attachment_url($c['attach_id']); ?> " alt="<?php echo $c['name']; ?>" id="image-preview<?php echo $i; ?>" width='100' height='100' style='max-height: 100px; width: 100px;'>
                                            <input type='hidden' name="contacts[<?php echo $i; ?>][attach_id]" id='image_attachment_id<?php echo $i; ?>' value='<?php echo $c['attach_id']; ?>'>
                                            <button type="button" class="button" onclick="set_avatar(<?php echo $i; ?>);"><?php _e('Upload image'); ?></button>
                                        </td>
                                        <td><input type="number" name="contacts[<?php echo $i; ?>][phone]" value="<?php echo $c['phone']; ?>"></td>
                                        <td><input type="text" name="contacts[<?php echo $i; ?>][name]" value="<?php echo $c['name']; ?>"></td>
                                        <td><input type="text" name="contacts[<?php echo $i; ?>][label]" value="<?php echo $c['label']; ?>"></td>
                                        <td><button type="button" class="button btn btn-danger btn-remove" onclick="remove_row(this, <?php echo $i; ?>);" style="">
                                                <span class="fa fa-minus" aria-hidden="true">-</span>
                                            </button></td>
                                    </tr>
                            <?php
                                    $i++;
                                }
                            } ?>
                            <tr class="entry">
                                <td>
                                    <img src="" alt="" id="image-preview<?php echo $i; ?>" width='100' height='100' style='max-height: 100px; width: 100px;'>
                                    <input type='hidden' name="contacts[<?php echo $i; ?>][attach_id]" id='image_attachment_id<?php echo $i; ?>' value=''>
                                    <button type="button" class="button" onclick="set_avatar(<?php echo $i; ?>);">Upload Image</button>
                                </td>
                                <td><input type="number" name="contacts[<?php echo $i; ?>][phone]" value=""></td>
                                <td><input type="text" name="contacts[<?php echo $i; ?>][name]" value=""></td>
                                <td><input type="text" name="contacts[<?php echo $i; ?>][label]" value=""></td>
                                <td><button type="button" class="button btn btn-success btn-add" onclick="add_row(this, <?php echo $i; ?>);" style="">
                                        <span class="fa fa-add" aria-hidden="true">+</span>
                                    </button></td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <?php submit_button() ?>
</form> 