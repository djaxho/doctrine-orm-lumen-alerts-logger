<?php

namespace Emporium\Svc\Alert\Http\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Emporium\Svc\Alert\Model\{Alert\CategoryFetch};

class CategoryController extends AbstractController
{
    /**
     * Retrieve all Categories
     * @return [type]                      [description]
     */
    public function index(CategoryFetch $category_fetch)
    {
        return response()->json($category_fetch->fetchCategories());
    }
}
