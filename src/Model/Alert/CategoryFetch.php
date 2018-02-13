<?php

namespace Emporium\Svc\Alert\Model\Alert;

use Doctrine\ORM\EntityManagerInterface;

class CategoryFetch
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * Retrieve all Categories
     * @return [type]                      [description]
     */
    public function fetchCategories()
    { 
        // Fetch all distinct categores
        $query = $this->em->createQuery("SELECT DISTINCT u.category FROM Alert:Alert\Alert u ORDER BY u.category ASC");
        $queryResult = $query->getArrayResult();

        $categories = [];

        // Extract categories from the Query results (an array of arrays)
        foreach ($queryResult as $singleResultArray) {
            foreach ($singleResultArray as $value) {
                $categories[] = $value;
            }
        }

        return $categories;
    }
}
