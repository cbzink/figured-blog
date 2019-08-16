<?php

namespace App\Console\Commands;

use App\Author;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAuthorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new author';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $input = [
            'first_name' => $this->ask('What is the author\'s first name?'),
            'last_name' => $this->ask('What is the author\'s last name?'),
            'email' => $this->ask('What is the author\'s email address?'),
            'password' => $this->secret('What is the author\'s password?'),
            'password_confirmation' => $this->secret('Please confirm the author\'s password.'),
        ];

        $validator = Validator::make($input, [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:authors,email'],
            'password' => ['required', 'confirmed']
        ]);

        if ($validator->fails()) {
            $this->line('Sorry, something went wrong when creating this author. Please review the errors below.');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return;
        }

        $author = Author::create([
            'name' => "{$input['first_name']} {$input['last_name']}",
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
        ]);

        $this->info("Author {$input['first_name']} {$input['last_name']} has been successfully created with ID {$author->id} and may now login.");
    }
}
