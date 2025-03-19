<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AF_Controller extends CI_Controller
{
  protected const TITLE = '';
  protected const MODEL = '';
  protected const UPLOAD_URL = '';

  protected $delete_text = '';
  protected $rules = [];

  public function __construct()
  {
    parent::__construct();

    $this->load->model(static::MODEL);
  }

  public function index()
  {
    $this->displayIndexPage();
  }

  public function view()
  {
    $id = $this->input->get('id');

    if (
      !$id
      || $this->{static::MODEL}->get($id) === false
    ) {
      redirect('/' . $this->router->fetch_class());
    }

    $this->displayIndexPage(true, true);
  }

  public function new()
  {
    $this->displayIndexPage(true);
  }

  public function edit()
  {
    $this->displayIndexPage(true);
  }

  public function delete()
  {
    $id = $this->input->get('id');

    if (
      !$id
      || $this->{static::MODEL}->get($id) === false
    ) {
      redirect('/' . $this->router->fetch_class());
    }

    $this->{static::MODEL}->delete($id);

    redirect('/' . $this->router->fetch_class());
  }

  protected function displayPage($template, $vars = [])
  {
    $this->smarty->assign('app_name', APPNAME);

    $this->displayHead();
    $this->displayNavbar();
    $this->display($template, $vars);
    $this->displayFooter();
  }

  protected function display($template, $vars = [])
  {
    foreach ($vars as $name => $value) {
      $this->smarty->assign($name, $value);
    }

    $this->smarty->display($template);
  }

  private function displayHead()
  {
    $this->smarty->display('layouts/head.tpl');
  }

  private function displayFooter()
  {
    $this->smarty->display('layouts/footer.tpl');
  }

  private function displayNavbar()
  {
    $links = [
      [
        'url' => '/automezzo',
        'label' => 'Automezzi',
        'is_current' => false,
        'icon_class' => 'fa-solid fa-truck-moving'
      ],
      [
        'url' => '/filiale',
        'label' => 'Filali',
        'is_current' => false,
        'icon_class' => 'fa-solid fa-building'
      ]
    ];

    $class = $this->router->fetch_class();

    foreach ($links as &$link) {
      if (strpos($link['url'], '/' . $class) === 0) {
        $link['is_current'] = true;
        break;
      }
    }

    $this->smarty->assign('links', $links);

    $this->smarty->display('components/navbar.tpl');
  }

  private function displayIndexPage($display_form = false, $readonly = false)
  {
    $class = $this->router->fetch_class();
    $method = $this->router->fetch_method();

    $id = $this->input->get('id') ?? $this->input->post('id');

    $commands = [
      [
        'url' => '/' . $class . '/new',
        'new_page' => false,
        'label' => 'Nuovo',
        'is_active' => $method === 'new',
        'is_disabled' => false,
        'is_upload_command' => false,
        'icon_class' => 'fa-solid fa-plus'
      ],
      [
        'url' => '/api/' . $class,
        'new_page' => true,
        'label' => 'Ottieni JSON',
        'is_active' => false,
        'is_disabled' => false,
        'is_upload_command' => false,
        'icon_class' => 'fa-solid fa-code'
      ],
      [
        'url' => '/api/' . $class . '/upload',
        'new_page' => false,
        'label' => !empty(static::UPLOAD_URL) ? 'Carica su ' . parse_url(static::UPLOAD_URL)['host'] : 'Carica',
        'is_active' => false,
        'is_disabled' => empty(static::UPLOAD_URL),
        'is_upload_command' => true,
        'icon_class' => 'fa-solid fa-upload'
      ]
    ];

    $table_commands = [
      [
        'url' => '/' . $class . '/view',
        'label' => 'Visualizza',
        'is_delete' => false,
        'is_edit' => false,
        'icon_class' => 'fa-solid fa-eye'
      ],
      [
        'url' => '/' . $class . '/edit',
        'label' => 'Modifica',
        'is_delete' => false,
        'is_edit' => true,
        'icon_class' => 'fa-solid fa-pen-to-square'
      ],
      [
        'url' => '/' . $class . '/delete',
        'label' => 'Elimina',
        'is_delete' => true,
        'is_edit' => false,
        'icon_class' => 'fa-solid fa-trash'
      ],
    ];

    $upload_url = base_url() . 'api/' . $class . '/upload';

    $vars = [
      'title' => static::TITLE,
      'url' => '/' . $class,
      'columns' => $this->{static::MODEL}->getColumns(),
      'rows' => $this->{static::MODEL}->getRows(),
      'commands' => $commands,
      'table_commands' => $table_commands,
      'id' => $id,
      'delete_text' => $this->delete_text,
      'upload_text' => 'Carica ' . strtolower(static::TITLE),
      'upload_fields' => [
        [
          'type' => 'email',
          'label' => 'Email',
          'name' => 'email',
          'placeholder' => 'mario.rossi@esempio.it',
          'description' => 'Il caricamento viene effettuato attraverso <a href="' . $upload_url . '">' . $upload_url . '</a>'
        ]
      ]
    ];

    if ($display_form) {
      $vars['form'] = [
        'is_new' => $method === 'new',
        'readonly' => boolval($readonly),
        'fields' => $this->{static::MODEL}->getColumns(),
        'data' => []
      ];

      if ($id) {
        $vars['form']['data'] = $this->{static::MODEL}->get($id);
      }
    }

    $this->displayPage('index.tpl', $vars);
  }
}
