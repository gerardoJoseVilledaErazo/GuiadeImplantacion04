<?php
defined('BASEPATH') or exit('No direct script access allowed');
//class EstudiantesController extends CI_Controller
class Estudiantes extends CI_Controller
{
    //Metodo magico
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    //// FUNCIONES QUE CARGAN VISTAS ////
    public function index()
    {        
        $this->load->model('Estudiante_model');
        $data = array(
            "records" => $this->Estudiante_model->getAll(),
            "title" => "Estudiantes",//
        );
        //$data["titulo"] = "GUÍA 4 - ACCESO A DATOS";
        $this->load->view("shared/header", $data);//
        $this->load->view("estudiantes/index", $data);//
        $this->load->view("shared/footer", $data);//
    }

    public function insertar()
    {
    $this->load->model('Carrera_model');
        $data = array(
            "carreras" => $this->Carrera_model->getAll(),
            //"estudiantes" => $this->Estudiante_model->getAll(),
            "title" => "Insertar estudiante"
        );
        $this->load->view("shared/header", $data);//
        $this->load->view("estudiantes/add_edit", $data);//
        $this->load->view("shared/footer");//
    }

    public function modificar($id)
    {
        $this->load->model('Carrera_model');
        $this->load->model('Estudiante_model');
        $estudiante = $this->Estudiante_model->getById($id);
        $data = array(
            "carreras" => $this->Carrera_model->getAll(),
            "estudiante" => $estudiante,
            "title" => "Modificar estudiante",
        );
        $this->load->view("shared/header", $data);
        $this->load->view("estudiantes/add_edit", $data);
        $this->load->view("shared/footer", $data);
    }
    /// FIN FUNCIONES QUE CARGAN VISTA ///

    //=====================================

    // FUNCIONES QUE REALIZAN OPERACIONES
    public function add()
    {/*
        if ($this->input->post()) {
        }*/
        $this->load->model('Estudiante_model');
        $data = array(
            "idestudiante" => $this->input->post("idestudiante"),
            "nombre" => $this->input->post("nombre"),
            "apellido" => $this->input->post("apellido"),
            "email" => $this->input->post("email"),
            "usuario" => $this->input->post("usuario"),
            "idcarrera" => $this->input->post("idcarrera")
        );
        $rows = $this->Estudiante_model->insert($data);
        if ($rows > 0) {
            $this->session->set_flashdata('success', "Información guardada correctamente.");
        } else {
            $this->session->set_flashdata('error', "No se guardó la información.");
        }
        redirect("estudiantes/insertar");
    }

    public function update()
    {
        $this->load->model('Estudiante_model');
        $data = array(
            "idestudiante" => $this->input->post("idestudiante"),
            "nombre" => $this->input->post("nombre"),
            "apellido" => $this->input->post("apellido"),
            "email" => $this->input->post("email"),
            "usuario" => $this->input->post("usuario"),
            "idcarrera" => $this->input->post("idcarrera"),
        );
        try {
            $rows = $this->Estudiante_model->update($data, $data["idestudiante"]);
            $this->session->set_flashdata('success', "Información modificada correctamente.");
        } catch (Exception $e) {
            $this->session->set_flashdata('error', "No se guardó la información.");
        } finally {
            redirect("estudiantes/modificar/" . $data["idestudiante"]);
        } 
    }

    public function eliminar($id)
    {
        $this->load->model('Estudiante_model');
        $result = $this->Estudiante_model->delete($id);
        if ($result) {
            $this->session->set_flashdata('success', "Registro borrado correctamente.");
        } else {
            $this->session->set_flashdata('error', "No se pudo borrar el registro.");
        }
        //redirect("estudiantesController");
        redirect("estudiantes");
    }/*
    public function modificar($id)
    {
        $this->load->model('Carrera_model');
        $this->load->model('Estudiante_model');
        $estudiante = $this->Estudiante_model->getById($id);
        $data = array(
            "carreras" => $this->Carrera_model->getAll(),
            "estudiante" => $estudiante,
        );
        $this->load->view("estudiantes/add_edit", $data);
    }*/
}