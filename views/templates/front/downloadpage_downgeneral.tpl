<div class ="col-md-12">
	<h3>{l s='Documents généraux' mod='downloadpage'}</h3>
	{if !empty($downloads)}
		<!-- LISTE DOWNLOAD -->
		<table  class="table">
			<thead>
				<tr>
					<th>{l s='Fichier' mod='downloadpage'}</th>
					<th>{l s='Description' mod='downloadpage'}</th>
					<th>{l s='Format du fichier' mod='downloadpage'}</th>
					<th>{l s='Date d\'ajout' mod='downloadpage'}</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$downloads item=download}
					<tr>
						<td><b><a href="{$content_dir}modules/downloadpage/upload/{$download['url']}" download="{$download['url']}">{$download['nom_fichier']|escape:'html':'UTF-8'}</a></b></td>
						<td>{$download['description']|escape:'html':'UTF-8'}</td>
						<td>{if $download['type_fichier'] == 'image/png'}
							<img src="{$content_dir}modules/downloadpage/img/png.jpg" />
							{else if $download['type_fichier'] == 'application/pdf'}
							<img src="{$content_dir}modules/downloadpage/img/pdf.jpg" />
							{else}
							<img src="{$content_dir}modules/downloadpage/img/jpeg.jpg" />
							{/if}
						</td>
						<td>{$download['date_add']|date_format:'%d/%m/%Y'}</td>

					</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		<p>{l s='Il n\'y a aucun téléchargement disponible' mod='downloadpage'}</p>
	{/if}
</div>