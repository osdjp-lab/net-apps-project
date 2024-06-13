{extends file="main.tpl"}

{block name=bottom}

<div class="bottom-margin">
<a class="pure-button button-success" href="{$conf->action_root}treeNew">+ Add tree</a>
</div>	

<table id="tab_trees" class="pure-table pure-table-bordered">
<thead>
	<tr>
		<th>Name</th>
		<th>Family</th>
		<th>Options</th>
	</tr>
</thead>
<tbody>
{foreach $trees as $p}
{strip}
	<tr>
		<td>{$p["name"]}</td>
		<td>{$p["family"]}</td>
		<td>
			<a class="button-small pure-button button-secondary" href="{$conf->action_url}treeEdit&id={$p['idtree']}">Edit</a>
			&nbsp;
			<a class="button-small pure-button button-warning" href="{$conf->action_url}treeDelete&id={$p['idtree']}">Remove</a>
		</td>
	</tr>
{/strip}
{/foreach}
</tbody>
</table>

{/block}
