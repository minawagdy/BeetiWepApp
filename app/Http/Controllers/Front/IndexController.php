<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Interfaces\Front\IndexRepositoryInterface;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    private IndexRepositoryInterface $indexRepository;

    public function __construct(IndexRepositoryInterface $indexRepository)
    {
        $this->indexRepository = $indexRepository;

    }

    public function index()
    {

        return $this->indexRepository->index();
    }
}
