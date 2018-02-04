const $ = require('jquery');
$(function(){
    const $contentLinks = $('.js-content').find('a');
    if ($contentLinks.length !== 0) {
        $contentLinks.each(function () {
            const $this = $(this);
            const href = $this.attr('href');
            if (!$this.is('[target="_blank"]')) {
                if (!href.match(/(^http|^https):\/\/(.)+(\.psy-dreamer\.com)|(^\/)/im)) {
                    // add target="_blank" rel="noopener noreferrer"
                    $this.attr('target', '_blank').attr('rel', 'noopener noreferrer');
                }
            }
        });
    }
});