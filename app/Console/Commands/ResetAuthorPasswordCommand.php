<?php

namespace App\Console\Commands;

use App\Author;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResetAuthorPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:reset-password {author : The ID of the author}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the password of a given author';

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
        try {
            $author = Author::findOrFail($this->argument('author'));
        } catch (ModelNotFoundException $e) {
            $this->error("Sorry, that author could not be found.");

            return;
        }

        $input = [
            'password' => $this->secret('What would you like to set the author\'s password to?'),
            'password_confirmation' => $this->secret('Please confirm the author\'s new password.'),
        ];

        $validator = Validator::make($input, [
            'password' => ['required', 'confirmed'],
        ]);

        if ($validator->fails()) {
            $this->line('Sorry, something went wrong when resetting this author\'s password. Please review the errors below.');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return;
        }

        $author->password = bcrypt($input['password']);
        $author->save();

        $this->info("{$author->name}'s password has been changed successfully.");
    }
}
