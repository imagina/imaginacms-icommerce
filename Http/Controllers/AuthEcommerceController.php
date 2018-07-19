<?php

namespace Modules\Icommerce\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Modules\User\Http\Requests\ResetRequest;
use Modules\User\Http\Controllers\AuthController;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;
use Modules\User\Contracts\Authentication;
use Modules\User\Entities\Sentinel\User;
use Modules\Iprofile\Entities\Profile;
use Modules\Iprofile\Repositories\AddressRepository;
use Modules\Iprofile\Transformers\AddressesTransformer;
use Socialite;

use Laravel\Socialite\Contracts\User as ProviderUser;


class AuthEcommerceController extends AuthController
{
  private $user;
  /**
   * @var RoleRepository
   */
  private $role;
  private $address;

  public function __construct(UserRepository $user, RoleRepository $role, AddressRepository $address)
  {
    parent::__construct();
    $this->user = $user;
    $this->role = $role;
    $this->address = $address;
  }


  public function postLogin(LoginRequest $request)
  {
    parent::postLogin($request);
    $user = $this->auth->user();
    $addresses = '';
    if (isset($user) && !empty($user)) {
      $profile = $user->profile()->first();
      $addresses = $this->address->findByProfileId($profile->id);

      return response()->json([
        "status" => "ok",
        "user" => $user,
        "addresses" => $addresses,
        "addressSelect" => AddressesTransformer::collection($addresses)
      ]);
    } else
      return response()->json([
        "status" => "error",
        "user" => $user
      ]);
  }

  public function userRegister(Request $request)
  {

    try {

      $roleCustomer = $this->role->findByName('Customers');
      $roleUser = $this->role->findByName(config('asgard.user.config.default_role', 'User'));
      $user = User::where("email", $request->email)->first();

      if (isset($user->email) && !empty($user->email)) {

        if ($request->guestOrCustomer == 2) {
          return response()->json([
            "status" => "ok",
            "user" => $user,
          ]);
        } else {
          if ($user->roles()->first()->slug == 'user') {
            $this->user->update($user, $request->all());
            $user->roles()->sync($roleCustomer->id);
            $code = $this->auth->createActivation($user);
            $this->auth->activate($user->id, $code);

            return response()->json([
              "status" => "ok",
              "user" => $user,
            ]);
          } else {
            return response()->json([
              "status" => "error",
              "message" => trans('icommerce::customer.messages.email_used')." ESTE MENSASE",
              "data" => $request->email,
            ]);

          }
        }
      } else {

        if ($request->guestOrCustomer == 2)
          $user = $this->user->createWithRoles($request->all(), $roleUser, false);
        else {
          $user = $this->user->createWithRolesFromCli($request->all(), $roleCustomer, true);

          $credentials = [
            'email' => $request->email,
            'password' => $request->password,
          ];
          $error = $this->auth->login($credentials, false);
          if ($error) {
            return response()->json([
              "status" => "error",
              "message" => $error,
            ]);
          }
        }


        return response()->json([
          "status" => "ok",
          "user" => $user,
        ]);
      }
    } catch (\Exception $e) {
      return response()->json([
        "status" => "error",
        "message" => $e->getMessage()." O ESTE",
      ]);
    }
  }

  public function createProfile($request, $user)
  {
    $profile = new Profile();
    if (config('asgard.iprofile.config.fields_register.identification')) {
      if (isset($request->identification) && !empty($request->identification))
        $profile->identification = $request->identification;
    }
    if (config('asgard.iprofile.config.fields_register.business')) {
      if (isset($request->business) && !empty($request->business))
        $profile->business = $request->business;
    }
    if (isset($request->tel) && !empty($request->tel))
      $profile->tel = $request->tel;
    $profile->user_id = $user->id;
    $profile->save();
  }

  public function getLogout()

  {
    parent::getLogout();
    return \Redirect::to('/checkout');
  }

}
