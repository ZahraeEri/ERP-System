<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function users_list()
    {
        $users = User::all();
        return view('user.list', compact('users'));  //compact is used to
        //send data from controller to view
    }
    public function users_add()
    {
        return view('user.add');
    }
    public function users_add_treatment(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'email' => ['required', 'unique:users'],
            'password' => 'required|min:6',
            'photo' => 'image', // Add validation for photo
        ]);

        // Store file in variable
        $file = $request->file('photo');
        $filename = null;

        // Handle profile picture upload
        if ($request->hasFile('photo')) {

            // dd($request->file('photo')->getClientOriginalName());
            if ($file != null) {

                // make sure that the imported file is a photo
                if ($file->getClientOriginalExtension() == "png" || $file->getClientOriginalExtension() == "jpg" || $file->getClientOriginalExtension() == "jpeg") {

                    // Specify a filename
                    $username = $request->input("name") . '_' . $request->input("lastname");
                    $filename = str_replace( " ", "_",$username).".".$file->getClientOriginalExtension();
                    // Create file path
                    $path = public_path("assets/profile_pictures");
                    //check if this directory exist or not
                    if (!File::exists($path)) {
                        // if (!File::isDirctory($path)) {
                            File::makeDirectory(public_path("assets/profile_pictures"));
                        // }
                    }
                    $file->move($path, $filename);
                }
            }

            // // Get the file name with the extension
            // $filenameWithExt = $request->file('photo')->getClientOriginalName();
            // // Just get the file name without extension
            // $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // // Get the file extension
            // $extension = $request->file('photo')->getClientOriginalExtension();
            // // Filename to store
            // $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // // Upload Image
            // $path = $request->file('photo')->storeAs('public/photos/treatments', $fileNameToStore);
        }
        //  else {
        //     // Handle case where no photo is uploaded (optional)
        //     // You can create a default photo or display an error message
        //     return redirect('/add')->with('error', 'Please select a profile picture');
        // }

        // Create a new User instance
        $user = new User();
        // Set the user data
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Use bcrypt for password hashing
        $user->photo = $filename; // Save the photo filename in the user's photo field
        // Save the user data to the database
        $user->save();

        // Redirect back with success message
        return redirect('/add')->with('status', 'The user is added successfully');
    }

    // public function users_add_treatment(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => ['required', 'unique:users'],
    //         'password' => 'required|min:6',
    //         'photo' => 'required', // Add validation for photo
    //     ]);
    //     // Handle profile picture upload
    //     $photo = $request->file('photo');
    //     dd($photo);
    //     if ($photo) {
    //         $photoName = time() . '.' . $photo->getClientOriginalExtension();
    //         $photo->storeAs('public/users/profile_pictures', $photoName); // Store in 'public/users/profile_pictures'

    //         // Update user data with photo path
    //         $user = new User();
    //         $user->name = $request->name;
    //         $user->email = $request->email;
    //         $user->password = bcrypt($request->password); // Use bcrypt for password hashing
    //         $user->photo = $photoName; // Save the photo filename in the user's photo field
    //         $user->save();
    //         dd($request->all()) ;//for checking the request values

    //     } else {
    //         // Handle case where no photo is uploaded (optional)
    //         // You can create a default photo or display an error message
    //         return redirect('/add')->with('error', 'Please select a profile picture');
    //     }

    //     return redirect('/add')->with('status', 'The user is added successfully');
    // }
    public function update_user($id)
    {
        $users = User::find($id);

        if (!$users) {
            return redirect()->route('users.list')->with('error', 'User not found');
        }

        return view('user.update', compact('users'));
    }

    public function users_update_treatment(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required',
        'lastname' => 'required',
        'email' => ['required', 'unique:users,email,' . $request->id],
        'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for photo
    ]);

    // Find the user by ID
    $user = User::find($request->id);

    // If user is not found, redirect back with an error message
    if (!$user) {
        return redirect('/user')->with('error', 'User not found');
    }

    // Check if a new photo has been uploaded
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');

        // Validate file extension
        $validExtensions = ['png', 'jpg', 'jpeg'];
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $validExtensions)) {
            return redirect()->back()->with('error', 'Invalid file format. Only PNG, JPG, and JPEG are allowed.');
        }

        // Specify a filename for the uploaded photo
        $username = $request->input("name") . '_' . $request->input("lastname");
        $filename = str_replace(" ", "_", $username) . "." . $file->getClientOriginalExtension();

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

    // Check if the password field is not empty (indicating the user wants to change their password)
    if (!empty($request->password)) {
        // Validate the password
        $request->validate([
            'password' => 'required|min:6',
        ]);

        // Update the user's password
        $user->password = bcrypt($request->password); // Use bcrypt for password hashing
    }

    // Update other fields of the user
    $user->name = $request->name;
    $user->lastname = $request->lastname;
    $user->email = $request->email;

    // Save the updated user data to the database
    $user->save();

    // Redirect back to the user list page with a success message
    return redirect('/user')->with('status', 'The user has been updated successfully');
}





    public function delete_user($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/user')->with('status', 'The user has been deleted successfully');
    }

}
