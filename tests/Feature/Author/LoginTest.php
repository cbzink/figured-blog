<?php

namespace Tests\Feature\Author;

use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    private function validParams($overrides = [])
    {
        return array_merge([
            'email' => 'author@example.com',
            'password' => 'password123',
        ], $overrides);
    }

    private function assertValidationError($field)
    {
        $this->response->assertSessionHasErrors($field);
        $this->assertGuest();
    }

    /** @test */
    public function viewing_the_login_page()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('login');

        $response->assertSuccessful();
        $response->assertViewIs('login');
    }

    /** @test */
    public function logged_in_authors_viewing_the_login_page_are_redirected_home()
    {
        $author = factory(Author::class)->create();

        $response = $this->actingAs($author)->get('login');

        $response->assertRedirect('/');
    }

    /** @test */
    public function successfully_logging_in()
    {
        $this->withoutExceptionHandling();

        $author = factory(Author::class)->create([
            'email' => 'author@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('login', [
            'email' => 'author@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($author);
    }

    /** @test */
    public function logging_in_with_invalid_information_fails()
    {
        $response = $this->from('login')->post('login', [
            'email' => 'invalid@example.com',
            'password' => 'invalid',
        ]);

        $response->assertRedirect('login');
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function email_is_required()
    {
        $this->response = $this->post('login', $this->validParams(['email' => '']));

        $this->assertValidationError('email');
    }

    /** @test */
    public function email_must_be_an_email()
    {
        $this->response = $this->post('login', $this->validParams(['email' => 'not-an-email']));

        $this->assertValidationError('email');
    }

    /** @test */
    public function password_is_required()
    {
        $this->response = $this->post('login', $this->validParams(['password' => '']));

        $this->assertValidationError('password');
    }
}
