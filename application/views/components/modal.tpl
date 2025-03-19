<div class="modal fade" id="{$id}" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal_title">{$title}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modal_button_alert" class="alert alert-success" role="alert" style="display: none;"></div>
                <div>
                    {$body|default:''}
                </div>
                {if isset($fields) && !empty($fields)}
                    <form id="modal_form">
                        {foreach $fields as $field}
                            <div class="mb-3">
                                <label for="{$field.name}" class="form-label">{$field.label}</label>
                                <input
                                    type="{$field.type}"
                                    class="form-control"
                                    id="{$field.name}"
                                    name="{$field.name}"
                                    placeholder="{$field.placeholder|default:''}"
                                />

                                {if isset($field.description) && !empty($field.description)}
                                    <small class="form-text text-muted">{$field.description}</small>
                                {/if}
                            </div>
                        {/foreach}
                    </form>
                {/if}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                <a
                    onclick="handleClick(this);"
                    class="btn btn-{$class|default:'primary'}"
                    tabindex="-1"
                    role="button"
                    id="modal_execute_button"
                >
                    <span id="modal_button_spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                    {$button_text}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    var url = '';
    var isPostRequest = false;

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('{$id}').addEventListener('show.bs.modal', function(e) {
            url = e.relatedTarget.getAttribute('data-url');
            isPostRequest = e.relatedTarget.getAttribute('data-is-post-request') === 'true';
        });

        var form = document.getElementById('modal_form');
        if (typeof(form) != 'undefined' && form != null) {
            form.addEventListener('submit', (e) => { e.preventDefault(); handleClick(document.getElementById('modal_execute_button')); });
        }
    });
    

    function handleClick(el) {
        if (url.length > 0) {
            if (!isPostRequest) {
                window.location.href = url;
                return;
            }

            beforeSend(el);

            // Il timeout serve esclusivamente a migliorare l'esperienza utente,
            // in quanto se la richiesta venisse inviata immediatamente si potrebbe
            // pensare che sia stato troppo veloce per poter aver funzionato correttamente
            setTimeout(function () {
                var xhttp = new XMLHttpRequest();
                
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        afterSend(el, this.status, this.responseText);
                    }
                };

                xhttp.open('POST', url, true);
                xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');  
                
                xhttp.send(getParamsString());
            }, 500);
        }
    }

    function beforeSend(el) {
        el.disabled = true;
        el.classList.add('disabled');

        var alert = document.getElementById('modal_button_alert');

        alert.style.display = 'none';
        alert.innerText = '';

        document.getElementById('modal_button_spinner').style.display = '';
    }

    function afterSend(el, status, responseText) {
        el.disabled = false;
        el.classList.remove('disabled');

        var alert = document.getElementById('modal_button_alert');

        alert.style.display = '';

        if (status == 200) {
            alert.classList.remove('alert-danger');
            alert.classList.add('alert-success');
        } else {
            alert.classList.remove('alert-success');
            alert.classList.add('alert-danger');
        }

        jsonResponse = JSON.parse(responseText);

        alert.innerText = jsonResponse.message;
        
        document.getElementById('modal_button_spinner').style.display = 'none';
    }

    function getParamsString() {
        var fields = document
            .querySelector('#modal_form')
            .querySelectorAll('input, select');

        var paramsString = '';
        fields.forEach((v, i) => {
            paramsString += v.getAttribute('name') + '=' + v.value;
        });

        return paramsString;
    }
</script>