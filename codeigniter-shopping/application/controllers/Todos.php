<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Todos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Makes a link to the models so that we can use it
        $this->load->model('Customers');
        $this->load->model('Products');
        $this->load->model('Cart');
        $this->load->model('Checkout');
        // Needed to be called for re-directions and load_views
        $this->load->helper('url');
    }

    public function index() {
        // Meta helps with SEO
        $this->load->library('template');
        $this->template->set_title('Home');
        $this->template->set_title_desc('Shopping goodness');
        $this->template->add_meta('description', 'Shopping Goodness at its goodness of goodness');
        $this->template->add_meta('keywords', 'shopping, goodness');
//        $this->template->add_js('assets/themes/default/js/main.js');
//        $this->template->add_js('assets/themes/default/js/main.js');
//        $this->template->add_css('assets/themes/default/css/main.css');
//        $data['my_random_variable'] = 'I am random';
//        $this->template->load_view('pages/list', $data);

        // Loads the page
        $this->template->load_view('pages/home');
    }

}