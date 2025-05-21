<?php
namespace App\Services\Interfaces;

use App\Models\ContactForm;

interface ContactFormServiceInterface
{
    public function store(array $data): ContactForm;
    public function getAll();
    public function markAsRead($id);
}
