jQuery.fn.wordify=function(){return this.find(":not(iframe,textarea)").addBack().contents().filter((function(){return 3===this.nodeType})).each((function(){var t=jQuery(this),e=t.text();e=e.replace(/([^\s-()[\]{}<>"]+)/g,"<span>$1</span>"),t.replaceWith(e)})),this};