jQuery(document).ready(function($) {
	if (typeof lepopup_data == "undefined" || lepopup_data.length == 0) return false;

	$.each(lepopup_data, function(i, v) {
		$.each(v, function(x, y) {
			try {
				v[x] = eval(v[x])
			} catch (er) {}
		});
		$('#' + v.ele).find("img.alignnone, iframe").each(function() {
			if ($(this).parent("p").length) {
				$(this).unwrap();
			} else {
				$(this).unwrap().unwrap();
			}
		});
		$('#' + v.ele).LePopup(v);
	});

});