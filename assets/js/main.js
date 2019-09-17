// jQuery(function($) {
//     jQuery(document).on('click', '.btn-add', function(e) {
//         // console.log("Hello");
//         e.preventDefault();
//         var controlForm = $('#allContacts:first'),
//             currentEntry = $(this).parents('.entry:first'),
//             newEntry = $(currentEntry.clone()).appendTo(controlForm);
//         newEntry.find('input').val('');
//         controlForm.find('.entry:not(:last) .btn-add')
//             .removeClass('btn-add').addClass('btn-remove')
//             .removeClass('btn-success').addClass('btn-danger')
//             .html('<span class="fa fa-minus"></span>');
//     }).on('click', '.btn-remove', function(e) {
//         e.preventDefault();
//         $(this).parents('.entry').remove();
//         return false;
//     });
// });

function add_row(instance, id) {
    id = id + 1;
    var controlForm = $('#allContacts:first'),
        currentEntry = $(instance).parents('.entry:first')
    var html = '<tr class="entry">';
    html += '<td><img src="" alt="" id="image-preview' + id + '" width=\'100\' height=\'100\' style=\'max-height: 100px; width: 100px;\'>';
    html += '<input type=\'hidden\' name="contacts[' + id + '][\'attach_id\']" id=\'image_attachment_id' + id + '\'>';
    html += '<button type = "button" class = "button" onclick = "set_image(' + id + ', 0);" > Upload Image </button>';
    html += '</td>';
    html += '<td>';
    html += '<input type="number" name="contacts[' + id + '][\'phone\'][]" value=""> </td>';
    html += '<td><input type="text" name="contacts[' + id + '][\'name\']" value=""></td>';
    html += '<td><input type="text" name="contacts[' + id + '][\'label\']" value=""></td>';
    html += '<td><button type="button" onclick="add_row(this, ' + id + ');" class="btn btn-info btn-add" style="">';
    html += '<span class="fa fa-add" aria-hidden="true">+</span>';
    html += '</button></td>';
    html += '</tr>';
    jQuery(html).appendTo(controlForm)
    jQuery('.entry:nth-last-child(2) .btn-add')
        .removeClass('btn-add').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .attr('onclick', "remove_row(this, " + id + ");")
        .html('<span class="fa fa-minus">-</span>');
}

function remove_row(instance, id) {
    $(instance).parents('.entry').remove();
    return false;
}

function set_image(id, aid) {
    var file_frame;
    var wp_media_post_id = wp.media.model.settings.post.id;
    if (aid == '') aid = 0;
    var set_to_post_id = aid;
    // If the media frame already exists, reopen it.
    if (file_frame) {
        // Set the post ID to what we want
        file_frame.uploader.uploader.param('post_id', set_to_post_id);
        // Open frame
        file_frame.open();
        return;
    } else {
        // Set the wp.media post id so the uploader grabs the ID we want when initialised
        wp.media.model.settings.post.id = set_to_post_id;
    }
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
        title: 'Select a image to upload',
        button: {
            text: 'Use this image',
        },
        multiple: false // Set to true to allow multiple files to be selected
    });
    // When an image is selected, run a callback.
    file_frame.on('select', function() {
        // We set multiple to false so only get one image from the uploader
        attachment = file_frame.state().get('selection').first().toJSON();
        // Do something with attachment.id and/or attachment.url here
        var cssid = "#image-preview" + id
        $(cssid).attr('src', attachment.url).css('width', 'auto');
        var imgattch = "image_attachment_id" + id
        $(imgattch).val(attachment.id);
        // Restore the main post ID
        wp.media.model.settings.post.id = wp_media_post_id;
    });
    // Finally, open the modal
    file_frame.open();
}
jQuery('a.add_media').on('click', function() {
    var wp_media_post_id = wp.media.model.settings.post.id;
    wp.media.model.settings.post.id = wp_media_post_id;
})