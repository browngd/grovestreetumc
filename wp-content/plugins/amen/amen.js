// TODO
jQuery(document).ready(function($) {
    $('.amenButton').click(function() {
        var updateEl = $(this)
        $.post(Amen.ajaxurl,
               {'action': 'pray',
                'requestID': updateEl.attr('id'),
                'amen-submit': updateEl.data('amen-submit'),
                'amen-state1': updateEl.data('amen-state1'),
                'amen-state2': updateEl.data('amen-state2'),
                'amen-state3': updateEl.data('amen-state3'),
                 },
               function(d) {
                 updateEl.closest('.praying').text(d.contents)
               })
        
      })
  })
