<?php

namespace App\Http\Livewire;

use App\Models\Application;
use Livewire\Component;

class Applications extends Component
{
    public $createNewAppModalOpened = false;
    public $updateAppModalOpened = false;
    public $deleteAppModalOpened = false;
    public $applicationId;
    public $name;
    public $owner_name;
    public $owner_mobile;
    public $application_status;

    public function openNewAppModal()
    {
        $this->createNewAppModalOpened = true;
    }

    public function closeNewAppModal()
    {
        $this->createNewAppModalOpened = false;
    }

    public function openDeleteAppModal($id)
    {
        $this->applicationId = $id;
        $this->deleteAppModalOpened = true;
    }

    public function closeDeleteAppModal()
    {
        $this->deleteAppModalOpened = false;
        $this->resetProps();
    }

    public function openUpdateAppModal($id)
    {
        $application = Application::find($id);
        $this->applicationId = $id;
        $this->name = $application->name;
        $this->owner_name = $application->owner_name;
        $this->owner_mobile = substr($application->owner_mobile, 2, strlen($application->owner_mobile));
        $this->application_status = $application->status;

        $this->updateAppModalOpened = true;
    }

    public function closeUpdateAppModal()
    {
        $this->updateAppModalOpened = false;
        $this->resetProps();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|unique:applications,name,' . $this->applicationId ?? '',
            'owner_name' => 'required|string|min:3',
            'owner_mobile' => 'required|digits:11'
        ];
    }

    public function updatedDeleteAppModalOpened()
    {
        !$this->deleteAppModalOpened ? $this->resetProps() : null;
    }

    public function updatedUpdateAppModalOpened()
    {
        !$this->updateAppModalOpened ? $this->resetProps() : null;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createApplication()
    {
        $this->validate();
        Application::create([
            'name' => $this->name,
            'owner_name' => $this->owner_name,
            'owner_mobile' => '+2' . $this->owner_mobile,
            'api_key' => base64_encode($this->name . time())
        ]);
        $this->resetProps();
        session()->flash('success', 'Application created successfully');

    }

    public function updateApplication()
    {
        $this->validate();
        Application::whereId($this->applicationId)->update([
            'name' => $this->name,
            'owner_name' => $this->owner_name,
            'owner_mobile' => '+2' . $this->owner_mobile,
            'status' => $this->application_status
        ]);
        $this->resetProps();
        session()->flash('success', 'Application updated successfully');
    }

    public function deleteApplication()
    {
        Application::destroy($this->applicationId);
        $this->resetProps();
        session()->flash('success', 'Application deleted successfully');
    }

    public function resetProps()
    {
        $this->createNewAppModalOpened = false;
        $this->updateAppModalOpened = false;
        $this->deleteAppModalOpened = false;
        $this->applicationId = null;
        $this->name = null;
        $this->owner_name = null;
        $this->owner_mobile = null;
        $this->application_status = null;
    }

    public function render()
    {
        return view('livewire.applications', [
            'applications' => Application::latest()->get()
        ]);
    }
}
