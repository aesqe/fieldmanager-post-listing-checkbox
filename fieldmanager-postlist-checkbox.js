jQuery(document).ready(function()
{
	jQuery(".fieldmanager-postslist-checkbox-action").on("click", function (e) {
		e.preventDefault();

		var $this = jQuery(this);
		var checked = $this.prop("checked");
		var metakey = $this.data("key");
		var data = {
			action: "fieldmanager_postlist_checkbox-" + metakey,
			post_id: $this.data("post_id"),
		};
		data[metakey] = checked ? 1 : 0;

		jQuery.post(ajaxurl, data, function (res) {
			if( res.success === true ) {
				$this.prop("checked", checked);
			}
		}).fail(function (error) {
			if( window.console && console.log ) {
				console.log(error);
			}
		});
	});
});