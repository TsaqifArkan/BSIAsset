<?php

namespace App\Controllers;

use App\Models\NotifikasiModel;
use App\Models\SewaModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use NumberFormatter;
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
    protected $helpers = ['auth', 'form', 'url'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->numfmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);

        // Session untuk notifikasi jatuh tempo [DEPRECATED]
        // $sessionNotif = session();
        // if (!$sessionNotif->has('notif')) {
        //     $model = new SewaModel();
        //     $result = $model->builder()
        //         ->select('nama, jatuh_tempo')
        //         ->where('jatuh_tempo <= ', date('Y-m-d'))
        //         ->get()->getResultArray();
        //     $sessionNotif->set('notif', $result);
        // }
    }

    // Function to show pages
    protected function showPages(String $view, $data = [])
    {
        $notifikasiModel = new NotifikasiModel();
        $query = $notifikasiModel->builder()->select('*')->orderBy('waktu', 'ASC');
        $result = $query->get()->getResultArray();
        $data['notifikasi'] = $result;
        return view($view, $data);
    }
}
