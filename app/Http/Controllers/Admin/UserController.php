<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;

class UserController extends Controller {

    public function getIndex(Request $request)
    {
    	
        $users = new User;

        if(!empty($request->q))
        {
            $users = $users->where("email","LIKE","%".$request->q."%");
        }


        $users = $users->paginate(20);

        $users->setPath('');
    	return view('backend/user/index', array('users' => $users));
    }

    public function getEdit($userid)
    {
        $user = User::find($userid);
        return view('backend/user/createedit', array('user' => $user));
        
    }

    public function getCreate()
    {
        $user = new User();
        return view('backend/user/createedit', array('user' => $user));
    }


    public function postCreateEdit(Request $request)
    {
    	$newUser = false;
        $user = User::find($request->id);

        if(!$user){
        	$user = new User;
        	$newUser = true;
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->confirmed = $request->confirmed;

        if(isset($request->password) && $request->password != ""){

            if($request->password == $request->password_confirmation){
                $user->password = Hash::make($request->password);
            }else{
                flash()->error('Passwords do not match.');
                return redirect('admin/user/edit/'.$request->id)->withInput($request->except(['password', 'password_confirmation']));
            }
        }
        

        if($user->save()){
        	if($newUser){
        		flash()->success('User created successfully.');
        	}else{
        		flash()->success('User updated successfully.');
        	}
        }else{
        	flash()->error('Error occured while saving user.');
        }
        

        return redirect('admin/users');

    }

    public function getDelete($userid)
    {
    	$user = User::find($userid);

    	if($user){
    		if($user->delete()){
    			flash()->success('User deleted successfully.');
    		}else{
    			flash()->error('Can not delete user.');
    		}
    	}else{
    		flash()->error('Can not find user in database.');
    	}

    	return redirect('admin/users');

    }


}