{extends file="helpers/form/form.tpl"}
{block name="input"}

	<!-- CHAMPS URL ET TYPE FICHIER EN HIDDEN POUR METTRE UNE VALUE SI YEN A DEJA UNE DE RENTREE -->
	{if $input.name =='url'}
			<input id="{$input.name}" type="hidden" name="{$input.name}" {if isset($fields_value[$input.name])}value="{$fields_value[$input.name]}"{/if}>
	 		{if !empty($fields_value[$input.name])}
				<p>{l s='Un fichier a déjà été uploadé :' mod='downloadpage'} {$fields_value[$input.name]}</p>
			{/if}

	{else if $input.type == 'file_lang'}
		<div class="col-lg-12">

				<div class="form-group">
					<div class="col-lg-6">
							<input id="{$input.name}" type="file" name="{$input.name}" class="hide" />
						<div class="dummyfile input-group">
							<span class="input-group-addon"><i class="icon-file"></i></span>
							<input id="{$input.name}-name" type="text" class="disabled" name="filename" readonly />
							<span class="input-group-btn">
								<button id="{$input.name}-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
									<i class="icon-folder-open"></i> {l s='Choose a file' mod='blockbanner'}
								</button>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					{if isset($fields_value[$input.name]) && $fields_value[$input.name] != ''}
					<div id="{$input.name}-images-thumbnails" class="col-lg-12">
						<img src="{$uri}img/{$fields_value[$input.name]}" class="img-thumbnail"/>
					</div>
					{/if}
				</div>

		</div>
			<script>
				$(document).ready(function(){
					$('#{$input.name}-selectbutton').click(function(e){
						$('#{$input.name}').trigger('click');
					});
					$('#{$input.name}').change(function(e){
						var val = $(this).val();
						var file = val.split(/[\\/]/);
						$('#{$input.name}-name').val(file[file.length-1]);
					});
				});
			</script>
	{else}
		{$smarty.block.parent}
	{/if}
{/block}
