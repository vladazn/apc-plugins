    ;(function ($,window,document) {

    var exitPopup = {

		cookie_name: 'infx_exit_popup_showed',
		modalcontent: '.infx--modal',
		modaltitle: '.infx--modal-title',

		init: function() {
			var me = this;

			if(me.cookieExists()) {
				return;
			}

			me.setCookie(me.cookie_name,'1',30);
			me.trackCursor();
		},

		trackCursor: function() {
			var me = this;
			$(document).mousemove(function(e){
				if(e.pageY < 5) {
					me.showPopup();
				}
			});
		},

		showPopup: function() {
			var me = this;

			$.modal.open($(me.modalcontent).html(),{
                title: $(me.modaltitle).text(),
                showCloseButton: false,
                additionalClass: 'infx--modalbox',
                sizing: 'content',
            });
			me.unbindTracking();
		},

		unbindTracking: function() {
			var me = this;

			$(document).off('mousemove');
		},

		setCookie: function(cname, cvalue, exdays) {
			var me = this;

			var d = new Date();

			d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

			var expires = "expires=" + d.toUTCString();

			document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		},

		getCookie: function(cname) {
			var me = this;

			var name = cname + "=";
			var ca = document.cookie.split(';');
			for(var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) == 0) {
					return c.substring(name.length, c.length);
				}
			}
			return "";
		},

		cookieExists: function() {
			var me = this;

			var value = me.getCookie(me.cookie_name);

			if (value == '1') {
				return true;
			}

			return false;
		},

	};

    $(document).ready(function(){
       exitPopup.init();
    });

})($,window,document);
