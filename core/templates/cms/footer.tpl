
{literal}
<script src="/files4cms/js/libs/jquery-ui-1.10.2.custom.min.js"></script>
<script src="/files4cms/js/setup.js"></script>

<!-- Template functions -->
<script src="/files4cms/js/developr.accordions.js"></script>
<script src="/files4cms/js/developr.auto-resizing.js"></script>
<script src="/files4cms/js/developr.input.js"></script>
<script src="/files4cms/js/developr.message.js"></script>
<script src="/files4cms/js/developr.modal.js"></script>
<script src="/files4cms/js/developr.navigable.js"></script>
<script src="/files4cms/js/developr.collapsible.js"></script>
<script src="/files4cms/js/developr.notify.js"></script>
<script src="/files4cms/js/developr.scroll.js"></script>
<script src="/files4cms/js/developr.progress-slider.js"></script>
<script src="/files4cms/js/developr.tooltip.js"></script>
<script src="/files4cms/js/developr.confirm.js"></script>
<script src="/files4cms/js/developr.content-panel.js"></script>
<script src="/files4cms/js/developr.agenda.js"></script>
<script src="/files4cms/js/developr.table.js"></script>
<script src="/files4cms/js/developr.wizard.js"></script>
<script src="/files4cms/js/developr.tabs.js"></script>		<!-- Must be loaded last -->

<!-- Tinycon -->
<script src="/files4cms/js/libs/tinycon.min.js"></script>

<!-- Google code prettifier -->
<script src="/files4cms/js/libs/google-code-prettify/prettify.js?v=1"></script>

<!-- Hashchange polyfill -->
<script src="/files4cms/js/libs/jquery.ba-hashchange.min.js?v=1"></script>

<!-- Tablesorter -->
<script src="/files4cms/js/libs/jquery.tablesorter.min.js"></script>

<!-- DataTables -->
<script src="/files4cms/js/libs/DataTables/jquery.dataTables.min.js"></script>
<script src="/files4cms/js/core/jquery.ui.datepicker-pl.js"></script>

<script>

	var win = $(window),
		bod = $(document.body),
		main = $('#main'),
		init = false;

	// Ajax navigation
	$(document).on('click', 'a', function(event)
	{
		var link = $(this),
			href = link.attr('href'),
			docmenu;

		// Some elements from the doc shouldn't be processed
		if (link.closest('#main').length > 0 && link.closest('.navigable, .collapsible').length > 0)
		{
			return;
		}

		// If local link
		if (href && !href.match(/^(https?:|#|\.\/|javascript:)/))
		{
			event.preventDefault();
			window.location.hash = '#'+href;
			if (!bod.parent().hasClass('hashchange'))
			{
				win.hashchange();
			}

			// If in menu, add visual indicator
			docmenu = link.closest('#doc-menu');
			if (docmenu.length > 0)
			{
				docmenu.find('.current').removeClass('current');
				link.addClass('current');
			}
		}
	});

	// Listen to hash changes
	win.hashchange(function(event)
	{
		var hash = $.trim(window.location.hash || '');
		if (hash.length > 1)
		{
			main.load(hash.substring(1), function()
			{
				// Code display
				prettyPrint();

				// Scroll
				if (init)
				{
					bod.animate({
						scrollTop: 0
					});
				}
			});
		}
		else
		{
			window.location.reload();
		}
	});

	// Init
	if (window.location.hash && window.location.hash.length > 1)
	{
		win.hashchange();
	}
	init = true;

	// Documentation won't work on local files with chrome
	if (document.location.protocol === 'file:' && navigator.userAgent.match(/Chrome/))
	{
		$.modal.alert('<p>The documentation won\'t work on Chrome because you opened it as a local file. Place files on any web server to browse it safely.</p>Or use another modern brower, but Chrome just rocks...');
	}

</script>

{/literal}
</body>
</html>