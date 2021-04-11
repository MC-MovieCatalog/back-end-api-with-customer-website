<?php

namespace App\DataFixtures;

class FakeInvoiceData
{
    // Invoice data 
    
    private $invoices = array(
        array(
            'id' => 1
        ),
        array(
            'id' => 2
        ),
        array(
            'id' => 3
        ),
        array(
            'id' => 4
        )
    );
    
    // invoices data getter
    public function getInvoices(): ?array
    {
        return $this->invoices;
    }
}
