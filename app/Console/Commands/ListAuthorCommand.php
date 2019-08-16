<?php

namespace App\Console\Commands;

use App\Author;
use Illuminate\Console\Command;

class ListAuthorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all registered authors';

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
        $authors = Author::get()->map->only('id', 'name', 'email');

        $this->table(['ID', 'Name', 'Email'], $authors);
    }
}
