
jQuery(document).ready(function($) {
    // Show modal when specific element is clicked
    $('.open-newsletter-modal').click(function() {
        $('#newsletter-modal').show();
    });

    // Handle form submission
    $('#newsletter-form').submit(function(e) {
        e.preventDefault();
        var formData = {
            'action': 'subscribe',
            'nonce': $('#newsletter_nonce_field').val(),
            'name': $('#name').val(),
            'email': $('#email').val(),
            'consent': $('#consent').is(':checked') ? 1 : 0
        };

        $.post(ajax_object.ajax_url, formData, function(response) {
            alert(response.data);
            $('#newsletter-modal').hide();
        });
    });

    // Clicking anywhere outside the modal closes it
    $(document).mouseup(function(e) {
        var container = $('#newsletter-modal');
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });

    // Hitting escape closes the modal
    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $('#newsletter-modal').hide();
        }
    });

    // If URL contains #newsletter, show modal
    if (window.location.hash == '#newsletter') {
        $('#newsletter-modal').show();
    }
});
