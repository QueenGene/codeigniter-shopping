<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Todos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Makes a link to the model so that we can use it
        $this->load->model('Todo');
        // Needed to be called for re-directions and load_views
        $this->load->helper('url');
    }

    public function index() {
//title/meta helps with SEO - use this
        $this->load->library('template');
        $this->template->set_title('List');
        $this->template->set_title_desc('A list of todos');
        $this->template->add_meta('description', 'This is a pretty sweet list of todos.');
        $this->template->add_meta('keywords', 'todos, list');
//        $this->template->add_js('assets/themes/default/js/main.js');
//        $this->template->add_js('assets/themes/default/js/main.js');
//        $this->template->add_css('assets/themes/default/css/main.css');
//        $data['my_random_variable'] = 'I am random';
//        $this->template->load_view('pages/list', $data);

        // Manual Database that we created
//        $todos = [[1, 'Fix time-machine', 'done'], [2, 'Pet the unicorn', 'done']];

        // Now that we've linked to the model, we can now create a query to access from the db
        $query = $this->Todo->db->query('SELECT * FROM todos');
        
        $data ['todos'] = $query->result();

        // Loads the page
        $this->template->load_view('pages/list', $data);
    }

    public function add_edit($id = null) {
        $this->load->library('template');
        // Loads form validation library
        $this->load->library('form_validation');

        $this->template->set_title('Add/Edit');
        $this->template->set_title_desc('Add or Edit todos');
        $this->template->add_meta('description', 'This is where you add or edit todos.');
        $this->template->add_meta('keywords', 'todos,add, edit');

        // Now that we've linked to the model, we can now create a query to access from the db
        $query = $this->Todo->db->query('SELECT * FROM todos');

        $data ['todos'] = $query->result();

        $todo = null;

        // If there is something in the post then
        if ($this->input->post()) {

            // Sets the validaiton rules
            $this->form_validation->set_rules(array(
                array(
                    // Links with the name in the form so it knows what form it's talking to
                    'field' => 'title',
                    // This is put in place of the 'Title' in the codeigniter message
                    'label' => '\'Add/Edit\'',
                    // What rules do you want it to follow
                    'rules' => 'required'
                )
            ));

            // Check to see if form validates
            if($this->form_validation->run()) {

                // create an array of data that can be added/edited to the db
                $data = array(
                    // Gets the title from the post
                    'title' => $this->input->post('title')
                );

                // if there is no ID set then...
                if (!$id) { // Add a job
                    // inserts the data into the db
                    $this->Todo->db->insert('todos', $data);
                    // Enables 'success' flashdata
                    $this->session->set_flashdata('success', 'Job successfully added');

                // if there is an ID set then...
                } else { // Edit a job
                    // locates the row that you're editing by matching the id
                    $this->Todo->db->where('id', $id);
                    // enables user to update the relative table
                    $this->Todo->db->update('todos', $data);
                    // Enables 'success' flashdata
                    $this->session->set_flashdata('success', 'Job successfully edited');
                }

                // redirects user to the lists page
                redirect('#', 'refresh');

            } else { // if the form doesn't validate - using the set rules above
                // Creates a new model so that we can show a title with no value
                $todo = new Todo();
                // Gives the title a value of the already existing 'title' in the form
                $todo->title = $this->input->post('title');
            }

        } else {
            if (!$id) { // Coming to the page to add data
                // Creates a new model so that we can show a title with no value
                $todo = new Todo();
                // Gives the title a value of nothing (to be shown in the add/edit input when there is nothing to be edited)
                $todo->title = '';
            } else { // Coming to the page to edit data
                // Get Todos db (to show in the value of input)
                $query = $this->Todo->db->get_where('todos', array('id' => $id), 1);
                $todo = $query->row();
            }
        }

        // Sets the data and loads the page using the data
        $data['todo'] = $todo;
        $this->template->load_view('pages/add_edit', $data);
    }

    public function delete($id = 'id') {
        // If it can Find the row from the id then...
        if($this->Todo->db->delete('todos', array('id' => $id))){ // ...use the codeigniter session object to display the success message if the id is found
            $this->session->set_flashdata('success', 'Job successfully deleted');
        } else { // if it can't find the id then use the codeigniter session object to display the error message
            $this->session->set_flashdata('error', 'The job could not be deleted. Please refresh and try again.');
        }

        // redirects user to the lists page
        redirect('#', 'refresh');
    }

}
