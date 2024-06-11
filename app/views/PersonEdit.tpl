{extends file="main.tpl"}

{block name=top}

<div class="bottom-margin">
<form action="{$conf->action_root}personSave" method="post" class="pure-form pure-form-aligned">
	<fieldset>
		<legend>User data</legend>
		<div class="pure-control-group">
            <label for="username">Username</label>
            <input id="username" type="text" placeholder="Nazwa użytkownika" name="username" value="{$form->username}">
        </div>
		
        <div class="pure-control-group">
            <label for="password">Password</label>
            <input id="password" type="text" placeholder="Password" name="password" value="{$form->password}">
        </div>
        
        <div class="pure-control-group">
            <label for="user_access">User access</label>
            <input id="user_access" type="text" placeholder="User access" name="user_access" value="{$form->user_access}">
        </div>
        
        <div class="pure-control-group">
            <label for="tree_access">Tree access</label>
            <input id="tree_access" type="text" placeholder="Tree access" name="tree_access" value="{$form->tree_access}">
        </div>
        
        <div class="pure-control-group">
            <label for="herb_access">Herb access</label>
            <input id="herb_access" type="text" placeholder="Herb access" name="herb_access" value="{$form->herb_access}">
        </div>

		<div class="pure-controls">
			<input type="submit" class="pure-button pure-button-primary" value="Save"/>
			<a class="pure-button button-secondary" href="{$conf->action_root}personList">Return to userlist</a>
		</div>
	</fieldset>
    <input type="hidden" name="id" value="{$form->id}">
</form>	
</div>

{/block}
