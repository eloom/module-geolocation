define([
	"jquery",
	"jquery/ui",
	"mage/translate"
], function ($) {

	$.widget('mage.dbIp', {
		options: {},

		_create: function () {

			$('#eloom-upload').click(function () {
				$('#eloom-upload').prop('disabled', true);

				$(".progress .upload").show();

				this.run(this.options.url);
			}.bind(this));
		},

		error: function (error, processer) {
		},

		done: function (response) {

		},

		run: function (url) {
			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'json',
				data: {form_key: FORM_KEY}
			}).done($.proxy(function (response) {
				$(".progress .upload").hide();
				$(".progress .completed").show();

				if(response.code == 200) {
				}
				$(".filename").html(response.file);

				$('#eloom-upload').prop('disabled', false);
			}, this));
		},
	});

	return $.mage.dbIp;
});