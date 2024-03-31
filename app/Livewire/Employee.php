<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    public $nama;
    public $email;
    public $alamat;
    // public $dataEmployees;
    protected $paginationTheme = 'bootstrap';

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
        ];

        $messageerror = [
            'nama.required' => 'Nama Wajib Di isi',
            'email.required' => 'Email Wajib Di isi',
            'email.email' => 'Format Email Tidak Sesuai',
            'alamat.required' => 'Alamat Wajib Di isi'
        ];

        $validated = $this->validate($rules, $messageerror);

        // Employee::create($validated);
        ModelsEmployee::create($validated);

        session()->flash('message', 'Data Berhasil Dimasukkan');
    }

    public function render()
    {
        $data = ModelsEmployee::latest()->paginate(2);
        return view('livewire.employee', ['dataEmployees' => $data]);
    }
}
