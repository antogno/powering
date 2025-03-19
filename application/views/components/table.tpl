<div class="table-responsive">
    <table class="table">
        {if !empty($columns)}
            <thead>
                <tr>
                    {foreach $columns as $column}
                        <th scope="col">{$column->description}</th>
                    {/foreach}
                    {if !empty($commands)}
                        {for $i = 0; $i < count($commands); $i++}
                            <th></th>
                        {/for}
                    {/if}
                </tr>
            </thead>
        {/if}
        
        <tbody>
            {foreach $rows as $row}
                <tr {if $row.codice == $id}class="table-primary"{/if}>
                    {foreach $row as $field => $value}
                        <td>{$value}</td>
                    {/foreach}
                    {if !empty($commands)}
                        {foreach $commands as $command}
                            <td>
                                <a
                                    href="{if !$command.is_delete}{$command.url}?id={$row.codice}{else}#{/if}"
                                    class="btn btn-sm {if $command.is_delete}btn btn-danger{else}btn-outline-primary{/if}"
                                    title="{$command.label}"
                                    {if $command.is_delete}
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal_delete"
                                        data-url="{$command.url}?id={$row.codice}"
                                    {/if}
                                >
                                    <i class="{$command.icon_class}"></i>
                                </a>
                            </td>
                        {/foreach}
                    {/if}
                </tr>
            {foreachelse}
                <tr>
                    <td colspan="{count($columns) + count($commands)}">Non ci sono risultati.</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>

{include
    file="./modal.tpl"
    class="danger"
    id="modal_delete"
    title="Elimina"
    body=$delete_text
    button_text="Elimina"
}
