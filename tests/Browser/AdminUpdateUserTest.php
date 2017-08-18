<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminUpdateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test Route View Admin Create User.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/users')
                ->click('table tbody tr:nth-child(1) td:nth-child(7) a:nth-child(2)')
                ->assertPathIs('/users/1/edit')
                ->assertSee('UPDATE USER PAGE');
        });
    }

    /**
     * Test Validation Admin Create User.
     *
     * @return void
     */
    public function testFormUpdateUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/users/1/edit')
                ->assertPathIs('/users/1/edit')
                ->assertInputValue('full_name', 'DungVan')
                ->assertInputValue('email', 'admin@gmail.com')
                ->assertSelected('gender', 0)
                ->screenshot('testFormUpdateUser');
        });
    }

    /**
     * Test Admin create User success.
     *
     * @return void
     */
    public function testUpdateUserSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/users/1/edit')
                ->type('password', '123123')
                ->type('full_name', 'test user')
                ->select('gender', 1)
                ->type('phone_number', '12345678')
                ->type('address', 'test address')
                ->script([
                    "document.querySelector('#date-picker').value = '2017-02-23'",
                ]);
            $browser->press('Save Changes')
                ->assertPathIs('/users/1/edit')
                ->assertSee('Update Successfully')
                ->assertInputValue('full_name', 'test user')
                ->assertSelected('gender', 1)
                ->assertInputValue('phone_number', '12345678')
                ->assertInputValue('address', 'test address')
                ->assertInputValue('birthday', '2017-02-23')
                ->screenShot('testUpdateUserSuccess');
        });
        $this->assertDatabaseHas('users', ['email' => 'admin@gmail.com', 'full_name' => 'test user']);
    }


    public function listCaseTestValidationForUpdateUser()
    {
        return [
            ['123', 'test user', '1', '12345678', 'test address', '2017-02-23', 'The password must be at least 6 characters.'],
            ['', '', '1', '12345678', 'test address', '2017-02-23', 'The full name field is required.'],
            ['', 'test user', '1', '', 'test address', '2017-02-23', 'The phone number field is required.'],
            ['', 'test user', '1', 'abcdefgh', 'test address', '2017-02-23', 'The phone number must be a number.'],
            ['', 'test user', '1', '12345678', '', '2017-02-23', 'The address field is required.'],
            ['', 'test user', '1', '12345678', 'test address', '', 'The birthday is not a valid date.'],
        ];
    }

    /**
     * @dataProvider listCaseTestValidationForUpdateUser
     *
     */
    public function testUpdateUserFailValidation(
        $password,
        $full_name,
        $gender,
        $phone_number,
        $address,
        $birthday,
        $expected
    )
    {

        $this->browse(function (Browser $browser) use (
            $password,
            $full_name,
            $gender,
            $phone_number,
            $address,
            $birthday,
            $expected
        ) {

            $browser->loginAs(1)
                ->visit('/users/1/edit')
                ->type('password', $password)
                ->type('full_name', $full_name)
                ->select('gender', $gender)
                ->type('phone_number', $phone_number)
                ->type('address', $address)
                ->script([
                    "document.querySelector('#date-picker').value = '".$birthday."'",
                ]);
            $browser->press('Save Changes')
                ->assertPathIs('/users/1/edit');
        });
    }

    /**
     * Test Button Reset
     *
     */
    public function testBtnReset()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/users/1/edit')
                ->type('password', '123123')
                ->type('full_name', 'test user')
                ->type('phone_number', '12345678')
                ->type('address', 'test address')
                ->script([
                    "document.querySelector('#date-picker').value = '2017-02-23'",
                ]);
            $browser->press('Reset')
                ->assertPathIs('/users/1/edit')
                ->assertInputValueIsNot('full_name', 'test user')
                ->assertInputValueIsNot('birthday', '2017-02-23')
                ->assertInputValueIsNot('phone_number', '12345678')
                ->assertInputValueIsNot('address', 'test address')
                ->screenShot('testBtnReset');
        });
    }
}
