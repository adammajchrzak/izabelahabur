<div id="container">

	<hgroup id="login-title" class="large-margin-bottom">
		<h1 class="login-title-image">Netiz CMS System</h1>	
		<h5>&copy; netiz.pl</h5>
	</hgroup>

	<form method="post" action="" id="form-login">
		<ul class="inputs black-input large">
			<!-- The autocomplete="off" attributes is the only way to prevent webkit browsers from filling the inputs with yellow -->
			<li><span class="icon-user mid-margin-right"></span><input type="text" name="login" id="login" value="" class="input-unstyled" placeholder="{$locale.cms.auth.user}" autocomplete="off"></li>
			<li><span class="icon-lock mid-margin-right"></span><input type="password" name="passwd" id="passwd" value="" class="input-unstyled" placeholder="{$locale.cms.auth.password}" autocomplete="off"></li>
		</ul>

		<button type="submit" class="button glossy full-width huge">{$locale.cms.auth.login}</button>
	</form>

</div>


{literal}
<script>

		/*
		 * How do I hook my login script to this?
		 * --------------------------------------
		 *
		 * This script is meant to be non-obtrusive: if the user has disabled javascript or if an error occurs, the login form
		 * works fine without ajax.
		 *
		 * The only part you need to edit is the login script between the EDIT SECTION tags, which does inputs validation
		 * and send data to server. For instance, you may keep the validation and add an AJAX call to the server with the
		 * credentials, then redirect to the dashboard or display an error depending on server return.
		 *
		 * Or if you don't trust AJAX calls, just remove the event.preventDefault() part and let the form be submitted.
		 */

		$(document).ready(function()
		{
			/*
			 * JS login effect
			 * This script will enable effects for the login page
			 */
				// Elements
			var doc = $('html').addClass('js-login'),
				container = $('#container'),
				formLogin = $('#form-login'),

				// If layout is centered
				centered;

			/******* EDIT THIS SECTION *******/

			/*
			 * AJAX login
			 * This function will handle the login process through AJAX
			 */
			formLogin.submit(function(event)
			{
				// Values
				var login = $.trim($('#login').val()),
					pass = $.trim($('#passwd').val());

				// Check inputs
				if (login.length === 0)
				{
					// Display message
					displayError('{/literal}{$locale.cms.auth.nologin}{literal}');
					return false;
				}
				else if (pass.length === 0)
				{
					// Remove empty login message if displayed
					formLogin.clearMessages('{/literal}{$locale.cms.auth.nologin}{literal}');

					// Display message
					displayError('{/literal}{$locale.cms.auth.nopasswd}{literal}');
					return false;
				}
				else
				{
					// Remove previous messages
					formLogin.clearMessages();

					// Show progress
					displayLoading('{/literal}{$locale.cms.auth.process}{literal}');
					event.preventDefault();

					// Stop normal behavior
					event.preventDefault();
					  $.ajax({
					  		type: 'POST',
					  		url: '{/literal}/{$router->getUrl('cms','auth','login')}{literal}', 
					  		data: {
					  			login:	login,
					  			passwd:	pass
					  		},
					  		success: function(data)
					  		{
					  			if ($.trim(data) == 'logged')
					  			{
					  				document.location.href = '/cms/index';
					  			}
					  			else
					  			{
					  				formLogin.clearMessages();
					  				displayError('{/literal}{$locale.cms.auth.error}{literal}');
					  			}
					  		},
					  		error: function()
					  		{
					  			formLogin.clearMessages();
					  			displayError('Error while contacting server, please try again');
					  		}
					  });
				}
			});

			/******* END OF EDIT SECTION *******/

			// Handle resizing (mostly for debugging)
			function handleLoginResize()
			{
				// Detect mode
				centered = (container.css('position') === 'absolute');

				// Set min-height for mobile layout
				if (!centered)
				{
					container.css('margin-top', '');
				}
				else
				{
					if (parseInt(container.css('margin-top'), 10) === 0)
					{
						centerForm(false);
					}
				}
			};

			// Register and first call
			$(window).bind('normalized-resize', handleLoginResize);
			handleLoginResize();

			/*
			 * Center function
			 * @param boolean animate whether or not to animate the position change
			 * @param string|element|array any jQuery selector, DOM element or set of DOM elements which should be ignored
			 * @return void
			 */
			function centerForm(animate, ignore)
			{
				// If layout is centered
				if (centered)
				{
					var siblings = formLogin.siblings(),
						finalSize = formLogin.outerHeight();

					// Ignored elements
					if (ignore)
					{
						siblings = siblings.not(ignore);
					}

					// Get other elements height
					siblings.each(function(i)
					{
						finalSize += $(this).outerHeight(true);
					});

					// Setup
					container[animate ? 'animate' : 'css']({ marginTop: -Math.round(finalSize/2)+'px' });
				}
			};

			// Initial vertical adjust
			centerForm(false);

			/**
			 * Function to display error messages
			 * @param string message the error to display
			 */
			function displayError(message)
			{
				// Show message
				var message = formLogin.message(message, {
					append: false,
					arrow: 'bottom',
					classes: ['red-gradient'],
					animate: false					// We'll do animation later, we need to know the message height first
				});

				// Vertical centering (where we need the message height)
				centerForm(true, 'fast');

				// Watch for closing and show with effect
				message.bind('endfade', function(event)
				{
					// This will be called once the message has faded away and is removed
					centerForm(true, message.get(0));

				}).hide().slideDown('fast');
			}

			/**
			 * Function to display loading messages
			 * @param string message the message to display
			 */
			function displayLoading(message)
			{
				// Show message
				var message = formLogin.message('<strong>'+message+'</strong>', {
					append: false,
					arrow: 'bottom',
					classes: ['blue-gradient', 'align-center'],
					stripes: true,
					darkStripes: false,
					closable: false,
					animate: false					// We'll do animation later, we need to know the message height first
				});

				// Vertical centering (where we need the message height)
				centerForm(true, 'fast');

				// Watch for closing and show with effect
				message.bind('endfade', function(event)
				{
					// This will be called once the message has faded away and is removed
					centerForm(true, message.get(0));

				}).hide().slideDown('fast');
			}
		});

	</script>
{/literal}
