<div class="with-padding">
<form id="form-edit-user" name="form-edit-user" method="post" action="/{$router->getUrl('cms', 'user', 'edit')}">
	
	<h2 class="thin float-left">Edycja użytkownika</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/{$router->getUrl('cms#','cms','user')}';" class="button glossy button-cancel-text"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>

	<input type="hidden" id="user_id" name="user_id" value="{$user_details.user_id}" />
	
	<h3 class="thin underline clear-both">Dane podstawowe</h3>	
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Login</label>
			<input type="text" id="user_login" name="user_login" value="{$user_details.user_login}" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Hasło</label>
			<input type="password" id="user_passwd" name="user_passwd" value="" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Imię</label>
			<input type="text" id="user_firstname" name="user_firstname" value="{$user_details.user_firstname}" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Nazwisko</label>
			<input type="text" id="user_lastname" name="user_lastname" value="{$user_details.user_lastname}" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Adres e-mail</label>
			<input type="text" id="user_email" name="user_email" value="{$user_details.user_email}" class="input full-width" />
		</p>
	</fieldset>
		
	<h3 class="thin underline">Ustawienia zaawansowane</h3>	
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Użytkownik aktywny</label>
			<input id="user_active" name="user_active" type="checkbox" value="1"{if $user_details.user_active == '1'} checked="checked"{/if} class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Rola</label>
			<select id="role_id" name="role_id" class="select check-list">
				<option value="2"{if $user_details.role_id == '2'} selected="selected"{/if}>administrator strony</option>
			</select>
		</p>
	</fieldset>

</form>
</div>