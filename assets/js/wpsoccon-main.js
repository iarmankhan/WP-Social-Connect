jQuery(document).ready(function() {
	jQuery('#color').wpColorPicker();
});

function add_row(instance, id) {
    id = id + 1;
    var controlForm = $('#allContacts:first'),
        currentEntry = $(instance).parents('.entry:first')
    var html = '<tr class="entry">';
    html += '<td><img src="" alt="" id="image-preview' + id + '" width=\'100\' height=\'100\' style=\'max-height: 100px; width: 100px;\'>';
    html += '<input type=\'hidden\' name="contacts[' + id + '][attach_id]" id=\'image_attachment_id' + id + '\'>';
    html += '<button type = "button" class = "button" onclick = "set_avatar(' + id + ');" > Upload Image </button>';
    html += '</td>';
    html += '<td>';
    html += '<input type="number" name="contacts[' + id + '][phone]" value=""> </td>';
    html += '<td><input type="text" name="contacts[' + id + '][name]" value=""></td>';
    html += '<td><input type="text" name="contacts[' + id + '][label]" value=""></td>';
    html += '<td><button type="button" onclick="add_row(this, ' + id + ');" class="button btn btn-info btn-add" style="">';
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

function set_avatar(nid) {
    var mediaUploader;
    mediaUploader = wp.media.frames.file_frame = wp.media({
        title: 'Choose Image',
        button: {
            text: 'Choose Image'
        },
        multiple: false
    });
    let img_id = "#image_attachment_id" + nid
    let img_url = "#image-preview" + nid
    mediaUploader.on('select', function() {
        attachment = mediaUploader.state().get('selection').first().toJSON();
        jQuery(img_id).val(attachment.id);
        jQuery(img_url).attr('src', attachment.url);
    });

    mediaUploader.on('open', function() {
        // On open, get the id from the hidden input
        // and select the appropiate images in the media manager
        var selection = mediaUploader.state().get('selection');
        var ids = jQuery(img_id).val().split(',');
        ids.forEach(function(id) {
            var attachment = wp.media.attachment(id);
            attachment.fetch();
            selection.add(attachment ? [attachment] : []);
        });
    });
    mediaUploader.open();
}