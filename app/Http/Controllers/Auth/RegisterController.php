<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'phone' => ['required', 'max:50', 'unique:users'],
            'street' => ['nullable', 'string', 'max:50', ],
            'city' => ['nullable', 'string', 'max:50', ],
            'country' => ['nullable', 'string', 'max:50', ],
            'img_path' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        /*
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // يجب أن تحتوي على حرف صغير
                'regex:/[A-Z]/',      // يجب أن تحتوي على حرف كبير
                'regex:/[0-9]/',      // يجب أن تحتوي على رقم
                'regex:/[@$!%*?&#]/'  // يجب أن تحتوي على رمز خاص
            ],
        */

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'street' => $data['street'],
            'city' => $data['city'],
            'country' => $data['country'],
            'password' => Hash::make($data['password']),
        ]);
        if ($data['img_path']) {
            $file = $data['img_path'];
            $fileName = Str::slug($user->username).time().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/users',$fileName, ['disk'=>'uploads']);

            $user->update([
                'img_path' => $path,
            ]);

        }

        return $user;
    }

    public function register(Request $request)
    {
        // return $request;
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        Session::flash('success','Thank you for register');
        return redirect()->route('frontend.index');
    }

}



