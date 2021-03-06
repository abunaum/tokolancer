<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->validation =  \Config\Services::validation();
        $this->namaweb = 'Tokolancer';
        //model
        $this->produk = new \App\Models\ProdukModel();
        $this->item = new \App\Models\ItemModel();
        $this->subitem = new \App\Models\SubitemModel();
        $this->toko = new \App\Models\TokoModel();
        $this->transaksi_saldo = new \App\Models\TransaksiSaldoModel();
        $this->users = new \App\Models\User();
        $this->role = new \App\Models\Role();
        $this->apipayment = new \App\Models\ApiPaymentModel();
        $this->keranjang = new \App\Models\Keranjang();
        $this->invoice = new \App\Models\Invoice();
        $this->kirimpesanan = new \App\Models\Kirimpesanan();

        //helper
        helper(['item' ,'auth','user','number','config','tanggal']);
        // E.g.: $this->session = \Config\Services::session();
    }
}
