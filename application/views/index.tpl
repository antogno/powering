<div class="m-3">
    <h1>
        <a href="{$url|default:'#'}" style="all: unset; cursor: pointer;">{$title}</a>
    </h1>

    {if !empty($commands)}
        <ul class="nav nav-tabs nav-fill">
            {foreach $commands as $command}
                <li class="nav-item">
                    <a
                        class="nav-link {if $command.is_active}active{/if} {if $command.is_disabled}disabled{/if}"
                        {if $command.is_active}
                            aria-current="page"
                        {/if}
                        href="{if !$command.is_upload_command}{$command.url|default:'#'}{else}#{/if}"
                        {if $command.new_page}target="_blank"{/if}
                        {if $command.is_upload_command}
                            data-bs-toggle="modal"
                            data-bs-target="#modal_upload"
                            data-url="{$command.url}"
                            data-is-post-request="true"
                        {/if}
                    >
                        {if $command.icon_class}
                            <i class="{$command.icon_class}"></i>
                        {/if}
                        {$command.label}
                    </a>
                </li>
            {/foreach}
        </ul>

        {include
            file="./components/modal.tpl"
            class="primary"
            id="modal_upload"
            title=$upload_text
            button_text="Carica"
            fields=$upload_fields
        }

    {/if}

    {if isset($form)}
        {include
            file="./components/form.tpl"
            is_new=$form.is_new
            readonly=$form.readonly
            fields=$form.fields
            data=$form.data
        }
    {/if}

    {include
        file="./components/table.tpl"
        columns=$columns
        rows=$rows
        commands=$table_commands
    }
</div>
