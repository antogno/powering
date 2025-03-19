<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/AF_Api_Controller.php';

class Automezzo extends AF_Api_Controller
{
  protected const MODEL = 'Automezzo_model';
  protected const UPLOAD_URL = 'https://edoo.poweringsrl.it/exercises/Automezzo/upload.json';
}
