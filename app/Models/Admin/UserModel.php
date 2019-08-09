<?php

namespace App\Models\Admin;

use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\UserAlreadyExistsException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidSelectorTokenPairException;
use Delight\Auth\TokenExpiredException;
use Delight\Auth\UnknownIdException;
use Delight\Auth\Role;
use Delight\Auth\NotLoggedInException;
use \RedBeanPHP\R as R;
use SimpleMail;

class UserModel extends BaseModel
{
    public function login()
    {
            if ($_POST['remember'] == 'on') {
                // keep logged in for one year
                $rememberDuration = (int) (60 * 60 * 24 * 365.25);
            }
            else {
                // do not keep logged in after session ends
                $rememberDuration = null;
            }
            try {
                self::$auth->login($_POST['email'], $_POST['password'], $rememberDuration);
            }

            catch (InvalidEmailException $e) {
                die('Wrong email address');
            }
            catch (InvalidPasswordException $e) {
                die('Wrong password');
            }
            catch (EmailNotVerifiedException $e) {
                die('Email not verified');
            }
            catch (TooManyRequestsException $e) {
                die('Too many requests');
            }
            header("Location: /admin");
    }

    public function signUp()
    {
            try {
                self::$auth->register($_POST['email'], $_POST['password'], $_POST['text'], function ($selector, $token) {

                    SimpleMail::make()
                        ->setTo($_POST['email'], $_POST['username'])
                        ->setFrom('admin@mar.blog', 'Admin')
                        ->setSubject('Verification')
                        ->setMessage('http://marlin.blog/verify_email/' . urlencode($selector) . '/' . urlencode($token))
                        ->setHtml()
                        ->send();
                });
            }
            catch (InvalidEmailException $e) {
                die('Invalid email address');
            }
            catch (InvalidPasswordException $e) {
                die('Invalid password');
            }
            catch (UserAlreadyExistsException $e) {
                die('User already exists');
            }
            catch (TooManyRequestsException $e) {
                die('Too many requests');
            }

        header("Location: /admin/login");
    }

    public function logout()
    {
        return self::$auth->logOut();
    }

    public function verification()
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $selector = $uri[2];
        $token = $uri[3];

        try {
            self::$auth->confirmEmail($selector, $token);

//            echo 'Email address has been verified';
//            header( "refresh:5;url=/admin/login");
            header("Location: /admin");
            echo("<script>alert('Email address has been verified')</script>");

        }
        catch (InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (TokenExpiredException $e) {
            die('Token expired');
        }
        catch (UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function destroy($id)
    {
        try {
            self::$auth->admin()->deleteUserById($id);
        }
        catch (UnknownIdException $e) {
            die('Unknown ID');
        }
        header("Refresh:1 /admin/users");
    }

    public function setRole($userId, $role)
    {
        try {
            if ( $role == 1 ) {
                self::$auth->admin()->addRoleForUserById($userId, Role::ADMIN);
            } elseif ( $role == 2 ) {
                self::$auth->admin()->addRoleForUserById($userId, Role::AUTHOR);
            } elseif ( $role == 4 ) {
                self::$auth->admin()->addRoleForUserById($userId, Role::EDITOR);
            } else {
                echo "Type correctly role!";
            }
        }
        catch (UnknownIdException $e) {
            die('Unknown user ID');
        }
    }

    public function deleteRole($userId)
    {
        try {
            self::$auth->admin()->removeRoleForUserById($userId, Role::ADMIN);
        }
        catch (UnknownIdException $e) {
            die('Unknown user ID');
        }
    }

    public function checkRole($userId)
    {
        try {
            if (self::$auth->admin()->doesUserHaveRole($userId, Role::ADMIN)) {
                return 1;
            } elseif (self::$auth->admin()->doesUserHaveRole($userId, Role::AUTHOR)) {
                return 2;
            } elseif (self::$auth->admin()->doesUserHaveRole($userId, Role::EDITOR)) {
                return 1024;
            } else {
                return 0;
            }
        }
        catch (UnknownIdException $e) {
            die('Unknown user ID');
        }
    }

    public function changePassword()
    {
        try {
            self::$auth->changePassword($_POST['oldPassword'], $_POST['newPassword']);

            echo 'Password has been changed';
        }
        catch (NotLoggedInException $e) {
            die('Not logged in');
        }
        catch (InvalidPasswordException $e) {
            die('Invalid password(s)');
        }
        catch (TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function changeEmail()
    {
        try {
            if (self::$auth->reconfirmPassword($_POST['oldPassword'])) {
                self::$auth->changeEmail($_POST['email'], function ($selector, $token) {
                    SimpleMail::make()
                        ->setTo($_POST['email'], $_POST['username'])
                        ->setFrom('admin@mar.blog', 'Admin')
                        ->setSubject('Verification Email')
                        ->setMessage('http://marlin.blog/verify_email/' . urlencode($selector) . '/' . urlencode($token))
                        ->setHtml()
                        ->send();
                });
                echo 'The change will take effect as soon as the new email address has been confirmed';
            }
            else {
                echo 'We can\'t say if the user is who they claim to be';
            }

        }
        catch (InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (EmailNotVerifiedException $e) {
            die('Account not verified');
        }
        catch (NotLoggedInException $e) {
            die('Not logged in');
        }
        catch (TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function getUserId()
    {
        return self::$auth->getUserId();
    }

    public function getAvatar($id)
    {
        $avatar = R::load('users', $id);
        return $avatar->avatar;
    }

    public function index($role, $id = '')
    {
        if ( $role == 1 ) {
             return R::getAll("SELECT * FROM users");
        } elseif ( $role == 1024 ) {
            return R::getAll("SELECT * FROM users WHERE roles_mask!=1");
        } elseif ( $role == 2 ) {
            if ( $this->checkRole($id) == 2 ) {
                return R::getAll("SELECT * FROM users WHERE id=:id", [':id' => $id]);
            } else { exit; }
        }
    }

    public function edit($id)
    {
        return R::load('users', $id);
    }

    public function getTitleRole()
    {
        return [
            '1'     => 'Admin',
            '2'     => 'Author',
            '1024'  => 'Editor'
        ];
    }

    public function getActualStatus()
    {
        return [
            '0'     => 'Verification',
            '2'     => 'Banned',
            '1'     => 'Active'
        ];
    }

    public function getLanguageDescription()
    {
        return [
            'en' => 'all_desc',
            'pl' => 'all_desc_pl',
            'de' => 'all_desc_de',
            'ru' => 'all_desc_ru'
        ];
    }

    public function getLanguageTitle()
    {
        return [
            'en' => 'title',
            'pl' => 'title_pl',
            'de' => 'title_de',
            'ru' => 'title_ru'
        ];
    }

    public function update()
    {
        foreach ($this->getActualStatus() as $key => $value) {
            if ( $_POST['status'] == $value ) $status = $key;
        }

        foreach ($this->getTitleRole() as $key => $value) {
            if ( $_POST['roles_mask'] == $value ) $roles_mask = $key;
        }

        $profile = R::load('users', $_POST['id']);

        if ( $_POST['email'] && $profile->email != $_POST['email'] ) {
             self::changeEmail();
        }
        if ($_POST['username']) $profile->username = $_POST['username'];
        if ( $_POST['roles_mask']) {
            $profile->roles_mask = $roles_mask;
        }

        if ( $_POST['status']) {
            $profile->status = $status;
        }

        if ( $_FILES['file']['size'] != 0 ) {
            $avatar = $this->loadImg('user', $_POST['username'], $_POST['username']);
            $profile->avatar = $avatar;
        }
        if ( $_POST['oldPassword'] != "" && $_POST['newPassword'] != "" ) {
            self::changePassword();
        }

        R::store($profile);

        header("Location: /admin/users");
    }

    public function getAuthors()
    {
        return R::getAll("SELECT * FROM users WHERE roles_mask=2");
    }

    public function getStatus($id)
    {
        $status = R::load('users', $id);
        return $status->status;
    }
}
