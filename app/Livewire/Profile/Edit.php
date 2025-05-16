<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Edit extends Component
{
    use WithFileUploads;

    public User $user;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $photo;
    public $currentPhotoUrl;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->currentPhotoUrl = $user->profile_photo_url ?? null;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:6',
            'photo' => 'nullable|image|max:2048',
        ]);

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->phone = $this->phone;

        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        if ($this->photo) {
            $path = $this->photo->store('profile-photos', 'public');
            $this->user->profile_photo_url = '/storage/' . $path;
            $this->currentPhotoUrl = $this->user->profile_photo_url;
        }

        $this->user->save();

        session()->flash('success', 'تم حفظ التعديلات بنجاح');
    }

    public function render()
    {
        return view('livewire.profile.edit')->layout('layouts.app');
    }
}
