<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test Route View Admin Create User.
     *
     * @return void
     */
    public function testCreatesUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/users')
                ->click('#btn-add-user')
                ->assertPathIs('/users/create')
                ->assertSee('CREATE USER PAGE')
                ->assertSee('Create New User');
        });
    }

    /**
     * Test Validation Admin Create User.
     *
     * @return void
     */
    public function testValidationCreatesUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/users/create')
                ->press('Create')
                ->assertPathIs('/users/create')
                ->assertSee('The password field is required.')
                ->assertSee('The birthday is not a valid date.')
                ->assertSee('The full name field is required.')
                ->assertSee('The email field is required.')
                ->assertSee('The address field is required.')
                ->assertSee('The phone number field is required.');
        });
    }

    /**
     * Test Admin create User success.
     *
     * @return void
     */
    public function testCreatesUserSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/users/create')
                ->type('password','123123')
                ->type('full_name','test user')
                ->type('email','test.user@gmail.com')
                ->select('gender', 1)
                ->type('phone_number','12345678')
                ->type('address','test address')
                ->script([
                    "document.querySelector('#date-picker').value = '2017-02-23'",
                ]);
            $browser->press('Create')
                ->assertPathIs('/users')
                ->assertSee('User Created!')
                ->screenShot('success');
        });
        $this->assertDatabaseHas('users', ['email' => 'test.user@gmail.com']);
    }


    public function listCaseTestValidationForCreateUser()
    {
        return [
            ['', 'test user', 'HTYen' ,'hty@gmail.com', '12345678', 'The username field is required.'],
            ['123456', '', 'HTYen' ,'hty@gmail.com', '12345678', 'The password field is required.'],
            ['123456', 'test user', 'HTYen' ,'hty@gmail.com', '12345678', 'The password confirmation field is required.'],
            ['123', 'test user', '' ,'hty@gmail.com', '12345678', 'The full name field is required.'],
            ['123', 'test user', 'HTYen' ,'', '12345678', 'The email field is required.'],
            ['123', 'test user', 'HTYen' ,'hty@', '12345678', 'The email must be a valid email address.'],
            ['123', 'test user', 'HTYen' ,'hty@gmail.com', '', 'The phone field is required.'],
            ['123', 'test user', 'HTYen' ,'hty@gmail.com', '12fff', 'The phone must be a number.'],
        ];
    }
    /**
     * @dataProvider listCaseTestValidationForCreateUser
     *
     */
    public function testCreateUserFailValidation(
        $username,
        $password,
        $password_confirmation,
        $full_name,
        $email,
        $phone,
        $expected
    ) {

        $this->browse(function (Browser $browser) use(
            $username,
            $password,
            $password_confirmation,
            $full_name,
            $email,
            $phone,
            $expected
        ) {

            $browser->visit('/admin/user/create')
                ->type('username', $username)
                ->type('password', $password)
                ->type('password_confirmation', $password_confirmation)
                ->type('full_name', $full_name)
                ->type('email', $email)
                ->type('phone', $phone)
                ->press('Submit')
                ->assertSee($expected)
                ->assertPathIs('/admin/user/create');
        });
    }
}
