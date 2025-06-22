<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;


class ProfileController extends Controller
{
    /**
     * عرض صفحة البروفايل للمستخدم الحالي.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * تحديث بيانات المستخدم.
     */
    public function update(Request $request): RedirectResponse
    {


        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'preferred_language' => ['nullable', 'in:ar,en'],
            'technician_status' => ['nullable', 'in:available,busy,unavailable'],
            'photo_url' => ['nullable', 'image', 'max:12120'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        // ✅ تحديث كلمة المرور لو اتغيرت
        if ($validated['password'] ?? false) {
            $user->password = bcrypt($validated['password']);
        }

        // ✅ رفع الصورة لو موجودة
        if ($request->hasFile('photo_url')) {
            if ($user->photo_url) {
                Storage::disk('public')->delete($user->photo_url);
            }

            $path = $request->file('photo_url')->store('profile_photos', 'public');
            $user->photo_url = $path;
        }

        // ✅ تحديث باقي الحقول
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'preferred_language' => $validated['preferred_language'] ?? null,
            'technician_status' => $validated['technician_status'] ?? null,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', __('messages.profile_updated_successfully'));
    }

    /**
     * حذف الحساب (لو هتستخدمه بعدين).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
