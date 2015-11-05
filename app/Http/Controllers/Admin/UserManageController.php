<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Admin;
use App\Model\Teacher;
use App\Model\Student;
use App\Model\Parents;


class UserManageController extends Controller
{
    public function get_ad(){
        $adminlist = Admin::all();
        return view('adminpage.usermanage.adduser_ad', ['adminlist' => $adminlist]);
    }

    public function get_te(){
        $teacherlist = Teacher::all();
        return view('adminpage.usermanage.adduser_te', ['teacherlist' => $teacherlist]);
    }

    public function get_stu(){
        $studentlist = Student::all();
        return view('adminpage.usermanage.adduser_stu', ['studentlist' => $studentlist]);
    }

    public function get_pa(){
        $parentlist = Parents::all();
        return view('adminpage.usermanage.adduser_pa', ['parentlist' => $parentlist]);
    }

    public function get_userlist(){
        $userlist = User::all();
        return view('adminpage.usermanage.userlist', ['userlist' => $userlist]);
    }

    public function store_ad(Request $request)
    {

        $this->validate($request, [
            'password' => 'required|max:60',
            'email' => 'required|max:60|email_address',
        ]);

        $user = new User;
        $admin = new Admin;
        $id = Admin::all()->count();
        $offset = strlen($id);
        $newid = "0000000";
        $newid = substr($newid,$offset);
        $newid = "ad_".$newid.$id;

        // Create User
        $user->id = $newid;
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->fullname = $request['fullname'];
        $user->address = $request['address'];
        $user->role = "0";
        $user->dateofbirth = $request['dateofbirth'];
        $user->save();

        // Create Admin
        $admin->id = $newid;
        $admin->ownername = $request['fullname'];
        $admin->mobilephone = $request['mobilephone'];
        $admin->save();

        return Redirect('/admin/manage-user/admin');
    }

    public function store_te(Request $request)
    {
        $user = new User;
        $teacher = new Teacher;
        $id = Teacher::all()->count();
        $offset = strlen($id);
        $newid = "0000000";
        $newid = substr($newid,$offset);
        $newid = "te_".$newid.$id;

        // Create User
        $user->id = $newid;
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->fullname = $request['fullname'];
        $user->address = $request['address'];
        $user->role = "1";
        $user->dateofbirth = $request['dateofbirth'];
        $user->save();

        // Create Admin
        $teacher->id = $newid;
        $teacher->mobilephone = $request['mobilephone'];
        $teacher->homephone = $request['homephone'];
        $teacher->group = $request['group'];
        $teacher->position = $request['position'];
        $teacher->specialize = $request['specialize'];
        $teacher->incomingday = $request['incomingday'];
        $teacher->save();

        return Redirect('/admin/manage-user/teacher');
    }

    public function store_stu(Request $request)
    {
        $user = new User;
        $student = new Student;
        $id = Teacher::all()->count();
        $offset = strlen($id);
        $newid = "0000000";
        $newid = substr($newid,$offset);
        $newid = "st_".$newid.$id;

        // Create User
        $user->id = $newid;
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->fullname = $request['fullname'];
        $user->address = $request['address'];
        $user->role = "2";
        $user->dateofbirth = $request['dateofbirth'];
        $user->save();

        // Create Student
        $student->id = $newid;
        $student->enrolled_year = $request['enrolled_year'];
        $student->graduated_year = $request['graduated_year'];
        $student->parent_id = $request['parent_id'];
        $student->save();

        return Redirect('/admin/manage-user/student');
    }

    public function store_pa(Request $request)
    {
        $user = new User;
        $parent = new Parents;
        $id = Teacher::all()->count();
        $offset = strlen($id);
        $newid = "0000000";
        $newid = substr($newid,$offset);
        $newid = "pa_".$newid.$id;

        // Create User
        $user->id = $newid;
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->fullname = $request['fullname'];
        $user->address = $request['address'];
        $user->role = "3";
        $user->dateofbirth = $request['dateofbirth'];
        $user->save();

        // Create Student
        $parent->id = $newid;
        $parent->mobilephone = $request['mobilephone'];
        $parent->homephone = $request['homephone'];
        $parent->job = $request['job'];
        $parent->save();

        return Redirect('/admin/manage-user/parent');
    }

    public function delete_ad($id)
    {
        $admin = Admin::where('id',$id)->delete();
        return Redirect('/admin/manage-user/admin');
    }

    public function delete_te($id)
    {
        $admin = Teacher::where('id',$id)->delete();
        return Redirect('/admin/manage-user/teacher');
    }

    public function get_edit_form($id)
    {
        $admin = Admin::where('id',$id)->get();
        return view('adminpage.usermanage.edit_ad')->with($admin);
    }
}
