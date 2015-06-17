<div id="rg-gallery" class="rg-gallery">
	<div class="rg-thumbs">
		<div class="es-carousel-wrapper">
			<div class="es-nav">
				<span class="es-nav-prev">Poprzednie</span>
				<span class="es-nav-next">Następne</span>
			</div>
			<div class="es-carousel">
				<ul>
				{foreach $picture_list as $tree}	
					<li><a href="#"><img src="{$tree.file_dir}/small/{$tree.file_name}" data-large="{$tree.file_dir}/big/{$tree.file_name}" alt="image01" /></a></li>
				{/foreach}
				</ul>
			</div>
		</div>
	</div>
</div>