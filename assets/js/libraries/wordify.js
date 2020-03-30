//	https://gist.github.com/yukulele/8668962
jQuery.fn.wordify = function(){
	this.find(":not(iframe,textarea)").addBack().contents().filter(function() {
		return this.nodeType === 3;
	}).each(function() {
		var textnode = jQuery(this);
		var text = textnode.text();
//		text = text.replace(/([^\s-.,;:!?()[\]{}<>"]+)/g,'<span>$1</span>');
		text = text.replace(/([^\s-()[\]{}<>"]+)/g,'<span>$1</span>');

		textnode.replaceWith(text);
	});
	return this;
};
