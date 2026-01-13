(function ($) {
  function showNotice(notice) {
    if (!notice || !notice.message) return;

    // Elementor has changed APIs over time; these are the most common options.
    try {
      if (window.elementor && elementor.notifications) {
        elementor.notifications.showToast({
          message: notice.message,
          type: notice.type || 'error',
        });
        return;
      }
    } catch (e) {}

    // Fallback: simple alert if notifications API isn't present
    alert(notice.message);
  }

  $(window).on('elementor:init', function () {
    $.post(FontawesomeElementorAddonEditor.ajaxUrl, {
      action: 'fontawesome_elementor_get_editor_notice',
      nonce: FontawesomeElementorAddonEditor.nonce,
    }).done(function (res) {
      if (res && res.success) showNotice(res.data);
    });
  });
})(jQuery);
