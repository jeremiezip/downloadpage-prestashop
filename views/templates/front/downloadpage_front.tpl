<!-- @TODO : récuperer le bon lien réécrit -->
{capture name=path}<a href="{$link->getModuleLink('downloadpage', 'display')|escape:'html':'UTF-8'}">{l s='Téléchargements généraux' mod='downloadpage'}</a>{/capture}

{include file='./downloadpage_downgeneral.tpl'}

<div class="col-md-12">
	<h3>{l s='Documents, manuels et photos produits' mod='downloadpage'}</h3>

	<select id="select_download_product">
		<option>{l s='Sélection référence' mod='downloadpage'}</option>
		{foreach from=$products item=product}

		<option value="{$product['id_product']}">{$product['reference']}</option>
		{/foreach}
	</select>
</div>
{include file='./downloadpage_product.tpl'}

<!-- link de la page -->
<input type="hidden" id="downloadpage_link" value="{$link->getModuleLink('downloadpage', 'display')|escape:'html':'UTF-8'}">

