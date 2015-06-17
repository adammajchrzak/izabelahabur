<div id="page-header-row" class="row">
    <div id="page-header" class="container">
        <div id="page-slogan">
            <h2>WELCOME TO MY PORTFOLIO</h2>
            <div><p>MY NAME IS IZA HABUR I AM STOCK PHOTOGRAPHER WORKING EXCLUSIVE FOR ISTOCKPHOTOS.COM AND GETTY IMAGES.  CHECK OUR PORTFOLIO TO SEE OUR WORK</p></div>
        </div>
    </div>
</div>
<div id="page-picture-row" class="row">
<div class="container">
	<div id="breadcrumbs">
		<a href="/{$router->getUrl($config->current_locale)}">{$locale.site.core.breadcrumb.item01}</a> /
		{foreach $breadcrumb as $item}
			<a href="/{$router->getUrl($config->current_locale,'index',$router->getItemCode($item.page_id,$config->current_locale),$item.page_id)}">{$item.node_title}</a> {if !$item@last}/{/if} 
		{/foreach}
	</div>
	<div id="content_header">
		<h1 class="font_hel_lt">{$parent_page.node_title}</h1>
	</div>
	<div id="content_area">
            <div id="side_area" class="col-lg-6">
			<div id="sidemenu"></div>
			<div id="side_text" itemscope itemtype="http://data-vocabulary.org/Organization">
				<div style="margin-top: 15px; font-weight: bold;" itemprop="name">Habur Images s.c.<br/>Izabela Habur, Bartłomiej Kuchalski</div>
				<br />
				<span itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
				<span itemprop="street-address">ul. Przemysłowa 51/5</span><br />
				<span itemprop="postal-code">61-541</span> <span itemprop="locality">Poznań</span><br />
				<br />
				tel.: <span itemprop="tel">+48 70 00 00 000</span><br />
				fax: +48 70 00 00 000<br />
				<a href="mailto:biuro@habur.com">biuro@habur.com</a>
				</span><br/><br/>
			</div>
		</div>
		<div class="col-lg-6">
			<form id="main_form" action="/pl/forms/send" class="form-horizontal">
				<div class="main_form_column">
                                    <div class="form-group">
					<label class="col-sm-2 control-label" for="firstname">{$locale.site.index.contact.form.label01}</label>
                                        <div class="col-sm-10">
                                        <input id="firstname" name="firstname" type="text" class="form-control" />
                                        </div>
                                    </div>    
                                    <div class="form-group">
					<label class="col-sm-2 control-label" for="lastname">{$locale.site.index.contact.form.label02}</label>
                                        <div class="col-sm-10">
                                            <input id="lastname" name="lastname" type="text" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
					<label class="col-sm-2 control-label" for="email">{$locale.site.index.contact.form.label03}</label>
                                        <div class="col-sm-10">
                                        <input id="email" name="email" type="text" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
					<label class="col-sm-2 control-label" for="phone">{$locale.site.index.contact.form.label04}</label>
                                        <div class="col-sm-10">
                                        <input id="phone" name="phone" type="text" class="form-control" />
                                        </div>
                                    </div>    
				</div>
				<div class="main_form_column">
					<label class="description" for="message">{$locale.site.index.contact.form.label05}</label>
                                        <textarea id="message" name="message" class="form-control"></textarea>
					<br />
					<input id="main_form_submit" type="submit" value="{$locale.site.index.contact.form.send}" />
				</div>
				<div id="thankyou">{$locale.site.index.contact.form.thx_message}</div>
			</form>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function () {
	
	// Launching validator main contact form
	$("#main_form").validate({
		errorPlacement: function(error, element) {
				error.insertBefore(element);
		},
		rules: {
			firstname: "required",
			lastname: "required",
			phone: {
				required: true,
				phonePL: true
			},
			email: {
				required: true,
				email: true
			},
			message: "required",
		},
		messages: {
			firstname: "{/literal}{$locale.site.index.contact.form.required}{literal}",
			lastname: "{/literal}{$locale.site.index.contact.form.required}{literal}",
			phone: {
				required: "{/literal}{$locale.site.index.contact.form.required}{literal}",
				phonePL: "{/literal}{$locale.site.index.contact.form.correct}{literal}"
			},
			email: {
				required: "{/literal}{$locale.site.index.contact.form.required}{literal}",
				email: "{/literal}{$locale.site.index.contact.form.correct}{literal}"
			},
			message: "{/literal}{$locale.site.index.contact.form.required}{literal}",
		},
		submitHandler: function() {
			$.ajax({
				url 	: '/pl/forms/send',
				global 	: false,
				type	: 'POST',
				data	: ({
					'contact-name' 		: $('#firstname').val() + ' ' + $('#lastname').val(),
					'contact-phone' 	: $('#phone').val(),
					'contact-email'		: $('#email').val(),
					'contact-message'	: $('#message').val()
				}),
				async	: false,
				success	: function(){
					_gaq.push(['_trackPageview', '/kontaktwyslany.html']);
					$("#main_form").children().hide(300);
					setTimeout(function(){$("#thankyou").show(300);},300)  
				}
			});
		}
	});
});	
	
</script>
{/literal}