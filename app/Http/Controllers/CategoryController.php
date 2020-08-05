<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->getAll();

        return view('countCategory', compact('categories'));
    }
}
