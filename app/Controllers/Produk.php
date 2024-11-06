<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use CodeIgniter\HTTP\ResponseInterface;

class Produk extends BaseController
{
    protected $produkmodel;

    public function __construct()
    {
        $this->produkmodel = new ProdukModel;
    }

    public function index()
    {
        return view('v_produk');
    }

    public function tampil_produk()
    {
        $produk = $this->produkmodel->findAll();
        return $this->response->setJSON([
            'status' => 'success',
            'produk' => $produk
        ]);
    }

    public function simpan_produk()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_produk' => 'required',
            'harga' => 'required|decimal',
            'stok' => 'required|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok')
        ];

        $this->produkmodel->save($data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data produk berhasil disimpan',
        ]);
    }

    public function tampil_by_id($id)
    {
        $produk = $this->produkmodel->find($id);
        if ($produk) {
            return $this->response->setJSON([
                'status' => 'success',
                'produk' => $produk
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan'
            ]);
        }
    }

    public function update()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_produk' => 'required',
            'harga' => 'required|decimal',
            'stok' => 'required|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok')
        ];

        $id = $this->request->getVar('id');
        // Update the product
        $this->produkmodel->update($id, $data);
 
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data produk berhasil diperbarui',
        ]);
    }

    public function hapus_produk($id)
    {
        $this->produkmodel->delete($id);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data produk berhasil dihapus.'
        ]);
    }
}
