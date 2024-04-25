<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Response;

class TicketController extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //     $ticketModel = new \App\Models\TicketModel();
        //     $result = $ticketModel->findAll();

        //     if (!$result) {
        //         return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        //     }

        //     return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($result);
        return view('pages/tickets');
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $ticketModel = new \App\Models\TicketModel();
        $result = $ticketModel->find($id);

        if (!$result) {
            return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($result);
    }

    public function list(){
        $ticketModel = new \App\Models\TicketModel();
        $postData = $this->request->getPost();

        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length'];
        $seachvalue = $postData['search']['value'];
        $sortby = $postData['order'][0]['column'];
        $sortdir = $postData['order'][0]['dir'];
        $sortcolumn = $postData['columns'][$sortby]['data'];
       
        // total records 
        $totalRecords = $ticketModel->select('id')->countAllResults();

        // total records with filter

        $totalRecordswithFilter = $ticketModel->select('id')
        ->like('first_name',$seachvalue)
        ->orLike('last_name',$seachvalue)
        ->orLike('email',$seachvalue)
        ->orLike('state',$seachvalue)
        ->orLike('severity',$seachvalue)
        ->orLike('description',$seachvalue)
        ->orLike('remarks',$seachvalue)
        ->orderBy($sortcolumn,$sortdir)
        ->countAllResults();

        //records

        $records = $ticketModel->select('*')
        ->like('first_name',$seachvalue)
        ->orLike('last_name',$seachvalue)
        ->orLike('email',$seachvalue)
        ->orLike('state',$seachvalue)
        ->orLike('severity',$seachvalue)
        ->orLike('description',$seachvalue)
        ->orLike('remarks',$seachvalue)
        ->orderBy($sortcolumn,$sortdir)
        ->findAll($rowperpage,$start);

        $data = array();

        foreach ($records as $record) {
            $data[] = array (
                'id' => $record['id'],
                'first_name' => $record['first_name'],
                'last_name' => $record['last_name'],
                'email' => $record['email'],
                'state' => $record['state'],
                'severity' => $record['severity'],
                'description' => $record['description'],
                'remarks' => $record['remarks'],
            );
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $data
        );

        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($response);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $ticketModel = new \App\Models\TicketModel();
        $data = $this->request->getJSON();

        if (!$ticketModel->validate($data)) {
            $response = array(
                'status' => 'error',
                'message' => $ticketModel->errors()
            );
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)->setJSON($response);
        }

        $ticketModel->insert($data);
        $response = array(
            'status' => 'success',
            'message' => 'Office added successfully'
        );

        return $this->response->setStatusCode(Response::HTTP_CREATED)->setJSON($response);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $ticketModel = new \App\Models\TicketModel();
        $data = $this->request->getJSON();

        if (!$ticketModel->validate($data)) {
            $response = array(
                'status' => 'error',
                'message' => $ticketModel->errors()
            );
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)->setJSON($response);
        }

        $ticketModel->update($id, $data);
        $response = array(
            'status' => 'success',
            'message' => 'Ticket updated successfully'
        );

        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($response);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $ticketModel = new \App\Models\TicketModel();
        $data = $ticketModel->find($id);

        // if(!$data){
        //     $response = array(
        //         'status'=> 'error',
        //         'message' => 'Office not found'
        //     );
        //     return $this->response->setStatusCode(Response::HTTP_NOT_FOUND)->setJSON($response);
        // }

        $ticketModel->delete($id);
        $response = array(
            'status' => 'success',
            'message' => 'Office deleted successfully'
        );

        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($response);
    }
}
