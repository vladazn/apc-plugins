{extends file="parent:frontend/register/index.tpl"}
{block name='frontend_register_index_form_submit'}
    {* Submit button *}
    <div class="register--action">
        <button type="submit" class="register--submit btn is--primary is--large is--icon-right" name="Submit" disabled>{s name="RegisterIndexNewActionSubmit"}{/s} <i class="icon--arrow-right"></i></button>
    </div>
{/block}
