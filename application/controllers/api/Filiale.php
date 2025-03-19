<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/AF_Api_Controller.php';

class Filiale extends AF_Api_Controller
{
  protected const MODEL = 'Filiale_model';
  protected const UPLOAD_URL = 'https://edoo.poweringsrl.it/exercises/Filiale/upload.json';
}
