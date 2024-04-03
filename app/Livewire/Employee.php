<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama;
    public $email;
    public $alamat;
    public $updateData = false;
    public $employee_id;
    public $keyword;
    public $employee_selected_id = [];
    public $sortColumn = 'nama';
    public $sortDirection = 'asc';


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

        ModelsEmployee::create($validated);

        session()->flash('message', 'Data Berhasil Dimasukkan');

        $this->clear();
    }

    public function edit($id)
    {
        $data = ModelsEmployee::find($id);
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;
        $this->updateData = true;
        $this->employee_id = $id;
    }

    public function update()
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

        $data = ModelsEmployee::find($this->employee_id);

        $data->update($validated);

        session()->flash('message', 'Data Berhasil Diupdate');

        $this->clear();
    }

    public function clear()
    {
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';
        $this->updateData = false;
        $this->employee_id = '';
        $this->employee_selected_id = [];
    }

    public function delete()
    {
        if ($this->employee_id != '') {
            $id = $this->employee_id;
            ModelsEmployee::find($id)->delete();
        }

        if (count($this->employee_selected_id)) {
            for ($x = 0; $x < count($this->employee_selected_id); $x++) {
                ModelsEmployee::find($this->employee_selected_id[$x])->delete();
            }
        }

        session()->flash('message', 'Data Berhasil Dihapus');
        $this->clear();
    }

    public function deleteconfirm($id)
    {
        if ($id != '') {
            $this->employee_id = $id;
        }
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        if ($this->keyword != null) {
            $data = ModelsEmployee::where('nama', 'like', '%' . $this->keyword . '%')
                ->orwhere('email', 'like', '%' . $this->keyword . '%')
                ->orwhere('alamat', 'like', '%' . $this->keyword . '%')
                ->orderby($this->sortColumn, $this->sortDirection)->paginate(2);
        } else {
            $data = ModelsEmployee::orderby($this->sortColumn, $this->sortDirection)->paginate(5);
        }

        return view('livewire.employee', ['dataEmployees' => $data]);
    }
}
