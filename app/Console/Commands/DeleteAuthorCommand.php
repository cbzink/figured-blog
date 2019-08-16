<?php

namespace App\Console\Commands;

use App\Author;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteAuthorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:delete {author : The ID of the author}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes a given author';

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

        if (!$this->confirm("Are you sure you wish to delete {$author->name}?")) {
            $this->info('The operation has been canceled.');
            
            return;
        }

        $author->delete();

        $this->info("{$author->name} has been successfully deleted.");
    }
}
