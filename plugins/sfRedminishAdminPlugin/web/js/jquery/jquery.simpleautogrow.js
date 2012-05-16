/*
 * Simple Auto Expanding Text Area (0.1.1)
 * by Antti Kaihola (antti.kaihola.fi)
 * akaihol+jquery@ambitone.com
 *
 * Copyright (c) 2009 Antti Kaihola (antti.kaihola.fi)
 * Licensed under the MIT and BSD licenses.
 *
 * NOTE: This script requires jQuery to work.  Download jQuery at
 *       www.jquery.com
 */

(function(jQuery) {

	jQuery.fn.simpleautogrow = function() {
		return this.each(function() { new jQuery.simpleautogrow(this); }); };

	jQuery.simpleautogrow = function (e) {
		this.initialHeight = jQuery(e).outerHeight();
		this.lineHeight = parseInt(jQuery(e).css('line-height'));
		var self = this;
		var $e = this.textarea = jQuery(e)
			.css({overflow: 'hidden', display: 'block'})
			.bind('focus', function() {
				self.checkExpand();
				this.timer = window.setInterval(function() {self.checkExpand(); }, 500);
			})
			.bind('blur', function() {
				clearInterval(this.timer);
			});
		this.border = $e.outerHeight() - $e.innerHeight();
		this.clone = $e.clone().css({position: 'absolute', visibility: 'hidden'}).attr('name', '')
		$e.height(e.scrollHeight + this.border + this.lineHeight)
			.after(this.clone);
		self.checkExpand(); };

	jQuery.simpleautogrow.prototype.checkExpand = function() {
		var target_height = this.clone[0].scrollHeight + this.border + this.lineHeight;
		if (this.textarea.outerHeight() != target_height) {
			if (this.initialHeight < target_height)
			{	
				this.textarea.animate({height: target_height + 'px'}, 200);
			} else {
				this.textarea.animate({height: this.initialHeight + 'px'}, 200);
			}
		}
		this.clone.attr('value', this.textarea.attr('value')).height(0); };

})(jQuery);
