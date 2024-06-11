{extends file="main.tpl"}

{block name=top}

<div class="bottom-margin">
<form class="pure-form pure-form-stacked" action="{$conf->action_url}personList">
	<legend>Search options</legend>
	<fieldset>
		<input type="text" placeholder="Username" name="sf_username" value="{$searchForm->username}" /><br />
		<button type="submit" class="pure-button pure-button-primary">Filter</button>
	</fieldset>
</form>
</div>	

{/block}

{block name=bottom}

<div class="bottom-margin">
<a class="pure-button button-success" href="{$conf->action_root}personNew">+ Add user</a>
</div>	

<table id="tab_people" class="pure-table pure-table-bordered">
<thead>
	<tr>
		<th>Username</th>
		<th>User access</th>
		<th>Tree access</th>
		<th>Herb access</th>
		<th>Options</th>
	</tr>
</thead>
<tbody>
{foreach $people as $p}
{strip}
	<tr>
		<td>{$p["username"]}</td>
		<td>{$p["user_access"]}</td>
		<td>{$p["tree_access"]}</td>
		<td>{$p["herb_access"]}</td>
		<td>
			<a class="button-small pure-button button-secondary" href="{$conf->action_url}personEdit&id={$p['idperson']}">Edit</a>
			&nbsp;
			<a class="button-small pure-button button-warning" href="{$conf->action_url}personDelete&id={$p['idperson']}">Remove</a>
		</td>
	</tr>
{/strip}
{/foreach}
</tbody>
</table>

{/block}
