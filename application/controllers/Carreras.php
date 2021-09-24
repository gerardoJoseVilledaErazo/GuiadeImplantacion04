<?php

defined('BASEPATH') or exit('No direct script access allowed');

class carreras extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index()
    {
        $this->load->model('Carrera_model');
        $data = array(
            "records" => $this->Carrera_model->getAll(),
            "title" => "Carreras"
        );
        $this->load->view("shared/header", $data);
        $this->load->view("carreras/index", $data);
        $this->load->view("shared/footer", $data);
    }

    public function insertar()
    {
        $this->load->model('Carrera_model');
        $data = array(
            "carreras" => $this->Carrera_model->getAll(),
            "title" => "Insertar carrera"
        );
        $this->load->view("shared/header", $data);
        $this->load->view("carreras/add_edit", $data);
        $this->load->view("shared/footer", $data);
    }

    public function modificar($id)
    {
        $this->load->model('Carrera_model');
        $carrera = $this->Carrera_model->getById($id);
        $data = array(
            "carreras" => $this->Carrera_model->getAll(),
            "carrera" => $carrera,
            "title" => "Modificar carrera",
        );
        $this->load->view("shared/header", $data);
        $this->load->view("carreras/add_edit", $data);
        $this->load->view("shared/footer");
    }

    public function add()
    {
        $this->load->model('Carrera_model');
        $data = array(
            "idcarrera" => $this->input->post("idcarrera"),
            "carrera" => $this->input->post("carrera"),
        );
        $rows = $this->Carrera_model->insert($data);
        if ($rows > 0) {
            $this->session->set_flashdata('success', "Información guardada correctamente.");
        } else {
            $this->session->set_flashdata('error', "No se guardó la información.");
        }
        redirect("carreras/insertar");
    }

    public function update()
    {
        $this->load->model('Carrera_model');
        $data = array(
            "idcarrera" => $this->input->post("idcarrera"),
            "carrera" => $this->input->post("carrera"),
        );
        try {
            $rows = $this->Carrera_model->update($data, $data["idcarrera"]);
            $this->session->set_flashdata('success', "Información modificada correctamente.");
        } catch (Exception $e) {
            $this->session->set_flashdata('error', "No se guardó la información.");
        } finally {
            redirect("carreras/modificar/" . $data["idcarrera"]);
        }
    }

    public function eliminar($id)
    {
        $this->load->model('Carrera_model');
        $result = $this->Carrera_model->delete($id);
        if ($result) {
            $this->session->set_flashdata('success', "Registro borrado correctamente.");
        } else {
            $this->session->set_flashdata('error', "No se pudo borrar el registro.");
        }
        redirect("carreras");
    }
}
?>