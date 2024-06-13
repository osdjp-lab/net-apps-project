{extends file="main.tpl"}

{block name=bottom}

<div class="bottom-margin">
<a class="pure-button button-success" href="{$conf->action_root}herbNew">+ Add herb</a>
</div>	

<table id="tab_people" class="pure-table pure-table-bordered">
<thead>
	<tr>
		<th>Name</th>
        <th>Family</th>
		<th>Options</th>
	</tr>
</thead>
<tbody>
{foreach $herbs as $p}
{strip}
	<tr>
		<td>{$p["name"]}</td>
		<td>{$p["family"]}</td>
		<td>
			<a class="button-small pure-button button-secondary" href="{$conf->action_url}herbEdit&id={$p['idherb']}">Edit</a>
			&nbsp;
			<a class="button-small pure-button button-warning" href="{$conf->action_url}herbDelete&id={$p['idherb']}">Remove</a>
		</td>
	</tr>
{/strip}
{/foreach}
</tbody>
</table>

{/block}
