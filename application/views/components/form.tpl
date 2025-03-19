<div class="m-3">
    <h3 class="text-nowrap">
        {if $is_new}
            Nuovo
        {elseif $readonly}
            Visualizza
        {else}
            Modifica
        {/if}
    </h3>

    {if validation_errors()}
        <div class="alert alert-danger" role="alert">
            {validation_errors()}
        </div>
    {/if}

    <div class="mt-3">
        {if !$readonly}
            {form_open()}
            {if !$is_new && isset($id)}
                <input type="hidden" name="id" value="{$id}" />
            {/if}
        {else}
            <div>
        {/if}
            {if !empty($fields)}
                {foreach $fields as $field}
                    {if !$field->primary_key || $readonly}
                        <div class="mb-3 row">
                            <label for="{$field->name}" class="col-sm-2 col-form-label">{$field->description}</label>
                            <div class="col-sm-8">
                                {if $field->input_type === 'select'}
                                    <select
                                        class="form-select"
                                        name="{$field->name}"
                                        id="{$field->name}"
                                        required
                                        {if $readonly}disabled{/if}
                                    >
                                        {foreach $field->options as $option}
                                            <option
                                                value="{$option.value}"
                                                {if isset($data[$field->name]) && $data[$field->name] == $option.value}selected{/if}
                                            >
                                                {$option.label}
                                            </option>
                                        {foreachelse}
                                            {if !empty($field->option_if_empty)}
                                                <option value="{$field->option_if_empty.value}" selected disabled>{$field->option_if_empty.label}</option>
                                            {/if}
                                        {/foreach}
                                    </select>
                                {else}
                                    <input
                                        type="{$field->input_type}"
                                        class="form-control"
                                        name="{$field->name}"
                                        id="{$field->name}"
                                        value="{$data[$field->name]|default:''}"
                                        {if $field->max_length > 0}
                                            maxlength="{$field->max_length}"
                                        {/if}
                                        {if $field->name === 'cap'}
                                            max="99999"
                                        {/if}
                                        required
                                        {if $readonly}readonly disabled{/if}
                                    />
                                {/if}
                            </div>
                        </div>
                    {/if}
                {/foreach}

                <div class="col-auto">
                    {if !$readonly}
                        <button type="submit" class="btn btn-primary text-nowrap">{($is_new) ? 'Salva' : 'Aggiorna'}</button>
                    {/if}
                    
                    <a
                        href="{$url}"
                        class="btn btn-light text-nowrap"
                        tabindex="-1"
                        role="button"
                    >
                        Annulla
                    </a>
                </div>
            {/if}
        {if !$readonly}
            {form_close()}
        {else}
            </div>
        {/if}
    </div>
</div>
