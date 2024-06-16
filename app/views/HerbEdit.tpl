{extends file="main.tpl"}

{block name=top}

<div class="bottom-margin">
<form action="{$conf->action_root}herbSave" method="post" class="pure-form pure-form-aligned">
	<fieldset>
		<legend>User data</legend>
		<div class="pure-control-group">
            <label for="name">Name</label>
            <input id="name" type="text" placeholder="Name" name="name" value="{$form->name}">
        </div>
		
        <div class="pure-control-group">
            <label for="family">Family</label>
            <input id="family" type="text" placeholder="Family" name="family" value="{$form->family}">
        </div>
        
		<div class="pure-controls">
			<input type="submit" class="pure-button pure-button-primary" value="Save"/>
			<a class="pure-button button-secondary" href="{$conf->action_root}herbList">Return to herb list</a>
		</div>
	</fieldset>
    <input type="hidden" name="id" value="{$form->id}">
</form>	
</div>

{/block}
