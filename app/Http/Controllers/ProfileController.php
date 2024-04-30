<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Update user's information
    $user->fill($request->validated());

    // Check if the email has been changed and reset email verification
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Handle photo update
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');

        // Validate file extension
        $validExtensions = ['png', 'jpg', 'jpeg'];
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $validExtensions)) {
            return Redirect::back()->with('error', 'Invalid file format. Only PNG, JPG, and JPEG are allowed.');
        }

        // Specify a filename for the uploaded photo
        $username = $request->input("name") . '_' . $request->input("lastname");
        $filename = str_replace(" ", "_", $username) . "." . $extension;

        // Create file path for storing the photo
        $path = public_path("assets/profile_pictures");

        // Check if the directory exists, if not create it
        if (!File::exists($path)) {
            File::makeDirectory(public_path("assets/profile_pictures"));
        }

        // Move the uploaded photo to the specified path
        $file->move($path, $filename);

        // Update the user's photo field with the new filename
        $user->photo = $filename;
    }

    // Save the updated user data
    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}



    /**
     * Delete the user's account.
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
